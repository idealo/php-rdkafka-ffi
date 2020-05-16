<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

class FunctionPointer extends Pointer
{
    public function __construct(Function_ $type)
    {
        parent::__construct($type);
    }

    public function getCType(string $ptr = ''): string
    {
        return $this->type->getCType($ptr . '*');
    }

    public function getPhpTypes(): string
    {
        return $this->type->getPhpTypes();
    }

    public function getPhpDocTypes(): string
    {
        return $this->type->getPhpDocTypes();
    }
}