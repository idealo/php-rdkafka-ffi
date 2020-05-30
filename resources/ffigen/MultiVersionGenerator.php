<?php

declare(strict_types=1);

namespace RdKafka\FFIGen;

use Composer\Semver\Comparator;
use Klitsche\FFIGen\ConfigInterface;
use Klitsche\FFIGen\Constant;
use Klitsche\FFIGen\ConstantsCollection;
use Klitsche\FFIGen\ConstantsCollector;
use Klitsche\FFIGen\ConstantsPrinter;
use Klitsche\FFIGen\GeneratorInterface;
use Klitsche\FFIGen\MethodsCollection;
use Klitsche\FFIGen\MethodsCollector;
use Klitsche\FFIGen\MethodsPrinter;
use Symfony\Component\Filesystem\Filesystem;

class MultiVersionGenerator implements GeneratorInterface
{
    private const RELEASE_URL = 'https://api.github.com/repos/edenhill/librdkafka/releases';

    private const TEMPLATE_CONST_VERSION = <<<PHPTMP
    <?php
    /**
     * This file is generated! Do not edit directly.
     */
    
    declare(strict_types=1);
    
    // version specific constants
    {{constants}}
    
    PHPTMP;

    private const TEMPLATE_CONST_OVERALL = <<<PHPTMP
    <?php
    /**
     * This file is generated! Do not edit directly.
     */
    
    declare(strict_types=1);
    
    // rdkafka ext constants
    const RD_KAFKA_LOG_PRINT = 100;
    const RD_KAFKA_LOG_SYSLOG = 101;
    const RD_KAFKA_LOG_SYSLOG_PRINT = 102;
    const RD_KAFKA_MSG_PARTITIONER_RANDOM = 2;
    const RD_KAFKA_MSG_PARTITIONER_CONSISTENT = 3;
    const RD_KAFKA_MSG_PARTITIONER_CONSISTENT_RANDOM = 4;
    const RD_KAFKA_MSG_PARTITIONER_MURMUR2 = 5;
    const RD_KAFKA_MSG_PARTITIONER_MURMUR2_RANDOM = 6;
    const RD_KAFKA_MSG_PARTITIONER_FNV1A = 7;
    const RD_KAFKA_MSG_PARTITIONER_FNV1A_RANDOM = 8;
    
    // librdkafka overall constants
    {{constants}}
    
    PHPTMP;

    private const TEMPLATE_METHODS = <<<PHPTMP
    <?php
    /**
     * This file is generated! Do not edit directly.
     */
    
    declare(strict_types=1);
    
    namespace RdKafka\FFI;
    
    trait Methods 
    {
        abstract public static function getFFI():\FFI;
        
    {{methods}}
    }

    PHPTMP;

    private array $overAllMethods;
    private array $supportedMethods;
    private array $allConstants;

