<?php
/**
 * This file is generated! Do not edit directly.
 */

declare(strict_types=1);

namespace RdKafka\FFI;

use Closure;
use FFI;
use FFI\CData;

trait Methods
{
    abstract public static function getFFI(): FFI;
    
    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public static function rd_kafka_version(): ?int
    {
        return static::getFFI()->rd_kafka_version();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return string|null const char*
     */
    public static function rd_kafka_version_str(): ?string
    {
        return static::getFFI()->rd_kafka_version_str();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return string|null const char*
     */
    public static function rd_kafka_get_debug_contexts(): ?string
    {
        return static::getFFI()->rd_kafka_get_debug_contexts();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $errdescs struct rd_kafka_err_desc**
     * @param CData|null $cntp size_t*
     */
    public static function rd_kafka_get_err_descs(?CData $errdescs, ?CData $cntp): void
    {
        static::getFFI()->rd_kafka_get_err_descs($errdescs, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int $err rd_kafka_resp_err_t
     * @return string|null const char*
     */
    public static function rd_kafka_err2str(int $err): ?string
    {
        return static::getFFI()->rd_kafka_err2str($err);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int $err rd_kafka_resp_err_t
     * @return string|null const char*
     */
    public static function rd_kafka_err2name(int $err): ?string
    {
        return static::getFFI()->rd_kafka_err2name($err);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_last_error(): int
    {
        return static::getFFI()->rd_kafka_last_error();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $errnox int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_errno2err(?int $errnox): int
    {
        return static::getFFI()->rd_kafka_errno2err($errnox);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public static function rd_kafka_errno(): ?int
    {
        return static::getFFI()->rd_kafka_errno();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_fatal_error(?CData $rk, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_fatal_error($rk, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int $err rd_kafka_resp_err_t
     * @param string|null $reason const char*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_test_fatal_error(?CData $rk, int $err, ?string $reason): int
    {
        return static::getFFI()->rd_kafka_test_fatal_error($rk, $err, $reason);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktpar rd_kafka_topic_partition_t*
     */
    public static function rd_kafka_topic_partition_destroy(?CData $rktpar): void
    {
        static::getFFI()->rd_kafka_topic_partition_destroy($rktpar);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $size int
     * @return CData|null rd_kafka_topic_partition_list_t*
     */
    public static function rd_kafka_topic_partition_list_new(?int $size): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_new($size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkparlist rd_kafka_topic_partition_list_t*
     */
    public static function rd_kafka_topic_partition_list_destroy(?CData $rkparlist): void
    {
        static::getFFI()->rd_kafka_topic_partition_list_destroy($rkparlist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t*
     * @param string|null $topic const char*
     * @param int|null $partition int32_t
     * @return CData|null rd_kafka_topic_partition_t*
     */
    public static function rd_kafka_topic_partition_list_add(?CData $rktparlist, ?string $topic, ?int $partition): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_add($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t*
     * @param string|null $topic const char*
     * @param int|null $start int32_t
     * @param int|null $stop int32_t
     */
    public static function rd_kafka_topic_partition_list_add_range(?CData $rktparlist, ?string $topic, ?int $start, ?int $stop): void
    {
        static::getFFI()->rd_kafka_topic_partition_list_add_range($rktparlist, $topic, $start, $stop);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t*
     * @param string|null $topic const char*
     * @param int|null $partition int32_t
     * @return int|null int
     */
    public static function rd_kafka_topic_partition_list_del(?CData $rktparlist, ?string $topic, ?int $partition): ?int
    {
        return static::getFFI()->rd_kafka_topic_partition_list_del($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t*
     * @param int|null $idx int
     * @return int|null int
     */
    public static function rd_kafka_topic_partition_list_del_by_idx(?CData $rktparlist, ?int $idx): ?int
    {
        return static::getFFI()->rd_kafka_topic_partition_list_del_by_idx($rktparlist, $idx);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $src rd_kafka_topic_partition_list_t*
     * @return CData|null rd_kafka_topic_partition_list_t*
     */
    public static function rd_kafka_topic_partition_list_copy(?CData $src): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_copy($src);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t*
     * @param string|null $topic const char*
     * @param int|null $partition int32_t
     * @param int|null $offset int64_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_topic_partition_list_set_offset(?CData $rktparlist, ?string $topic, ?int $partition, ?int $offset): int
    {
        return static::getFFI()->rd_kafka_topic_partition_list_set_offset($rktparlist, $topic, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t*
     * @param string|null $topic const char*
     * @param int|null $partition int32_t
     * @return CData|null rd_kafka_topic_partition_t*
     */
    public static function rd_kafka_topic_partition_list_find(?CData $rktparlist, ?string $topic, ?int $partition): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_find($rktparlist, $topic, $partition);
    }

    /**
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t*
     * @param CData|Closure $cmp int(*)(void*, void*, void*)
     * @param CData|object|string|null $opaque void*
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_topic_partition_list_sort(?CData $rktparlist, $cmp, $opaque): void
    {
        static::getFFI()->rd_kafka_topic_partition_list_sort($rktparlist, $cmp, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $initial_count size_t
     * @return CData|null rd_kafka_headers_t*
     */
    public static function rd_kafka_headers_new(?int $initial_count): ?CData
    {
        return static::getFFI()->rd_kafka_headers_new($initial_count);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t*
     */
    public static function rd_kafka_headers_destroy(?CData $hdrs): void
    {
        static::getFFI()->rd_kafka_headers_destroy($hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $src rd_kafka_headers_t*
     * @return CData|null rd_kafka_headers_t*
     */
    public static function rd_kafka_headers_copy(?CData $src): ?CData
    {
        return static::getFFI()->rd_kafka_headers_copy($src);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t*
     * @param string|null $name const char*
     * @param int|null $name_size ssize_t
     * @param CData|object|string|null $value void*
     * @param int|null $value_size ssize_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_header_add(?CData $hdrs, ?string $name, ?int $name_size, $value, ?int $value_size): int
    {
        return static::getFFI()->rd_kafka_header_add($hdrs, $name, $name_size, $value, $value_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t*
     * @param string|null $name const char*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_header_remove(?CData $hdrs, ?string $name): int
    {
        return static::getFFI()->rd_kafka_header_remove($hdrs, $name);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t*
     * @param string|null $name const char*
     * @param CData|object|string|null $valuep void**
     * @param CData|null $sizep size_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_header_get_last(?CData $hdrs, ?string $name, $valuep, ?CData $sizep): int
    {
        return static::getFFI()->rd_kafka_header_get_last($hdrs, $name, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t*
     * @param int|null $idx size_t
     * @param string|null $name const char*
     * @param CData|object|string|null $valuep void**
     * @param CData|null $sizep size_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_header_get(?CData $hdrs, ?int $idx, ?string $name, $valuep, ?CData $sizep): int
    {
        return static::getFFI()->rd_kafka_header_get($hdrs, $idx, $name, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t*
     * @param int|null $idx size_t
     * @param CData|null $namep char**
     * @param CData|object|string|null $valuep void**
     * @param CData|null $sizep size_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_header_get_all(?CData $hdrs, ?int $idx, ?CData $namep, $valuep, ?CData $sizep): int
    {
        return static::getFFI()->rd_kafka_header_get_all($hdrs, $idx, $namep, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t*
     */
    public static function rd_kafka_message_destroy(?CData $rkmessage): void
    {
        static::getFFI()->rd_kafka_message_destroy($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t*
     * @param CData|null $tstype rd_kafka_timestamp_type_t*
     * @return int|null int64_t
     */
    public static function rd_kafka_message_timestamp(?CData $rkmessage, ?CData $tstype): ?int
    {
        return static::getFFI()->rd_kafka_message_timestamp($rkmessage, $tstype);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t*
     * @return int|null int64_t
     */
    public static function rd_kafka_message_latency(?CData $rkmessage): ?int
    {
        return static::getFFI()->rd_kafka_message_latency($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t*
     * @param CData|null $hdrsp rd_kafka_headers_t**
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_message_headers(?CData $rkmessage, ?CData $hdrsp): int
    {
        return static::getFFI()->rd_kafka_message_headers($rkmessage, $hdrsp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t*
     * @param CData|null $hdrsp rd_kafka_headers_t**
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_message_detach_headers(?CData $rkmessage, ?CData $hdrsp): int
    {
        return static::getFFI()->rd_kafka_message_detach_headers($rkmessage, $hdrsp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t*
     * @param CData|null $hdrs rd_kafka_headers_t*
     */
    public static function rd_kafka_message_set_headers(?CData $rkmessage, ?CData $hdrs): void
    {
        static::getFFI()->rd_kafka_message_set_headers($rkmessage, $hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t*
     * @return int|null size_t
     */
    public static function rd_kafka_header_cnt(?CData $hdrs): ?int
    {
        return static::getFFI()->rd_kafka_header_cnt($hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t*
     * @return int rd_kafka_msg_status_t
     */
    public static function rd_kafka_message_status(?CData $rkmessage): int
    {
        return static::getFFI()->rd_kafka_message_status($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return CData|null rd_kafka_conf_t*
     */
    public static function rd_kafka_conf_new(): ?CData
    {
        return static::getFFI()->rd_kafka_conf_new();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     */
    public static function rd_kafka_conf_destroy(?CData $conf): void
    {
        static::getFFI()->rd_kafka_conf_destroy($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @return CData|null rd_kafka_conf_t*
     */
    public static function rd_kafka_conf_dup(?CData $conf): ?CData
    {
        return static::getFFI()->rd_kafka_conf_dup($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param int|null $filter_cnt size_t
     * @param CData|null $filter char**
     * @return CData|null rd_kafka_conf_t*
     */
    public static function rd_kafka_conf_dup_filter(?CData $conf, ?int $filter_cnt, ?CData $filter): ?CData
    {
        return static::getFFI()->rd_kafka_conf_dup_filter($conf, $filter_cnt, $filter);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param string|null $name const char*
     * @param string|null $value const char*
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_conf_res_t
     */
    public static function rd_kafka_conf_set(?CData $conf, ?string $name, ?string $value, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_conf_set($conf, $name, $value, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param int|null $events int
     */
    public static function rd_kafka_conf_set_events(?CData $conf, ?int $events): void
    {
        static::getFFI()->rd_kafka_conf_set_events($conf, $events);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $event_cb void(*)(rd_kafka_t*, rd_kafka_event_t*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_background_event_cb(?CData $conf, $event_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_background_event_cb($conf, $event_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $dr_cb void(*)(rd_kafka_t*, void*, size_t, rd_kafka_resp_err_t, void*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_dr_cb(?CData $conf, $dr_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_dr_cb($conf, $dr_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $dr_msg_cb void(*)(rd_kafka_t*, rd_kafka_message_t*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_dr_msg_cb(?CData $conf, $dr_msg_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_dr_msg_cb($conf, $dr_msg_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $consume_cb void(*)(rd_kafka_message_t*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_consume_cb(?CData $conf, $consume_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_consume_cb($conf, $consume_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $rebalance_cb void(*)(rd_kafka_t*, rd_kafka_resp_err_t, rd_kafka_topic_partition_list_t*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_rebalance_cb(?CData $conf, $rebalance_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_rebalance_cb($conf, $rebalance_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $offset_commit_cb void(*)(rd_kafka_t*, rd_kafka_resp_err_t, rd_kafka_topic_partition_list_t*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_offset_commit_cb(?CData $conf, $offset_commit_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_offset_commit_cb($conf, $offset_commit_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $error_cb void(*)(rd_kafka_t*, int, const char*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_error_cb(?CData $conf, $error_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_error_cb($conf, $error_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $throttle_cb void(*)(rd_kafka_t*, const char*, int32_t, int, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_throttle_cb(?CData $conf, $throttle_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_throttle_cb($conf, $throttle_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $log_cb void(*)(rd_kafka_t*, int, const char*, const char*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_log_cb(?CData $conf, $log_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_log_cb($conf, $log_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $stats_cb int(*)(rd_kafka_t*, char*, size_t, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_stats_cb(?CData $conf, $stats_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_stats_cb($conf, $stats_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $socket_cb int(*)(int, int, int, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_socket_cb(?CData $conf, $socket_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_socket_cb($conf, $socket_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $connect_cb int(*)(int, struct sockaddr*, int, const char*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_connect_cb(?CData $conf, $connect_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_connect_cb($conf, $connect_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $closesocket_cb int(*)(int, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_closesocket_cb(?CData $conf, $closesocket_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_closesocket_cb($conf, $closesocket_cb);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|Closure $open_cb int(*)(const char*, int, mode_t, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_set_open_cb(?CData $conf, $open_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_open_cb($conf, $open_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|object|string|null $opaque void*
     */
    public static function rd_kafka_conf_set_opaque(?CData $conf, $opaque): void
    {
        static::getFFI()->rd_kafka_conf_set_opaque($conf, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|object|string|null void*
     */
    public static function rd_kafka_opaque(?CData $rk)
    {
        return static::getFFI()->rd_kafka_opaque($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|null $tconf rd_kafka_topic_conf_t*
     */
    public static function rd_kafka_conf_set_default_topic_conf(?CData $conf, ?CData $tconf): void
    {
        static::getFFI()->rd_kafka_conf_set_default_topic_conf($conf, $tconf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param string|null $name const char*
     * @param CData|null $dest char*
     * @param CData|null $dest_size size_t*
     * @return int rd_kafka_conf_res_t
     */
    public static function rd_kafka_conf_get(?CData $conf, ?string $name, ?CData $dest, ?CData $dest_size): int
    {
        return static::getFFI()->rd_kafka_conf_get($conf, $name, $dest, $dest_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t*
     * @param string|null $name const char*
     * @param CData|null $dest char*
     * @param CData|null $dest_size size_t*
     * @return int rd_kafka_conf_res_t
     */
    public static function rd_kafka_topic_conf_get(?CData $conf, ?string $name, ?CData $dest, ?CData $dest_size): int
    {
        return static::getFFI()->rd_kafka_topic_conf_get($conf, $name, $dest, $dest_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const char**
     */
    public static function rd_kafka_conf_dump(?CData $conf, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_conf_dump($conf, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const char**
     */
    public static function rd_kafka_topic_conf_dump(?CData $conf, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_topic_conf_dump($conf, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $arr char**
     * @param int|null $cnt size_t
     */
    public static function rd_kafka_conf_dump_free(?CData $arr, ?int $cnt): void
    {
        static::getFFI()->rd_kafka_conf_dump_free($arr, $cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $fp FILE*
     */
    public static function rd_kafka_conf_properties_show(?CData $fp): void
    {
        static::getFFI()->rd_kafka_conf_properties_show($fp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return CData|null rd_kafka_topic_conf_t*
     */
    public static function rd_kafka_topic_conf_new(): ?CData
    {
        return static::getFFI()->rd_kafka_topic_conf_new();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t*
     * @return CData|null rd_kafka_topic_conf_t*
     */
    public static function rd_kafka_topic_conf_dup(?CData $conf): ?CData
    {
        return static::getFFI()->rd_kafka_topic_conf_dup($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null rd_kafka_topic_conf_t*
     */
    public static function rd_kafka_default_topic_conf_dup(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_default_topic_conf_dup($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topic_conf rd_kafka_topic_conf_t*
     */
    public static function rd_kafka_topic_conf_destroy(?CData $topic_conf): void
    {
        static::getFFI()->rd_kafka_topic_conf_destroy($topic_conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t*
     * @param string|null $name const char*
     * @param string|null $value const char*
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_conf_res_t
     */
    public static function rd_kafka_topic_conf_set(?CData $conf, ?string $name, ?string $value, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_topic_conf_set($conf, $name, $value, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t*
     * @param CData|object|string|null $opaque void*
     */
    public static function rd_kafka_topic_conf_set_opaque(?CData $conf, $opaque): void
    {
        static::getFFI()->rd_kafka_topic_conf_set_opaque($conf, $opaque);
    }

    /**
     * @param CData|null $topic_conf rd_kafka_topic_conf_t*
     * @param CData|Closure $partitioner int32_t(*)(rd_kafka_topic_t*, void*, size_t, int32_t, void*, void*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_topic_conf_set_partitioner_cb(?CData $topic_conf, $partitioner): void
    {
        static::getFFI()->rd_kafka_topic_conf_set_partitioner_cb($topic_conf, $partitioner);
    }

    /**
     * @param CData|null $topic_conf rd_kafka_topic_conf_t*
     * @param CData|Closure $msg_order_cmp int(*)(rd_kafka_message_t*, rd_kafka_message_t*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_topic_conf_set_msg_order_cmp(?CData $topic_conf, $msg_order_cmp): void
    {
        static::getFFI()->rd_kafka_topic_conf_set_msg_order_cmp($topic_conf, $msg_order_cmp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @return int|null int
     */
    public static function rd_kafka_topic_partition_available(?CData $rkt, ?int $partition): ?int
    {
        return static::getFFI()->rd_kafka_topic_partition_available($rkt, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param int|null $partition_cnt int32_t
     * @param CData|object|string|null $opaque void*
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int32_t
     */
    public static function rd_kafka_msg_partitioner_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_random($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param int|null $partition_cnt int32_t
     * @param CData|object|string|null $opaque void*
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int32_t
     */
    public static function rd_kafka_msg_partitioner_consistent(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_consistent($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param int|null $partition_cnt int32_t
     * @param CData|object|string|null $opaque void*
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int32_t
     */
    public static function rd_kafka_msg_partitioner_consistent_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_consistent_random($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param int|null $partition_cnt int32_t
     * @param CData|object|string|null $rkt_opaque void*
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int32_t
     */
    public static function rd_kafka_msg_partitioner_murmur2(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_murmur2($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param int|null $partition_cnt int32_t
     * @param CData|object|string|null $rkt_opaque void*
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int32_t
     */
    public static function rd_kafka_msg_partitioner_murmur2_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_murmur2_random($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int $type rd_kafka_type_t
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return CData|null rd_kafka_t*
     */
    public static function rd_kafka_new(int $type, ?CData $conf, ?CData $errstr, ?int $errstr_size): ?CData
    {
        return static::getFFI()->rd_kafka_new($type, $conf, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     */
    public static function rd_kafka_destroy(?CData $rk): void
    {
        static::getFFI()->rd_kafka_destroy($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $flags int
     */
    public static function rd_kafka_destroy_flags(?CData $rk, ?int $flags): void
    {
        static::getFFI()->rd_kafka_destroy_flags($rk, $flags);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return string|null const char*
     */
    public static function rd_kafka_name(?CData $rk): ?string
    {
        return static::getFFI()->rd_kafka_name($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return int rd_kafka_type_t
     */
    public static function rd_kafka_type(?CData $rk): int
    {
        return static::getFFI()->rd_kafka_type($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null char*
     */
    public static function rd_kafka_memberid(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_memberid($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return CData|null char*
     */
    public static function rd_kafka_clusterid(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_clusterid($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return int|null int32_t
     */
    public static function rd_kafka_controllerid(?CData $rk, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_controllerid($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $topic const char*
     * @param CData|null $conf rd_kafka_topic_conf_t*
     * @return CData|null rd_kafka_topic_t*
     */
    public static function rd_kafka_topic_new(?CData $rk, ?string $topic, ?CData $conf): ?CData
    {
        return static::getFFI()->rd_kafka_topic_new($rk, $topic, $conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     */
    public static function rd_kafka_topic_destroy(?CData $rkt): void
    {
        static::getFFI()->rd_kafka_topic_destroy($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @return string|null const char*
     */
    public static function rd_kafka_topic_name(?CData $rkt): ?string
    {
        return static::getFFI()->rd_kafka_topic_name($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @return CData|object|string|null void*
     */
    public static function rd_kafka_topic_opaque(?CData $rkt)
    {
        return static::getFFI()->rd_kafka_topic_opaque($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_poll(?CData $rk, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_poll($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     */
    public static function rd_kafka_yield(?CData $rk): void
    {
        static::getFFI()->rd_kafka_yield($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $partitions rd_kafka_topic_partition_list_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_pause_partitions(?CData $rk, ?CData $partitions): int
    {
        return static::getFFI()->rd_kafka_pause_partitions($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $partitions rd_kafka_topic_partition_list_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_resume_partitions(?CData $rk, ?CData $partitions): int
    {
        return static::getFFI()->rd_kafka_resume_partitions($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $topic const char*
     * @param int|null $partition int32_t
     * @param CData|null $low int64_t*
     * @param CData|null $high int64_t*
     * @param int|null $timeout_ms int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_query_watermark_offsets(?CData $rk, ?string $topic, ?int $partition, ?CData $low, ?CData $high, ?int $timeout_ms): int
    {
        return static::getFFI()->rd_kafka_query_watermark_offsets($rk, $topic, $partition, $low, $high, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $topic const char*
     * @param int|null $partition int32_t
     * @param CData|null $low int64_t*
     * @param CData|null $high int64_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_get_watermark_offsets(?CData $rk, ?string $topic, ?int $partition, ?CData $low, ?CData $high): int
    {
        return static::getFFI()->rd_kafka_get_watermark_offsets($rk, $topic, $partition, $low, $high);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $offsets rd_kafka_topic_partition_list_t*
     * @param int|null $timeout_ms int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_offsets_for_times(?CData $rk, ?CData $offsets, ?int $timeout_ms): int
    {
        return static::getFFI()->rd_kafka_offsets_for_times($rk, $offsets, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|object|string|null $ptr void*
     */
    public static function rd_kafka_mem_free(?CData $rk, $ptr): void
    {
        static::getFFI()->rd_kafka_mem_free($rk, $ptr);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null rd_kafka_queue_t*
     */
    public static function rd_kafka_queue_new(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_new($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t*
     */
    public static function rd_kafka_queue_destroy(?CData $rkqu): void
    {
        static::getFFI()->rd_kafka_queue_destroy($rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null rd_kafka_queue_t*
     */
    public static function rd_kafka_queue_get_main(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_main($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null rd_kafka_queue_t*
     */
    public static function rd_kafka_queue_get_consumer(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_consumer($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $topic const char*
     * @param int|null $partition int32_t
     * @return CData|null rd_kafka_queue_t*
     */
    public static function rd_kafka_queue_get_partition(?CData $rk, ?string $topic, ?int $partition): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_partition($rk, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null rd_kafka_queue_t*
     */
    public static function rd_kafka_queue_get_background(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_background($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $src rd_kafka_queue_t*
     * @param CData|null $dst rd_kafka_queue_t*
     */
    public static function rd_kafka_queue_forward(?CData $src, ?CData $dst): void
    {
        static::getFFI()->rd_kafka_queue_forward($src, $dst);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_set_log_queue(?CData $rk, ?CData $rkqu): int
    {
        return static::getFFI()->rd_kafka_set_log_queue($rk, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @return int|null size_t
     */
    public static function rd_kafka_queue_length(?CData $rkqu): ?int
    {
        return static::getFFI()->rd_kafka_queue_length($rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param int|null $fd int
     * @param CData|object|string|null $payload void*
     * @param int|null $size size_t
     */
    public static function rd_kafka_queue_io_event_enable(?CData $rkqu, ?int $fd, $payload, ?int $size): void
    {
        static::getFFI()->rd_kafka_queue_io_event_enable($rkqu, $fd, $payload, $size);
    }

    /**
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param CData|Closure $event_cb void(*)(rd_kafka_t*, void*)
     * @param CData|object|string|null $opaque void*
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_queue_cb_event_enable(?CData $rkqu, $event_cb, $opaque): void
    {
        static::getFFI()->rd_kafka_queue_cb_event_enable($rkqu, $event_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $offset int64_t
     * @return int|null int
     */
    public static function rd_kafka_consume_start(?CData $rkt, ?int $partition, ?int $offset): ?int
    {
        return static::getFFI()->rd_kafka_consume_start($rkt, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $offset int64_t
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @return int|null int
     */
    public static function rd_kafka_consume_start_queue(?CData $rkt, ?int $partition, ?int $offset, ?CData $rkqu): ?int
    {
        return static::getFFI()->rd_kafka_consume_start_queue($rkt, $partition, $offset, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @return int|null int
     */
    public static function rd_kafka_consume_stop(?CData $rkt, ?int $partition): ?int
    {
        return static::getFFI()->rd_kafka_consume_stop($rkt, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $offset int64_t
     * @param int|null $timeout_ms int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_seek(?CData $rkt, ?int $partition, ?int $offset, ?int $timeout_ms): int
    {
        return static::getFFI()->rd_kafka_seek($rkt, $partition, $offset, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_message_t*
     */
    public static function rd_kafka_consume(?CData $rkt, ?int $partition, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_consume($rkt, $partition, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $timeout_ms int
     * @param CData|null $rkmessages rd_kafka_message_t**
     * @param int|null $rkmessages_size size_t
     * @return int|null ssize_t
     */
    public static function rd_kafka_consume_batch(?CData $rkt, ?int $partition, ?int $timeout_ms, ?CData $rkmessages, ?int $rkmessages_size): ?int
    {
        return static::getFFI()->rd_kafka_consume_batch($rkt, $partition, $timeout_ms, $rkmessages, $rkmessages_size);
    }

    /**
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $timeout_ms int
     * @param CData|Closure $consume_cb void(*)(rd_kafka_message_t*, void*)
     * @param CData|object|string|null $opaque void*
     * @return int|null int
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_consume_callback(?CData $rkt, ?int $partition, ?int $timeout_ms, $consume_cb, $opaque): ?int
    {
        return static::getFFI()->rd_kafka_consume_callback($rkt, $partition, $timeout_ms, $consume_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_message_t*
     */
    public static function rd_kafka_consume_queue(?CData $rkqu, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_consume_queue($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param int|null $timeout_ms int
     * @param CData|null $rkmessages rd_kafka_message_t**
     * @param int|null $rkmessages_size size_t
     * @return int|null ssize_t
     */
    public static function rd_kafka_consume_batch_queue(?CData $rkqu, ?int $timeout_ms, ?CData $rkmessages, ?int $rkmessages_size): ?int
    {
        return static::getFFI()->rd_kafka_consume_batch_queue($rkqu, $timeout_ms, $rkmessages, $rkmessages_size);
    }

    /**
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param int|null $timeout_ms int
     * @param CData|Closure $consume_cb void(*)(rd_kafka_message_t*, void*)
     * @param CData|object|string|null $opaque void*
     * @return int|null int
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_consume_callback_queue(?CData $rkqu, ?int $timeout_ms, $consume_cb, $opaque): ?int
    {
        return static::getFFI()->rd_kafka_consume_callback_queue($rkqu, $timeout_ms, $consume_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $offset int64_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_offset_store(?CData $rkt, ?int $partition, ?int $offset): int
    {
        return static::getFFI()->rd_kafka_offset_store($rkt, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $offsets rd_kafka_topic_partition_list_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_offsets_store(?CData $rk, ?CData $offsets): int
    {
        return static::getFFI()->rd_kafka_offsets_store($rk, $offsets);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $topics rd_kafka_topic_partition_list_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_subscribe(?CData $rk, ?CData $topics): int
    {
        return static::getFFI()->rd_kafka_subscribe($rk, $topics);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_unsubscribe(?CData $rk): int
    {
        return static::getFFI()->rd_kafka_unsubscribe($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $topics rd_kafka_topic_partition_list_t**
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_subscription(?CData $rk, ?CData $topics): int
    {
        return static::getFFI()->rd_kafka_subscription($rk, $topics);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_message_t*
     */
    public static function rd_kafka_consumer_poll(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_poll($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_consumer_close(?CData $rk): int
    {
        return static::getFFI()->rd_kafka_consumer_close($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $partitions rd_kafka_topic_partition_list_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_assign(?CData $rk, ?CData $partitions): int
    {
        return static::getFFI()->rd_kafka_assign($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $partitions rd_kafka_topic_partition_list_t**
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_assignment(?CData $rk, ?CData $partitions): int
    {
        return static::getFFI()->rd_kafka_assignment($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $offsets rd_kafka_topic_partition_list_t*
     * @param int|null $async int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_commit(?CData $rk, ?CData $offsets, ?int $async): int
    {
        return static::getFFI()->rd_kafka_commit($rk, $offsets, $async);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $rkmessage rd_kafka_message_t*
     * @param int|null $async int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_commit_message(?CData $rk, ?CData $rkmessage, ?int $async): int
    {
        return static::getFFI()->rd_kafka_commit_message($rk, $rkmessage, $async);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $offsets rd_kafka_topic_partition_list_t*
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param CData|Closure $cb void(*)(rd_kafka_t*, rd_kafka_resp_err_t, rd_kafka_topic_partition_list_t*, void*)
     * @param CData|object|string|null $opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_commit_queue(?CData $rk, ?CData $offsets, ?CData $rkqu, $cb, $opaque): int
    {
        return static::getFFI()->rd_kafka_commit_queue($rk, $offsets, $rkqu, $cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $partitions rd_kafka_topic_partition_list_t*
     * @param int|null $timeout_ms int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_committed(?CData $rk, ?CData $partitions, ?int $timeout_ms): int
    {
        return static::getFFI()->rd_kafka_committed($rk, $partitions, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $partitions rd_kafka_topic_partition_list_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_position(?CData $rk, ?CData $partitions): int
    {
        return static::getFFI()->rd_kafka_position($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $msgflags int
     * @param CData|object|string|null $payload void*
     * @param int|null $len size_t
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int
     */
    public static function rd_kafka_produce(?CData $rkt, ?int $partition, ?int $msgflags, $payload, ?int $len, $key, ?int $keylen, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_produce($rkt, $partition, $msgflags, $payload, $len, $key, $keylen, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param mixed ...$args
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_producev(?CData $rk, ...$args): int
    {
        return static::getFFI()->rd_kafka_producev($rk, ...$args);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param int|null $partition int32_t
     * @param int|null $msgflags int
     * @param CData|null $rkmessages rd_kafka_message_t*
     * @param int|null $message_cnt int
     * @return int|null int
     */
    public static function rd_kafka_produce_batch(?CData $rkt, ?int $partition, ?int $msgflags, ?CData $rkmessages, ?int $message_cnt): ?int
    {
        return static::getFFI()->rd_kafka_produce_batch($rkt, $partition, $msgflags, $rkmessages, $message_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_flush(?CData $rk, ?int $timeout_ms): int
    {
        return static::getFFI()->rd_kafka_flush($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $purge_flags int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_purge(?CData $rk, ?int $purge_flags): int
    {
        return static::getFFI()->rd_kafka_purge($rk, $purge_flags);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $all_topics int
     * @param CData|null $only_rkt rd_kafka_topic_t*
     * @param CData|null $metadatap struct rd_kafka_metadata**
     * @param int|null $timeout_ms int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_metadata(?CData $rk, ?int $all_topics, ?CData $only_rkt, ?CData $metadatap, ?int $timeout_ms): int
    {
        return static::getFFI()->rd_kafka_metadata($rk, $all_topics, $only_rkt, $metadatap, $timeout_ms);
    }

    /**
     * @param CData|Closure $metadata rd_kafka_resp_err_t(rd_kafka_metadata*)(rd_kafka_t*, int, rd_kafka_topic_t*, struct rd_kafka_metadata**, int)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_metadata_destroy($metadata): void
    {
        static::getFFI()->rd_kafka_metadata_destroy($metadata);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $group const char*
     * @param CData|null $grplistp struct rd_kafka_group_list**
     * @param int|null $timeout_ms int
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_list_groups(?CData $rk, ?string $group, ?CData $grplistp, ?int $timeout_ms): int
    {
        return static::getFFI()->rd_kafka_list_groups($rk, $group, $grplistp, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $grplist struct rd_kafka_group_list*
     */
    public static function rd_kafka_group_list_destroy(?CData $grplist): void
    {
        static::getFFI()->rd_kafka_group_list_destroy($grplist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $brokerlist const char*
     * @return int|null int
     */
    public static function rd_kafka_brokers_add(?CData $rk, ?string $brokerlist): ?int
    {
        return static::getFFI()->rd_kafka_brokers_add($rk, $brokerlist);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param CData|Closure $func void(*)(rd_kafka_t*, int, const char*, const char*)
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_set_logger(?CData $rk, $func): void
    {
        static::getFFI()->rd_kafka_set_logger($rk, $func);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $level int
     */
    public static function rd_kafka_set_log_level(?CData $rk, ?int $level): void
    {
        static::getFFI()->rd_kafka_set_log_level($rk, $level);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $level int
     * @param string|null $fac const char*
     * @param string|null $buf const char*
     */
    public static function rd_kafka_log_print(?CData $rk, ?int $level, ?string $fac, ?string $buf): void
    {
        static::getFFI()->rd_kafka_log_print($rk, $level, $fac, $buf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $level int
     * @param string|null $fac const char*
     * @param string|null $buf const char*
     */
    public static function rd_kafka_log_syslog(?CData $rk, ?int $level, ?string $fac, ?string $buf): void
    {
        static::getFFI()->rd_kafka_log_syslog($rk, $level, $fac, $buf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return int|null int
     */
    public static function rd_kafka_outq_len(?CData $rk): ?int
    {
        return static::getFFI()->rd_kafka_outq_len($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $fp FILE*
     * @param CData|null $rk rd_kafka_t*
     */
    public static function rd_kafka_dump(?CData $fp, ?CData $rk): void
    {
        static::getFFI()->rd_kafka_dump($fp, $rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public static function rd_kafka_thread_cnt(): ?int
    {
        return static::getFFI()->rd_kafka_thread_cnt();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_wait_destroyed(?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_wait_destroyed($timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public static function rd_kafka_unittest(): ?int
    {
        return static::getFFI()->rd_kafka_unittest();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_poll_set_consumer(?CData $rk): int
    {
        return static::getFFI()->rd_kafka_poll_set_consumer($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return int|null rd_kafka_event_type_t
     */
    public static function rd_kafka_event_type(?CData $rkev): ?int
    {
        return static::getFFI()->rd_kafka_event_type($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return string|null const char*
     */
    public static function rd_kafka_event_name(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_name($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     */
    public static function rd_kafka_event_destroy(?CData $rkev): void
    {
        static::getFFI()->rd_kafka_event_destroy($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null const rd_kafka_message_t*
     */
    public static function rd_kafka_event_message_next(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_message_next($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @param CData|null $rkmessages const rd_kafka_message_t**
     * @param int|null $size size_t
     * @return int|null size_t
     */
    public static function rd_kafka_event_message_array(?CData $rkev, ?CData $rkmessages, ?int $size): ?int
    {
        return static::getFFI()->rd_kafka_event_message_array($rkev, $rkmessages, $size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return int|null size_t
     */
    public static function rd_kafka_event_message_count(?CData $rkev): ?int
    {
        return static::getFFI()->rd_kafka_event_message_count($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_event_error(?CData $rkev): int
    {
        return static::getFFI()->rd_kafka_event_error($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return string|null const char*
     */
    public static function rd_kafka_event_error_string(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_error_string($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return int|null int
     */
    public static function rd_kafka_event_error_is_fatal(?CData $rkev): ?int
    {
        return static::getFFI()->rd_kafka_event_error_is_fatal($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|object|string|null void*
     */
    public static function rd_kafka_event_opaque(?CData $rkev)
    {
        return static::getFFI()->rd_kafka_event_opaque($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @param CData|null $fac char**
     * @param CData|null $str char**
     * @param CData|null $level int*
     * @return int|null int
     */
    public static function rd_kafka_event_log(?CData $rkev, ?CData $fac, ?CData $str, ?CData $level): ?int
    {
        return static::getFFI()->rd_kafka_event_log($rkev, $fac, $str, $level);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return string|null const char*
     */
    public static function rd_kafka_event_stats(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_stats($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null rd_kafka_topic_partition_list_t*
     */
    public static function rd_kafka_event_topic_partition_list(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_topic_partition_list($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null rd_kafka_topic_partition_t*
     */
    public static function rd_kafka_event_topic_partition(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_topic_partition($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null const rd_kafka_CreateTopics_result_t*
     */
    public static function rd_kafka_event_CreateTopics_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_CreateTopics_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null const rd_kafka_DeleteTopics_result_t*
     */
    public static function rd_kafka_event_DeleteTopics_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_DeleteTopics_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null const rd_kafka_CreatePartitions_result_t*
     */
    public static function rd_kafka_event_CreatePartitions_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_CreatePartitions_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null const rd_kafka_AlterConfigs_result_t*
     */
    public static function rd_kafka_event_AlterConfigs_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_AlterConfigs_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return CData|null const rd_kafka_DescribeConfigs_result_t*
     */
    public static function rd_kafka_event_DescribeConfigs_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_DescribeConfigs_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_event_t*
     */
    public static function rd_kafka_queue_poll(?CData $rkqu, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_queue_poll($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t*
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_queue_poll_callback(?CData $rkqu, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_queue_poll_callback($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|object|string|null $plug_opaquep void**
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_plugin_f_conf_init_t(?CData $conf, $plug_opaquep, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_plugin_f_conf_init_t($conf, $plug_opaquep, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t*
     * @param string|null $name const char*
     * @param string|null $val const char*
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_conf_res_t
     */
    public static function rd_kafka_interceptor_f_on_conf_set_t(?CData $conf, ?string $name, ?string $val, ?CData $errstr, ?int $errstr_size, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_conf_set_t($conf, $name, $val, $errstr, $errstr_size, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_conf rd_kafka_conf_t*
     * @param CData|null $old_conf rd_kafka_conf_t*
     * @param int|null $filter_cnt size_t
     * @param CData|null $filter char**
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_conf_dup_t(?CData $new_conf, ?CData $old_conf, ?int $filter_cnt, ?CData $filter, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_conf_dup_t($new_conf, $old_conf, $filter_cnt, $filter, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_conf_destroy_t($ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_conf_destroy_t($ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $conf rd_kafka_conf_t*
     * @param CData|object|string|null $ic_opaque void*
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_new_t(?CData $rk, ?CData $conf, $ic_opaque, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_new_t($rk, $conf, $ic_opaque, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_destroy_t(?CData $rk, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_destroy_t($rk, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $rkmessage const rd_kafka_message_t*
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_send_t(?CData $rk, ?CData $rkmessage, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_send_t($rk, $rkmessage, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $rkmessage const rd_kafka_message_t*
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_acknowledgement_t(?CData $rk, ?CData $rkmessage, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_acknowledgement_t($rk, $rkmessage, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $rkmessage const rd_kafka_message_t*
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_consume_t(?CData $rk, ?CData $rkmessage, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_consume_t($rk, $rkmessage, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $offsets rd_kafka_topic_partition_list_t*
     * @param int $err rd_kafka_resp_err_t
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_commit_t(?CData $rk, ?CData $offsets, int $err, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_commit_t($rk, $offsets, $err, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $sockfd int
     * @param string|null $brokername const char*
     * @param int|null $brokerid int32_t
     * @param int|null $ApiKey int16_t
     * @param int|null $ApiVersion int16_t
     * @param int|null $CorrId int32_t
     * @param int|null $size size_t
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_request_sent_t(?CData $rk, ?int $sockfd, ?string $brokername, ?int $brokerid, ?int $ApiKey, ?int $ApiVersion, ?int $CorrId, ?int $size, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_request_sent_t($rk, $sockfd, $brokername, $brokerid, $ApiKey, $ApiVersion, $CorrId, $size, $ic_opaque);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_conf_set rd_kafka_conf_res_t(rd_kafka_interceptor_f_on_conf_set_t*)(rd_kafka_conf_t*, const char*, const char*, char*, size_t, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_interceptor_add_on_conf_set(?CData $conf, ?string $ic_name, $on_conf_set, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_conf_interceptor_add_on_conf_set($conf, $ic_name, $on_conf_set, $ic_opaque);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_conf_dup rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_conf_dup_t*)(rd_kafka_conf_t*, rd_kafka_conf_t*, size_t, char**, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_interceptor_add_on_conf_dup(?CData $conf, ?string $ic_name, $on_conf_dup, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_conf_interceptor_add_on_conf_dup($conf, $ic_name, $on_conf_dup, $ic_opaque);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_conf_destroy rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_conf_destroy_t*)(void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_interceptor_add_on_conf_destroy(?CData $conf, ?string $ic_name, $on_conf_destroy, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_conf_interceptor_add_on_conf_destroy($conf, $ic_name, $on_conf_destroy, $ic_opaque);
    }

    /**
     * @param CData|null $conf rd_kafka_conf_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_new rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_new_t*)(rd_kafka_t*, rd_kafka_conf_t*, void*, char*, size_t)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_conf_interceptor_add_on_new(?CData $conf, ?string $ic_name, $on_new, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_conf_interceptor_add_on_new($conf, $ic_name, $on_new, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_destroy rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_destroy_t*)(rd_kafka_t*, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_destroy(?CData $rk, ?string $ic_name, $on_destroy, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_destroy($rk, $ic_name, $on_destroy, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_send rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_send_t*)(rd_kafka_t*, const rd_kafka_message_t*, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_send(?CData $rk, ?string $ic_name, $on_send, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_send($rk, $ic_name, $on_send, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_acknowledgement rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_acknowledgement_t*)(rd_kafka_t*, const rd_kafka_message_t*, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_acknowledgement(?CData $rk, ?string $ic_name, $on_acknowledgement, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_acknowledgement($rk, $ic_name, $on_acknowledgement, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_consume rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_consume_t*)(rd_kafka_t*, const rd_kafka_message_t*, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_consume(?CData $rk, ?string $ic_name, $on_consume, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_consume($rk, $ic_name, $on_consume, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_commit rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_commit_t*)(rd_kafka_t*, rd_kafka_topic_partition_list_t*, rd_kafka_resp_err_t, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_commit(?CData $rk, ?string $ic_name, $on_commit, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_commit($rk, $ic_name, $on_commit, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_request_sent rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_request_sent_t*)(rd_kafka_t*, int, const char*, int32_t, int16_t, int16_t, int32_t, size_t, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.0.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_request_sent(?CData $rk, ?string $ic_name, $on_request_sent, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_request_sent($rk, $ic_name, $on_request_sent, $ic_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topicres rd_kafka_topic_result_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_topic_result_error(?CData $topicres): int
    {
        return static::getFFI()->rd_kafka_topic_result_error($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topicres rd_kafka_topic_result_t*
     * @return string|null const char*
     */
    public static function rd_kafka_topic_result_error_string(?CData $topicres): ?string
    {
        return static::getFFI()->rd_kafka_topic_result_error_string($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topicres rd_kafka_topic_result_t*
     * @return string|null const char*
     */
    public static function rd_kafka_topic_result_name(?CData $topicres): ?string
    {
        return static::getFFI()->rd_kafka_topic_result_name($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int $for_api rd_kafka_admin_op_t
     * @return CData|null rd_kafka_AdminOptions_t*
     */
    public static function rd_kafka_AdminOptions_new(?CData $rk, int $for_api): ?CData
    {
        return static::getFFI()->rd_kafka_AdminOptions_new($rk, $for_api);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t*
     */
    public static function rd_kafka_AdminOptions_destroy(?CData $options): void
    {
        static::getFFI()->rd_kafka_AdminOptions_destroy($options);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param int|null $timeout_ms int
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_AdminOptions_set_request_timeout(?CData $options, ?int $timeout_ms, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_request_timeout($options, $timeout_ms, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param int|null $timeout_ms int
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_AdminOptions_set_operation_timeout(?CData $options, ?int $timeout_ms, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_operation_timeout($options, $timeout_ms, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param int|null $true_or_false int
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_AdminOptions_set_validate_only(?CData $options, ?int $true_or_false, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_validate_only($options, $true_or_false, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param int|null $broker_id int32_t
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_AdminOptions_set_broker(?CData $options, ?int $broker_id, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_broker($options, $broker_id, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param CData|object|string|null $opaque void*
     */
    public static function rd_kafka_AdminOptions_set_opaque(?CData $options, $opaque): void
    {
        static::getFFI()->rd_kafka_AdminOptions_set_opaque($options, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic const char*
     * @param int|null $num_partitions int
     * @param int|null $replication_factor int
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return CData|null rd_kafka_NewTopic_t*
     */
    public static function rd_kafka_NewTopic_new(?string $topic, ?int $num_partitions, ?int $replication_factor, ?CData $errstr, ?int $errstr_size): ?CData
    {
        return static::getFFI()->rd_kafka_NewTopic_new($topic, $num_partitions, $replication_factor, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topic rd_kafka_NewTopic_t*
     */
    public static function rd_kafka_NewTopic_destroy(?CData $new_topic): void
    {
        static::getFFI()->rd_kafka_NewTopic_destroy($new_topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topics rd_kafka_NewTopic_t**
     * @param int|null $new_topic_cnt size_t
     */
    public static function rd_kafka_NewTopic_destroy_array(?CData $new_topics, ?int $new_topic_cnt): void
    {
        static::getFFI()->rd_kafka_NewTopic_destroy_array($new_topics, $new_topic_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topic rd_kafka_NewTopic_t*
     * @param int|null $partition int32_t
     * @param CData|null $broker_ids int32_t*
     * @param int|null $broker_id_cnt size_t
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_NewTopic_set_replica_assignment(?CData $new_topic, ?int $partition, ?CData $broker_ids, ?int $broker_id_cnt, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_NewTopic_set_replica_assignment($new_topic, $partition, $broker_ids, $broker_id_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topic rd_kafka_NewTopic_t*
     * @param string|null $name const char*
     * @param string|null $value const char*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_NewTopic_set_config(?CData $new_topic, ?string $name, ?string $value): int
    {
        return static::getFFI()->rd_kafka_NewTopic_set_config($new_topic, $name, $value);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $new_topics rd_kafka_NewTopic_t**
     * @param int|null $new_topic_cnt size_t
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param CData|null $rkqu rd_kafka_queue_t*
     */
    public static function rd_kafka_CreateTopics(?CData $rk, ?CData $new_topics, ?int $new_topic_cnt, ?CData $options, ?CData $rkqu): void
    {
        static::getFFI()->rd_kafka_CreateTopics($rk, $new_topics, $new_topic_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result const rd_kafka_CreateTopics_result_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const rd_kafka_topic_result_t**
     */
    public static function rd_kafka_CreateTopics_result_topics(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_CreateTopics_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic const char*
     * @return CData|null rd_kafka_DeleteTopic_t*
     */
    public static function rd_kafka_DeleteTopic_new(?string $topic): ?CData
    {
        return static::getFFI()->rd_kafka_DeleteTopic_new($topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $del_topic rd_kafka_DeleteTopic_t*
     */
    public static function rd_kafka_DeleteTopic_destroy(?CData $del_topic): void
    {
        static::getFFI()->rd_kafka_DeleteTopic_destroy($del_topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $del_topics rd_kafka_DeleteTopic_t**
     * @param int|null $del_topic_cnt size_t
     */
    public static function rd_kafka_DeleteTopic_destroy_array(?CData $del_topics, ?int $del_topic_cnt): void
    {
        static::getFFI()->rd_kafka_DeleteTopic_destroy_array($del_topics, $del_topic_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $del_topics rd_kafka_DeleteTopic_t**
     * @param int|null $del_topic_cnt size_t
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param CData|null $rkqu rd_kafka_queue_t*
     */
    public static function rd_kafka_DeleteTopics(?CData $rk, ?CData $del_topics, ?int $del_topic_cnt, ?CData $options, ?CData $rkqu): void
    {
        static::getFFI()->rd_kafka_DeleteTopics($rk, $del_topics, $del_topic_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result const rd_kafka_DeleteTopics_result_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const rd_kafka_topic_result_t**
     */
    public static function rd_kafka_DeleteTopics_result_topics(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_DeleteTopics_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic const char*
     * @param int|null $new_total_cnt size_t
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return CData|null rd_kafka_NewPartitions_t*
     */
    public static function rd_kafka_NewPartitions_new(?string $topic, ?int $new_total_cnt, ?CData $errstr, ?int $errstr_size): ?CData
    {
        return static::getFFI()->rd_kafka_NewPartitions_new($topic, $new_total_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_parts rd_kafka_NewPartitions_t*
     */
    public static function rd_kafka_NewPartitions_destroy(?CData $new_parts): void
    {
        static::getFFI()->rd_kafka_NewPartitions_destroy($new_parts);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_parts rd_kafka_NewPartitions_t**
     * @param int|null $new_parts_cnt size_t
     */
    public static function rd_kafka_NewPartitions_destroy_array(?CData $new_parts, ?int $new_parts_cnt): void
    {
        static::getFFI()->rd_kafka_NewPartitions_destroy_array($new_parts, $new_parts_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_parts rd_kafka_NewPartitions_t*
     * @param int|null $new_partition_idx int32_t
     * @param CData|null $broker_ids int32_t*
     * @param int|null $broker_id_cnt size_t
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_NewPartitions_set_replica_assignment(?CData $new_parts, ?int $new_partition_idx, ?CData $broker_ids, ?int $broker_id_cnt, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_NewPartitions_set_replica_assignment($new_parts, $new_partition_idx, $broker_ids, $broker_id_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $new_parts rd_kafka_NewPartitions_t**
     * @param int|null $new_parts_cnt size_t
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param CData|null $rkqu rd_kafka_queue_t*
     */
    public static function rd_kafka_CreatePartitions(?CData $rk, ?CData $new_parts, ?int $new_parts_cnt, ?CData $options, ?CData $rkqu): void
    {
        static::getFFI()->rd_kafka_CreatePartitions($rk, $new_parts, $new_parts_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result const rd_kafka_CreatePartitions_result_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const rd_kafka_topic_result_t**
     */
    public static function rd_kafka_CreatePartitions_result_topics(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_CreatePartitions_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int $confsource rd_kafka_ConfigSource_t
     * @return string|null const char*
     */
    public static function rd_kafka_ConfigSource_name(int $confsource): ?string
    {
        return static::getFFI()->rd_kafka_ConfigSource_name($confsource);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @return string|null const char*
     */
    public static function rd_kafka_ConfigEntry_name(?CData $entry): ?string
    {
        return static::getFFI()->rd_kafka_ConfigEntry_name($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @return string|null const char*
     */
    public static function rd_kafka_ConfigEntry_value(?CData $entry): ?string
    {
        return static::getFFI()->rd_kafka_ConfigEntry_value($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @return int rd_kafka_ConfigSource_t
     */
    public static function rd_kafka_ConfigEntry_source(?CData $entry): int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_source($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_read_only(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_read_only($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_default(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_default($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_sensitive(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_sensitive($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_synonym(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_synonym($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const rd_kafka_ConfigEntry_t**
     */
    public static function rd_kafka_ConfigEntry_synonyms(?CData $entry, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_ConfigEntry_synonyms($entry, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int $restype rd_kafka_ResourceType_t
     * @return string|null const char*
     */
    public static function rd_kafka_ResourceType_name(int $restype): ?string
    {
        return static::getFFI()->rd_kafka_ResourceType_name($restype);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int $restype rd_kafka_ResourceType_t
     * @param string|null $resname const char*
     * @return CData|null rd_kafka_ConfigResource_t*
     */
    public static function rd_kafka_ConfigResource_new(int $restype, ?string $resname): ?CData
    {
        return static::getFFI()->rd_kafka_ConfigResource_new($restype, $resname);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t*
     */
    public static function rd_kafka_ConfigResource_destroy(?CData $config): void
    {
        static::getFFI()->rd_kafka_ConfigResource_destroy($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t**
     * @param int|null $config_cnt size_t
     */
    public static function rd_kafka_ConfigResource_destroy_array(?CData $config, ?int $config_cnt): void
    {
        static::getFFI()->rd_kafka_ConfigResource_destroy_array($config, $config_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t*
     * @param string|null $name const char*
     * @param string|null $value const char*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_ConfigResource_set_config(?CData $config, ?string $name, ?string $value): int
    {
        return static::getFFI()->rd_kafka_ConfigResource_set_config($config, $name, $value);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const rd_kafka_ConfigEntry_t**
     */
    public static function rd_kafka_ConfigResource_configs(?CData $config, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_ConfigResource_configs($config, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t*
     * @return int rd_kafka_ResourceType_t
     */
    public static function rd_kafka_ConfigResource_type(?CData $config): int
    {
        return static::getFFI()->rd_kafka_ConfigResource_type($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t*
     * @return string|null const char*
     */
    public static function rd_kafka_ConfigResource_name(?CData $config): ?string
    {
        return static::getFFI()->rd_kafka_ConfigResource_name($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_ConfigResource_error(?CData $config): int
    {
        return static::getFFI()->rd_kafka_ConfigResource_error($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t*
     * @return string|null const char*
     */
    public static function rd_kafka_ConfigResource_error_string(?CData $config): ?string
    {
        return static::getFFI()->rd_kafka_ConfigResource_error_string($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $configs rd_kafka_ConfigResource_t**
     * @param int|null $config_cnt size_t
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param CData|null $rkqu rd_kafka_queue_t*
     */
    public static function rd_kafka_AlterConfigs(?CData $rk, ?CData $configs, ?int $config_cnt, ?CData $options, ?CData $rkqu): void
    {
        static::getFFI()->rd_kafka_AlterConfigs($rk, $configs, $config_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result const rd_kafka_AlterConfigs_result_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const rd_kafka_ConfigResource_t**
     */
    public static function rd_kafka_AlterConfigs_result_resources(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_AlterConfigs_result_resources($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $configs const rd_kafka_ConfigResource_t**
     * @param int|null $config_cnt size_t
     * @param CData|null $options rd_kafka_AdminOptions_t*
     * @param CData|null $rkqu rd_kafka_queue_t*
     */
    public static function rd_kafka_DescribeConfigs(?CData $rk, ?CData $configs, ?int $config_cnt, ?CData $options, ?CData $rkqu): void
    {
        static::getFFI()->rd_kafka_DescribeConfigs($rk, $configs, $config_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result const rd_kafka_DescribeConfigs_result_t*
     * @param CData|null $cntp size_t*
     * @return CData|null const rd_kafka_ConfigResource_t**
     */
    public static function rd_kafka_DescribeConfigs_result_resources(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_DescribeConfigs_result_resources($result, $cntp);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null const rd_kafka_conf_t*
     */
    public static function rd_kafka_conf(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_conf($rk);
    }

    /**
     * @param CData|null $conf const rd_kafka_conf_t*
     * @param CData|Closure $oauthbearer_token_refresh_cb void(*)(rd_kafka_t*, const char*, void*)
     *@since 1.1.0 of librdkafka
     */
    public static function rd_kafka_conf_set_oauthbearer_token_refresh_cb(?CData $conf, $oauthbearer_token_refresh_cb): void
    {
        static::getFFI()->rd_kafka_conf_set_oauthbearer_token_refresh_cb($conf, $oauthbearer_token_refresh_cb);
    }

    /**
     * @param CData|null $conf const rd_kafka_conf_t*
     * @param CData|Closure $ssl_cert_verify_cb int(*)(rd_kafka_t*, const char*, int32_t, int*, int, const char*, size_t, char*, size_t, void*)
     * @return int rd_kafka_conf_res_t
     *@since 1.1.0 of librdkafka
     */
    public static function rd_kafka_conf_set_ssl_cert_verify_cb(?CData $conf, $ssl_cert_verify_cb): int
    {
        return static::getFFI()->rd_kafka_conf_set_ssl_cert_verify_cb($conf, $ssl_cert_verify_cb);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $conf const rd_kafka_conf_t*
     * @param int $cert_type rd_kafka_cert_type_t
     * @param int $cert_enc rd_kafka_cert_enc_t
     * @param CData|object|string|null $buffer void*
     * @param int|null $size size_t
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_conf_res_t
     */
    public static function rd_kafka_conf_set_ssl_cert(?CData $conf, int $cert_type, int $cert_enc, $buffer, ?int $size, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_conf_set_ssl_cert($conf, $cert_type, $cert_enc, $buffer, $size, $errstr, $errstr_size);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t*
     * @return string|null const char*
     */
    public static function rd_kafka_event_config_string(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_config_string($rkev);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $token_value const char*
     * @param int|null $md_lifetime_ms int64_t
     * @param string|null $md_principal_name const char*
     * @param CData|null $extensions char**
     * @param int|null $extension_size size_t
     * @param CData|null $errstr char*
     * @param int|null $errstr_size size_t
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_oauthbearer_set_token(?CData $rk, ?string $token_value, ?int $md_lifetime_ms, ?string $md_principal_name, ?CData $extensions, ?int $extension_size, ?CData $errstr, ?int $errstr_size): int
    {
        return static::getFFI()->rd_kafka_oauthbearer_set_token($rk, $token_value, $md_lifetime_ms, $md_principal_name, $extensions, $extension_size, $errstr, $errstr_size);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $errstr const char*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_oauthbearer_set_token_failure(?CData $rk, ?string $errstr): int
    {
        return static::getFFI()->rd_kafka_oauthbearer_set_token_failure($rk, $errstr);
    }

    /**
     * @since 1.2.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int $thread_type rd_kafka_thread_type_t
     * @param string|null $thread_name const char*
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_thread_start_t(?CData $rk, int $thread_type, ?string $thread_name, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_thread_start_t($rk, $thread_type, $thread_name, $ic_opaque);
    }

    /**
     * @since 1.2.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int $thread_type rd_kafka_thread_type_t
     * @param string|null $thread_name const char*
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_interceptor_f_on_thread_exit_t(?CData $rk, int $thread_type, ?string $thread_name, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_f_on_thread_exit_t($rk, $thread_type, $thread_name, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_thread_start rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_thread_start_t*)(rd_kafka_t*, rd_kafka_thread_type_t, const char*, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.2.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_thread_start(?CData $rk, ?string $ic_name, $on_thread_start, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_thread_start($rk, $ic_name, $on_thread_start, $ic_opaque);
    }

    /**
     * @param CData|null $rk rd_kafka_t*
     * @param string|null $ic_name const char*
     * @param CData|Closure $on_thread_exit rd_kafka_resp_err_t(rd_kafka_interceptor_f_on_thread_exit_t*)(rd_kafka_t*, rd_kafka_thread_type_t, const char*, void*)
     * @param CData|object|string|null $ic_opaque void*
     * @return int rd_kafka_resp_err_t
     *@since 1.2.0 of librdkafka
     */
    public static function rd_kafka_interceptor_add_on_thread_exit(?CData $rk, ?string $ic_name, $on_thread_exit, $ic_opaque): int
    {
        return static::getFFI()->rd_kafka_interceptor_add_on_thread_exit($rk, $ic_name, $on_thread_exit, $ic_opaque);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t*
     * @return int rd_kafka_resp_err_t
     */
    public static function rd_kafka_error_code(?CData $error): int
    {
        return static::getFFI()->rd_kafka_error_code($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t*
     * @return string|null const char*
     */
    public static function rd_kafka_error_name(?CData $error): ?string
    {
        return static::getFFI()->rd_kafka_error_name($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t*
     * @return string|null const char*
     */
    public static function rd_kafka_error_string(?CData $error): ?string
    {
        return static::getFFI()->rd_kafka_error_string($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t*
     * @return int|null int
     */
    public static function rd_kafka_error_is_fatal(?CData $error): ?int
    {
        return static::getFFI()->rd_kafka_error_is_fatal($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t*
     * @return int|null int
     */
    public static function rd_kafka_error_is_retriable(?CData $error): ?int
    {
        return static::getFFI()->rd_kafka_error_is_retriable($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t*
     * @return int|null int
     */
    public static function rd_kafka_error_txn_requires_abort(?CData $error): ?int
    {
        return static::getFFI()->rd_kafka_error_txn_requires_abort($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t*
     */
    public static function rd_kafka_error_destroy(?CData $error): void
    {
        static::getFFI()->rd_kafka_error_destroy($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param int $code rd_kafka_resp_err_t
     * @param string|null $fmt const char*
     * @param mixed ...$args
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_error_new(int $code, ?string $fmt, ...$args): ?CData
    {
        return static::getFFI()->rd_kafka_error_new($code, $fmt, ...$args);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param int|null $partition_cnt int32_t
     * @param CData|object|string|null $rkt_opaque void*
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int32_t
     */
    public static function rd_kafka_msg_partitioner_fnv1a(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_fnv1a($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t*
     * @param CData|object|string|null $key void*
     * @param int|null $keylen size_t
     * @param int|null $partition_cnt int32_t
     * @param CData|object|string|null $rkt_opaque void*
     * @param CData|object|string|null $msg_opaque void*
     * @return int|null int32_t
     */
    public static function rd_kafka_msg_partitioner_fnv1a_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_fnv1a_random($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null rd_kafka_consumer_group_metadata_t*
     */
    public static function rd_kafka_consumer_group_metadata(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata($rk);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param string|null $group_id const char*
     * @return CData|null rd_kafka_consumer_group_metadata_t*
     */
    public static function rd_kafka_consumer_group_metadata_new(?string $group_id): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_new($group_id);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $arg0 rd_kafka_consumer_group_metadata_t*
     */
    public static function rd_kafka_consumer_group_metadata_destroy(?CData $arg0): void
    {
        static::getFFI()->rd_kafka_consumer_group_metadata_destroy($arg0);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $cgmd rd_kafka_consumer_group_metadata_t*
     * @param CData|object|string|null $bufferp void**
     * @param CData|null $sizep size_t*
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_consumer_group_metadata_write(?CData $cgmd, $bufferp, ?CData $sizep): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_write($cgmd, $bufferp, $sizep);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $cgmdp rd_kafka_consumer_group_metadata_t**
     * @param CData|object|string|null $buffer void*
     * @param int|null $size size_t
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_consumer_group_metadata_read(?CData $cgmdp, $buffer, ?int $size): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_read($cgmdp, $buffer, $size);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_init_transactions(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_init_transactions($rk, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_begin_transaction(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_begin_transaction($rk);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param CData|null $offsets rd_kafka_topic_partition_list_t*
     * @param CData|null $cgmetadata rd_kafka_consumer_group_metadata_t*
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_send_offsets_to_transaction(?CData $rk, ?CData $offsets, ?CData $cgmetadata, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_send_offsets_to_transaction($rk, $offsets, $cgmetadata, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_commit_transaction(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_commit_transaction($rk, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t*
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t*
     */
    public static function rd_kafka_abort_transaction(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_abort_transaction($rk, $timeout_ms);
    }
}
