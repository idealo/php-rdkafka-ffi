<?php

namespace RdKafka;

class ProducerTopic extends Topic
{
    /**
     * @param Producer $producer
     * @param string $name
     * @param TopicConf $conf
     * @throws Exception
     */
    public function __construct(Producer $producer, string $name, TopicConf $conf = null)
    {
        parent::__construct($producer, $name, $conf);
    }

    /**
     * @param int $partition
     * @param int $msgflags
     * @param string $payload
     * @param string $key
     *
     * @return void
     * @throws Exception
     */
    public function produce(int $partition, int $msgflags, string $payload, string $key = null)
    {
        if ($partition != RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new \InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }

        // todo why?
        if ($msgflags != 0) {
            throw new \InvalidArgumentException(sprintf("Invalid value '%d' for msgflags", $msgflags));
        }

        $ret = self::$ffi->rd_kafka_produce(
            $this->topic,
            $partition,
            $msgflags | RD_KAFKA_MSG_F_COPY,
            $payload,
            is_null($payload) ? null : strlen($payload),
            $key,
            is_null($key) ? null : strlen($key),
            null
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }
    }
}
