<?php

declare(strict_types=1);

namespace RdKafka;

use Countable;
use FFI;
use FFI\CData;
use Iterator;
use RdKafka\FFI\Library;

use function array_key_exists;
use function count;
use function current;
use function key;
use function next;
use function reset;

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
        $nativeTopicPartitionList = Library::rd_kafka_topic_partition_list_new($this->count());

        foreach ($this->items as $item) {
            $nativeTopicPartition = Library::rd_kafka_topic_partition_list_add(
                $nativeTopicPartitionList,
                $item->getTopic(),
                $item->getPartition()
            );
            $nativeTopicPartition->offset = $item->getOffset();
            if ($item->getMetadata() !== null) {
                $metadata = $item->getMetadata();
                $metadataNative = Library::new('char[' . $item->getMetadataSize() . ']', false, true);
                FFI::memcpy($metadataNative, $metadata, $item->getMetadataSize());
                $nativeTopicPartition->metadata = FFI::cast('char*', $metadataNative);
                $nativeTopicPartition->metadata_size = $item->getMetadataSize();
            }
        }

        return $nativeTopicPartitionList;
    }

    public function current(): TopicPartition
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function key(): int
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return array_key_exists(key($this->items), $this->items);
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return TopicPartition[]
     */
    public function asArray(): array
    {
        return $this->items;
    }
}
