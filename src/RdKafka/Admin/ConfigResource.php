<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;
use RdKafka\Exception;

class ConfigResource extends Api
{
    private CData $resource;

    public function __construct(int $type, string $name)
    {
        $this->resource = self::getFFI()->rd_kafka_ConfigResource_new(
            $type,
            $name
        );
    }

    public function __destruct()
    {
        self::getFFI()->rd_kafka_ConfigResource_destroy($this->resource);
    }

    public function getCData(): CData
    {
        return $this->resource;
    }

    /**
     * @throws Exception
     */
    public function setConfig(string $name, string $value): void
    {
        $err = (int) self::getFFI()->rd_kafka_ConfigResource_set_config(
            $this->resource,
            $name,
            $value
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }
}
