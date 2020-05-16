<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI;
use FFI\CData;
use RdKafka\FFI\Library;

class ConfigResourceResult
{
    public string $name;
    public int $type;
    public int $error;
    public ?string $errorString;

    /**
     * @var ConfigEntry[]
     */
    public array $configs;

    public function __construct(CData $result)
    {
        $this->name = Library::rd_kafka_ConfigResource_name($result);
        $this->type = Library::rd_kafka_ConfigResource_type($result);
        $this->error = Library::rd_kafka_ConfigResource_error($result);
        $this->errorString = Library::rd_kafka_ConfigResource_error_string($result);

        $size = Library::new('size_t');
        $configsPtr = Library::rd_kafka_ConfigResource_configs($result, FFI::addr($size));
        $configs = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $configs[] = new ConfigEntry($configsPtr[$i]);
        }
        $this->configs = $configs;
    }
}
