<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Library;
use RdKafka\TopicPartition;
use RdKafka\TopicPartitionList;

class DeleteConsumerGroupOffsets
{
    private ?CData $consumerGroupOffsets;

    public function __construct(string $group, TopicPartition ...$partitions)
    {
        $topicPartitionList = new TopicPartitionList(...$partitions);
        $nativeTopicPartitionList = $topicPartitionList->getCData();

        $this->consumerGroupOffsets = Library::rd_kafka_DeleteConsumerGroupOffsets_new($group, $nativeTopicPartitionList);

        if ($this->consumerGroupOffsets === null) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }
    }

    public function __destruct()
    {
        if ($this->consumerGroupOffsets === null) {
            return;
        }

        Library::rd_kafka_DeleteConsumerGroupOffsets_destroy($this->consumerGroupOffsets);
    }

    public function getCData(): CData
    {
        return $this->consumerGroupOffsets;
    }
}
