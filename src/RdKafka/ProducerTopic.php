<?php

declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;

class ProducerTopic extends Topic
{
    /**
     * @param Producer $producer
     * @param string $name
     * @param TopicConf $conf
     * @throws Exception
     */
    public function __construct(Producer $producer, string $name, TopicConf $conf = null)
    {
        parent::__construct($producer, $name, $conf);
    }

    /**
     * @param int $partition
     * @param int $msgflags
     * @param string $payload
     * @param string $key
     *
     * @return void
     * @throws Exception
     */
    public function produce(int $partition, int $msgflags, string $payload = null, string $key = null)
    {
        $this->assertPartition($partition);
        $this->assertMsgflags($msgflags);

        $ret = self::$ffi->rd_kafka_produce(
            $this->topic,
            $partition,
            $msgflags | RD_KAFKA_MSG_F_COPY,
            $payload,
            \is_null($payload) ? null : \strlen($payload),
            $key,
            \is_null($key) ? null : \strlen($key),
            null
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }
    }

    /**
     * @param int $partition
     * @param int $msgflags
     * @param string|null $payload
     * @param string|null $key
     * @param array $headers
     *
     * @return void
     * @throws Exception
     */
    public function producev(
        int $partition,
        int $msgflags,
        string $payload = null,
        string $key = null,
        array $headers = [],
        int $timestamp_ms = null
    ) {
        $this->assertPartition($partition);
        $this->assertMsgflags($msgflags);

        $args = [
            RD_KAFKA_VTYPE_RKT,
            $this->topic,
            RD_KAFKA_VTYPE_PARTITION,
            $partition,
            RD_KAFKA_VTYPE_MSGFLAGS,
            $msgflags | RD_KAFKA_MSG_F_COPY,
            RD_KAFKA_VTYPE_VALUE,
            $payload,
            \is_null($payload) ? null : \strlen($payload),
            RD_KAFKA_VTYPE_KEY,
            $key,
            \is_null($key) ? null : \strlen($key),
            RD_KAFKA_VTYPE_TIMESTAMP,
            \is_null($timestamp_ms) ? 0 : $timestamp_ms,
        ];

        if (empty($headers) === false) {
            foreach ($headers as $headerName => $headerValue) {
                $args[] = RD_KAFKA_VTYPE_HEADER;
                $args[] = $headerName;
                $args[] = $headerValue;
                $args[] = \strlen($headerValue);
            }
        }

        $args[] = RD_KAFKA_VTYPE_END;

        $ret = self::$ffi->rd_kafka_producev(
            $this->kafka->getCData(),
            ...$args
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }
    }

    private function assertPartition(int $partition): void
    {
        if ($partition != RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }
    }

    private function assertMsgflags(int $msgflags): void
    {
        if ($msgflags != 0 && $msgflags != RD_KAFKA_MSG_F_BLOCK) {
            throw new InvalidArgumentException(sprintf("Invalid value '%d' for msgflags", $msgflags));
        }
    }
}
