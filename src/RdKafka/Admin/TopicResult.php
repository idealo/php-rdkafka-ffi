<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI;
use FFI\CData;
use RdKafka\Api;

class TopicResult extends Api
{
    public int $error;
    public ?string $errorString;
    public string $name;

    public function __construct(CData $result)
    {
        $this->error = (int) self::getFFI()->rd_kafka_topic_result_error($result);
        $errorStringCdata = self::getFFI()->rd_kafka_topic_result_error_string($result);
        $this->errorString = $errorStringCdata === null ? null : FFI::string($errorStringCdata);
        $this->name = FFI::string(self::getFFI()->rd_kafka_topic_result_name($result));
    }
}
