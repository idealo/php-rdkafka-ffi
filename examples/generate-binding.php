<?php

declare(strict_types=1);

/**
 * Generate librdkafka files for version specific constants, overall stable constants and methods trait
 * Supports librdkafka versions ^1.0.0
 *
 * Needs lots of cleanup - quick & dirty right now... but kind of works...
 *
 * (Windows is not supported)
 */

use FFI\CData;
use PHPCParser\Context;
use PHPCParser\CParser;
use PHPCParser\Node\Decl\NamedDecl\ValueDecl\DeclaratorDecl\FunctionDecl;
use PHPCParser\Node\Type;
use PHPCParser\PreProcessor\Token;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class VersionRelatedConstGenerator
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

    private const CAST_TYPE_MAP = [
        'bool' => 'bool',
        'char' => 'int',
        'int' => 'int',
        'long' => 'int',
        'long long' => 'int',
        'long int' => 'int',
        'long long int' => 'int',
        'int8_t' => 'int',
        'uint8_t' => 'int',
        'int16_t' => 'int',
        'uint16_t' => 'int',
        'int32_t' => 'int',
        'uint32_t' => 'int',
        'int64_t' => 'int',
        'uint64_t' => 'int',
        'unsigned' => 'int',
        'unsigned char' => 'int',
        'unsigned int' => 'int',
        'unsigned long' => 'int',
        'unsigned long int' => 'int',
        'unsigned long long' => 'int',
        'unsigned long long int' => 'int',
        'size_t' => 'float',
        'float' => 'float',
        'double' => 'float',
        'long double' => 'float',
    ];

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
    private array $constTypes = [];
    private array $overAllMethods = [];
    private array $overAllMethodsTrait = [];

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
                if (\Composer\Semver\Comparator::greaterThanOrEqualTo($version, '1.0.0')) {
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

        echo "  Save as ${hFileParsed}" . PHP_EOL;

        file_put_contents($hFileParsed, $printer->print($ast));

        // prepare compiler
        $compiler = new \Compiler();
        $compiler->buildResolver($ast->declarations);

        // extract const
        $consts = [];
        // add defines as const
        foreach ($context->getDefines() as $identifier => $token) {
            // filter not supported identifieres
            if (strpos($identifier, 'RD_KAFKA_') !== 0
                || $identifier === 'RD_KAFKA_VERSION'
            ) {
                continue;
            }
            $value = '';
            $next = $token;
            $skip = false;
            do {
                if ($next instanceof Token && $next->type === Token::IDENTIFIER) {
                    // cast basic types, eg ((int32_t)-1) => ((int)-1)
                    if (array_key_exists($next->value, self::CAST_TYPE_MAP)) {
                        $value .= self::CAST_TYPE_MAP[$next->value];
                        continue;
                    }
                    $skip = true;
                    break;
                }
                if ($next instanceof Token && $next->type === Token::LITERAL) {
                    $skip = true;
                    break;
                }
                if ($next instanceof Token && $next->type !== Token::WHITESPACE) {
                    $value .= $next->value;
                    continue;
                }
            } while (($next = $next->next) !== null);
            if ($skip) {
                continue;
            }
            $consts[$identifier] = "const ${identifier} = ${value};";
        }

        // add enums
        $this->constTypes = [];
        foreach ($ast->declarations as $declaration) {
            if ($declaration instanceof \PHPCParser\Node\Decl\NamedDecl\TypeDecl\TagDecl\EnumDecl ||
                ($declaration instanceof \PHPCParser\Node\Decl\NamedDecl\TypeDecl\TypedefNameDecl
                    && $declaration->type instanceof \PHPCParser\Node\Type\TagType\EnumType)) {
                $enums = $compiler->compileDecl($declaration);
                foreach ($enums as $enum) {
                    if (preg_match('/const (\w+) =/', $enum, $matches)) {
                        $consts[$matches[1]] = $enum;
                        $this->constTypes[$matches[1]] = $declaration->name;
                    }
                }
            }
        }

        // compact values and add lib version
        foreach ($consts as $i => $const) {
            $const = trim($const);
            $const = preg_replace_callback(
                '/(.+?= )([^;]+)(;)/',
                function ($matches) {
                    try {
                        $value = eval('return ' . $matches[2] . ';');
                    } catch (ParseError $exception) {
                        $value = 'null';
                    }
                    return $matches[1] . $value . $matches[3];
                },
                $const
            );
            if ($const === null) {
                continue;
            }
            $consts[$i] = $const;
        }

        echo "  Generate @methods annotations and trait methods" . PHP_EOL;
        $methods = [];
        foreach ($ast->declarations as $declaration) {
            if ($declaration instanceof FunctionDecl) {
                $methods[$declaration->name] = $this->compileMethod($compiler, $declaration);
                if (array_key_exists($declaration->name, $this->overAllMethodsTrait) === false) {
                    $this->overAllMethodsTrait[$declaration->name] = $this->compileMethod($compiler, $declaration, false, $version);
                }
            }
        }
        // add to supported method const
        $constMethods = [];
        foreach (array_keys($methods) as $method) {
            $constMethods[] = sprintf("'%s' => '%s'", $method, $method);
        }

        $consts['RD_KAFKA_SUPPORTED_METHODS'] = "const RD_KAFKA_SUPPORTED_METHODS = [\n    " . implode(
                ",\n    ",
                $constMethods
            ) . ",\n];";
        $consts['RD_KAFKA_CDEF'] = "const RD_KAFKA_CDEF = <<<CDEF\n" . $printer->print($ast) . "CDEF;";

        file_put_contents(
            dirname(__DIR__) . '/resources/rdkafka.' . $version . '.methods.php',
            '<?php' . "\n\n/**\n * " . implode("\n * ", $methods) . "\n */\n"
        );

        // add to overall methods
        $this->overAllMethods[] = 'since librdkafka ' . $version;
        foreach ($methods as $name => $method) {
            if (array_key_exists($name, $this->overAllMethods) === false) {
                $this->overAllMethods[$name] = $method;
            }
        }

        // add to overall consts
        $this->allConstants[$version] = $consts;
    }

    private function generateConstantsFiles()
    {
        $versionRelatedConstants = [];
        $overAllConstants = [];
        foreach ($this->allConstants as $version => $constants) {
            $versionRelatedConstants[$version] = [];
            foreach ($constants as $identifier => $const) {
                $different = false;
                // comment?
                if (is_int($identifier)) {
                    $overAllConstants[$identifier] = $const;
                    $versionRelatedConstants[$version][$identifier] = $const;
                    continue;
                }
                foreach ($this->allConstants as $versionB => $constantsB) {
                    if ($version === $versionB) {
                        continue;
                    }
                    // identifier found and different?
                    if (array_key_exists($identifier, $constantsB) && $const !== $constantsB[$identifier]) {
                        $desc = '';
                        if (array_key_exists($identifier, $this->constTypes)) {
                            $desc = "/**\n * typedefenum " . $this->constTypes[$identifier] . "\n */\n";
                        }
                        $versionRelatedConstants[$version][$identifier] = $desc . $const;
                        $different = true;
                        break;
                    }
                }
                if ($different === false && array_key_exists($identifier, $overAllConstants) === false) {
                    $desc = '';
                    if (array_key_exists($identifier, $this->constTypes)) {
                        $desc = " * typedefenum " . $this->constTypes[$identifier] . "\n";
                    }
                    $overAllConstants[$identifier] = "/**\n$desc * @since $version of librdkafka\n */\n" . $const;
                }
            }
        }

        foreach (array_keys($this->allConstants) as $version) {
            file_put_contents(
                dirname(__DIR__) . '/src/RdKafka/FFI/Versions/' . $version . '.php',
                sprintf(self::TEMPLATE_CONST_VERSION, implode("\n", $versionRelatedConstants[$version]))
            );
        }

        file_put_contents(
            dirname(__DIR__) . '/src/constants.php',
            sprintf(self::TEMPLATE_CONST_OVERALL, implode("\n", $overAllConstants))
        );
    }

    private function generateMethodsTraitFile()
    {
        file_put_contents(
            dirname(__DIR__) . '/src/RdKafka/FFI/Methods.php',
            sprintf(self::TEMPLATE_METHODS, implode("\n\n", $this->overAllMethodsTrait))
        );
    }

    private function compileMethod(
        \Compiler $compiler,
        FunctionDecl $declaration,
        bool $annotionOnly = true,
        ?string $version = null
    ) {
        $nativeTypes = [
            'int',
            'float',
            'bool',
            'string',
            'array',
            'callable',
            'void',
        ];

        $returnType = $compiler->compileType($declaration->type->return);
        $origReturnType = $returnType;
        $returnTypeCode = $returnType;

        if ($returnType === 'void_ptr') {
            // void * could be CData|string(pointer to a immutable string)|null
            $returnType = '\\' . CData::class . '|string|null';
            $returnTypeCode = '';
        } elseif (preg_match('/_ptr$/', $returnType) || $returnType === 'string') {
            // pointer might be null
            $returnType = '\\' . CData::class . '|null';
            $returnTypeCode = '?\\' . CData::class;
        } elseif (in_array($returnType, $nativeTypes) === false) {
            $returnType = '\\' . CData::class;
            $returnTypeCode = '\\' . CData::class;
        } elseif ($returnType !== 'void') {
            $returnType = $returnType . '|null';
            $returnTypeCode = '?' . $returnTypeCode;
        }

        $params = $compiler->compileParameters($declaration->type->params);
        $paramSignature = [];
        $paramsTraitInternalSignature = [];
        $paramsTraitSignature = [];
        $paramsTraitSignatureAnnotation = [];
        foreach ($params as $idx => $type) {
            $name = $declaration->type->paramNames[$idx];
            $origName = $name;
            $origType = $type;
            $typeCode = $type;

            if ($type === 'void_ptr') {
                $type = '\\' . CData::class . '|string|null';
                $typeCode = '';
            } elseif (preg_match('/_ptr$/', $type)) {
                if (in_array(str_replace('_ptr', '', $type), $nativeTypes) === false) {
                    $name = $type;
                }
                $type = '\\' . CData::class . '|null';
                $typeCode = '?\\' . CData::class;
            } elseif (in_array($type, $nativeTypes) === false) {
                $name = $type;
                $type = '\\' . CData::class;
                $typeCode = '\\' . CData::class;
            } elseif ($type !== 'void') {
                $type = $type . '|null';
                $typeCode = '?' . $typeCode;
            }
            $origName = $origName ?: $name;
            $paramSignature[] = $type . ' $' . $name;
            $paramsTraitSignature[] = $typeCode . ' $' . $origName;
            $paramsTraitInternalSignature[] = '$' . $origName;
            $paramsTraitSignatureAnnotation[] = " * @param $type $$origName $origType";
        }

        // lets add generic variadic param
        if ($declaration->type->isVariadic === true) {
            $paramSignature[] = 'mixed ...$params';
            $paramsTraitSignature[] = '...$params';
            $paramsTraitInternalSignature[] = '...$params';
            $paramsTraitSignatureAnnotation[] = ' * @param mixed ...$params';
        }

        //@method setString(integer $integer)
        if ($annotionOnly) {
            $signature = sprintf(
                '@method static %s %s(%s)',
                $returnType,
                $declaration->name,
                implode(', ', $paramSignature)
            );
        } else {
            $signature = sprintf(
                <<<PHPTMP
                    /**
                     * @since %s of librdkafka%s%s
                     */
                    public static function %s(%s)%s 
                    {
                        %sstatic::getFFI()->%s(%s);
                    }
                PHPTMP,
                $version,
                empty($paramsTraitSignatureAnnotation)
                    ? ''
                    : "\n    " . implode("\n    ", $paramsTraitSignatureAnnotation),
                $returnType === 'void' ? '' : "\n     * @return " . $returnType . ($origReturnType !== $returnType ? ' ' . $origReturnType : ''),
                $declaration->name,
                implode(', ', $paramsTraitSignature),
                $returnTypeCode ? ': ' . $returnTypeCode : '',
                $returnTypeCode === 'void' ? '' : 'return ',
                $declaration->name,
                implode(', ', $paramsTraitInternalSignature)
            );
        }

        return $signature;
    }
}

