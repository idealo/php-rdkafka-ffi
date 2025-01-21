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
        try {
            ($this->callback)(
                RdKafka::resolveFromCData($consumerOrProducer),
                FFI::string($json, $json_len),
                $json_len,
                OpaqueMap::get($opaque)
            );
        } catch (\Throwable $exception) {
            error_log($exception->getMessage(), E_ERROR);
        }

        return 0;
    }
}
