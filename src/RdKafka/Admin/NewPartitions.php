<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI;
use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Library;

use function array_values;
use function count;

class NewPartitions
{
    private CData $partitions;

    public function __construct(string $topicName, int $new_total_cnt)
    {
        $errstr = Library::new('char[512]');
        $this->partitions = Library::rd_kafka_NewPartitions_new(
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

        Library::rd_kafka_NewPartitions_destroy($this->partitions);
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
        if (empty($broker_ids) === true) {
            throw new \InvalidArgumentException('broker_ids array must not be empty');
        }

        foreach ($broker_ids as $key => $value) {
            if (is_int($value) === false) {
                throw new \InvalidArgumentException(
                    sprintf('broker_ids array element %s must be int', $key)
                );
            }
        }

        $brokerIdsCount = count($broker_ids);
        $brokerIds = Library::new('int*[' . $brokerIdsCount . ']');
        foreach (array_values($broker_ids) as $i => $broker_id) {
            $int = Library::new('int');
            $int->cdata = $broker_id;
            $brokerIds[$i] = FFI::addr($int);
        }

        $errstr = Library::new('char[512]');
        $err = (int) Library::rd_kafka_NewPartitions_set_replica_assignment(
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
