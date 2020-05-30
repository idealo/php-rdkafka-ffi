<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use RdKafka\FFI\Library;

class KafkaError extends Exception
{
    private CData $error;

    public static function newRetriable(int $code, string $message = ''): self
    {
        Library::requireVersion('>=', '1.4.0');

        $error = Library::rd_kafka_error_new($code, $message);
        if ($error === null) {
            throw new Exception(sprintf('Failed to create with code %d and message %s', $code, $message));
        }
        $error->retriable = 1;
        return new static($error);
    }

    public static function newFatal(int $code, string $message = ''): self
    {
        Library::requireVersion('>=', '1.4.0');

        $error = Library::rd_kafka_error_new($code, $message);
        if ($error === null) {
            throw new Exception(sprintf('Failed to create with code %d and message %s', $code, $message));
        }
        $error->fatal = 1;
        return new static($error);
    }

    public static function newTransactionRequiresAbort(int $code, string $message = ''): self
    {
        Library::requireVersion('>=', '1.4.0');

        $error = Library::rd_kafka_error_new($code, $message);
        if ($error === null) {
            throw new Exception(sprintf('Failed to create with code %d and message %s', $code, $message));
        }
        $error->txn_requires_abort = 1;
        return new static($error);
    }

    public function __construct(CData $error)
    {
        Library::requireVersion('>=', '1.4.0');

        $message = Library::rd_kafka_error_string($error);
        $code = Library::rd_kafka_error_code($error);
        $this->error = $error;

        parent::__construct($message, $code);
    }

    public function __destruct()
    {
        Library::rd_kafka_error_destroy($this->error);
    }

    public function isFatal(): bool
    {
        return Library::rd_kafka_error_is_fatal($this->error) === 1;
    }

    public function isRetriable(): bool
    {
        return Library::rd_kafka_error_is_retriable($this->error) === 1;
    }

    public function transactionRequiresAbort(): bool
    {
        return Library::rd_kafka_error_txn_requires_abort($this->error) === 1;
    }

    public function getName(): string
    {
        return Library::rd_kafka_error_name($this->error);
    }
}
