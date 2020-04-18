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

    public function getCName(): string
    {
        return $this->type->getCName() . '[' . (string) $this->size . ']';
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