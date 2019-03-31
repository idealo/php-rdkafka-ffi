<?php

namespace RdKafka;

class Message extends Api
{
    public function __construct($nativeMessage)
    {
        parent::__construct();

        $timestampType = self::$ffi->new('rd_kafka_timestamp_type_t');
        $this->timestamp = (int)self::$ffi->rd_kafka_message_timestamp($nativeMessage, \FFI::addr($timestampType));
        $this->timestampType = (int)$timestampType;

        $this->err = $nativeMessage->err;

        if ($nativeMessage->rkt !== null) {
            $this->topic_name = (string)self::$ffi->rd_kafka_topic_name($nativeMessage->rkt);
        }

        $this->partition = (int)$nativeMessage->partition;

        if ($nativeMessage->payload !== null) {
            $this->payload = \FFI::string($nativeMessage->payload, $nativeMessage->len);
            $this->len = (int)$nativeMessage->len;
        }

        if ($nativeMessage->key !== null) {
            $this->key = \FFI::string($nativeMessage->key, $nativeMessage->key_len);
        }

        $this->offset = (int)$nativeMessage->offset;

        return $this;
    }

    /**
     * @var int
     */
    public $err;

    /**
     * @var string
     */
    public $topic_name;

    /**
     * @var int
     */
    public $partition;

    /**
     * @var string
     */
    public $payload;

    /**
     * @var int
     */
    public $len;

    /**
     * @var string
     */
    public $key;

    /**
     * @var int
     */
    public $offset;

    /**
     * @var int
     */
    public $timestamp;

    /**
     * @var int
     */
    public $timestampType;

    /**
     * @return string
     */
    public function errstr()
    {
        return self::err2str($this->err);
    }
}
