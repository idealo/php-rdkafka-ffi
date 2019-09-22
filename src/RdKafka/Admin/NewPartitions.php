<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;
use RdKafka\Exception;

class NewPartitions extends Api
{
    private CData $partitions;

    public function __construct(string $topicName, int $new_total_cnt)
    {
        parent::__construct();

        $errstr = \FFI::new("char[512]");
        $this->partitions = self::$ffi->rd_kafka_NewPartitions_new(
            $topicName,
            $new_total_cnt,
            $errstr,
            \FFI::sizeOf($errstr)
        );

        if ($this->partitions === null) {
            throw new Exception(\FFI::string($errstr));
        }
    }

    public function __destruct()
    {
        if ($this->partitions === null) {
            return;
        }

        self::$ffi->rd_kafka_NewPartitions_destroy($this->partitions);
    }

    public function getCData(): CData
    {
        return $this->partitions;
    }

    /**
     * @param int $new_partition_id
     * @param int[] $broker_ids
     * @throws Exception
     */
    public function setReplicaAssignment(int $new_partition_id, array $broker_ids)
    {
        // rd_kafka_NewPartitions_set_replica_assignment
    }
}
