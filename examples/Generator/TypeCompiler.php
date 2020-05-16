<?php

declare(strict_types=1);

namespace FFI\Generator;

use FFI\Generator\Types\Array_;
use FFI\Generator\Types\CharPointer;
use FFI\Generator\Types\CType;
use FFI\Generator\Types\Function_;
use FFI\Generator\Types\FunctionPointer;
use FFI\Generator\Types\BuiltinType;
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
        print_r($this->resolver);
        $this->collect(...$declarations);

        print_r($this->types);
        print_r($this->typeDefs);
        exit();
    }

    // collect all types first

    /**
     * @var Type[]
     */
    private array $types;
    /**
     * @var Type[]
     */
    private array $typeDefs;

    // TODO: clean up resolver, what about built in types? what about enums (out of scope here > const?
    public function collect(Decl ...$declarations)
    {
        /*
// resolved types
[ssize_t] => long int
[mode_t] => long int
[int16_t] => signed int
[int32_t] => signed int
[int64_t] => signed long int
[rd_kafka_type_t] => int
[rd_kafka_timestamp_type_t] => int
[rd_kafka_resp_err_t] => int
[rd_kafka_vtype_t] => int
[rd_kafka_msg_status_t] => int
[rd_kafka_conf_res_t] => int
[rd_kafka_event_type_t] => int
[rd_kafka_admin_op_t] => int
[rd_kafka_ConfigSource_t] => int
[rd_kafka_ResourceType_t] => int
         */
        foreach ($declarations as $decl) {
            if ($decl instanceof Decl\NamedDecl\TypeDecl\TypedefNameDecl\TypedefDecl) {
                $type = $this->compile($decl->type); //, $decl->name);
                $this->types[$type->getCName()] = $type;
                $this->typeDefs[$decl->name] = $type;
//                if ($decl->type instanceof Type\TypedefType) {
//                    $this->types[$decl->name] = $type;
//                } elseif ($decl->type instanceof Type\BuiltinType) {
//                    $this->types[$type->getCName()] = $type;
//                } elseif ($decl->type instanceof Type\TagType\EnumType) {
////                    $result[$decl->name] = 'int';
//                }
            }
        }
//        print_r($this->types);
//        exit();
    }

    public function resolveType(Type $type):?Types\Type
    {
        if (isset($this->types[$type->decl->name])){
            return $this->types[$type->decl->name];
        }
        if (isset($this->typeDefs[$type->decl->name])){
            print_r($type->decl->name);
            return $this->typeDefs[$type->decl->name];
        }

        return null;
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

    // todo: what about functionproto & name?
    // todo: cleanup resolver based mapping
    public function compile(Type $type): Types\Type
    {
        if ($type instanceof Type\TypedefType) {
            $name = $type->name;
//            restart:
            if (BuiltinType::isMappable($name)) {
                return new BuiltinType($name);
            }
//            if (isset($this->types[$name])){
//                return $this->types[$name];
//            }
            if (isset($this->typeDefs[$name])){
                return $this->typeDefs[$name];
            }
//            if (isset($this->resolver[$name])) {
//                $name = $this->resolver[$name];
//                goto restart;
//            }
            return new CType($name);
        } elseif ($type instanceof Type\BuiltinType && BuiltinType::isMappable($type->name)) {
            return new BuiltinType($type->name); //  void, int, float
        } elseif ($type instanceof Type\TagType\EnumType) {
            return new BuiltinType('int'); // int
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
                return new BuiltinType('char*'); // string
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
                    return new BuiltinType('char*'); // string
                }
                // we can omit const from our compilation
                return $this->compile($type->parent);
            } elseif ($type->kind === Type\AttributedType::KIND_EXTERN) {
                return $this->compile($type->parent);
            }
        } elseif ($type instanceof Type\TagType\RecordType) {

            if (isset($this->types[$type->decl->name])){
                print_r($type->decl->name);
                return $this->types[$type->decl->name];
            }
            if (isset($this->typeDefs[$type->decl->name])){
                print_r($type->decl->name);
                return $this->typeDefs[$type->decl->name];
            }
//            if (empty($type->decl->fields)) {
//                print_r($type);
//                exit();
//            }
            if ($type->decl->name !== null) {
                $struct = new Struct(
                    $type->decl->name,
                    $type->decl->kind === Decl\NamedDecl\TypeDecl\TagDecl\RecordDecl::KIND_UNION
                );
                foreach ((array) $type->decl->fields as $field) {
                    $struct->add($field->name, $this->compile($field->type));
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