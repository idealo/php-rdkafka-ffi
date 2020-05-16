<?php

declare(strict_types=1);

namespace RdKafka;

use RdKafka;
use RdKafka\FFI\Library;

class Consumer extends RdKafka
{
    /**
     * @throws Exception
     */
    public function __construct(?Conf $conf = null)
    {
        parent::__construct(RD_KAFKA_CONSUMER, $conf);
    }

    public function addBrokers(string $broker_list): int
    {
        return Library::rd_kafka_brokers_add($this->kafka, $broker_list);
    }

    public function poll(int $timeout_ms): int
    {
        return parent::poll($timeout_ms);
    }

    /**
     * @throws Exception
     */
    public function newTopic(string $topic_name, ?TopicConf $topic_conf = null): ConsumerTopic
    {
        return new ConsumerTopic($this, $topic_name, $topic_conf);
    }

    /**
     * @throws Exception
     */
    public function newQueue(): Queue
    {
        return Queue::fromRdKafka($this);
    }

    public function getOutQLen(): int
    {
        return parent::getOutQLen();
    }
}
