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
        ?CData $topic_opaque = null,
        ?CData $msg_opaque = null
    ): int {
        try {
            return (int) ($this->callback)(
                $keydata === null ? null : FFI::string($keydata, $keylen),
                $partition_cnt,
                OpaqueMap::get($topic_opaque),
                OpaqueMap::get($msg_opaque)
            );
        } catch (\Throwable $exception) {
            error_log($exception->getMessage(), E_ERROR);
        }

        return RD_KAFKA_PARTITION_UA;
    }
}
