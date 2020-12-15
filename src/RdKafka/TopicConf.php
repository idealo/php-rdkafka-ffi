<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;
use InvalidArgumentException;
use RdKafka\FFI\Library;
use RdKafka\FFI\NativePartitionerCallbackProxy;
use RdKafka\FFI\OpaqueMap;
use RdKafka\FFI\PartitionerCallbackProxy;

/**
 * @link https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md Configuration reference for librdkafka
 */
class TopicConf
{
    private CData $topicConf;
    private ?CData $cOpaque;

    public function __construct()
    {
        $this->topicConf = Library::rd_kafka_topic_conf_new();
        $this->cOpaque = null;
    }

    public function __destruct()
    {
        Library::rd_kafka_topic_conf_destroy($this->topicConf);
    }

    public function getCData(): CData
    {
        return $this->topicConf;
    }

    public function dump(): array
    {
        $count = Library::new('size_t');
        $dump = Library::rd_kafka_topic_conf_dump($this->topicConf, FFI::addr($count));
        $count = (int) $count->cdata;

        $result = [];
        for ($i = 0; $i < $count; $i += 2) {
            $key = FFI::string($dump[$i]);
            $val = FFI::string($dump[$i + 1]);
            $result[$key] = $val;
        }

        Library::rd_kafka_conf_dump_free($dump, $count);

        return $result;
    }

    /**
     * @throws Exception
     */
    public function set(string $name, string $value): void
    {
        $errstr = Library::new('char[512]');

        $result = Library::rd_kafka_topic_conf_set(
            $this->topicConf,
            $name,
            $value,
            $errstr,
            FFI::sizeOf($errstr)
        );

        switch ($result) {
            case RD_KAFKA_CONF_UNKNOWN:
            case RD_KAFKA_CONF_INVALID:
                throw new Exception(FFI::string($errstr, FFI::sizeOf($errstr)), $result);
                break;
            case RD_KAFKA_CONF_OK:
            default:
                break;
        }
    }

    public function setPartitioner(int $partitioner): void
    {
        switch ($partitioner) {
            case RD_KAFKA_MSG_PARTITIONER_RANDOM:
                $partitionerMethod = 'rd_kafka_msg_partitioner_random';
                break;
            case RD_KAFKA_MSG_PARTITIONER_CONSISTENT:
                $partitionerMethod = 'rd_kafka_msg_partitioner_consistent';
                break;
            case RD_KAFKA_MSG_PARTITIONER_CONSISTENT_RANDOM:
                $partitionerMethod = 'rd_kafka_msg_partitioner_consistent_random';
                break;
            case RD_KAFKA_MSG_PARTITIONER_MURMUR2:
                $partitionerMethod = 'rd_kafka_msg_partitioner_murmur2';
                break;
            case RD_KAFKA_MSG_PARTITIONER_MURMUR2_RANDOM:
                $partitionerMethod = 'rd_kafka_msg_partitioner_murmur2_random';
                break;
            case RD_KAFKA_MSG_PARTITIONER_FNV1A:
                $partitionerMethod = 'rd_kafka_msg_partitioner_fnv1a';
                break;
            case RD_KAFKA_MSG_PARTITIONER_FNV1A_RANDOM:
                $partitionerMethod = 'rd_kafka_msg_partitioner_fnv1a_random';
                break;

            default:
                throw new InvalidArgumentException('Invalid partitioner');
                break;
        }

        Library::rd_kafka_topic_conf_set_partitioner_cb(
            $this->topicConf,
            NativePartitionerCallbackProxy::create($partitionerMethod)
        );
    }

    public function setPartitionerCb(callable $callback): void
    {
        Library::rd_kafka_topic_conf_set_partitioner_cb(
            $this->topicConf,
            PartitionerCallbackProxy::create($callback)
        );
    }

    /**
     * @param mixed $opaque
     */
    public function setOpaque($opaque): void
    {
        if ($this->cOpaque !== null) {
            OpaqueMap::pull($this->cOpaque);
        }

        $this->cOpaque = OpaqueMap::push($opaque);
        Library::rd_kafka_topic_conf_set_opaque($this->topicConf, FFI::addr($this->cOpaque));
    }

    /**
     * @return mixed|null
     */
    public function getOpaque()
    {
        $cOpaque = Library::rd_kafka_topic_opaque($this->topicConf);
        return OpaqueMap::get($cOpaque);
    }
}
