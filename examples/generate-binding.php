<?php

declare(strict_types=1);

/**
 * Generate FFIMe based bindings for all librdkafka versions ^1.0
 *
 * Just playing around ...
 *
 * (Windows is not supported)
 */

use PHPCParser\Context;
use PHPCParser\CParser;
use PHPCParser\PreProcessor\Token;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$supported = [
    '1.0.0' => 'https://raw.githubusercontent.com/edenhill/librdkafka/v1.0.0/src/rdkafka.h',
    '1.0.1' => 'https://raw.githubusercontent.com/edenhill/librdkafka/v1.0.1/src/rdkafka.h',
    '1.1.0' => 'https://raw.githubusercontent.com/edenhill/librdkafka/v1.1.0/src/rdkafka.h',
    '1.2.0' => 'https://raw.githubusercontent.com/edenhill/librdkafka/v1.2.0/src/rdkafka.h',
    '1.2.1' => 'https://raw.githubusercontent.com/edenhill/librdkafka/v1.2.1/src/rdkafka.h',
    '1.2.2' => 'https://raw.githubusercontent.com/edenhill/librdkafka/v1.2.2/src/rdkafka.h',
    '1.3.0' => 'https://raw.githubusercontent.com/edenhill/librdkafka/v1.3.0/src/rdkafka.h',
];

$ffiDefines = <<<FFI
        #define FFI_SCOPE "RDKAFKA"
        #define FFI_LIB "librdkafka.so"
        
        FFI;

// prepend required included types before parsing (including header files - like feature.h - some syntax is not supported by cparser)
$types = <<<TYPES
        typedef long int ssize_t;
        struct _IO_FILE;
        typedef struct _IO_FILE FILE;
        typedef long int mode_t;
        typedef signed int int16_t;
        typedef signed int int32_t;
        typedef signed long int int64_t;
        TYPES;

$overAllConsts = [];

// download raw header files
foreach ($supported as $version => $hFileUrl) {
    // prepare
    $versionName = str_replace('.', '', $version);
    $hFileOrig = dirname(__DIR__) . '/resources/rdkafka.' . $version . '.orig.h';
    $hFileFiltered = dirname(__DIR__) . '/resources/rdkafka.' . $version . '.h';
    $hFileParsed = dirname(__DIR__) . '/resources/rdkafka.' . $version . '.parsed.h';

    echo "Download ${hFileUrl}" . PHP_EOL;

    $hFileContent = file_get_contents($hFileUrl);
    file_put_contents($hFileOrig, $hFileContent);

    echo "Save as ${hFileOrig}" . PHP_EOL;

    echo "Filter ${hFileOrig}" . PHP_EOL;

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

    echo "Save as ${hFileFiltered}" . PHP_EOL;

    file_put_contents($hFileFiltered, $types . $hFileContentFiltered);

    echo "Parse ${hFileFiltered}" . PHP_EOL;

    $context = new Context();
    // ignore includes
    $context->defineInt('_STDIO_H', 0);
    $context->defineInt('_INTTYPES_H', 0);
    $context->defineInt('_SYS_TYPES_H', 0);
    $context->defineInt('_SYS_SOCKET_H', 0);
    $parser = new CParser();
    $ast = $parser->parse($hFileFiltered, $context);
    $printer = new PHPCParser\Printer\C();

    echo "Save as ${hFileParsed}" . PHP_EOL;

    file_put_contents($hFileParsed, $ffiDefines . $printer->print($ast));

    // extract const
    $consts = [];
    // add defines as const
    foreach ($context->getDefines() as $identifier => $token) {
        if (strpos($identifier, 'RD_KAFKA_') !== 0 || $identifier === 'RD_KAFKA_VERSION') {
            continue;
        }
        $value = '';
        $next = $token;
        $skip = false;
        do {
            if ($next instanceof Token && in_array($next->type, [Token::IDENTIFIER, Token::LITERAL], true)) {
                $skip = true;
                break;
            }
            if ($next instanceof Token && $next->type !== Token::WHITESPACE) {
                $value .= $next->value;
            }
        } while (($next = $next->next) !== null);
        if ($skip) {
            continue;
        }
        $consts[] = "    const ${identifier} = ${value};";
    }
    // add enums
    $compiler = new \FFIMe\Compiler();
    foreach ($ast->declarations as $declaration) {
        if ($declaration instanceof \PHPCParser\Node\Decl\NamedDecl\TypeDecl\TagDecl\EnumDecl ||
            ($declaration instanceof \PHPCParser\Node\Decl\NamedDecl\TypeDecl\TypedefNameDecl
                && $declaration->type instanceof \PHPCParser\Node\Type\TagType\EnumType)) {
            $consts = array_merge($consts, $compiler->compileDecl($declaration));
        }
    }
    // compact values and add lib version
    foreach ($consts as $i => $const) {
        $consts[$i] = preg_replace_callback(
            '/(.+?= )([0-9\-\+\(\)\s]+)(;)/',
            function ($matches) {
                $value = eval('return ' . $matches[2] . ';');
                return $matches[1] . $value . $matches[3];
            },
            $const
        );
    }
    file_put_contents(
        dirname(__DIR__) . '/resources/rdkafka.' . $version . '.const.php',
        '<?php' . "\n\n" . implode("\n", $consts)
    );
    // add to overall consts
    $overAllConsts[] = '// since librdkafka v' . $version;
    foreach ($consts as $const) {
        if (array_key_exists($const, $overAllConsts) === false) {
            $overAllConsts[$const] = $const;
        }
    }

    echo "Generate bindings RdKafka\\Binding\\LibRdKafkaV${versionName}" . PHP_EOL;

    (new FFIMe\FFIMe('librdkafka.so'))
        ->include($hFileParsed)
        ->codeGen(
            'RdKafka\\Binding\\LibRdKafka',
            dirname(__DIR__) . '/src/RdKafka/Binding/LibRdKafkaV' . $versionName . '.php'
        );

    echo 'Generate bindings done.' . PHP_EOL;
}

file_put_contents(
    dirname(__DIR__) . '/resources/constants.php',
    '<?php' . "\n\n" . implode("\n", $overAllConsts)
);
echo 'Generate overall const done.' . PHP_EOL;
