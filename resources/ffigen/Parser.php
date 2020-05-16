<?php

declare(strict_types=1);

namespace RdKafka\FFIGen;

use Klitsche\FFIGen\Config;
use RuntimeException;

class Parser extends \Klitsche\FFIGen\Adapter\PHPCParser\Parser
{
    public function __construct(Config $config)
    {
        parent::__construct($config);

        $this->context->defineInt('_STDIO_H', 0);
        $this->context->defineInt('_INTTYPES_H', 0);
        $this->context->defineInt('_SYS_TYPES_H', 0);
        $this->context->defineInt('_SYS_SOCKET_H', 0);
    }

    protected function parseHeaderFile(string $file): array
    {
        if (strpos($file, 'rdkafka.h') === false) {
            return parent::parseHeaderFile($file);
        }

        $file = $this->searchHeaderFilePath($file);

        // prefilter header file content - not supported by cparser
        $tmpFileContent = file_get_contents($file);
        $tmpFileContent = preg_replace_callback(
            '/static RD_INLINE.+?rd_kafka_message_errstr[^}]+?}/si',
            function ($matches) {
                return '//' . str_replace("\n", "\n//", $matches[0]);
            },
            $tmpFileContent,
            1
        );
        $tmpFileContent = preg_replace_callback(
            '/(#define.+RD_.[\w_]+)\s+__attribute__.+/i',
            function ($matches) {
                return '' . $matches[1];
            },
            $tmpFileContent
        );

        $prependHeaderFile = <<<CDEF
        typedef long int ssize_t;
        typedef struct _IO_FILE FILE;
        typedef long int mode_t;
        typedef signed int int16_t;
        typedef signed int int32_t;
        typedef signed long int int64_t;
        
        CDEF;

        $tmpfile = tempnam(sys_get_temp_dir(), 'ffigen');
        file_put_contents($tmpfile, $prependHeaderFile . $tmpFileContent);

        try {
            $declarations = parent::parseHeaderFile($tmpfile);
        } finally {
            unlink($tmpfile);
        }

        return $declarations;
    }

    private function searchHeaderFilePath(string $file): string
    {
        if (file_exists($file)) {
            return $file;
        }
        foreach ($this->context->headerSearchPaths as $headerSearchPath) {
            if (file_exists($headerSearchPath . '/' . $file)) {
                return $headerSearchPath . '/' . $file;
            }
        }

        throw new RuntimeException(sprintf('File not found: %s', $file));
    }
}
