<?php

namespace RdKafka\Examples\Protocol;

use Exception;

/**
 * @see readGroupMessageValue https://github.com/apache/kafka/blob/trunk/core/src/main/scala/kafka/coordinator/group/GroupMetadataManager.scala#L1375
 */
class GroupMetadataValueParser extends Parser
{
    const V0 = 0;
    const V1 = 1;
    const V2 = 2;
    const V3 = 3;

    private int $version;
    private array $parsed;

    public function __construct(string $data)
    {
        parent::__construct($data);
        $this->parsed = [];
        $this->version = -1;
        $this->parse();
    }

    protected function parse()
    {
        $this->version = $this->parseInt16();

        switch ($this->version) {
            case self::V0:
                $this->parsed = $this->parseV0();
                break;
            case self::V1:
                $this->parsed = $this->parseV1();
                break;
            case self::V2:
                $this->parsed = $this->parseV2();
                break;
            case self::V3:
                $this->parsed = $this->parseV3();
                break;
            default:
                throw new Exception(sprintf('Version %d not supported', $this->version));
                break;
        }
    }

    protected function parseV0(): array
    {
        return [
            'protocol_type' => $this->parseString(),
            'generation' => $this->parseInt32(),
            'protocol' => $this->parseString(), // nullable
            'leader' => $this->parseString(), // nullable
            'members' => $this->parseArray([$this, 'parseMembersV0']),
        ];
    }

    protected function parseMembersV0(): array
    {
        return [
            'member_id' => $this->parseString(),
            'client_id' => $this->parseString(),
            'client_host' => $this->parseString(),
            'session_timeout' => $this->parseInt32(),
            'subscription' => (new SubscriptionParser($this->parseBytes()))->getParsed(),
            'assignment' => (new AssignmentParser($this->parseBytes()))->getParsed(),
        ];
    }

    protected function parseV1(): array
    {
        return [
            'protocol_type' => $this->parseString(),
            'generation' => $this->parseInt32(),
            'protocol' => $this->parseString(), // nullable
            'leader' => $this->parseString(), // nullable
            'members' => $this->parseArray([$this, 'parseMembersV1']),
        ];
    }

    protected function parseMembersV1(): array
    {
        return [
            'member_id' => $this->parseString(),
            'client_id' => $this->parseString(),
            'client_host' => $this->parseString(),
            'rebalance_timeout' => $this->parseInt32(),
            'session_timeout' => $this->parseInt32(),
            'subscription' => (new SubscriptionParser($this->parseBytes()))->getParsed(),
            'assignment' => (new AssignmentParser($this->parseBytes()))->getParsed(),
        ];
    }

    protected function parseV2(): array
    {
        return [
            'protocol_type' => $this->parseString(),
            'generation' => $this->parseInt32(),
            'protocol' => $this->parseString(), // nullable
            'leader' => $this->parseString(), // nullable
            'current_state_timestamp' => $this->parseInt64(),
            'members' => $this->parseArray([$this, 'parseMembersV2']),
        ];
    }

    protected function parseMembersV2(): array
    {
        return $this->parseMembersV1();
    }

    protected function parseV3(): array
    {
        return [
            'protocol_type' => $this->parseString(),
            'generation' => $this->parseInt32(),
            'protocol' => $this->parseString(), // nullable
            'leader' => $this->parseString(), // nullable
            'current_state_timestamp' => $this->parseInt64(),
            'members' => $this->parseArray([$this, 'parseMembersV3']),
        ];
    }

    protected function parseMembersV3(): array
    {
        return [
            'member_id' => $this->parseString(),
            'group_instance_id' => $this->parseString(),
            'client_id' => $this->parseString(),
            'client_host' => $this->parseString(),
            'rebalance_timeout' => $this->parseInt32(),
            'session_timeout' => $this->parseInt32(),
            'subscription' => (new SubscriptionParser($this->parseBytes()))->getParsed(),
            'assignment' => (new AssignmentParser($this->parseBytes()))->getParsed(),
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
