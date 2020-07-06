<?php

declare(strict_types=1);

namespace RdKafka\Examples\Protocol;

use Exception;

/**
 * @see readOffsetMessageValue https://github.com/apache/kafka/blob/trunk/core/src/main/scala/kafka/coordinator/group/GroupMetadataManager.scala#L1324
 */
class OffsetCommitValueParser extends Parser
{
    public const V0 = 0;
    public const V1 = 1;
    public const V2 = 2;
    public const V3 = 3;

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
                $this->parsed = $this->parseOffsetCommitV0();
                break;
            case self::V1:
                $this->parsed = $this->parseOffsetCommitV1();
                break;
            case self::V2:
                $this->parsed = $this->parseOffsetCommitV2();
                break;
            case self::V3:
                $this->parsed = $this->parseOffsetCommitV3();
                break;
            default:
                throw new Exception(sprintf('Version %d not supported', $this->version));
                break;
        }
    }

    protected function parseOffsetCommitV0(): array
    {
        return [
            'offset' => $this->parseInt64(),
            'metadata' => $this->parseString(),
            'timestamp' => $this->parseInt64(),
        ];
    }

    protected function parseOffsetCommitV1(): array
    {
        return [
            'offset' => $this->parseInt64(),
            'metadata' => $this->parseString(),
            'commit_timestamp' => $this->parseInt64(),
            'expire_timestamp' => $this->parseInt64(),
        ];
    }

    protected function parseOffsetCommitV2(): array
    {
        return [
            'offset' => $this->parseInt64(),
            'metadata' => $this->parseString(),
            'commit_timestamp' => $this->parseInt64(),
        ];
    }

    protected function parseOffsetCommitV3(): array
    {
        return [
            'offset' => $this->parseInt64(),
            'leader_epoch' => $this->parseInt32(),
            'metadata' => $this->parseString(),
            'commit_timestamp' => $this->parseInt64(),
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
