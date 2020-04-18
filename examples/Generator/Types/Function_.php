<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

class Function_ extends CType
{
    private Type $return;
    private array $params;
    private bool $isVariadic;

    public function __construct(Type $return, array $params, bool $isVariadic)
    {
        $this->return = $return;
        $this->params = $params;
        $this->isVariadic = $isVariadic;
    }

    public function getCName(): string
    {
        $params = array_map(fn(Type $param) => $param->getCName(), $this->params);
        if ($this->isVariadic()) {
            $params[] = '...';
        }
        return sprintf(
            '%s (%s)',
            $this->return->getCName(),
            implode(', ', $params)
        );
    }

    public function getPhpTypes(): string
    {
        return 'callable';
    }

    public function getPhpDocTypes(): string
    {
        return 'callable';
    }

    public function isVariadic(): bool
    {
        return $this->isVariadic;
    }
}