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
        parent::__construct();

        $this->event = $event;
    }

    public function __destruct()
    {
        self::$ffi->rd_kafka_event_destroy($this->event);
    }

    public function getCData()
    {
        return $this->event;
    }

    public function type()
    {
        return (int)self::$ffi->rd_kafka_event_type($this->event);
    }

    public function name()
    {
        return (int)self::$ffi->rd_kafka_event_name($this->event);
    }

    public function error()
    {
        return (int)self::$ffi->rd_kafka_event_error($this->event);
    }

    public function errorString()
    {
        return FFI::string(self::$ffi->rd_kafka_event_error_string($this->event));
    }

    public function errorIsFatal()
    {
        return (bool)self::$ffi->rd_kafka_event_error_is_fatal($this->event);
    }

}
