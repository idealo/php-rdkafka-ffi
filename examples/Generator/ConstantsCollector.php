<?php

declare(strict_types=1);

namespace FFI\Generator;

use FFI\Generator\Types\BuiltinType;
use LogicException;
use ParseError;
use PHPCParser\Context;
use PHPCParser\Node\Decl;
use PHPCParser\Node\Stmt\ValueStmt\Expr;
use PHPCParser\Node\TranslationUnitDecl;
use PHPCParser\Node\Type;
use PHPCParser\PreProcessor\Token;
use RuntimeException;

class ConstantsCollector
{
    private array $constants = [];

    public function collect(Context $context, TranslationUnitDecl $ast)
    {
        $this->constant = [];

        $this->collectFromContext($context);
        $this->collectFromDeclarations(...$ast->declarations);
    }

    private function collectFromContext(Context $context)
    {
        foreach ($context->getDefines() as $identifier => $token) {
            $value = '';
            $next = $token;
            $skip = false;
            do {
                if ($next instanceof Token && $next->type === Token::IDENTIFIER) {
                    // cast basic types, eg ((int32_t)-1) => ((int)-1)
                    if ($mapped = BuiltinType::map($next->value)) {
                        $value .= $mapped;
                        continue;
                    }
                    $skip = true;
                    break;
                }
                if ($next instanceof Token && $next->type === Token::LITERAL) {
                    $skip = true;
                    break;
                }
                if ($next instanceof Token && $next->type !== Token::WHITESPACE) {
                    $value .= $next->value;
                    continue;
                }
            } while (($next = $next->next) !== null);
            if ($skip) {
                continue;
            }
            $value = $this->analyzeValue($value);
            if ($value !== null) {
                $this->constants[$identifier] = new Constant_($identifier, $value, '#define');
            }
        }
    }

    /**
     * @param string $value
     * @return string|int|array|float|null
     */
    private function analyzeValue(string $value)
    {
        try {
            $value = eval('return ' . trim($value) . ';');
        } catch (ParseError $exception) {
            $value = null;
        }

        return $value;
    }

    private function collectFromDeclarations(Decl ...$declarations)
    {
        foreach ($declarations as $declaration) {
            if ($declaration instanceof Decl\NamedDecl\TypeDecl\TagDecl\EnumDecl) {
                $this->collectFromEnumDeclarationFields($declaration->fields ?? [], "enum {$declaration->name}");
            } elseif ($declaration instanceof Decl\NamedDecl\TypeDecl\TypedefNameDecl && $declaration->type instanceof Type\TagType\EnumType) {
                $this->collectFromEnumDeclarationFields($declaration->type->decl->fields ?? [], "typedefenum {$declaration->name}");
            }
        }
    }

    // based on FFIMe
    private function collectFromEnumDeclarationFields(array $fields, string $description)
    {
        $id = 0;
        $lastValue = 0;
        foreach ($fields as $field) {
            // do not override #define constants
            if (isset($this->constants[$field->name])) {
                $id++;
                continue;
            }
            if ($field->value !== null) {
                $lastValue = $this->compileExpr($field->value);
                $id = 0;
            }
            $this->constants[$field->name] = new Constant_($field->name, $this->analyzeValue("($lastValue) + $id"), $description);
            $id++;
        }
    }

    // based on FFIMe
    private function compileExpr(Expr $expr): string
    {
        if ($expr instanceof Expr\IntegerLiteral) {
            // parse out type qualifiers
            $value = str_replace(['u', 'U', 'l', 'L'], '', $expr->value);
            return (string) intval($expr->value);
        }
        if ($expr instanceof Expr\AbstractConditionalOperator\ConditionalOperator) {
            return '(' . $this->compileExpr($expr->cond) . ' ? ' . $this->compileExpr($expr->ifTrue) . ' : ' . $this->compileExpr(
                    $expr->ifFalse
                ) . ')';
        }
        if ($expr instanceof Expr\UnaryOperator) {
            switch ($expr->kind) {
                case Expr\UnaryOperator::KIND_PLUS:
                    return '(+' . $this->compileExpr($expr->expr) . ')';
                case Expr\UnaryOperator::KIND_MINUS:
                    return '(-' . $this->compileExpr($expr->expr) . ')';
                case Expr\UnaryOperator::KIND_BITWISE_NOT:
                    return '(~' . $this->compileExpr($expr->expr) . ')';
                case Expr\UnaryOperator::KIND_LOGICAL_NOT:
                    return '(!' . $this->compileExpr($expr->expr) . ')';
                default:
                    throw new LogicException("Unsupported unary operator for library: " . $expr->kind);
            }
        }
        if ($expr instanceof Expr\BinaryOperator) {
            switch ($expr->kind) {
                case Expr\BinaryOperator::KIND_ADD:
                    return '(' . $this->compileExpr($expr->left) . ' + ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_SUB:
                    return '(' . $this->compileExpr($expr->left) . ' - ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_MUL:
                    return '(' . $this->compileExpr($expr->left) . ' * ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_DIV:
                    return '(' . $this->compileExpr($expr->left) . ' / ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_REM:
                    return '(' . $this->compileExpr($expr->left) . ' % ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_SHL:
                    return '(' . $this->compileExpr($expr->left) . ' << ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_SHR:
                    return '(' . $this->compileExpr($expr->left) . ' >> ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_LT:
                    return '(' . $this->compileExpr($expr->left) . ' < ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_GT:
                    return '(' . $this->compileExpr($expr->left) . ' > ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_LE:
                    return '(' . $this->compileExpr($expr->left) . ' <= ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_GE:
                    return '(' . $this->compileExpr($expr->left) . ' >= ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_EQ:
                    return '(' . $this->compileExpr($expr->left) . ' === ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_NE:
                    return '(' . $this->compileExpr($expr->left) . ' !== ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_BITWISE_AND:
                    return '(' . $this->compileExpr($expr->left) . ' & ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_BITWISE_OR:
                    return '(' . $this->compileExpr($expr->left) . ' | ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_BITWISE_XOR:
                    return '(' . $this->compileExpr($expr->left) . ' ^ ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_LOGICAL_AND:
                    return '(' . $this->compileExpr($expr->left) . ' && ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_LOGICAL_OR:
                    return '(' . $this->compileExpr($expr->left) . ' || ' . $this->compileExpr($expr->right) . ')';
                case Expr\BinaryOperator::KIND_COMMA:
                    return $this->compileExpr($expr->left) . ', ' . $this->compileExpr($expr->right);
            }
        }
//        if ($expr instanceof Expr\DeclRefExpr) {
//            return 'self::' . $expr->name;
//        }
        throw new RuntimeException(sprintf('Expression type %s not supported', $expr->getType()));
    }

    /**
     * @return Constant_[]
     */
    public function getAll(): array
    {
        return $this->constants;
    }
}