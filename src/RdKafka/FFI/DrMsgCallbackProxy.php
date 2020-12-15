<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use RdKafka;
use RdKafka\Message;

class DrMsgCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $producer, CData $nativeMessage, ?CData $opaque = null): void
    {
        ($this->callback)(
            RdKafka::resolveFromCData($producer),
            new Message($nativeMessage),
            OpaqueMap::get($opaque)
        );
    }
}
