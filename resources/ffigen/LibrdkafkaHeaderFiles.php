<?php

declare(strict_types=1);

namespace RdKafka\FFIGen;

use Composer\Semver\Comparator;
use Klitsche\FFIGen\ConfigInterface;
use Symfony\Component\Filesystem\Filesystem;

class LibrdkafkaHeaderFiles
{
    private const RELEASE_URL = 'https://api.github.com/repos/confluentinc/librdkafka/releases';
    private const DOWNLOAD_BASE_URL_TEMPLATE = 'https://raw.githubusercontent.com/confluentinc/librdkafka/%s/src';


    private ConfigInterface $config;
    private ?array $supportedVersions;
    private Filesystem $filesystem;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->supportedVersions = null;
        $this->filesystem = new Filesystem();
    }

    public function prepareVersion(string $version): void
    {
        if (array_key_exists($version, $this->supportedVersions) === false) {
            throw new \InvalidArgumentException(sprintf('Version %s not supported', $version));
        }

        $baseUrl = $this->supportedVersions[$version];

        $headerFiles = $this->config->getHeaderFiles();

        // download header files and parse
        foreach ($headerFiles as $fileName) {
            $file = $this->config->getOutputPath() . '/' . $fileName;
            $this->filesystem->remove($file);

            if (file_exists($this->config->getOutputPath() . '/' . $version . '-' . $fileName)) {
                $content = @file_get_contents($this->config->getOutputPath() . '/' . $version . '-' . $fileName);
            } else {
                $url = $baseUrl . '/' . $fileName;
                echo "  Download {$url}" . PHP_EOL;

                $content = @file_get_contents($url);
                if ($content === false) {
                    echo '  Not found - skip' . PHP_EOL;
                    continue;
                }
                $this->filesystem->dumpFile($this->config->getOutputPath() . '/' . $version . '-' . $fileName, $content);
            }

            $content = $this->prepareFileContent($file, $content, $version);
            $this->filesystem->dumpFile($file, $content);

            echo "  Save as {$file}" . PHP_EOL;
        }
    }

    public function getSupportedVersions(): array
    {
        if ($this->supportedVersions === null) {
            $this->supportedVersions = $this->loadSupportedVersions();
        }
        return array_keys($this->supportedVersions);
    }

    private function loadSupportedVersions(): array
    {
        echo 'Load librdkafka releases ...';

        $content = file_get_contents(
            self::RELEASE_URL,
            false,
            stream_context_create(
                [
                    'http' => [
                        'header' => [
                            'Connection: close',
                            'Accept: application/json',
                            'User-Agent: php',
                        ],
                    ],
                ]
            )
        );

        $releases = \json_decode($content);

        $supportedVersions = [];
        foreach ($releases as $release) {
            if ($release->prerelease === false) {
                $version = str_replace('v', '', $release->tag_name);
                if (Comparator::greaterThanOrEqualTo($version, '1.0.0') && Comparator::lessThan($version, '2.1.0')) {
                    $supportedVersions[$version] = sprintf(
                        self::DOWNLOAD_BASE_URL_TEMPLATE,
                        $release->tag_name
                    );
                }
            }
        }
        asort($supportedVersions);

        echo ' found ' . count($supportedVersions) . PHP_EOL;
        print_r($supportedVersions);

        return $supportedVersions;
    }

    private function prepareFileContent(string $file, string $content, string $version): string
    {
        if (strpos($file, 'rdkafka.h') !== false) {
            // prefilter header file content - not supported by cparser
            $content = preg_replace_callback(
                '/static RD_INLINE.+?rd_kafka_message_errstr[^}]+?}/si',
                function ($matches) {
                    return '//' . str_replace("\n", "\n//", $matches[0]);
                },
                $content,
                1
            );
            $content = preg_replace_callback(
                '/(#define.+RD_.[\w_]+)\s+__attribute__.+/i',
                function ($matches) {
                    return '' . $matches[1];
                },
                $content
            );
            // filter rd_kafka_conf_set_open_cb - not supported by windows
            $content = preg_replace_callback(
                '/RD_EXPORT[\s\w\n]+?void.+?rd_kafka_conf_set_open_cb[^;]+?;/i',
                function ($matches) {
                    return '//' . str_replace("\n", "\n//", $matches[0]);
                },
                $content
            );
            // use typdef from rdkafka_error.h for KafkaError class
            $content = preg_replace_callback(
                '/typedef struct rd_kafka_error_s/i',
                function ($matches) {
                    return <<<CDEF
                    typedef struct rd_kafka_error_s {
                        unsigned int code;
                        char *errstr;
                        unsigned char fatal;
                        unsigned char retriable;
                        unsigned char txn_requires_abort;
                    }
                    CDEF;
                },
                $content
            );

            // #define RD_FORMAT(...) not supported by cparser
            $content = preg_replace_callback(
                '/(#define.+RD_FORMAT[^\n]+)/i',
                function ($matches) {
                    return '//' . $matches[1];
                },
                $content
            );
            $content = preg_replace_callback(
                '/(RD_FORMAT[^)]+\))/i',
                function ($matches) {
                    return '';
                },
                $content
            );

            // prepend
            $prepend = <<<CDEF
            typedef long int ssize_t;
            typedef struct _IO_FILE FILE;
            typedef long int mode_t;
            typedef signed int int16_t;
            typedef unsigned int uint16_t;
            typedef signed int int32_t;
            typedef signed long int int64_t;
            
            CDEF;
            $content = $prepend . $content;
        }

        return $content;
    }
}
