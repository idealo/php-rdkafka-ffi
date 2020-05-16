<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

use Exception;

// todo: or better PhpType
class BuiltinType extends Type
{
    private const MAP = [
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
        'signed' => 'int',
        'signed char' => 'int',
        'signed int' => 'int',
        'signed long' => 'int',
        'signed long int' => 'int',
        'signed long long' => 'int',
        'signed long long int' => 'int',
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
            throw new Exception(sprintf('Can not map ctype %s to native php type', $cName));
        }
        $this->cName = $cName;
        $this->name = self::MAP[$cName];
    }

    public static function isMappable(string $cName): bool
    {
        return isset(self::MAP[$cName]);
    }

    public static function map(string $cName): ?string
    {
        return self::MAP[$cName] ?? null;
    }

    public function getCName(): string
    {
        return $this->cName;
    }

    public function getCType(string $ptr = ''): string
    {
        return ($this->const ? 'const ' : '') . $this->getCName() . $ptr;
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