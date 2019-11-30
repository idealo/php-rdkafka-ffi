<?php

declare(strict_types=1);

namespace RdKafka\Metadata;

class Broker
{
    private int $id;
    private string $host;
    private int $port;

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
