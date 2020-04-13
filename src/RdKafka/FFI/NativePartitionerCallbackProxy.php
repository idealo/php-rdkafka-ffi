<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;

class NativePartitionerCallbackProxy
{
    private string $partitionerMethod;

    public function __construct(string $partitionerMethod)
    {
        $this->partitionerMethod = $partitionerMethod;
    }

    public function __invoke(
        ?CData $topic,
        ?CData $keydata,
        int $keylen,
        int $partition_cnt,
        ?object $topic_opaque = null,
        ?object $msg_opaque = null
    ): int {
        return (int) Api::{$this->partitionerMethod}(
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
