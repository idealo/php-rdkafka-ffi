<?php
declare(strict_types=1);

namespace RdKafka;

use FFI;

class Api
{
    /**
     * @var FFI librdkafka binding - see https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
     */
    protected static FFI $ffi;

    public function __construct()
    {
        self::ensureFFI();
    }

    private static function ensureFFI()
    {
        if (!isset(self::$ffi)) {
            self::$ffi = FFI::load(dirname(__DIR__, 2) . '/resources/rdkafka.h');
        }
    }

    public static function err2str(int $err): string
    {
        self::ensureFFI();
        return self::$ffi->rd_kafka_err2str($err);
    }

    /**
     * @return int
     * @deprecated
     */
    public static function errno(): int
    {
        self::ensureFFI();
        return self::$ffi->rd_kafka_errno();
    }

    public static function errno2err(int $err): int
    {
        self::ensureFFI();
        return self::$ffi->rd_kafka_errno2err($err);
    }

    public static function threadCount(): int
    {
        self::ensureFFI();
        return self::$ffi->rd_kafka_thread_cnt();
    }

    public static function version(): string
    {
        self::ensureFFI();
        return self::$ffi->rd_kafka_version_str();
    }
}
