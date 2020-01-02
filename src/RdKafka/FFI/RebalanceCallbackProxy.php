<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use RdKafka;
use RdKafka\TopicPartitionList;

class RebalanceCallbackProxy extends CallbackProxy
{
    public function __invoke($consumer, $err, $nativeTopicPartitionList, $opaque = null): void
    {
        $callback = $this->callback;
        $callback(
            RdKafka::resolveFromCData($consumer),
            (int) $err,
            TopicPartitionList::fromCData($nativeTopicPartitionList)->asArray(),
            $opaque
        );
    }
}
