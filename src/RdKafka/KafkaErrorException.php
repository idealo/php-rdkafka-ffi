<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use RdKafka\FFI\Library;

class KafkaErrorException extends Exception
{
    private string $error_string;
    private bool $isFatal;
    private bool $isRetriable;
    private bool $transactionRequiresAbort;

    public function __construct(
        string $message,
        int $code,
        string $error_string,
        bool $isFatal = false,
        bool $isRetriable = false,
        bool $transactionRequiresAbort = false
    ) {
        parent::__construct($message, $code);

        $this->error_string = $error_string;
        $this->isFatal = $isFatal;
        $this->isRetriable = $isRetriable;
        $this->transactionRequiresAbort = $transactionRequiresAbort;
    }

    public static function fromCData(CData $error)
    {
        Library::requireVersion('>=', '1.4.0');

        return new static(
            Library::rd_kafka_error_name($error),
            Library::rd_kafka_error_code($error),
            Library::rd_kafka_error_string($error),
            (bool) Library::rd_kafka_error_is_fatal($error),
            (bool) Library::rd_kafka_error_is_retriable($error),
            (bool) Library::rd_kafka_error_txn_requires_abort($error),
        );
    }

    public function getErrorString(): string
    {
        return $this->error_string;
    }

    public function isFatal(): bool
    {
        return $this->isFatal;
    }

    public function isRetriable(): bool
    {
        return $this->isRetriable;
    }

    public function transactionRequiresAbort(): bool
    {
        return $this->transactionRequiresAbort;
    }
}
