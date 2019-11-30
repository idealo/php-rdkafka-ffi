<?php

declare(strict_types=1);

namespace RdKafka;

use RdKafka;

class Consumer extends RdKafka
{
    /**
     * @param Conf|null $conf
     * @throws Exception
     */
    public function __construct(Conf $conf = null)
    {
        parent::__construct(RD_KAFKA_CONSUMER, $conf);
    }

    /**
     * @param string $broker_list
     *
     * @return int
     */
    public function addBrokers(string $broker_list): int
    {
        return self::$ffi->rd_kafka_brokers_add($this->kafka, $broker_list);
    }

    public function poll(int $timeout_ms): int
    {
        return parent::poll($timeout_ms);
    }

    /**
     * @param string $topic_name
     * @param TopicConf|null $topic_conf
     *
     * @return ConsumerTopic
     * @throws Exception
     */
    public function newTopic(string $topic_name, TopicConf $topic_conf = null): ConsumerTopic
    {
        return new ConsumerTopic($this, $topic_name, $topic_conf);
    }

    public function newQueue(): Queue
    {
        return new Queue($this);
    }

    public function getOutQLen(): int
    {
        return parent::getOutQLen();
    }
}
