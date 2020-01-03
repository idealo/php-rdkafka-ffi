<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use Assert\Assert;
use FFI;
use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Api;

class NewPartitions extends Api
{
    private CData $partitions;

    public function __construct(string $topicName, int $new_total_cnt)
    {
        $errstr = FFI::new('char[512]');
        $this->partitions = self::getFFI()->rd_kafka_NewPartitions_new(
            $topicName,
            $new_total_cnt,
            $errstr,
            FFI::sizeOf($errstr)
        );

        if ($this->partitions === null) {
            throw new Exception(FFI::string($errstr));
        }
    }

    public function __destruct()
    {
        if ($this->partitions === null) {
            return;
        }

        self::getFFI()->rd_kafka_NewPartitions_destroy($this->partitions);
    }

    public function getCData(): CData
    {
        return $this->partitions;
    }

    /**
     * @param int[] $broker_ids
     * @throws Exception
     */
    public function setReplicaAssignment(int $new_partition_id, array $broker_ids): void
    {
        Assert::that($broker_ids)->notEmpty()->all()->integer();

        $brokerIdsCount = \count($broker_ids);
        $brokerIds = FFI::new('int*[' . $brokerIdsCount . ']');
        foreach (\array_values($broker_ids) as $i => $broker_id) {
            $int = FFI::new('int');
            $int->cdata = $broker_id;
            $brokerIds[$i] = FFI::addr($int);
        }

        $errstr = FFI::new('char[512]');
        $err = (int) self::getFFI()->rd_kafka_NewPartitions_set_replica_assignment(
            $this->partitions,
            $new_partition_id,
            $brokerIds[0],
            $brokerIdsCount,
            $errstr,
            FFI::sizeOf($errstr)
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(FFI::string($errstr));
        }
    }
}
