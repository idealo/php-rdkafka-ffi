<?php

declare(strict_types=1);

namespace FFI\Generator\Types;


class Array_ extends CType
{
    private Type $type;
    private ?int $size;

    public function __construct(Type $type, ?int $size = null)
    {
        $this->type = $type;
        $this->size = $size;
    }

    // array of numbers: int (* ptr)[5] = NULL; data type (*var name)[size of array];
    //  array to pointers: int *ptr[3]; int *var_name[array_size];
    public function getCType(string $ptr = ''): string
    {
        if ($ptr === '') {
            return $this->type->getCType() . '[' . (string) $this->size . ']';
        }
        return $ptr . '(' . $this->type->getCType() . ')' . '[' . (string) $this->size . ']';
    }

    public function getPhpTypes(): string
    {
        return 'array';
    }

    public function getPhpDocTypes(): string
    {
        return 'array';
    }
}