<?php

namespace RdKafka\Metadata;

class Collection implements \Iterator, \Countable
{
    /**
     * @var array
     */
    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->current($this->items);
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->items);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return isset($this->items[$this->key()]);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->rewind($this->items);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}
