<?php

declare(strict_types=1);

namespace FFI\Generator;

use PHPCParser\Node\Decl\NamedDecl\ValueDecl\DeclaratorDecl\FunctionDecl;
use PHPCParser\Node\TranslationUnitDecl;

class MethodsCollector
{
    /**
     * @var TypeCompiler
     */
    private TypeCompiler $typeCompiler;
    /**
     * @var TypeCompilerFactory
     */
    private TypeCompilerFactory $typeCompilerFactory;

    /**
     * @var Method[]
     */
    private array $methods;

    public function __construct(TypeCompilerFactory $typeCompilerFactory)
    {
        $this->typeCompilerFactory = $typeCompilerFactory;
    }

    public function collect(TranslationUnitDecl $ast)
    {
        $this->typeCompiler = $this->typeCompilerFactory->create(...$ast->declarations);
        $this->methods = [];

        foreach ($ast->declarations as $declaration) {
            if ($declaration instanceof FunctionDecl) {
                $this->methods[$declaration->name] = $this->compileMethod($declaration);
            }
        }
    }

    private function compileMethod(FunctionDecl $declaration)
    {
        $returnParamType = $this->typeCompiler->compile($declaration->type->return);
        $returnParam = new Param($returnParamType, null, $returnParamType->getCName());
        $params = [];
        foreach ($declaration->type->params as $i => $type) {
            $paramType = $this->typeCompiler->compile($type);
            if ($paramType->getCName() === 'void') {
                break;
            }
            $params[] = new Param($paramType, $declaration->type->paramNames[$i] ?: 'arg' . ($i + 1), $paramType->getCName());
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