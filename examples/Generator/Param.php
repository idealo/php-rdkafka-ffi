<?php

declare(strict_types=1);

namespace FFI\Generator;


class Param
{
    private array $types;

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

    public function __construct(array $types, ?string $name, string $description, bool $isVariadic = false)
    {
        $this->types = array_combine(array_values($types), array_values($types));
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

    public function isVoid(): bool
    {
        return $this->getPhpCodeType() === 'void';
    }

    public function getPhpCodeType(): string
    {
        $types = $this->types;
        $typeCount = count($types);
        if ($typeCount === 1) {
            return implode('', $types);
        }
        if ($typeCount === 2 && array_key_exists('null', $types)) {
            unset($types['null']);
            return '?' . implode('', $types);
        }
        return '';
    }

    public function getPhpVar(): string
    {
        return sprintf('%s$%s', $this->isVariadic ? '...' : '', $this->name);
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
        if (count($this->types) === 0) {
            return 'mixed';
        }

        return implode('|', $this->types);
    }
}