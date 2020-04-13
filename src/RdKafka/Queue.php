<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use RdKafka;
use RdKafka\FFI\Api;

class Queue
{
    private CData $queue;

    public function __construct(CData $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @throws Exception
     */
    public static function fromRdKafka(RdKafka $kafka): self
    {
        $queue = Api::rd_kafka_queue_new($kafka->getCData());

        if ($queue === null) {
            throw new Exception('Failed to create new queue.');
        }

        return new self($queue);
    }

    public function __destruct()
    {
        Api::rd_kafka_queue_destroy($this->queue);
    }

    public function getCData(): CData
    {
        return $this->queue;
    }

    /**
     * @throws Exception
     */
    public function consume(int $timeout_ms): ?Message
    {
        $nativeMessage = Api::rd_kafka_consume_queue(
            $this->queue,
            $timeout_ms
        );

        if ($nativeMessage === null) {
            $err = (int) Api::rd_kafka_last_error();

            if ($err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
                return null;
            }

            throw Exception::fromError($err);
        }

        $message = new Message($nativeMessage);

        Api::rd_kafka_message_destroy($nativeMessage);

        return $message;
    }

    public function poll(int $timeout_ms): ?Event
    {
        $nativeEvent = Api::rd_kafka_queue_poll(
            $this->queue,
            $timeout_ms
        );

        if ($nativeEvent === null) {
            return null;
        }

        return new Event($nativeEvent);
    }
}
