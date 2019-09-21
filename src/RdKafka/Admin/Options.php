<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;

abstract class Options extends Api
{
    public function __construct(int $for_api)
    {
        parent::__construct();

        // rd_kafka_AdminOptions_new
    }

    public function __destruct()
    {
        // rd_kafka_AdminOptions_destroy
    }

    public function getCData(): CData
    {

    }

    public function setRequestTimeout(int $timeout_ms)
    {
        // rd_kafka_AdminOptions_set_request_timeout
    }

    public function setOperationTimeout(int $timeout_ms)
    {
        // rd_kafka_AdminOptions_set_request_timeout
    }

    public function setValidateOnly(bool $true_or_false)
    {
        // rd_kafka_AdminOptions_set_validate_only
    }

    public function setBrokerId(int $broker_id)
    {
        // rd_kafka_AdminOptions_set_broker
    }
}
