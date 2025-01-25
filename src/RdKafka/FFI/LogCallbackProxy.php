<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use RdKafka;

class LogCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $rdkafka, int $level, string $facility, string $message): void
    {
        ($this->callback)(
            RdKafka::resolveFromCData($rdkafka),
            $level,
            $facility,
            $message
        );
    }
}
