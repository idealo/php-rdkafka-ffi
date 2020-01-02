<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;

class PartitionerCallbackProxy extends CallbackProxy
{
    public function __invoke($topic, $keydata, $keylen, $partition_cnt, $topic_opaque, $msg_opaque): int
    {
        $callback = $this->callback;
        return (int) $callback(
            FFI::string($keydata, $keylen),
            (int) $partition_cnt
        );
    }
}
