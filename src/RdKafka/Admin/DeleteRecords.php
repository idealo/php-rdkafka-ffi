<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Library;
use RdKafka\TopicPartition;
use RdKafka\TopicPartitionList;

class DeleteRecords
{
    private ?CData $records;

    public function __construct(TopicPartition ...$beforeOffsets)
    {
        $topicPartitionList = new TopicPartitionList(...$beforeOffsets);
        $nativeTopicPartitionList = $topicPartitionList->getCData();

        $this->records = Library::rd_kafka_DeleteRecords_new($nativeTopicPartitionList);

        if ($this->records === null) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }
    }

    public function __destruct()
    {
        if ($this->records === null) {
            return;
        }

        Library::rd_kafka_DeleteRecords_destroy($this->records);
    }

    public function getCData(): CData
    {
        return $this->records;
    }
}
