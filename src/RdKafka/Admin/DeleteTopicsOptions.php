<?php
declare(strict_types=1);

namespace RdKafka\Admin;

class DeleteTopicsOptions extends Options
{
    public function __construct()
    {
        parent::__construct(RD_KAFKA_ADMIN_OP_DELETETOPICS);
    }
}
