<?php

declare(strict_types=1);

namespace RdKafka\FFI;

class CallbackProxyStub extends CallbackProxy
{
    public function __invoke(...$args)
    {
        return ($this->callback)(...$args);
    }
}
