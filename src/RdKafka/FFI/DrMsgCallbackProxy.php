<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use RdKafka;
use RdKafka\Message;

class DrMsgCallbackProxy extends CallbackProxy
{
    public function __invoke($producer, $nativeMessage, $opaque = null): void
    {
        $callback = $this->callback;
        $callback(
            RdKafka::resolveFromCData($producer),
            new Message($nativeMessage),
            $opaque
        );
    }
}
