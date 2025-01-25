<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use RdKafka\Message;

class ConsumeCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $nativeMessage, ?CData $opaque = null): void
    {
        ($this->callback)(
            new Message($nativeMessage),
            OpaqueMap::get($opaque)
        );
    }
}
