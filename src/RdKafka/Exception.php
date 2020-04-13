<?php

declare(strict_types=1);

namespace RdKafka;

use Throwable;

class Exception extends \Exception
{
    public static function fromError(int $code): self
    {
        return new self(rd_kafka_err2str($code), $code);
    }

    public function __construct($message = '', $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
