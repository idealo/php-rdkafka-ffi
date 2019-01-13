<?php

namespace RdKafka;

class KafkaConsumerTopic extends Topic
{
    public function __construct(string $name)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param int $partition
     * @param int $offset
     *
     * @return void
     */
    public function offsetStore($partition, $offset)
    {
    }
}
