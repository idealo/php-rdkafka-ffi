<?php

declare(strict_types=1);

namespace RdKafka\Metadata;

class Partition
{
    private int $id;
    private int $err;
    private int $leader;
    private Collection $replicas;
    private Collection $isrs;

    public function __construct(int $id, int $err, int $leader, Collection $replicas, Collection $isrs)
    {
        $this->id = $id;
        $this->err = $err;
        $this->leader = $leader;
        $this->replicas = $replicas;
        $this->isrs = $isrs;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getErr(): int
    {
        return $this->err;
    }

    public function getLeader(): int
    {
        return $this->leader;
    }

    public function getReplicas(): Collection
    {
        return $this->replicas;
    }

    public function getIsrs(): Collection
    {
        return $this->isrs;
    }
}
