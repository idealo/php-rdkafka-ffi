<?php

declare(strict_types=1);

namespace RdKafka\Examples\Protocol;

use Exception;

/**
 * @see readMessageKey https://github.com/apache/kafka/blob/trunk/core/src/main/scala/kafka/coordinator/group/GroupMetadataManager.scala#L1295
 */
class MessageKeyParser extends Parser
{
    public const V0_OFFSET_COMMIT_KEY = 0;
    public const V1_OFFSET_COMMIT_KEY = 1;
    public const V2_GROUP_METADATA_KEY = 2;

    private int $version;
    private array $parsed;

    public function __construct(string $data)
    {
        parent::__construct($data);

        $this->version = -1;
        $this->parsed = [];
        $this->parse();
    }

    protected function parse(): void
    {
        $this->version = $this->parseInt16();

        switch ($this->version) {
            case self::V0_OFFSET_COMMIT_KEY:
            case self::V1_OFFSET_COMMIT_KEY:
                $this->parsed = $this->parseOffsetCommitKey();
                break;
            case self::V2_GROUP_METADATA_KEY:
                $this->parsed = $this->parseGroupMetadataKey();
                break;
            default:
                throw new Exception(sprintf('Version %d not supported', $this->version));
                break;
        }
    }

    protected function parseOffsetCommitKey(): array
    {
        return [
            'group' => $this->parseString(),
            'topic' => $this->parseString(),
            'partition' => $this->parseInt32(),
        ];
    }

    protected function parseGroupMetadataKey(): array
    {
        return [
            'group' => $this->parseString(),
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
