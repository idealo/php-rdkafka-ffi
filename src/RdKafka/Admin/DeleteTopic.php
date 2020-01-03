<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Api;

class DeleteTopic extends Api
{
    private ?CData $topic;

    public function __construct(string $name)
    {
        $this->topic = self::getFFI()->rd_kafka_DeleteTopic_new($name);

        if ($this->topic === null) {
            $err = self::getFFI()->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }
    }

    public function __destruct()
    {
        if ($this->topic === null) {
            return;
        }

        self::getFFI()->rd_kafka_DeleteTopic_destroy($this->topic);
    }

    public function getCData(): CData
    {
        return $this->topic;
    }
}
