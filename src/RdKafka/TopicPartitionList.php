<?php

declare(strict_types=1);

namespace RdKafka;

use Countable;
use FFI\CData;
use Iterator;

class TopicPartitionList extends Api implements Iterator, Countable
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
        parent::__construct();

        $this->items = $items;
    }

    public function getCData(): CData
    {
        $nativeTopicPartitionList = self::$ffi->rd_kafka_topic_partition_list_new($this->count());

        foreach ($this->items as $item) {
            $nativeTopicPartition = self::$ffi->rd_kafka_topic_partition_list_add(
                $nativeTopicPartitionList,
                $item->getTopic(),
                $item->getPartition()
            );
            $nativeTopicPartition->offset = $item->getOffset();
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
