<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use FFI\CData;
use RdKafka;

class LogCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $consumerOrProducer, int $level, CData $fac, CData $buf): void
    {
        ($this->callback)(
            RdKafka::resolveFromCData($consumerOrProducer),
            $level,
            FFI::string($fac),
            FFI::string($buf)
        );
    }
}
