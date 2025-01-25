<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use RdKafka;

class ErrorCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $consumerOrProducer, int $err, string $reason, ?CData $opaque = null): void
    {
        ($this->callback)(
            RdKafka::resolveFromCData($consumerOrProducer),
            $err,
            $reason,
            OpaqueMap::get($opaque)
        );
    }
}
