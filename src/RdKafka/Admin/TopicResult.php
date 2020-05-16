<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\FFI\Library;

class TopicResult
{
    public int $error;
    public ?string $errorString;
    public string $name;

    public function __construct(CData $result)
    {
        $this->error = (int) Library::rd_kafka_topic_result_error($result);
        $this->errorString = Library::rd_kafka_topic_result_error_string($result);
        $this->name = Library::rd_kafka_topic_result_name($result);
    }
}
