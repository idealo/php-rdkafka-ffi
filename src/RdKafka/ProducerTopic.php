<?php

declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;
use RdKafka\FFI\Library;
use RdKafka\FFI\OpaqueMap;

use function sprintf;
use function strlen;

class ProducerTopic extends Topic
{
    /**
     * @param TopicConf $conf
     * @throws Exception
     */
    public function __construct(Producer $producer, string $name, ?TopicConf $conf = null)
    {
        parent::__construct($producer, $name, $conf);
    }

    /**
     * @param string $payload
     * @param string $key
     *
     * @throws Exception
     */
    public function produce(int $partition, int $msgflags, ?string $payload = null, ?string $key = null, $opaque = null): void
    {
        $this->assertPartition($partition);
        $this->assertMsgflags($msgflags);

        $cOpaque = OpaqueMap::push($opaque);

        $ret = Library::rd_kafka_produce(
            $this->topic,
            $partition,
            $msgflags | RD_KAFKA_MSG_F_COPY,
            $payload,
            $payload === null ? null : strlen($payload),
            $key,
            $key === null ? null : strlen($key),
            $cOpaque === null ? null : \FFI::addr($cOpaque)
        );

        if ($ret === -1) {
            OpaqueMap::pull($cOpaque);
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }
    }

    /**
     * @throws Exception
     */
    public function producev(
        int $partition,
        int $msgflags,
        ?string $payload = null,
        ?string $key = null,
        ?array $headers = null,
        ?int $timestamp_ms = null,
        $opaque = null
    ): void {
        $this->assertPartition($partition);
        $this->assertMsgflags($msgflags);

        $cOpaque = OpaqueMap::push($opaque);

        $args = [
            RD_KAFKA_VTYPE_RKT,
            $this->topic,
            RD_KAFKA_VTYPE_PARTITION,
            $partition,
            RD_KAFKA_VTYPE_MSGFLAGS,
            $msgflags | RD_KAFKA_MSG_F_COPY,
            RD_KAFKA_VTYPE_VALUE,
            $payload,
            $payload === null ? null : strlen($payload),
            RD_KAFKA_VTYPE_KEY,
            $key,
            $key === null ? null : strlen($key),
            RD_KAFKA_VTYPE_TIMESTAMP,
            $timestamp_ms === null ? 0 : $timestamp_ms,
            RD_KAFKA_VTYPE_OPAQUE,
            $cOpaque === null ? null : \FFI::addr($cOpaque),
        ];

        if (empty($headers) === false) {
            foreach ($headers as $headerName => $headerValue) {
                $args[] = RD_KAFKA_VTYPE_HEADER;
                $args[] = $headerName;
                $args[] = $headerValue;
                $args[] = strlen($headerValue);
            }
        }

        $args[] = RD_KAFKA_VTYPE_END;

        $ret = Library::rd_kafka_producev(
            $this->kafka->getCData(),
            ...$args
        );

        if ($ret === -1) {
            OpaqueMap::pull($cOpaque);
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }
    }

    private function assertPartition(int $partition): void
    {
        if ($partition !== RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }
    }

    private function assertMsgflags(int $msgflags): void
    {
        if ($msgflags !== 0 && $msgflags !== RD_KAFKA_MSG_F_BLOCK) {
            throw new InvalidArgumentException(sprintf("Invalid value '%d' for msgflags", $msgflags));
        }
    }
}
