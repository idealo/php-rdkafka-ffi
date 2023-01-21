<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;
use RdKafka\FFI\Library;
use RdKafka\FFI\OpaqueMap;

class Message
{
    public int $err;

    public ?string $topic_name;

    public int $partition;

    public ?string $payload;

    public ?int $len;

    public ?string $key;

    public int $offset;

    public int $timestamp;

    public int $timestampType;

    public array $headers;

    /**
     * @var int microseconds
     */
    public int $latency;

    public int $status;

    /**
     * @since 1.5.0 of librdkafka
     */
    public int $brokerId;

    /**
     * @var mixed|null Note: RdKafka extension supports only string
     */
    public $opaque;

    public function __construct(CData $nativeMessage)
    {
        $timestampType = Library::new('rd_kafka_timestamp_type_t');
        $this->timestamp = (int) Library::rd_kafka_message_timestamp($nativeMessage, FFI::addr($timestampType));
        $this->timestampType = (int) $timestampType->cdata;

        $this->err = (int) $nativeMessage->err;

        if ($nativeMessage->rkt !== null) {
            $this->topic_name = Library::rd_kafka_topic_name($nativeMessage->rkt);
        } else {
            $this->topic_name = null;
        }

        $this->partition = (int) $nativeMessage->partition;

        if ($nativeMessage->payload !== null) {
            $this->payload = FFI::string($nativeMessage->payload, $nativeMessage->len);
            $this->len = (int) $nativeMessage->len;
        } else {
            $this->payload = null;
            $this->len = null;
        }

        if ($nativeMessage->key !== null) {
            $this->key = FFI::string($nativeMessage->key, $nativeMessage->key_len);
        } else {
            $this->key = null;
        }

        $this->offset = (int) $nativeMessage->offset;

        $this->headers = $this->parseHeaders($nativeMessage);

        $this->latency = (int) Library::rd_kafka_message_latency($nativeMessage);

        $this->status = (int) Library::rd_kafka_message_status($nativeMessage);

        if (Library::hasMethod('rd_kafka_message_broker_id') === true) {
            $this->brokerId = (int) Library::rd_kafka_message_broker_id($nativeMessage);
        } else {
            $this->brokerId = -1;
        }

        $this->opaque = OpaqueMap::pull($nativeMessage->_private);
    }

    public function errstr(): string
    {
        return rd_kafka_err2str($this->err);
    }

    private function parseHeaders(CData $nativeMessage): array
    {
        $headers = [];

        if ($nativeMessage->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            return $headers;
        }

        $message_headers = Library::rd_kafka_headers_new(0);

        $resp = (int) Library::rd_kafka_message_headers($nativeMessage, FFI::addr($message_headers));
        if ($resp === RD_KAFKA_RESP_ERR__NOENT) {
            return $headers;
        }

        if ($resp !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            $this->err = $resp;
            return $headers;
        }

        if ($message_headers !== null) {
            $header_count = (int) Library::rd_kafka_header_cnt($message_headers);
            $header_name = Library::new('char*');
            $header_name_ptr = FFI::addr($header_name);
            $header_value = Library::new('char*');
            $header_value_ptr = FFI::addr($header_value);
            $header_size = Library::new('size_t');
            $header_size_ptr = FFI::addr($header_size);

            for ($i = 0; $i < $header_count; $i++) {
                $header_response = (int) Library::rd_kafka_header_get_all(
                    $message_headers,
                    $i,
                    $header_name_ptr,
                    $header_value_ptr,
                    $header_size_ptr
                );

                if ($header_response !== RD_KAFKA_RESP_ERR_NO_ERROR) {
                    break;
                }

                $headers[FFI::string($header_name)] = FFI::string($header_value, (int) $header_size->cdata);
            }
        }

        return $headers;
    }
}
