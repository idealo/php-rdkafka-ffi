<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI\CData;
use RdKafka\Exception;
use RdKafka\FFI\Library;

class DeleteGroup
{
    private ?CData $group;

    public function __construct(string $name)
    {
        $this->group = Library::rd_kafka_DeleteGroup_new($name);

        if ($this->group === null) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }
    }

    public function __destruct()
    {
        if ($this->group === null) {
            return;
        }

        Library::rd_kafka_DeleteGroup_destroy($this->group);
    }

    public function getCData(): CData
    {
        return $this->group;
    }
}
