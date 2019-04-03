<?php
declare(strict_types=1);

namespace RdKafka;

use Countable;
use FFI;
use FFI\CData;
use Iterator;

class TopicPartitionList implements Iterator, Countable
{
    private array $items;

    public static function fromCData(CData $topicPartitionList)
    {
        $items = [];
        for ($i = 0; $i < (int)$topicPartitionList->cnt; $i++) {
            $data = $topicPartitionList->elems[$i];
            $items[] = new TopicPartition(
                FFI::string($data->topic),
                (int)$data->partition,
                (int)$data->offset,
                FFI::string($data->metadata, $data->metadata_size),
                $data->opaque,
                (int)$data->err
            );
        }

        return new self($items);
    }

    /**
     * @param TopicPartitionList[] $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
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
        return isset($this->items[$this->key()]);
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
