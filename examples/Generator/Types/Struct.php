<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

use FFI\CData;

class Struct extends CType
{
    private array $layout;
    private bool $isUnion;

    public function __construct(string $cName, bool $isUnion)
    {
        parent::__construct($cName);
        $this->isUnion = $isUnion;
        $this->layout = [];
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