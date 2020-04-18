<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

class FunctionPointer extends Pointer
{
    public function __construct(Function_ $type)
    {
        parent::__construct($type);
    }

    public function getCName(): string
    {
        return $this->type->getCName() . '*';
    }

    public function getPhpTypes(): string
    {
        return $this->getPhpTypes();
    }

    public function getPhpDocTypes(): string
    {
        return $this->getPhpDocTypes();
    }
}