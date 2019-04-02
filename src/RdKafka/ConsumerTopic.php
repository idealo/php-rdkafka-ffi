<?php
declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;

class ConsumerTopic extends Topic
{
    /**
     * @var array
     */
    private $consuming = [];

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

    /**
     * @param int $partition
     * @param int $timeout_ms
     *
     * @return Message|null
     * @throws Exception
     */
    public function consume(int $partition, int $timeout_ms)
    {
        if ($partition != RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }

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

            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }

        $message = new Message($nativeMessage);

        self::$ffi->rd_kafka_message_destroy($nativeMessage);

        return $message;
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
        if ($partition != RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }

        $key = $this->getName() . ':' . $partition;
        if (array_key_exists($key, $this->consuming)) {
            throw new Exception(sprintf(
                "%s:%d is already being consumed by the same Consumer instance",
                $this->getName(),
                $partition
            ));
        }

        $ret = self::$ffi->rd_kafka_consume_start_queue(
            $this->topic,
            $partition,
            $offset,
            $queue->getCData()
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }

        $this->consuming[$key] = true;
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
        if ($partition != RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }

        $key = $this->getName() . ':' . $partition;
        if (array_key_exists($key, $this->consuming)) {
            throw new Exception(sprintf(
                "%s:%d is already being consumed by the same Consumer instance",
                $this->getName(),
                $partition
            ));
        }

        $ret = self::$ffi->rd_kafka_consume_start(
            $this->topic,
            $partition,
            $offset
        );


        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }

        $this->consuming[$key] = true;
    }

    /**
     * @param int $partition
     *
     * @return void
     * @throws Exception
     */
    public function consumeStop(int $partition)
    {
        $ret = self::$ffi->rd_kafka_consume_stop(
            $this->topic,
            $partition
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }

        $key = $this->getName() . ':' . $partition;
        unset($this->consuming[$key]);
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
        $err = self::$ffi->rd_kafka_consume_stop(
            $this->topic,
            $partition,
            $offset
        );

        if ($err != RD_KAFKA_RESP_ERR_NO_ERROR) {
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }
    }
}
