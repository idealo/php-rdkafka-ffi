<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI;
use FFI\CData;
use RdKafka\FFI\Api;

class TopicResult
{
    public int $error;
    public ?string $errorString;
    public string $name;

    public function __construct(CData $result)
    {
        $this->error = (int) Api::rd_kafka_topic_result_error($result);
        $errorStringCdata = Api::rd_kafka_topic_result_error_string($result);
        $this->errorString = $errorStringCdata === null ? null : FFI::string($errorStringCdata);
        $this->name = FFI::string(Api::rd_kafka_topic_result_name($result));
    }
}
