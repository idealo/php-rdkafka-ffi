<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

class CType extends Type
{
    private string $cName;

    public function __construct(string $cName)
    {
        $this->cName = $cName;
    }

    public function getCName(): string
    {
        return $this->cName;
    }

    public function getCType(string $ptr = ''): string
    {
        return ($this->const ? 'const ' : '') . $this->getName() . $ptr;
    }

    public function getPhpTypes(): string
    {
        return 'object';
    }

    public function getPhpDocTypes(): string
    {
        return 'object';
    }
}