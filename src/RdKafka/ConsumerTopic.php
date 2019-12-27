<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use InvalidArgumentException;

class ConsumerTopic extends Topic
{
    /**
     * @var array
     */
    private array $consuming = [];

    /**
     * @param Consumer $consumer
     * @param string $name
     * @param TopicConf $conf
     * @throws Exception
     */
    public function __construct(Consumer $consumer, string $name, TopicConf $conf = null)
    {
        parent::__construct($consumer, $name, $conf);
    }

    public function __destruct()
    {
        foreach ($this->consuming as $partition => $ignore) {
            $this->consumeStop($partition);
        }

        parent::__destruct();
    }

    /**
     * @param int $partition
     * @param int $timeout_ms
     *
     * @return Message|null
     * @throws Exception
     */
    public function consume(int $partition, int $timeout_ms)
    {
        $this->assertPartition($partition);

        $nativeMessage = self::$ffi->rd_kafka_consume(
            $this->topic,
            $partition,
            $timeout_ms
        );

        if ($nativeMessage === null) {
            $err = self::$ffi->rd_kafka_last_error();

            if ($err == RD_KAFKA_RESP_ERR__TIMED_OUT) {
                return null;
            }

            throw new Exception(self::err2str($err));
        }

        $message = new Message($nativeMessage);

        self::$ffi->rd_kafka_message_destroy($nativeMessage);

        return $message;
    }

    /**
     * @param int $partition
     * @param int $timeout_ms
     * @param int $batch_size
     * @return Message[]
     * @throws Exception
     */
    public function consumeBatch(int $partition, int $timeout_ms, int $batch_size): array
    {
        if ($batch_size <= 0) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for batch_size", $batch_size));
        }

        $this->assertPartition($partition);

        $nativeMessages = self::$ffi->new('rd_kafka_message_t*[' . $batch_size . ']');

        $result = (int)self::$ffi->rd_kafka_consume_batch(
            $this->topic,
            $partition,
            $timeout_ms,
            $nativeMessages,
            $batch_size
        );

        if ($result == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }

        return $this->parseMessages($nativeMessages, $result);
    }

    private function parseMessages(CData $nativeMessages, int $size): array
    {
        $messages = [];
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                $messages[] = new Message($nativeMessages[$i]);
            }
            for ($i = 0; $i < $size; $i++) {
                self::$ffi->rd_kafka_message_destroy($nativeMessages[$i]);
            }
        }
        return $messages;
    }

    /**
     * @param int $partition
     * @param int $offset
     * @param Queue $queue
     *
     * @return void
     * @throws Exception
     */
    public function consumeQueueStart(int $partition, int $offset, Queue $queue)
    {
        $this->assertPartition($partition);

        if (\array_key_exists($partition, $this->consuming)) {
            throw new Exception(
                sprintf(
                    "%s:%d is already being consumed by the same Consumer instance",
                    $this->getName(),
                    $partition
                )
            );
        }

        $ret = self::$ffi->rd_kafka_consume_start_queue(
            $this->topic,
            $partition,
            $offset,
            $queue->getCData()
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }

        $this->consuming[$partition] = true;
    }

    /**
     * @param int $partition
     * @param int $offset
     *
     * @return void
     * @throws Exception
     */
    public function consumeStart(int $partition, int $offset)
    {
        $this->assertPartition($partition);

        if (\array_key_exists($partition, $this->consuming)) {
            throw new Exception(
                sprintf(
                    "%s:%d is already being consumed by the same Consumer instance",
                    $this->getName(),
                    $partition
                )
            );
        }

        $ret = self::$ffi->rd_kafka_consume_start(
            $this->topic,
            $partition,
            $offset
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }

        $this->consuming[$partition] = true;
    }

    /**
     * @param int $partition
     *
     * @return void
     * @throws Exception
     */
    public function consumeStop(int $partition)
    {
        $this->assertPartition($partition);

        $ret = self::$ffi->rd_kafka_consume_stop(
            $this->topic,
            $partition
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }

        unset($this->consuming[$partition]);
    }

    /**
     * @param int $partition
     * @param int $offset
     *
     * @return void
     * @throws Exception
     */
    public function offsetStore(int $partition, int $offset)
    {
        $this->assertPartition($partition);

        $err = self::$ffi->rd_kafka_offset_store(
            $this->topic,
            $partition,
            $offset
        );

        if ($err != RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }

    public function consumeCallback(int $partition, int $timeout_ms, callable $callback): int
    {
        $this->assertPartition($partition);

        $proxyCallback = function ($nativeMessage, $opaque = null) use ($callback) {
            $callback(
                new Message($nativeMessage),
                $opaque
            );
        };

        $result = (int)self::$ffi->rd_kafka_consume_callback(
            $this->topic,
            $partition,
            $timeout_ms,
            $proxyCallback,
            null // opaque
        );

        if ($result === -1) {
            $err = (int)self::$ffi->rd_kafka_last_error();

            throw new Exception(self::err2str($err));
        }

        return $result;
    }

    private function assertPartition(int $partition): void
    {
        if ($partition != RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }
    }
}