    private Filesystem $filesystem;
    private ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->filesystem = new Filesystem();
        $this->overAllMethods = [];
        $this->supportedMethods = [];
        $this->allConstants = [];
    }

    public function generate(): void
    {
        $supportedVersions = $this->getSupportedVersions();
        echo 'Found ' . count($supportedVersions) . ' librdkafka releases' . PHP_EOL;
        print_r($supportedVersions);

        foreach ($supportedVersions as $version => $hFileUrl) {
            $this->parse($version, $hFileUrl);
        }

        echo 'Generate constants files' . PHP_EOL;
        $this->generateConstantsFiles();

        echo 'Generate methods trait files' . PHP_EOL;
        $this->generateMethodsTraitFile();

        echo 'Done.' . PHP_EOL;
    }

    private function getSupportedVersions()
    {
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

        $releases = json_decode($content);

        $supportedVersions = [];
        foreach ($releases as $release) {
            if ($release->prerelease === false) {
                $version = str_replace('v', '', $release->tag_name);
                if (Comparator::greaterThanOrEqualTo($version, '1.0.0')) {
                    $supportedVersions[$version] = sprintf(
                        'https://raw.githubusercontent.com/edenhill/librdkafka/%s/src',
                        $release->tag_name
                    );
                }
            }
        }
        asort($supportedVersions);
        return $supportedVersions;
    }

    private function parse(string $version, string $baseUrl): void
    {
        $headerFiles = $this->config->getHeaderFiles();

        // download header files and parse
        foreach ($headerFiles as $fileName) {
            $file = $this->config->getOutputPath() . '/' . $fileName;
            $this->filesystem->remove($file);

            $url = $baseUrl . '/' . $fileName;
            echo "  Download ${url}" . PHP_EOL;

            $content = @file_get_contents($url);
            if ($content === false) {
                echo '  Not found - skip' . PHP_EOL;
                continue;
            }

            $content = $this->prepareFileContent($file, $content, $version);
            $this->filesystem->dumpFile($file, $content);

            echo "  Save as ${file}" . PHP_EOL;
        }

        echo '  Parse ...' . PHP_EOL;
        $parser = new Parser($this->config);

        // collect constants
        $constantsCollector = new ConstantsCollector();
        $constants = $constantsCollector
            ->collect($parser->getDefines(), $parser->getTypes())
            ->filter($this->config->getExcludeConstants());
        $constants->add(new Constant('RD_KAFKA_CDEF', $parser->getCDef(), implode(', ', $this->config->getHeaderFiles())));

        // add to overall consts
        foreach ($constants as $name => $const) {
            $const->addDocBlockTag('since', $version . ' of librdkafka');
        }
        $this->allConstants[$version] = iterator_to_array($constants);

        // collect methods
        $methodsCollector = new MethodsCollector();
        $methods = $methodsCollector
            ->collect($parser->getTypes())
            ->filter($this->config->getExcludeMethods());

        // add to overall & supported methods
        foreach ($methods as $name => $method) {
            $method->addDocBlockTag('since', $version . ' of librdkafka');
            if (array_key_exists($name, $this->overAllMethods) === false) {
                $this->overAllMethods[$name] = $method;
                $this->supportedMethods[$name] = $version;
            }
            if (array_key_exists($name, $this->supportedMethods) === false) {
                $this->supportedMethods[$name] = $version;
            }
        }
    }

    private function generateConstantsFiles(): void
    {
        $versionRelatedConstants = [];
        $overAllConstants = [];
        /** @var Constant[] $constants */
        foreach ($this->allConstants as $version => $constants) {
            $versionRelatedConstants[$version] = [];
            foreach ($constants as $identifier => $const) {
                $different = false;
                /** @var Constant[] $constantsB */
                foreach ($this->allConstants as $versionB => $constantsB) {
                    if ($version === $versionB) {
                        continue;
                    }
                    // identifier found and different?
                    if (array_key_exists($identifier, $constantsB) && $const->getValue() !== $constantsB[$identifier]->getValue()) {
                        $versionRelatedConstants[$version][$identifier] = $const;
                        $different = true;
                        break;
                    }
                }
                if ($different === false && array_key_exists($identifier, $overAllConstants) === false) {
                    $overAllConstants[$identifier] = $const;
                }
            }
        }

        // add supported methods
        $overAllConstants[] = new Constant('RD_KAFKA_SUPPORTED_METHODS', $this->supportedMethods);

        // print version specific constants
        foreach ($versionRelatedConstants as $version => $constants) {
            $printer = new ConstantsPrinter(new ConstantsCollection(...array_values($constants)));
            $this->filesystem->dumpFile(
                dirname(__DIR__, 2) . '/src/RdKafka/FFI/Versions/' . $version . '.php',
                $printer->print('', self::TEMPLATE_CONST_VERSION)
            );
        }

        $printer = new ConstantsPrinter(new ConstantsCollection(...array_values($overAllConstants)));
        $this->filesystem->dumpFile(
            dirname(__DIR__, 2) . '/src/constants.php',
            $printer->print('', self::TEMPLATE_CONST_OVERALL)
        );
    }

    private function generateMethodsTraitFile(): void
    {
        $printer = new MethodsPrinter(new MethodsCollection(...array_values($this->overAllMethods)));
        $this->filesystem->dumpFile(
            dirname(__DIR__, 2) . '/src/RdKafka/FFI/Methods.php',
            $printer->print('', self::TEMPLATE_METHODS)
        );
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

            // prepend
            $prepend = <<<CDEF
            typedef long int ssize_t;
            typedef struct _IO_FILE FILE;
            typedef long int mode_t;
            typedef signed int int16_t;
            typedef signed int int32_t;
            typedef signed long int int64_t;
            
            CDEF;
            $content = $prepend . $content;
        }

        return $content;
    }
}
