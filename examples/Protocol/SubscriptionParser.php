<?php

declare(strict_types=1);

namespace RdKafka\Examples\Protocol;

use Exception;

/**
 * @see https://github.com/apache/kafka/blob/master/clients/src/main/java/org/apache/kafka/clients/consumer/internals/ConsumerProtocol.java
 */
class SubscriptionParser extends Parser
{
    public const V0 = 0;
    public const V1 = 1;

    private int $version;
    private array $parsed;

    public function __construct(string $data)
    {
        parent::__construct($data);

        $this->parsed = [];
        $this->version = -1;
        $this->parse();
    }

    protected function parse(): void
    {
        $this->version = $this->parseInt16();

        switch ($this->version) {
            case self::V0:
                $this->parsed = $this->parseV0();
                break;
            case self::V1:
                $this->parsed = $this->parseV1();
                break;
            default:
                throw new Exception(sprintf('Version %d not supported', $this->version));
                break;
        }
    }

    protected function parseV0(): array
    {
        return [
            'topics' => $this->parseArray([$this, 'parseString']),
            'user_data' => $this->parseNullableBytes(),
        ];
    }

    protected function parseV1(): array
    {
        return [
            'topics' => $this->parseArray([$this, 'parseString']),
            'user_data' => $this->parseNullableBytes(),
            'owned_partitions' => $this->parseArray([$this, 'parseTopicPartitionsV0']),
        ];
    }

    protected function parseTopicPartitionsV0()
    {
        return [
            'topic' => $this->parseString(),
            'partitions' => $this->parseArray([$this, 'parseInt32']),
        ];
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getParsed(): array
    {
        return $this->parsed;
    }
}
