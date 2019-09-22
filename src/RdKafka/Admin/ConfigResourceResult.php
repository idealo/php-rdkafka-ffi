<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;

class ConfigResourceResult extends Api
{
    public function __construct(CData $event)
    {
        parent::__construct();
    }

    public function __destruct()
    {
        // rd_kafka_ConfigResource_destroy
        // rd_kafka_ConfigResource_destroy_array
    }

    public function getCData(): CData
    {

    }

    public function name(): string
    {
        // rd_kafka_ConfigResource_name
    }

    public function type(): string
    {
        // rd_kafka_ConfigResource_type
    }

    public function error(): int
    {
        // rd_kafka_ConfigResource_error
    }

    public function errorString(): string
    {
        // rd_kafka_ConfigResource_error_string
    }

    public function configs(): array
    {
        // rd_kafka_ConfigResource_configs
    }
}
