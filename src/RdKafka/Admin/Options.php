<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI;
use FFI\CData;
use RdKafka;
use RdKafka\Exception;
use RdKafka\FFI\Library;

abstract class Options
{
    private CData $options;

    public function __construct(RdKafka $kafka, int $for_api)
    {
        $this->options = Library::rd_kafka_AdminOptions_new($kafka->getCData(), $for_api);
    }

    public function __destruct()
    {
        if (isset($this->options)) {
            Library::rd_kafka_AdminOptions_destroy($this->options);
        }
    }

    public function getCData(): CData
    {
        return $this->options;
    }

    public function setRequestTimeout(int $timeout_ms): void
    {
        $errstr = Library::new('char[512]');
        $err = Library::rd_kafka_AdminOptions_set_request_timeout(
            $this->options,
            $timeout_ms,
            $errstr,
            FFI::sizeOf($errstr)
        );
        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(FFI::string($errstr));
        }
    }

    public function setOperationTimeout(int $timeout_ms): void
    {
        $errstr = Library::new('char[512]');
        $err = Library::rd_kafka_AdminOptions_set_operation_timeout(
            $this->options,
            $timeout_ms,
            $errstr,
            FFI::sizeOf($errstr)
        );
        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(FFI::string($errstr));
        }
    }

    public function setValidateOnly(bool $true_or_false): void
    {
        $errstr = Library::new('char[512]');
        $err = Library::rd_kafka_AdminOptions_set_validate_only(
            $this->options,
            (int) $true_or_false,
            $errstr,
            FFI::sizeOf($errstr)
        );
        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(FFI::string($errstr));
        }
    }

    public function setBrokerId(int $broker_id): void
    {
        $errstr = Library::new('char[512]');
        $err = Library::rd_kafka_AdminOptions_set_broker(
            $this->options,
            $broker_id,
            $errstr,
            FFI::sizeOf($errstr)
        );
        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(FFI::string($errstr));
        }
    }
}
