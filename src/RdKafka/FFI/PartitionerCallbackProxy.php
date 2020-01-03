<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use FFI\CData;

class PartitionerCallbackProxy extends CallbackProxy
{
    public function __invoke(
        ?CData $topic,
        ?CData $keydata,
        int $keylen,
        int $partition_cnt,
        ?object $topic_opaque = null,
        ?object $msg_opaque = null
    ): int {
        return (int) ($this->callback)(
            $keydata === null ? null : FFI::string($keydata, $keylen),
            $partition_cnt
        );
    }
}
