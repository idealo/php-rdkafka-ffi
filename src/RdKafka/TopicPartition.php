<?php
declare(strict_types=1);

namespace RdKafka;

class TopicPartition
{
    private string $topic;
    private int $partition;
    private ?int $offset = null;
    private ?string $metadata = null;
    /**
     * @var mixed
     */
    private $opaque = null;
    private ?int $err = null;


    public function __construct(
        string $topic_name,
        int $partition,
        int $offset = null,
        string $metadata = null,
        $opaque = null,
        int $err = null
    ) {
        $this->topic = $topic_name;
        $this->partition = $partition;
        $this->offset = $offset;
        $this->metadata = $metadata;
        $this->opaque = $opaque;
        $this->err = $err;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getPartition(): int
    {
        return $this->partition;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function getMetadata(): string
    {
        return $this->metadata;
    }

    public function getOpqaque()
    {
        return $this->opaque;
    }

    public function getErr(): ?int
    {
        return $this->err;
    }

    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    public function setPartition(int $partition)
    {
        $this->partition = $partition;
    }

    public function setTopic(string $topic_name)
    {
        $this->topic = $topic_name;
    }
}
