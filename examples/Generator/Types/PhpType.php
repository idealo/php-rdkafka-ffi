<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

use Exception;

class PhpType extends Type
{
    private const CTYPE_MAP = [
        'bool' => 'int',
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
        'size_t' => 'int',
        'float' => 'float',
        'double' => 'float',
        'long double' => 'float',
        'char*' => 'string', // immutable string: const char*
        'void' => 'void', // return type only
    ];

    /**
     * @var string
     */
    private string $name;
    private string $cName;

    public function __construct(string $cName)
    {
        if (self::isMappable($cName) === false) {
            throw new Exception(sprintf('Cannot map ctype %s to native php type', $cName));
        }
        $this->cName = $cName;
        $this->name = self::CTYPE_MAP[$cName];
    }

    public static function isMappable(string $cName): bool
    {
        return isset(self::CTYPE_MAP[$cName]);
    }

    public static function map(string $cName): ?string
    {
        return self::CTYPE_MAP[$cName] ?? null;
    }

    public function getCName(): string
    {
        return $this->cName;
    }

    public function getPhpTypes(): string
    {
        if ($this->cName === 'void') {
            return $this->name;
        }
        return '?' . $this->name;
    }

    public function getPhpDocTypes(): string
    {
        if ($this->cName === 'void') {
            return $this->name;
        }
        return $this->name . '|null';
    }
}