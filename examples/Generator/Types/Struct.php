<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

use FFI\CData;

class Struct extends CType
{
    private array $layout;
    private bool $isUnion;
    private string $name;

    public function __construct(string $name, bool $isUnion)
    {
        $this->name = $name;
        $this->isUnion = $isUnion;
        $this->layout = [];
    }

    public function getCName(): string
    {
        return $this->name;
    }

    public function getPhpTypes(): string
    {
        return '?\\' . CData::class;
    }

    public function getPhpDocTypes(): string
    {
        return '\\' . CData::class . '|null';
    }

    public function add(string $name, Type $type)
    {
        $this->layout[$name] = $type;
    }

    public function isUnion(): bool
    {
        return $this->isUnion;
    }
}