<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use FFI\CData;
use RdKafka;

class StatsCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $consumerOrProducer, CData $json, int $json_len, ?CData $opaque = null): int
    {
        ($this->callback)(
            RdKafka::resolveFromCData($consumerOrProducer),
            FFI::string($json, $json_len),
            $json_len,
            OpaqueMap::get($opaque)
        );

        return 0;
    }
}
