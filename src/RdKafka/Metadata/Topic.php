<?php

namespace RdKafka\Metadata;

class Topic
{
    /**
     * @var string
     */
    private $topic;
    /**
     * @var Collection
     */
    private $partitions;
    /**
     * @var int
     */
    private $err;

    public function __construct(string $topic, Collection $partitions, int $err)
    {
        $this->topic = $topic;
        $this->partitions = $partitions;
        $this->err = $err;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * @return Collection|Partition[]
     */
    public function getPartitions(): Collection
    {
        return $this->partitions;
    }

    public function getErr(): int
    {
        return $this->err;
    }
}
