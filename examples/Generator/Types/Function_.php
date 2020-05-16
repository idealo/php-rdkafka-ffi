<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

// todo: extend Pointer > resolve with FunctionPointer > are there "functions" or only "function pointers"
// todo: use for methods too > add return & params getter
class Function_ extends CType
{
    private Type $return;
    private array $params;
    private bool $isVariadic;

    /**
     * @param Type $return
     * @param Type[] $params
     * @param bool $isVariadic
     */
    public function __construct(string $cName, Type $return, array $params, bool $isVariadic)
    {
        parent::__construct($cName);
        $this->return = $return;
        $this->params = $params;
        $this->isVariadic = $isVariadic;
    }

    public function getCType($ptr = ''): string
    {
        $params = array_map(fn(Type $param) => $param->getCType(), $this->params);
        if ($this->isVariadic()) {
            $params[] = '...';
        }
        //void(*func_ptr_t)(void);
        // void (*)(void)
        //int (*functionPtr)(int,int); = return (name ptr_level)(params)
        return sprintf(
            '%s (%s)(%s)',
            $this->return->getCType(),
            parent::getCType($ptr),
            implode(', ', $params)
        );
    }

    // todo: resolve params & return to interface which should be implemented (and might event be implemented by proxying CData (slower)
    public function getPhpTypes(): string
    {
        return 'callable'; // todo: Closure and CData instead - they have better performance over anonymous functions
    }

    // todo: resolve to interface which should be implemented
    public function getPhpDocTypes(): string
    {
        return 'callable'; // todo: Closure and CData func pointer instead
    }

    public function isVariadic(): bool
    {
        return $this->isVariadic;
    }
}