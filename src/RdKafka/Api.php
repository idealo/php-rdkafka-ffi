<?php

namespace RdKafka;

class Api
{
    /**
     * @var \FFI librdkafka binding - see https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
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

    public static function err2str(int $err): string
    {
        return self::$ffi->rd_kafka_err2str($err);
    }
}
