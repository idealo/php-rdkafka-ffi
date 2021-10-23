<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use InvalidArgumentException;
use RdKafka\FFI\ConsumeCallbackProxy;
use RdKafka\FFI\Library;
use RdKafka\FFI\OpaqueMap;

use function array_key_exists;
use function array_keys;
use function sprintf;

class ConsumerTopic extends Topic
{
    private array $consuming = [];

    /**
     * @param TopicConf $conf
     * @throws Exception
     */
    public function __construct(Consumer $consumer, string $name, ?TopicConf $conf = null)
    {
        parent::__construct($consumer, $name, $conf);
    }

    public function __destruct()
    {
        foreach (array_keys($this->consuming) as $partition) {
            $this->consumeStop($partition);
        }

        parent::__destruct();
    }

    /**
     * @throws Exception
     */
    public function consume(int $partition, int $timeout_ms): ?Message
    {
        $this->assertPartition($partition);

        $nativeMessage = Library::rd_kafka_consume(
            $this->topic,
            $partition,
            $timeout_ms
        );

        if ($nativeMessage === null) {
            $err = (int) Library::rd_kafka_last_error();

            if ($err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
                return null;
            }

            throw Exception::fromError($err);
        }

        $message = new Message($nativeMessage);

        Library::rd_kafka_message_destroy($nativeMessage);

        return $message;
    }

    /**
     * @return Message[]
     * @throws Exception
     */
    public function consumeBatch(int $partition, int $timeout_ms, int $batch_size): array
    {
        if ($batch_size <= 0) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for batch_size", $batch_size));
        }

        $this->assertPartition($partition);

        $nativeMessages = Library::new('rd_kafka_message_t*[' . $batch_size . ']');

        $result = (int) Library::rd_kafka_consume_batch(
            $this->topic,
            $partition,
            $timeout_ms,
            $nativeMessages,
            $batch_size
        );

        if ($result === -1) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
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
                Library::rd_kafka_message_destroy($nativeMessages[$i]);
            }
        }
        return $messages;
    }

    /**
     * @throws Exception
     */
    public function consumeQueueStart(int $partition, int $offset, Queue $queue): void
    {
        $this->assertPartition($partition);

        if (array_key_exists($partition, $this->consuming)) {
            throw new Exception(
                sprintf(
                    '%s:%d is already being consumed by the same Consumer instance',
                    $this->getName(),
                    $partition
                )
            );
        }

        $ret = Library::rd_kafka_consume_start_queue(
            $this->topic,
            $partition,
            $offset,
            $queue->getCData()
        );

        if ($ret === -1) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }

        $this->consuming[$partition] = true;
    }

    /**
     * @throws Exception
     */
    public function consumeStart(int $partition, int $offset): void
    {
        $this->assertPartition($partition);

        if (array_key_exists($partition, $this->consuming)) {
            throw new Exception(
                sprintf(
                    '%s:%d is already being consumed by the same Consumer instance',
                    $this->getName(),
                    $partition
                )
            );
        }

        $ret = Library::rd_kafka_consume_start(
            $this->topic,
            $partition,
            $offset
        );

        if ($ret === -1) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }

        $this->consuming[$partition] = true;
    }

    /**
     * @throws Exception
     */
    public function consumeStop(int $partition): void
    {
        $this->assertPartition($partition);

        $ret = Library::rd_kafka_consume_stop(
            $this->topic,
            $partition
        );

        if ($ret === -1) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }

        unset($this->consuming[$partition]);
    }

    /**
     * @throws Exception
     */
    public function offsetStore(int $partition, int $offset): void
    {
        $this->assertPartition($partition);

        $err = Library::rd_kafka_offset_store(
            $this->topic,
            $partition,
            $offset
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw Exception::fromError($err);
        }
    }

    /**
     * @deprecated since 1.4.0 librdkafka
     */
    public function consumeCallback(int $partition, int $timeout_ms, callable $callback, $opaque = null): int
    {
        $this->assertPartition($partition);

        $cOpaque = OpaqueMap::push($opaque);

        $result = (int) Library::rd_kafka_consume_callback(
            $this->topic,
            $partition,
            $timeout_ms,
            ConsumeCallbackProxy::create($callback),
            $cOpaque === null ? null : \FFI::addr($cOpaque)
        );

        if ($result === -1) {
            OpaqueMap::pull($cOpaque);
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }

        return $result;
    }

    private function assertPartition(int $partition): void
    {
        if ($partition !== RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }
    }
}
