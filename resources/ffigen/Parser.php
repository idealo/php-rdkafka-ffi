<?php

declare(strict_types=1);

namespace RdKafka\FFIGen;

use Klitsche\FFIGen\ConfigInterface;
use RuntimeException;

class Parser extends \Klitsche\FFIGen\Adapter\PHPCParser\Parser
{
    public function __construct(ConfigInterface $config)
    {
        parent::__construct($config);

        $this->context->defineInt('_STDIO_H', 0);
        $this->context->defineInt('_INTTYPES_H', 0);
        $this->context->defineInt('_SYS_TYPES_H', 0);
        $this->context->defineInt('_SYS_SOCKET_H', 0);
    }

    protected function parseHeaderFile(string $file): array
    {
        if ($this->headerFilePathExists($file)) {
            $file = $this->searchHeaderFilePath($file);
            return parent::parseHeaderFile($file);
        }
        return [];
    }

    private function searchHeaderFilePath(string $file): ?string
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

    private function headerFilePathExists(string $file): bool
    {
        try {
            $this->searchHeaderFilePath($file);
        } catch (RuntimeException $exception) {
            return false;
        }
        return true;
    }
}
