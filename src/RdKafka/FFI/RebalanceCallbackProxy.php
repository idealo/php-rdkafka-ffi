<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use RdKafka;
use RdKafka\TopicPartitionList;

class RebalanceCallbackProxy extends CallbackProxy
{
    public function __invoke(CData $consumer, int $err, CData $nativeTopicPartitionList, ?CData $opaque = null): void
    {
        try {
            ($this->callback)(
                RdKafka::resolveFromCData($consumer),
                $err,
                TopicPartitionList::fromCData($nativeTopicPartitionList)->asArray(),
                OpaqueMap::get($opaque)
            );
        } catch (\Throwable $exception) {
            error_log($exception->getMessage(), E_ERROR);
        }
    }
}
