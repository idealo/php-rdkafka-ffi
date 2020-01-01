<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;

class Event extends Api
{
    private CData $event;

    public function __construct(CData $event)
    {
        $this->event = $event;
    }

    public function __destruct()
    {
        self::getFFI()->rd_kafka_event_destroy($this->event);
    }

    public function getCData()
    {
        return $this->event;
    }

    public function type(): int
    {
        return (int) self::getFFI()->rd_kafka_event_type($this->event);
    }

    public function name(): string
    {
        return FFI::string(self::getFFI()->rd_kafka_event_name($this->event));
    }

    public function error(): int
    {
        return (int) self::getFFI()->rd_kafka_event_error($this->event);
    }

    public function errorString(): string
    {
        return FFI::string(self::getFFI()->rd_kafka_event_error_string($this->event));
    }

    public function errorIsFatal(): bool
    {
        if ($this->type() !== RD_KAFKA_EVENT_ERROR) {
            return false;
        }

        return (bool) self::getFFI()->rd_kafka_event_error_is_fatal($this->event);
    }
}
