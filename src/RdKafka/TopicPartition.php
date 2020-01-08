<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;

class TopicPartition
{
    private string $topic;
    private int $partition;
    private ?int $offset = null;
    private ?string $metadata = null;
    private ?object $opaque = null;
    private ?int $err = null;

    public static function fromCData(CData $topicPartition): self
    {
        $topar = new self(
            FFI::string($topicPartition->topic),
            (int) $topicPartition->partition,
            (int) $topicPartition->offset
        );

        $topar->metadata = $topicPartition->metadata === null
            ? null
            : FFI::string($topicPartition->metadata, $topicPartition->metadata_size);
        $topar->opaque = $topicPartition->opaque;
        $topar->err = (int) $topicPartition->err;

        return $topar;
    }

    public function __construct(string $topic, int $partition, ?int $offset = null, ?string $metadata = null)
    {
        $this->topic = $topic;
        $this->partition = $partition;
        $this->offset = $offset;
        $this->metadata = $metadata;
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

    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    public function getOpqaque(): ?object
    {
        return $this->opaque;
    }

    public function getErr(): ?int
    {
        return $this->err;
    }

    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    public function setPartition(int $partition): void
    {
        $this->partition = $partition;
    }

    public function setTopic(string $topic_name): void
    {
        $this->topic = $topic_name;
    }

    public function setMetadata(?string $metadata): void
    {
        $this->metadata = $metadata;
    }
}
