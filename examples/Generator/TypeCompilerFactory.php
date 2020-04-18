<?php

declare(strict_types=1);

namespace FFI\Generator;

use PHPCParser\Node\Decl;

class TypeCompilerFactory
{
    public function create(Decl ...$declarations)
    {
        return new TypeCompiler(...$declarations);
    }
}