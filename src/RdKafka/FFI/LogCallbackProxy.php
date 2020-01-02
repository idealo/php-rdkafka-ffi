<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use RdKafka;

class LogCallbackProxy extends CallbackProxy
{
    public function __invoke($consumerOrProducer, $level, $fac, $buf): void
    {
        $callback = $this->callback;
        $callback(
            RdKafka::resolveFromCData($consumerOrProducer),
            (int) $level,
            FFI::string($fac),
            FFI::string($buf)
        );
    }
}
