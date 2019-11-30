<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;

class TopicResult extends Api
{
    private CData $result;

    public $error;
    public $errorString;
    public $name;

    public function __construct(CData $result)
    {
        parent::__construct();

        $this->error = (int)self::$ffi->rd_kafka_topic_result_error($result);
        $this->errorString = (string)self::$ffi->rd_kafka_topic_result_error_string($result);
        $this->name = (string)self::$ffi->rd_kafka_topic_result_name($result);
    }
}
