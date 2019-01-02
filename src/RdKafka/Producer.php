<?php

namespace RdKafka;

class Producer extends \RdKafka
{
    /**
     * @param Conf|null $conf
     * @throws Exception
     */
    public function __construct(Conf $conf = null)
    {
        parent::__construct(RD_KAFKA_PRODUCER, $conf);
    }

    /**
     * @param string $topic_name
     * @param TopicConf $topic_conf
     *
     * @return ProducerTopic
     * @throws Exception
     */
    public function newTopic(string $topic_name, TopicConf $topic_conf = null)
    {
        return new ProducerTopic($this, $topic_name, $topic_conf);
    }
}
