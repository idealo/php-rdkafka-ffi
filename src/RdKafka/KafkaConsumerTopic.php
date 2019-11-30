<?php

declare(strict_types=1);

namespace RdKafka;

class KafkaConsumerTopic extends Topic
{
    public function __construct(KafkaConsumer $consumer, string $name, TopicConf $conf = null)
    {
        parent::__construct($consumer, $name, $conf);
    }

    /**
     * @param int $partition
     * @param int $offset
     *
     * @return void
     * @throws Exception
     */
    public function offsetStore(int $partition, int $offset)
    {
        $err = self::$ffi->rd_kafka_offset_store(
            $this->topic,
            $partition,
            $offset
        );

        if ($err != RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }
}
