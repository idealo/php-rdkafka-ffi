<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use RdKafka;

class StatsCallbackProxy extends CallbackProxy
{
    public function __invoke($consumerOrProducer, $json, $json_len, $opaque = null): void
    {
        $callback = $this->callback;
        $callback(
            RdKafka::resolveFromCData($consumerOrProducer),
            FFI::string($json, $json_len),
            (int) $json_len,
            $opaque
        );
    }
}
