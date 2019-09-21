<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use RdKafka\Api;

class NewPartitions extends Api
{
    public function __construct(string $topicName, int $new_total_cnt)
    {
        parent::__construct();
        // rd_kafka_NewPartitions_new
    }

    public function __destruct()
    {
        // rd_kafka_NewPartitions_destroy
    }

    public function setReplicaAssignment(int $new_partition_id, array $broker_ids)
    {
        // rd_kafka_NewPartitions_set_replica_assignment
    }
}
