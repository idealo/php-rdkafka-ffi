<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use RdKafka;

class DeleteConsumerGroupOffsetsOptions extends Options
{
    public function __construct(RdKafka $kafka)
    {
        parent::__construct($kafka, RD_KAFKA_ADMIN_OP_DELETECONSUMERGROUPOFFSETS);
    }
}
