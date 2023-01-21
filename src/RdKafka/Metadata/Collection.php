<?php

declare(strict_types=1);

namespace RdKafka\Metadata;

use Countable;
use Iterator;

class Collection implements Iterator, Countable
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    #[\ReturnTypeWillChange]
    public function current()
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
}
