<?php

namespace RdKafka;

use RdKafka\Metadata\Broker;
use RdKafka\Metadata\Collection;
use RdKafka\Metadata\Topic;

class Metadata
{
    public function __construct()
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @return Collection|Broker[]
     */
    public function getBrokers()
    {
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics()
    {
    }

    /**
     * @return int
     */
    public function getOrigBrokerId()
    {
    }

    /**
     * @return string
     */
    public function getOrigBrokerName()
    {
    }
}
