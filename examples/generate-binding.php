<?php

declare(strict_types=1);

/**
 * Generate librdkafka files for version specific constants, overall stable constants and methods trait
 * Supports librdkafka versions ^1.0.0
 *
 * Needs cleanup... but kind of works...
 *
 * (Windows is not supported)
 */

use Composer\Autoload\ClassLoader;
use Composer\Semver\Comparator;
use FFI\Generator\Constant_;
use FFI\Generator\ConstantsCollector;
use FFI\Generator\Method;
use FFI\Generator\MethodsCollector;
use FFI\Generator\TypeCompilerFactory;
use PHPCParser\Context;
use PHPCParser\CParser;

/** @var ClassLoader $composerLoader */
$composerLoader = require_once dirname(__DIR__) . '/vendor/autoload.php';
$composerLoader->addPsr4('FFI\\Generator\\', __DIR__ . '/Generator');

class MultiVersionGenerator
{
    private string $releasesUrl = 'https://api.github.com/repos/edenhill/librdkafka/releases';

    // prepend required included types before parsing (including header files - like feature.h - some syntax is not supported by cparser)
    private const FFI_CDEF_TYPES = <<<TYPES
        typedef long int ssize_t;
        struct _IO_FILE;
        typedef struct _IO_FILE FILE;
        typedef long int mode_t;
        typedef signed int int16_t;
        typedef signed int int32_t;
        typedef signed long int int64_t;
        TYPES;

    private const TEMPLATE_CONST_VERSION = <<<PHPTMP
    <?php
    /**
     * This file is generated! Do not edit directly.
     */
    
    declare(strict_types=1);
    
    // version specific constants
    %s
    
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
    %s
    
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
        
