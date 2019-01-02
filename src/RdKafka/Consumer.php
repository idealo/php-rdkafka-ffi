<?php

namespace RdKafka;

class Consumer extends \RdKafka
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
     * @param string $topic_name
     * @param TopicConf $topic_conf
     *
     * @return ConsumerTopic
     * @throws Exception
     */
    public function newTopic(string $topic_name, TopicConf $topic_conf = null)
    {
        return new ConsumerTopic($this, $topic_name, $topic_conf);
    }
}
