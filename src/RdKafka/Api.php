<?php

namespace RdKafka;

class Api
{
    /**
     * @var \FFI librdkafka binding - see https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html
     */
    protected static $ffi;

    public function __construct()
    {
        if (is_null(self::$ffi)) {
            self::initFFI();
        }
    }

    private static function initFFI()
    {
        self::$ffi = \FFI::load(dirname(__DIR__, 2) . '/resources/rdkafka.h');
    }
}
