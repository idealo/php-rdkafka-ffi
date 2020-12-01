<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI;
use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Library;

use function array_values;
use function count;

class NewTopic
{
    private ?CData $topic;

    public function __construct(string $name, int $num_partitions, int $replication_factor)
    {
        $errstr = Library::new('char[512]');
        $this->topic = Library::rd_kafka_NewTopic_new(
            $name,
            $num_partitions,
            $replication_factor,
            $errstr,
            FFI::sizeOf($errstr)
        );

        if ($this->topic === null) {
            throw new Exception(FFI::string($errstr));
        }
    }

    public function __destruct()
    {
        if ($this->topic === null) {
            return;
        }

        Library::rd_kafka_NewTopic_destroy($this->topic);
    }

    public function getCData(): CData
    {
        return $this->topic;
    }

    public function setReplicaAssignment(int $partition_id, array $broker_ids): void
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
        $err = (int) Library::rd_kafka_NewTopic_set_replica_assignment(
            $this->topic,
            $partition_id,
            $brokerIds[0],
            $brokerIdsCount,
            $errstr,
            FFI::sizeOf($errstr)
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(FFI::string($errstr));
        }
    }

    public function setConfig(string $name, string $value): void
    {
        $err = Library::rd_kafka_NewTopic_set_config($this->topic, $name, $value);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw Exception::fromError($err);
        }
    }
}
