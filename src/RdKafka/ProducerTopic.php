<?php

namespace RdKafka;

class ProducerTopic extends Topic
{
    const RD_KAFKA_MSG_F_FREE = 0x1;
    const RD_KAFKA_MSG_F_COPY = 0x2;
    const RD_KAFKA_MSG_F_BLOCK = 0x4;
    const RD_KAFKA_MSG_F_PARTITION = 0x8;

    /**
     * @var \FFI\CData
     */
    private $topic;

    /**
     * @param Producer $producer
     * @param string $name
     * @param TopicConf $conf
     * @throws Exception
     */
    public function __construct(Producer $producer, string $name, TopicConf $conf)
    {
        parent::__construct($name);

        $this->topic = self::$ffi->rd_kafka_topic_new(
            $producer->getCData(),
            $name,
            $conf->getCData()
        );

        if ($this->topic === null) {
            $err = self::$ffi->rd_kafka_last_error();
            $errstr = self::$ffi->rd_kafka_err2str($err);
            throw new Exception($errstr);
        }
    }

    public function __destruct()
    {
        // todo handle error
        self::$ffi->rd_kafka_topic_destroy($this->topic);
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
            $msgflags | self::RD_KAFKA_MSG_F_COPY,
            $payload,
            is_null($payload) ? null : strlen($payload),
            $key,
            is_null($key) ? null : strlen($key),
            NULL
        );

        var_dump($ret . ' - ' . $payload);

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            $errstr = self::$ffi->rd_kafka_err2str($err);
            throw new Exception($errstr);
        }
    }
}
