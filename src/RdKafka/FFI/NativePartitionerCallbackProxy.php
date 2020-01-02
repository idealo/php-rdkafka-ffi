<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use RdKafka\Api;

class NativePartitionerCallbackProxy extends Api
{
    private string $partitionerMethod;

    public function __construct(string $partitionerMethod)
    {
        $this->partitionerMethod = $partitionerMethod;
    }

    public function __invoke($topic, $keydata, $keylen, $partition_cnt, $topic_opaque = null, $msg_opaque = null): int
    {
        return (int) self::getFFI()->{$this->partitionerMethod}(
            $topic,
            $keydata,
            $keylen,
            $partition_cnt,
            $topic_opaque,
            $msg_opaque
        );
    }

    public static function create(string $partitionerMethod): \Closure
    {
        return \Closure::fromCallable(new static($partitionerMethod));
    }
}
