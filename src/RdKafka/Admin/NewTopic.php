<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;

class NewTopic extends Api
{
    public function __construct(string $name, int $num_partitions, int $replication_factor)
    {
        parent::__construct();

        // rd_kafka_NewTopic_new
    }

    public function __destruct()
    {
        // rd_kafka_NewTopic_destroy
    }

    public function getCData(): CData
    {
    }

    public function setReplicaAssignment(int $partition_id, array $broker_ids)
    {
        // rd_kafka_NewTopic_set_replica_assignment
    }

    public function setConfig(string $name, string $value)
    {
        // rd_kafka_NewTopic_set_config
    }
}

