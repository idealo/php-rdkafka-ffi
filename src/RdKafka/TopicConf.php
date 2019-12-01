<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;
use InvalidArgumentException;

/**
 * Configuration reference: https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md
 */
class TopicConf extends Api
{
    private CData $topicConf;

    public function __construct()
    {
        parent::__construct();
        $this->topicConf = self::$ffi->rd_kafka_topic_conf_new();
    }

    public function __destruct()
    {
        self::$ffi->rd_kafka_topic_conf_destroy($this->topicConf);
    }

    /**
     * @return CData
     */
    public function getCData(): CData
    {
        return $this->topicConf;
    }

    /**
     * @return array
     */
    public function dump(): array
    {
        $count = FFI::new('size_t');
        $dump = self::$ffi->rd_kafka_topic_conf_dump($this->topicConf, FFI::addr($count));
        $count = (int)$count->cdata;

        $result = [];
        for ($i = 0; $i < $count; $i += 2) {
            $key = FFI::string($dump[$i]);
            $val = FFI::string($dump[$i + 1]);
            $result[$key] = $val;
        }

        self::$ffi->rd_kafka_conf_dump_free($dump, $count);

        return $result;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     * @throws Exception
     */
    public function set(string $name, string $value)
    {
        $errstr = FFI::new("char[512]");

        $result = self::$ffi->rd_kafka_topic_conf_set($this->topicConf, $name, $value, $errstr, FFI::sizeOf($errstr));

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

    public function setPartitioner(int $partitioner)
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

            default:
                throw new InvalidArgumentException('Invalid partitioner');
                break;
        }

        $ffi = self::$ffi;
        $proxyCallback = function ($topic, $keydata, $keylen, $partition_cnt, $topic_opaque, $msg_opaque) use (
            $ffi,
            $partitionerMethod
        ) {
            return (int)$ffi->$partitionerMethod($topic, $keydata, $keylen, $partition_cnt, $topic_opaque, $msg_opaque);
        };
        self::$ffi->rd_kafka_topic_conf_set_partitioner_cb(
            $this->topicConf,
            $proxyCallback
        );
    }

    public function setPartitionerCb(callable $callback)
    {
        $proxyCallback = function ($topic, $keydata, $keylen, $partition_cnt, $topic_opaque, $msg_opaque) use ($callback
        ) {
            return (int)$callback(
                FFI::string($keydata, $keylen),
                (int)$partition_cnt
            );
        };

        self::$ffi->rd_kafka_topic_conf_set_partitioner_cb(
            $this->topicConf,
            $proxyCallback
        );
    }
}
