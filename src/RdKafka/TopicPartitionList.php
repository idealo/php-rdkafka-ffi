<?php

declare(strict_types=1);

namespace RdKafka;

use Countable;
use FFI\CData;
use Iterator;
use RdKafka\FFI\Api;

class TopicPartitionList implements Iterator, Countable
{
    private array $items;

    public static function fromCData(CData $topicPartitionList): self
    {
        $items = [];
        for ($i = 0; $i < (int) $topicPartitionList->cnt; $i++) {
            $items[] = TopicPartition::fromCData($topicPartitionList->elems[$i]);
        }

        return new self(...$items);
    }

    /**
     * @param TopicPartition[] $items
     */
    public function __construct(TopicPartition ...$items)
    {
        $this->items = $items;
    }

    public function getCData(): CData
    {
        $nativeTopicPartitionList = Api::rd_kafka_topic_partition_list_new($this->count());

        foreach ($this->items as $item) {
            $nativeTopicPartition = Api::rd_kafka_topic_partition_list_add(
                $nativeTopicPartitionList,
                $item->getTopic(),
                $item->getPartition()
            );
            $nativeTopicPartition->offset = $item->getOffset();
            if ($item->getMetadata() !== null) {
                $metadataSize = strlen($item->getMetadata());
                $metadata = \FFI::new('char[' . $metadataSize . ']', false, true);
                \FFI::memcpy($metadata, $item->getMetadata(), $metadataSize);
                $nativeTopicPartition->metadata = \FFI::cast('char*', $metadata);
                $nativeTopicPartition->metadata_size = $metadataSize;
            }
        }

        return $nativeTopicPartitionList;
    }

    public function current(): TopicPartition
    {
        return \current($this->items);
    }

    public function next(): void
    {
        \next($this->items);
    }

    public function key(): int
    {
        return \key($this->items);
    }

    public function valid(): bool
    {
        return \array_key_exists(\key($this->items), $this->items);
    }

    public function rewind(): void
    {
        \reset($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @return TopicPartition[]
     */
    public function asArray(): array
    {
        return $this->items;
    }
}
