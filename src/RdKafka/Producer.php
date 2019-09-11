<?php
declare(strict_types=1);

namespace RdKafka;

use RdKafka;

class Producer extends RdKafka
{
    /**
     * @param Conf|null $conf
     * @throws Exception
     */
    public function __construct(Conf $conf = null)
    {
        parent::__construct(RD_KAFKA_PRODUCER, $conf);
    }

    public function __destruct()
    {
        // todo: why not this way?
        // like in librdkafka simple producer example > wait for max 10 sec
//        self::$ffi->rd_kafka_flush($this->kafka, 10000);

        parent::__destruct();
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
     * @return ProducerTopic
     * @throws Exception
     */
    public function newTopic(string $topic_name, TopicConf $topic_conf = null)
    {
        return new ProducerTopic($this, $topic_name, $topic_conf);
    }

    public function getOutQLen(): int
    {
        return parent::getOutQLen();
    }

    public function purge(int $purge_flags): int
    {
        // todo: handle binding for different librdkafka versions
        return (int)self::$ffi->rd_kafka_purge($this->kafka, $purge_flags);
    }

    public function flush(int $timeout_ms): int
    {
        return (int)self::$ffi->rd_kafka_flush($this->kafka, $timeout_ms);
    }
}
