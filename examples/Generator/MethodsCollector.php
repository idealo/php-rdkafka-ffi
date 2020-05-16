<?php

declare(strict_types=1);

namespace FFI\Generator;

use PHPCParser\Node\Decl\NamedDecl\ValueDecl\DeclaratorDecl\FunctionDecl;
use PHPCParser\Node\TranslationUnitDecl;

class MethodsCollector
{
    private TypesCollector $typesCollector;
    /**
     * @var Method[]
     */
    private array $methods;

    public function __construct(TypesCollector $typesCollector)
    {
        $this->typesCollector = $typesCollector;
    }

    public function collect(TranslationUnitDecl $ast)
    {
        $this->methods = [];

        foreach ($ast->declarations as $declaration) {
            if ($declaration instanceof FunctionDecl) {
                $this->methods[$declaration->name] = $this->compileMethod($declaration);
            }
        }
    }

    private function compileMethod(FunctionDecl $declaration)
    {
        $returnParamType = $this->typesCollector->compileType($declaration->type->return);
        $returnParam = new Param($returnParamType, null, $returnParamType->getCType());

        $params = [];
        foreach ($declaration->type->params as $i => $type) {
            $paramType = $this->typesCollector->compileType($type);
            if ($i === 0 && $paramType->getCName() === 'void') {
                break;
            }
            $params[] = new Param($paramType, $declaration->type->paramNames[$i] ?: 'arg' . ($i + 1), $paramType->getCType());
        }

        if ($declaration->type->isVariadic === true) {
            $params[] = new Param(null, 'args', '', true);
        }

        return new Method($declaration->name, $params, $returnParam, '');
    }

    /**
     * @return Method[]
     */
    public function getAll(): array
    {
        return $this->methods;
    }
}