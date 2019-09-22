<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Api;
use RdKafka\Exception;

class DeleteTopic extends Api
{
    private ?CData $topic;

    public function __construct(string $name)
    {
        parent::__construct();

        $this->topic = self::$ffi->rd_kafka_DeleteTopic_new($name);

        if ($this->topic === null) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }
    }

    public function __destruct()
    {
        if ($this->topic === null) {
            return;
        }

        self::$ffi->rd_kafka_DeleteTopic_destroy($this->topic);
    }

    public function getCData(): CData
    {
        return $this->topic;
    }
}

