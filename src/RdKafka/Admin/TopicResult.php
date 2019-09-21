<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;

class TopicResult extends Api
{
    public function __construct(CData $data)
    {
        parent::__construct();
    }

    public function error(): int
    {
        // rd_kafka_topic_result_error
    }

    public function errstr(): string
    {
        // rd_kafka_topic_result_error_string
    }

    public function name(): string
    {
        // rd_kafka_topic_result_name
    }
}
