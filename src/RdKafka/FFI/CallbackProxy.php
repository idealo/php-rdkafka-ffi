<?php

declare(strict_types=1);

namespace RdKafka\FFI;

abstract class CallbackProxy
{
    protected \Closure $callback;

    protected function __construct(callable $callback)
    {
        if ($callback instanceof \Closure) {
            $this->callback = $callback;
        } else {
            $this->callback = \Closure::fromCallable($callback);
        }
    }

    public static function create(callable $callback): \Closure
    {
        return \Closure::fromCallable(new static($callback));
    }
}
