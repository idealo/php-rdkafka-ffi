<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;

class TopicPartition
{
    private string $topic;
    private int $partition;
    private int $offset;
    private ?string $metadata = null;
    private int $metadataSize = 0;
    private $opaque = null;
    private ?int $err = null;

    public static function fromCData(CData $topicPartition): self
    {
        $topar = new self(
            FFI::string($topicPartition->topic),
            (int) $topicPartition->partition,
            (int) $topicPartition->offset
        );

        if ((int) $topicPartition->metadata_size > 0) {
            $topar->setMetadata(FFI::string($topicPartition->metadata, (int) $topicPartition->metadata_size));
        } else {
            $topar->setMetadata(null);
        }
        $topar->opaque = $topicPartition->opaque;
        $topar->err = (int) $topicPartition->err;

        return $topar;
    }

    /**
     * @param string|null $metadata requires librdkafka >= 1.2.0
     *
     * @since 1.2.0 of librdkafka - support for metadata was added for offset commits
     */
    public function __construct(string $topic, int $partition, int $offset = 0, ?string $metadata = null)
    {
        $this->topic = $topic;
        $this->partition = $partition;
        $this->offset = $offset;
        $this->setMetadata($metadata);
    }

    public function getOffset(): int
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

    public function getMetadataSize(): int
    {
        return $this->metadataSize;
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
        if (empty($metadata) === true) {
            $this->metadata = null;
            $this->metadataSize = 0;
        } else {
            $this->metadata = $metadata;
            $this->metadataSize = strlen($metadata);
        }
    }
}