// adds support for parentype and const char* vs char* handling
class Compiler extends \FFIMe\Compiler
{
    protected array $resolver;

    protected const INT_TYPES = [
        'bool',
        'char',
        'int',
        'long',
        'long long',
        'long int',
        'long long int',
        'int8_t',
        'uint8_t',
        'int16_t',
        'uint16_t',
        'int32_t',
        'uint32_t',
        'int64_t',
        'uint64_t',
        'unsigned',
        'unsigned char',
        'unsigned int',
        'unsigned long',
        'unsigned long int',
        'unsigned long long',
        'unsigned long long int',
        'size_t',
    ];

    protected const FLOAT_TYPES = [
        'float',
        'double',
        'long double',
    ];

    public function buildResolver(array $decls): array
    {
        $this->resolver = parent::buildResolver($decls);
        return $this->resolver;
    }

    public function compileType(Type $type): string
    {
        if ($type instanceof Type\TypedefType) {
            $name = $type->name;
            restart:
            if (in_array($name, self::INT_TYPES)) {
                return 'int';
            }
            if (in_array($name, self::FLOAT_TYPES)) {
                return 'float';
            }
            if (isset($this->resolver[$name])) {
                $name = $this->resolver[$name];
                goto restart;
            }
            return $name;
        } elseif ($type instanceof Type\BuiltinType && $type->name === 'void') {
            return 'void';
        } elseif ($type instanceof Type\BuiltinType && in_array($type->name, self::INT_TYPES)) {
            return 'int';
        } elseif ($type instanceof Type\BuiltinType && in_array($type->name, self::FLOAT_TYPES)) {
            return 'float';
        } elseif ($type instanceof Type\TagType\EnumType) {
            return 'int';
        } elseif ($type instanceof Type\PointerType) {
            // special case
            if ($type->parent instanceof Type\BuiltinType && $type->parent->name === 'char') {
                // it's a mutable string
                return 'string_ptr';
            } elseif ($type->parent instanceof Type\AttributedType && $type->parent->parent instanceof Type\BuiltinType && $type->parent->parent->name === 'char') {
                // const char* - it´s an immutable string
                return 'string';
            } elseif ($type->parent instanceof Type\FunctionType) {
                // it's function pointer
                return $this->compileType($type->parent);
            } elseif ($type->parent instanceof Type\ParenType) {
                return $this->compileType($type->parent);
            }
            return $this->compileType($type->parent) . '_ptr';
        } elseif ($type instanceof Type\AttributedType) {
            if ($type->kind === Type\AttributedType::KIND_CONST) {
                // special case const char* - it´s string
                if ($type->parent instanceof Type\PointerType && $type->parent->parent instanceof Type\BuiltinType && $type->parent->parent->name === 'char') {
                    return 'string';
                }
                // we can omit const from our compilation
                return $this->compileType($type->parent);
            } elseif ($type->kind === Type\AttributedType::KIND_EXTERN) {
                return $this->compileType($type->parent);
            }
        } elseif ($type instanceof Type\TagType\RecordType) {
            if ($type->decl->name !== null) {
                return $type->decl->name;
            }
        } elseif ($type instanceof Type\ArrayType\ConstantArrayType) {
            return 'array';
        } elseif ($type instanceof Type\ArrayType\IncompleteArrayType) {
            return 'array';
        } elseif ($type instanceof Type\FunctionType\FunctionProtoType) {
            return 'callable';
        } elseif ($type instanceof Type\ParenType) {
            return $this->compileType($type->parent);
        }
        var_dump($type);
        throw new \LogicException('Not implemented how to handle type yet: ' . get_class($type));
    }
}

$generator = new \VersionRelatedConstGenerator();
$generator->generate();