<?php

declare(strict_types=1);

namespace RdKafka\Examples\Protocol;

/**
 * @see https://kafka.apache.org/protocol#protocol_types
 */
class Parser
{
    protected int $offset;
    protected string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
        $this->offset = 0;
    }

    protected function parseString(): string
    {
        $length = $this->parseInt16();
        if ($length <= 0) {
            return '';
        }
        $value = substr($this->data, $this->offset, $length);
        $this->offset += $length;
        return $value;
    }

    protected function parseNullableString(): ?string
    {
        $length = $this->parseInt16();
        if ($length < 0) {
            return null;
        }
        if ($length === 0) {
            return '';
        }
        $value = substr($this->data, $this->offset, $length);
        $this->offset += $length;
        return $value;
    }

    protected function parseBytes(): string
    {
        $length = $this->parseInt32();
        if ($length <= 0) {
            return '';
        }
        $value = substr($this->data, $this->offset, $length);
        $this->offset += $length;
        return $value;
    }

    protected function parseNullableBytes(): ?string
    {
        $length = $this->parseInt32();
        if ($length < 0) {
            return null;
        }
        if ($length === 0) {
            return '';
        }
        $value = substr($this->data, $this->offset, $length);
        $this->offset += $length;
        return $value;
    }

    protected function parseInt16(): int
    {
        $value = current(unpack('n1', $this->data, $this->offset));
        // sign
        $value = $value << 48 >> 48;
        $this->offset += 2;
        return $value;
    }

    protected function parseInt32(): int
    {
        $value = current(unpack('N1', $this->data, $this->offset));
        // sign
        $value = $value << 32 >> 32;
        $this->offset += 4;
        return $value;
    }

    protected function parseUInt32(): int
    {
        $value = current(unpack('N1', $this->data, $this->offset));
        $this->offset += 4;
        return $value;
    }

    protected function parseInt64(): int
    {
        $value = current(unpack('J1', $this->data, $this->offset));
        $this->offset += 8;
        return $value;
    }

    protected function parseArray(callable $callable): array
    {
        $length = $this->parseInt32();
        if ($length === 4294967295 /* -1 */ || $length === 0) {
            return [];
        }
        $value = [];
        for ($i = 0; $i < $length; $i++) {
            $value[] = $callable();
        }
        return $value;
    }
}
