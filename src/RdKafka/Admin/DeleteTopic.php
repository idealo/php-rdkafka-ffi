<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Api;

class DeleteTopic
{
    private ?CData $topic;

    public function __construct(string $name)
    {
        $this->topic = Api::rd_kafka_DeleteTopic_new($name);

        if ($this->topic === null) {
            $err = (int) Api::rd_kafka_last_error();
            throw Exception::fromError($err);
        }
    }

    public function __destruct()
    {
        if ($this->topic === null) {
            return;
        }

        Api::rd_kafka_DeleteTopic_destroy($this->topic);
    }

    public function getCData(): CData
    {
        return $this->topic;
    }
}