    %s
    }

    PHPTMP;

    private array $allConstants = [];
    private array $overAllMethods = [];

    public function generate()
    {
        $supportedVersions = $this->getSupportedVersions();
        echo "Found " . count($supportedVersions) . ' librdkafka releases' . PHP_EOL;
        print_r($supportedVersions);

        // download raw header files
        foreach ($supportedVersions as $version => $hFileUrl) {
            echo "Analyze header file for version $version" . PHP_EOL;
            $this->analyzeHeaderFile($version, $hFileUrl);
        }

        echo 'Generate const files' . PHP_EOL;
        $this->generateConstantsFiles();

        echo 'Generate methods trait files' . PHP_EOL;
        $this->generateMethodsTraitFile();

        echo 'Done.' . PHP_EOL;
    }

    private function getSupportedVersions()
    {
        $content = file_get_contents(
            $this->releasesUrl,
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
                        'https://raw.githubusercontent.com/edenhill/librdkafka/%s/src/rdkafka.h',
                        $release->tag_name
                    );
                }
            }
        }
        asort($supportedVersions);
        return $supportedVersions;
    }

    private function analyzeHeaderFile($version, $hFileUrl)
    {
        $hFileOrig = dirname(__DIR__) . '/resources/rdkafka.' . $version . '.orig.h';
        $hFileFiltered = dirname(__DIR__) . '/resources/rdkafka.' . $version . '.h';
        $hFileParsed = dirname(__DIR__) . '/resources/rdkafka.' . $version . '.parsed.h';

        echo "  Download ${hFileUrl}" . PHP_EOL;

        $hFileContent = file_get_contents($hFileUrl);
        file_put_contents($hFileOrig, $hFileContent);

        echo "  Save as ${hFileOrig}" . PHP_EOL;

        echo "  Filter ${hFileOrig}" . PHP_EOL;

        $hFileContentFiltered = $hFileContent;

        // clean up: comment out unused inline function rd_kafka_message_errstr (not supported by cparser)
        $hFileContentFiltered = preg_replace_callback(
            '/static RD_INLINE.+?rd_kafka_message_errstr[^}]+?}/si',
            function ($matches) {
                return '//' . str_replace("\n", "\n//", $matches[0]);
            },
            $hFileContentFiltered,
            1
        );

        // clean up: replace __attribute__ in #define RD_* __attribute(...)___ (not supported by cparser)
        $hFileContentFiltered = preg_replace_callback(
            '/(#define.+RD_.[\w_]+)\s+__attribute__.+/i',
            function ($matches) {
                return '' . $matches[1];
            },
            $hFileContentFiltered
        );

        // cleanup plugin & interceptor (syntax not supported by cparser after printing it with cparser)
        $hFileContentFiltered = preg_replace_callback(
            '/(typedef|RD_EXPORT)[^;]+?_(plugin|interceptor)_[^;]+?;/si',
            function ($matches) {
                return '//' . str_replace("\n", "\n//", $matches[0]);
            },
            $hFileContentFiltered
        );

        // clean up: not supported on windows
        $hFileContentFiltered = preg_replace_callback(
            '/(RD_EXPORT)[^;]+?(rd_kafka_log_syslog|rd_kafka_conf_set_open_cb)[^;]+?;/si',
            function ($matches) {
                return '//' . str_replace("\n", "\n//", $matches[0]);
            },
            $hFileContentFiltered
        );


        echo "  Save as ${hFileFiltered}" . PHP_EOL;

        file_put_contents($hFileFiltered, self::FFI_CDEF_TYPES . $hFileContentFiltered);

        echo "  Parse ${hFileFiltered}" . PHP_EOL;

        $context = new Context();
        // ignore includes
        $context->defineInt('_STDIO_H', 0);
        $context->defineInt('_INTTYPES_H', 0);
        $context->defineInt('_SYS_TYPES_H', 0);
        $context->defineInt('_SYS_SOCKET_H', 0);
        $parser = new CParser();
        $ast = $parser->parse($hFileFiltered, $context);
        $printer = new PHPCParser\Printer\C();
        $printer->omitConst = false; // ffi casts const char* to string | const integertypes to int

        echo "  Save as ${hFileParsed}" . PHP_EOL;

        $declarations = $ast->declarations;

        file_put_contents($hFileParsed, $printer->printNodes($declarations, 0)); //$printer->print($ast));

        $constantsCollector = new ConstantsCollector();
        $constantsCollector->collect($context, $ast);
        $consts = $constantsCollector->getAll();

        $methodCollector = new MethodsCollector(new TypeCompilerFactory());
        $methodCollector->collect($ast);
        $methods = $methodCollector->getAll();

        // add version specific supported methods
        $consts['RD_KAFKA_SUPPORTED_METHODS'] = new Constant_(
            'RD_KAFKA_SUPPORTED_METHODS',
            array_combine(array_keys($methods), array_keys($methods)),
            ''
        );
        // add version specific c header definition
        $consts['RD_KAFKA_CDEF'] = new Constant_(
            'RD_KAFKA_CDEF',
            "\n" . $printer->print($ast),
            ''
        );

        // add to overall methods
        foreach ($methods as $name => $method) {
            $method->addDocBlockTag('since', $version . ' of librdkafka');
            if (array_key_exists($name, $this->overAllMethods) === false) {
                $this->overAllMethods[$name] = $method;
            }
        }

        // add to overall consts
        foreach ($consts as $name => $const) {
            $const->addDocBlockTag('since', $version . ' of librdkafka');
        }
        $this->allConstants[$version] = $consts;
    }

    private function generateConstantsFiles()
    {
        $versionRelatedConstants = [];
        $overAllConstants = [];
        /** @var Constant_[] $constants */
        foreach ($this->allConstants as $version => $constants) {
            $versionRelatedConstants[$version] = [];
            foreach ($constants as $identifier => $const) {
                $different = false;
                /** @var Constant_[] $constantsB */
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

        foreach (array_keys($this->allConstants) as $version) {
            file_put_contents(
                dirname(__DIR__) . '/src/RdKafka/FFI/Versions/' . $version . '.php',
                sprintf(
                    self::TEMPLATE_CONST_VERSION,
                    implode(
                        "\n",
                        array_map(fn(Constant_ $constant) => $constant->getPhpCode(), $versionRelatedConstants[$version]),
                    )
                )
            );
        }

        file_put_contents(
            dirname(__DIR__) . '/src/constants.php',
            sprintf(
                self::TEMPLATE_CONST_OVERALL,
                implode(
                    "\n",
                    array_map(fn(Constant_ $constant) => $constant->getPhpCode(), $overAllConstants),
                )
            )
        );
    }

    private function generateMethodsTraitFile()
    {
        file_put_contents(
            dirname(__DIR__) . '/src/RdKafka/FFI/Methods.php',
            sprintf(
                self::TEMPLATE_METHODS,
                implode(
                    "\n",
                    array_map(fn(Method $method) => $method->getPhpCode('    '), $this->overAllMethods),
                )
            )
        );
    }
}

$generator = new MultiVersionGenerator();
$generator->generate();