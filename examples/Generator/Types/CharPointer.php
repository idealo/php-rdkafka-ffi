<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

use FFI\CData;

/**
 * Handle string
 * - Immutable: char* = use CData
 * - Mutable: const char* = use php string
 */
class CharPointer extends Pointer
{
    public function getCName(): string
    {
        return $this->type->getCName();
    }

    public function getCType(string $ptr = ''): string
    {
        return $this->type->getCType($ptr . '*');
    }

    public function getPhpTypes(): string
    {
        if ($this->isConst()) {
            return '?string';
        }

        return '?\\' . CData::class;
    }

    public function getPhpDocTypes(): string
    {
        if ($this->isConst()) {
            return 'string|null';
        }

        return '\\' . CData::class . '|null';
    }

    public function isConst(): bool
    {
        // Note: CParser handles const char * differently - so we have to look at both here
        // function return:  pointer > const attribute > char
        // param: const attribute > pointer > char
        return parent::isConst() || $this->type->isConst();
    }
}