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
use Klitsche\FFIGen\ParserInterface;
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
    private ParserInterface $parser;

    public function __construct(ConfigInterface $config, ParserInterface $parser)
    {
        $this->config = $config;
        $this->parser = $parser;
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
            $url = $baseUrl . '/' . $fileName;
            echo "  Download ${url}" . PHP_EOL;

            $content = @file_get_contents($url);
            if ($content === false) {
                echo '  Not found - skip' . PHP_EOL;
                continue;
            }
            $this->filesystem->dumpFile($file, $content);

            echo "  Save as ${file}" . PHP_EOL;
        }

        echo '  Parse ...' . PHP_EOL;

        // reset parser state
        $this->parser = new Parser($this->config);

        // collect constants
        $constantsCollector = new ConstantsCollector();
        $constants = $constantsCollector
            ->collect($this->parser->getDefines(), $this->parser->getTypes())
            ->filter($this->config->getExcludeConstants());
        $constants->add(new Constant('RD_KAFKA_CDEF', $this->parser->getCDef(), implode(', ', $this->config->getHeaderFiles())));

        // add to overall consts
        foreach ($constants as $name => $const) {
            $const->addDocBlockTag('since', $version . ' of librdkafka');
        }
        $this->allConstants[$version] = iterator_to_array($constants);

        // collect methods
        $methodsCollector = new MethodsCollector();
        $methods = $methodsCollector
            ->collect($this->parser->getTypes())
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
}
