<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use FFI\CData;
use RdKafka;

class ErrorCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $consumerOrProducer, int $err, CData $reason, ?object $opaque = null): void
    {
        ($this->callback)(
            RdKafka::resolveFromCData($consumerOrProducer),
            $err,
            FFI::string($reason),
            $opaque
        );
    }
}
