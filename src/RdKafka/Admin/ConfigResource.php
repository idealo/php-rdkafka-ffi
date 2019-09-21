<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;

class ConfigResource extends Api
{
    public function __construct(int $type, string $name)
    {
        parent::__construct();

        // rd_kafka_ConfigResource_new
    }

    public function __destruct()
    {
        // rd_kafka_ConfigResource_destroy
        // rd_kafka_ConfigResource_destroy_array
    }

    public function getCData(): CData
    {

    }

    public function setConfig(string $name, string $value)
    {
        // rd_kafka_ConfigResource_set_config
    }
}
