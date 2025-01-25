<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use Closure;
use FFI\CData;

class NativePartitionerCallbackProxy
{
    private string $partitionerMethod;

    public function __construct(string $partitionerMethod)
    {
        Library::requireMethod($partitionerMethod);
        $this->partitionerMethod = $partitionerMethod;
    }

    public function __invoke(
        ?CData $topic,
        ?CData $keydata,
        int $keylen,
        int $partition_cnt,
        ?CData $topic_opaque = null,
        ?CData $msg_opaque = null
    ): int {
        return (int) Library::{$this->partitionerMethod}(
            $topic,
            $keydata,
            $keylen,
            $partition_cnt,
            OpaqueMap::get($topic_opaque),
            OpaqueMap::get($msg_opaque)
        );
    }

    public static function create(string $partitionerMethod): Closure
    {
        return Closure::fromCallable(new static($partitionerMethod));
    }
}
