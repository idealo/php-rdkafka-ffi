<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use RdKafka\Message;

class ConsumeCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $nativeMessage, $opaque = null)
    {
        $callback = $this->callback;
        $callback(new Message($nativeMessage), $opaque);
    }
}
