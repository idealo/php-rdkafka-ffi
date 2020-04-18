<?php

declare(strict_types=1);

namespace FFI\Generator;

use FFI\Generator\Types\Array_;
use FFI\Generator\Types\CharPointer;
use FFI\Generator\Types\CType;
use FFI\Generator\Types\Function_;
use FFI\Generator\Types\FunctionPointer;
use FFI\Generator\Types\PhpType;
use FFI\Generator\Types\Pointer;
use FFI\Generator\Types\Struct;
use PHPCParser\Node\Decl;
use PHPCParser\Node\Type;

/**
 * Based on FFIMe
 * @see https://github.com/ircmaxell/ffime
 * @license https://github.com/ircmaxell/FFIMe/blob/master/LICENSE
 */
class TypeCompiler
{
    private array $resolver;

    public function __construct(Decl ...$declarations)
    {
        $this->resolver = $this->buildResolver(...$declarations);
    }

    private function buildResolver(Decl ...$declarations): array
    {
        $toLookup = [];
        $result = [];
        foreach ($declarations as $decl) {
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

    public function compile(Type $type): Types\Type
    {
        if ($type instanceof Type\TypedefType) {
            $name = $type->name;
            restart:
            if (PhpType::isMappable($name)) {
                return new PhpType($name);
            }
            if (isset($this->resolver[$name])) {
                $name = $this->resolver[$name];
                goto restart;
            }
            return new CType($name);
        } elseif ($type instanceof Type\BuiltinType && PhpType::isMappable($type->name)) {
            return new PhpType($type->name); //  void, int, float
        } elseif ($type instanceof Type\TagType\EnumType) {
            return new PhpType('int'); // int
        } elseif ($type instanceof Type\PointerType) {
            // special case
            if ($type->parent instanceof Type\BuiltinType && $type->parent->name === 'char') {
                // it's a mutable string
                return new CharPointer();
            } elseif ($type->parent instanceof Type\AttributedType
                && $type->parent->kind === Type\AttributedType::KIND_CONST
                && $type->parent->parent instanceof Type\BuiltinType
                && $type->parent->parent->name === 'char') {
                // const char* - it´s an immutable string
                return new PhpType('char*'); // string
            } elseif ($type->parent instanceof Type\FunctionType) {
                // it's function pointer
                /** @var Function_ $pointer */
                $pointer = $this->compile($type->parent);
                return new FunctionPointer($pointer);
            } elseif ($type->parent instanceof Type\ParenType) {
                return $this->compile($type->parent);
            }
            return new Pointer($this->compile($type->parent));
        } elseif ($type instanceof Type\AttributedType) {
            if ($type->kind === Type\AttributedType::KIND_CONST) {
                // special case const char* - it´s string
                if ($type->parent instanceof Type\PointerType && $type->parent->parent instanceof Type\BuiltinType && $type->parent->parent->name === 'char') {
                    return new PhpType('char*'); // string
                }
                // we can omit const from our compilation
                return $this->compile($type->parent);
            } elseif ($type->kind === Type\AttributedType::KIND_EXTERN) {
                return $this->compile($type->parent);
            }
        } elseif ($type instanceof Type\TagType\RecordType) {
            if ($type->decl->name !== null) {
                $struct = new Struct(
                    $type->decl->name,
                    $type->decl->kind === Decl\NamedDecl\TypeDecl\TagDecl\RecordDecl::KIND_UNION
                );
                foreach ((array) $type->decl->fields as $field) {
                    $struct->add($field->name, $this->compile($field));
                }
                return $struct;
            }
        } elseif ($type instanceof Type\ArrayType\ConstantArrayType) {
            return new Array_($this->compile($type->parent), (int) $type->size->value);
        } elseif ($type instanceof Type\ArrayType\IncompleteArrayType) {
            return new Array_($this->compile($type->parent));
        } elseif ($type instanceof Type\FunctionType\FunctionProtoType) {
            $params = [];
            foreach ($type->params as $i => $param) {
                $paramType = $this->compile($param);
                $params[$type->paramNames[$i] ?? 'arg' . $i] = $paramType;
            }
            return new Function_(
                $this->compile($type->return),
                $params,
                $type->isVariadic
            );
        } elseif ($type instanceof Type\ParenType) {
            return $this->compile($type->parent);
        }
        var_dump($type);
        throw new LogicException('Not implemented how to handle type yet: ' . get_class($type));
    }
}