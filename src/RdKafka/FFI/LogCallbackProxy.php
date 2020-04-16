<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use RdKafka;

class LogCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $consumerOrProducer, int $level, string $fac, string $buf): void
    {
        ($this->callback)(
            RdKafka::resolveFromCData($consumerOrProducer),
            $level,
            $fac,
            $buf
        );
    }
}
