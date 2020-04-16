<?php

declare(strict_types=1);

namespace FFI\Generator;

use FFI\CData;
use LogicException;
use PHPCParser\Node\Decl;
use PHPCParser\Node\TranslationUnitDecl;
use PHPCParser\Node\Type;

class MethodsCollector
{
    private const NATIVE_TYPES = [
        'int',
        'float',
        'bool',
        'string',
        'array',
        'callable',
        'void',
    ];

    private const INT_TYPES = [
        'bool',
        'char',
        'int',
        'long',
        'long long',
        'long int',
        'long long int',
        'int8_t',
        'uint8_t',
        'int16_t',
        'uint16_t',
        'int32_t',
        'uint32_t',
        'int64_t',
        'uint64_t',
        'unsigned',
        'unsigned char',
        'unsigned int',
        'unsigned long',
        'unsigned long int',
        'unsigned long long',
        'unsigned long long int',
        'size_t',
    ];

    private const FLOAT_TYPES = [
        'float',
        'double',
        'long double',
    ];

    private array $methods;
    private array $resolver;

    public function __construct()
    {
    }

    public function collect(TranslationUnitDecl $ast)
    {
        $this->methods = [];
        $this->resolver = $this->buildResolver($ast->declarations);

        foreach ($ast->declarations as $declaration) {
            if ($declaration instanceof Decl\NamedDecl\ValueDecl\DeclaratorDecl\FunctionDecl) {
                $this->methods[$declaration->name] = $this->compileMethod($declaration);
            }
        }
    }

    /**
     * @return Method[]
     */
    public function getAll(): array
    {
        return $this->methods;
    }

    private function resolveType(Type $type, ?string $name = null)
    {
        $resolvedType = $this->compileType($type);

        if ($name === '') {
            $name = $resolvedType;
        }

        if ($resolvedType === 'void_ptr') {
            // void * could be CData|string(pointer to a immutable string)|null
            return new Param(['\\' . CData::class, 'string', 'null'], $name, $resolvedType);
        } elseif (preg_match('/_ptr$/', $resolvedType)) {
            // pointer might be null
            return new Param(['\\' . CData::class, 'null'], $name, $resolvedType);
        } elseif (in_array($resolvedType, self::NATIVE_TYPES) === false) {
            return new Param(['\\' . CData::class], $name, $resolvedType);
        } elseif ($resolvedType !== 'void') {
            return new Param([$resolvedType, 'null'], $name, $resolvedType);
        }

        return new Param([$resolvedType], $name, '');
    }

    private function compileMethod(
        Decl\NamedDecl\ValueDecl\DeclaratorDecl\FunctionDecl $declaration
    ) {
        $returnParam = $this->resolveType($declaration->type->return);
        $params = [];
        foreach ($declaration->type->params as $i => $type) {
            if ($type instanceof Type\BuiltinType && $type->name === 'void') {
                break;
            }
            $params[] = $this->resolveType($type, $declaration->type->paramNames[$i] ?: '');
        }

        // lets add generic variadic param
        // todo: resolve argument name conflict
        if ($declaration->type->isVariadic === true) {
            $params[] = new Param([], 'args', '', true);
        }

        return new Method($declaration->name, $params, $returnParam, '');
    }

    // FFIMe Compiler
    public function compileType(Type $type): string
    {
        if ($type instanceof Type\TypedefType) {
            $name = $type->name;
            restart:
            if (in_array($name, self::INT_TYPES)) {
                return 'int';
            }
            if (in_array($name, self::FLOAT_TYPES)) {
                return 'float';
            }
            if (isset($this->resolver[$name])) {
                $name = $this->resolver[$name];
                goto restart;
            }
            return $name;
        } elseif ($type instanceof Type\BuiltinType && $type->name === 'void') {
            return 'void';
        } elseif ($type instanceof Type\BuiltinType && in_array($type->name, self::INT_TYPES)) {
            return 'int';
        } elseif ($type instanceof Type\BuiltinType && in_array($type->name, self::FLOAT_TYPES)) {
            return 'float';
        } elseif ($type instanceof Type\TagType\EnumType) {
            return 'int';
        } elseif ($type instanceof Type\PointerType) {
            // special case
            if ($type->parent instanceof Type\BuiltinType && $type->parent->name === 'char') {
                // it's a mutable string
                return 'string_ptr';
            } elseif ($type->parent instanceof Type\AttributedType
                && $type->parent->kind === Type\AttributedType::KIND_CONST
                && $type->parent->parent instanceof Type\BuiltinType
                && $type->parent->parent->name === 'char') {
                // const char* - it´s an immutable string
                return 'string';
            } elseif ($type->parent instanceof Type\FunctionType) {
                // it's function pointer
                return $this->compileType($type->parent);
            } elseif ($type->parent instanceof Type\ParenType) {
                return $this->compileType($type->parent);
            }
            return $this->compileType($type->parent) . '_ptr';
        } elseif ($type instanceof Type\AttributedType) {
            if ($type->kind === Type\AttributedType::KIND_CONST) {
                // special case const char* - it´s string
                if ($type->parent instanceof Type\PointerType && $type->parent->parent instanceof Type\BuiltinType && $type->parent->parent->name === 'char') {
                    return 'string';
                }
                // we can omit const from our compilation
                return $this->compileType($type->parent);
            } elseif ($type->kind === Type\AttributedType::KIND_EXTERN) {
                return $this->compileType($type->parent);
            }
        } elseif ($type instanceof Type\TagType\RecordType) {
            if ($type->decl->name !== null) {
                return $type->decl->name;
            }
        } elseif ($type instanceof Type\ArrayType\ConstantArrayType) {
            return 'array';
        } elseif ($type instanceof Type\ArrayType\IncompleteArrayType) {
            return 'array';
        } elseif ($type instanceof Type\FunctionType\FunctionProtoType) {
            return 'callable';
        } elseif ($type instanceof Type\ParenType) {
            return $this->compileType($type->parent);
        }
        var_dump($type);
        throw new LogicException('Not implemented how to handle type yet: ' . get_class($type));
    }

    // FFIMe Compiler
    protected function buildResolver(array $decls): array
    {
        $toLookup = [];
        $result = [];
        foreach ($decls as $decl) {
            if ($decl instanceof Decl\NamedDecl\TypeDecl\TypedefNameDecl\TypedefDecl) {
                if ($decl->type instanceof Type\TypedefType) {
                    $toLookup[] = [$decl->name, $decl->type->name];
                } elseif ($decl->type instanceof Type\BuiltinType) {
                    $result[$decl->name] = $decl->type->name;
                } elseif ($decl->type instanceof Type\TagType\EnumType) {
                    $result[$decl->name] = 'int';
                }
            }
        }
        /**
         * This resolves chained typedefs. For example:
         * typedef int A;
         * typedef A B;
         * typedef B C;
         *
         * This will resolve C=>int, B=>int, A=>int
         *
         * It runs a maximum of 50 times (to prevent things that shouldn't be possible, like circular references)
         */
        $runs = 50;
        while ($runs-- > 0 && !empty($toLookup)) {
            $toRemove = [];
            for ($i = 0, $n = count($toLookup); $i < $n; $i++) {
                [$name, $ref] = $toLookup[$i];

                if (isset($result[$ref])) {
                    $result[$name] = $result[$ref];
                    $toRemove[] = $i;
                }
            }
            foreach ($toRemove as $index) {
                unset($toLookup[$index]);
            }
            if (empty($toRemove)) {
                // We removed nothing, so don't bother rerunning
                break;
            } else {
                $toLookup = array_values($toLookup);
            }
        }
        return $result;
    }
}