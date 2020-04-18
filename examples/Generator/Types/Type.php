<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

abstract class Type
{
    abstract public function getCName(): string;

    abstract public function getPhpTypes(): string;

    abstract public function getPhpDocTypes(): string;
}