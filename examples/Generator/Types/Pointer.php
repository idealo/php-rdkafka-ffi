<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

use FFI\CData;

class Pointer extends CType
{
    protected Type $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function getCName(): string
    {
        return $this->type->getCName() . '*';
    }

    public function getPhpTypes(): string
    {
        if ($this->type->getCName() === 'void') {
            return ''; // CData, object, string, or null
        }
        return '?\\' . CData::class;
    }

    public function getPhpDocTypes(): string
    {
        if ($this->type->getCName() === 'void') {
            return '\\' . CData::class . '|object|string|null';
        }
        return '\\' . CData::class . '|null';
    }
}