<?php

declare(strict_types=1);

namespace FFI\Generator;

use FFI\Generator\Types\Type;

class Param
{
    private ?Type $type;

    /**
     * @var string
     */
    private ?string $name;

    /**
     * @var string
     */
    private string $description;
    /**
     * @var bool
     */
    private bool $isVariadic;

    public function __construct(?Type $type, ?string $name, string $description, bool $isVariadic = false)
    {
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
        $this->isVariadic = $isVariadic;
    }

    public function getPhpCode(string $ident = ''): string
    {
        if ($this->name === null) {
            $type = $this->getPhpCodeType();
            if ($type === '') {
                return '';
            }
            return sprintf(': %s', $type);
        }

        $code = trim(sprintf('%s %s', $this->getPhpCodeType(), $this->getPhpVar()));

        if ($ident != '') {
            $parts = explode("\n", $code);
            $code = '';
            foreach ($parts as $part) {
                $code .= trim($ident . $part) . "\n";
            }
        }

        return $code;
    }

    public function getPhpCodeType(): string
    {
        return $this->type !== null
            ? $this->type->getPhpTypes()
            : '';
    }

    public function getPhpVar(): string
    {
        return sprintf('%s$%s', $this->isVariadic ? '...' : '', $this->name);
    }

    public function isVoid(): bool
    {
        return $this->type !== null && $this->type->getCName() === 'void';
    }

    public function getDocBlock(string $ident = ''): string
    {
        if ($this->name === null) {
            return sprintf('%s * @return %s %s', $ident, $this->getDocBlockType(), $this->description);
        }

        return sprintf('%s * @param %s %s %s', $ident, $this->getDocBlockType(), $this->getPhpVar(), $this->description);
    }

    public function getDocBlockType(): string
    {
        return $this->type !== null
            ? $this->type->getPhpDocTypes()
            : 'mixed';
    }
}