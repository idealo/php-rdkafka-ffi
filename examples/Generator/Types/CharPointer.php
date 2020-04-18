<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

/**
 * Immutable string: char*
 */
class CharPointer extends Pointer
{
    public function __construct()
    {
        parent::__construct(new CType('char'));
    }
}