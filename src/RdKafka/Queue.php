<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;

class Queue extends Api
{
    private CData $queue;

    public function __construct(Consumer $kafka)
    {
        parent::__construct();

        $this->queue = self::$ffi->rd_kafka_queue_new($kafka->getCData());

        if ($this->queue === null) {
            throw new Exception('Failed to create new queue.');
        }
    }

    public function __destruct()
    {
        self::$ffi->rd_kafka_queue_destroy($this->queue);
    }

    public function getCData(): CData
    {
        return $this->queue;
    }

    /**
     * @param int $timeout_ms
     *
     * @return Message|null
     * @throws Exception
     */
    public function consume(int $timeout_ms)
    {
        $nativeMessage = self::$ffi->rd_kafka_consume_queue(
            $this->queue,
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
}
