<?php

namespace RdKafka\Metadata;

class Broker
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;

    public function __construct(int $id, string $host, int $port)
    {
        $this->id = $id;
        $this->host = $host;
        $this->port = $port;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }
}
