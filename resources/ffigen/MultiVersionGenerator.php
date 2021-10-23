<?php

declare(strict_types=1);

namespace RdKafka\FFIGen;

use Klitsche\FFIGen\ConfigInterface;
use Klitsche\FFIGen\Constant;
use Klitsche\FFIGen\ConstantsCollection;
use Klitsche\FFIGen\ConstantsCollector;
use Klitsche\FFIGen\ConstantsPrinter;
use Klitsche\FFIGen\DocBlockTag;
use Klitsche\FFIGen\GeneratorInterface;
use Klitsche\FFIGen\MethodsCollection;
use Klitsche\FFIGen\MethodsCollector;
use Klitsche\FFIGen\MethodsPrinter;
use Symfony\Component\Filesystem\Filesystem;

class MultiVersionGenerator implements GeneratorInterface
{
    private const TEMPLATE_CONST_VERSION = <<<PHPTMP
    <?php
    /**
     * This file is generated! Do not edit directly.
     *
     * Description of librdkafka methods and constants is extracted from the official documentation.
     * @link https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
     */
    
    declare(strict_types=1);
    
    // version specific constants
    {{constants}}
    
    PHPTMP;

    private const TEMPLATE_CONST_OVERALL = <<<PHPTMP
    <?php
    /**
     * This file is generated! Do not edit directly.
     *
     * Description of librdkafka methods and constants is extracted from the official documentation.
     * @link https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
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
    
    /**
     * Description of librdkafka methods and constants is extracted from the official documentation.
     * @link https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
     */
    trait Methods 
    {
        abstract public static function getFFI():\FFI;
        
    {{methods}}
    }

    PHPTMP;

    private array $overAllMethods;
    private array $supportedMethods;
    private array $allConstants;
    private LibrdkafkaDocumentation $documentation;
    private LibrdkafkaHeaderFiles $headerFiles;

    private Filesystem $filesystem;
    private ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->filesystem = new Filesystem();
        $this->overAllMethods = [];
        $this->supportedMethods = [];
        $this->allConstants = [];
        $this->documentation = new LibrdkafkaDocumentation();
        $this->headerFiles = new LibrdkafkaHeaderFiles($config);
    }

    public function generate(): void
    {
        $this->documentation->extract();

        foreach ($this->headerFiles->getSupportedVersions() as $version) {
            $this->headerFiles->prepareVersion($version);
            $this->parse($version);
        }

        echo 'Generate constants files' . PHP_EOL;
        $this->generateConstantsFiles();

        echo 'Generate methods trait files' . PHP_EOL;
        $this->generateMethodsTraitFile();

        echo 'Done.' . PHP_EOL;
    }

    private function parse(string $version): void
    {
        echo '  Parse ...' . PHP_EOL;
        $parser = new Parser($this->config);

        // collect constants
        $constantsCollector = new ConstantsCollector();
        $constants = $constantsCollector
            ->collect($parser->getDefines(), $parser->getTypes())
            ->filter($this->config->getExcludeConstants());
        $constants->add(new Constant('RD_KAFKA_CDEF', $parser->getCDef(), implode(', ', $this->config->getHeaderFiles())));

        // add to overall constants
        foreach ($constants as $name => $const) {
            $const->getDocBlock()->addTag(new DocBlockTag('since', $version . ' of librdkafka'));

            $this->documentation->enrich($const);
        }
        $this->allConstants[$version] = iterator_to_array($constants);

        // collect methods
        $methodsCollector = new MethodsCollector();
        $methods = $methodsCollector
            ->collect($parser->getTypes())
            ->filter($this->config->getExcludeMethods());

        // add to overall & supported methods
        foreach ($methods as $name => $method) {
            $method->getDocBlock()->addTag(new DocBlockTag('since', $version . ' of librdkafka'));
            $this->documentation->enrich($method);
            if (array_key_exists($name, $this->overAllMethods) === false) {
                $this->overAllMethods[$name] = $method;
                $this->supportedMethods[$name]['min'] = $version;
            }
            if (array_key_exists($name, $this->supportedMethods) === true) {
                $this->supportedMethods[$name]['max'] = $version;
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
