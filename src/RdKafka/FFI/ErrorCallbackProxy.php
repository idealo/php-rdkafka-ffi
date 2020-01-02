<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use RdKafka;

class ErrorCallbackProxy extends CallbackProxy
{
    public function __invoke($consumerOrProducer, $err, $reason, $opaque = null): void
    {
        $callback = $this->callback;
        $callback(
            RdKafka::resolveFromCData($consumerOrProducer),
            (int) $err,
            FFI::string($reason),
            $opaque
        );
    }
}
