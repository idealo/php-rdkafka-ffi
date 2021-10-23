<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\FFI\Library;
use RdKafka\TopicPartitionList;

class GroupResult
{
    public int $error;
    public ?string $errorString;
    public ?string $name;
    public array $partitions;

    public function __construct(CData $result)
    {
        $this->error = (int) Library::rd_kafka_group_result_error($result);
        $this->errorString = Library::rd_kafka_err2str($this->error);
        $this->name = Library::rd_kafka_group_result_name($result);

        $nativePartitions = Library::rd_kafka_group_result_partitions($result);
        $this->partitions = $nativePartitions === null
            ? []
            : TopicPartitionList::fromCData($nativePartitions)->asArray();
    }
}
