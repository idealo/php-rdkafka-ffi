<?php
/**
 * This file is generated! Do not edit directly.
 */

declare(strict_types=1);

namespace RdKafka\FFI;

trait Methods 
{
    abstract public static function getFFI():\FFI;
    
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
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_version_str(): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_version_str();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_get_debug_contexts(): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_get_debug_contexts();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $errdescs rd_kafka_err_desc_ptr_ptr
     * @param \FFI\CData|null $cntp int_ptr
     */
    public static function rd_kafka_get_err_descs(?\FFI\CData $errdescs, ?\FFI\CData $cntp): void 
    {
        static::getFFI()->rd_kafka_get_err_descs($errdescs, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $err int
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_err2str(?int $err): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_err2str($err);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $err int
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_err2name(?int $err): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_err2name($err);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public static function rd_kafka_last_error(): ?int 
    {
        return static::getFFI()->rd_kafka_last_error();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $errnox int
     * @return int|null int
     */
    public static function rd_kafka_errno2err(?int $errnox): ?int 
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
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_fatal_error(?\FFI\CData $rk, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_fatal_error($rk, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $err int
     * @param string|null $reason string
     * @return int|null int
     */
    public static function rd_kafka_test_fatal_error(?\FFI\CData $rk, ?int $err, ?string $reason): ?int 
    {
        return static::getFFI()->rd_kafka_test_fatal_error($rk, $err, $reason);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktpar rd_kafka_topic_partition_t_ptr
     */
    public static function rd_kafka_topic_partition_destroy(?\FFI\CData $rktpar): void 
    {
        static::getFFI()->rd_kafka_topic_partition_destroy($rktpar);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $size int
     * @return \FFI\CData|null rd_kafka_topic_partition_list_t_ptr
     */
    public static function rd_kafka_topic_partition_list_new(?int $size): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_partition_list_new($size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkparlist rd_kafka_topic_partition_list_t_ptr
     */
    public static function rd_kafka_topic_partition_list_destroy(?\FFI\CData $rkparlist): void 
    {
        static::getFFI()->rd_kafka_topic_partition_list_destroy($rkparlist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return \FFI\CData|null rd_kafka_topic_partition_t_ptr
     */
    public static function rd_kafka_topic_partition_list_add(?\FFI\CData $rktparlist, ?string $topic, ?int $partition): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_partition_list_add($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $start int
     * @param int|null $stop int
     */
    public static function rd_kafka_topic_partition_list_add_range(?\FFI\CData $rktparlist, ?string $topic, ?int $start, ?int $stop): void 
    {
        static::getFFI()->rd_kafka_topic_partition_list_add_range($rktparlist, $topic, $start, $stop);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return int|null int
     */
    public static function rd_kafka_topic_partition_list_del(?\FFI\CData $rktparlist, ?string $topic, ?int $partition): ?int 
    {
        return static::getFFI()->rd_kafka_topic_partition_list_del($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param int|null $idx int
     * @return int|null int
     */
    public static function rd_kafka_topic_partition_list_del_by_idx(?\FFI\CData $rktparlist, ?int $idx): ?int 
    {
        return static::getFFI()->rd_kafka_topic_partition_list_del_by_idx($rktparlist, $idx);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $src rd_kafka_topic_partition_list_t_ptr
     * @return \FFI\CData|null rd_kafka_topic_partition_list_t_ptr
     */
    public static function rd_kafka_topic_partition_list_copy(?\FFI\CData $src): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_partition_list_copy($src);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @param int|null $offset int
     * @return int|null int
     */
    public static function rd_kafka_topic_partition_list_set_offset(?\FFI\CData $rktparlist, ?string $topic, ?int $partition, ?int $offset): ?int 
    {
        return static::getFFI()->rd_kafka_topic_partition_list_set_offset($rktparlist, $topic, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return \FFI\CData|null rd_kafka_topic_partition_t_ptr
     */
    public static function rd_kafka_topic_partition_list_find(?\FFI\CData $rktparlist, ?string $topic, ?int $partition): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_partition_list_find($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param callable|null $cmp callable
     * @param \FFI\CData|string|null $opaque void_ptr
     */
    public static function rd_kafka_topic_partition_list_sort(?\FFI\CData $rktparlist, ?callable $cmp,  $opaque): void 
    {
        static::getFFI()->rd_kafka_topic_partition_list_sort($rktparlist, $cmp, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $initial_count int
     * @return \FFI\CData|null rd_kafka_headers_t_ptr
     */
    public static function rd_kafka_headers_new(?int $initial_count): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_headers_new($initial_count);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     */
    public static function rd_kafka_headers_destroy(?\FFI\CData $hdrs): void 
    {
        static::getFFI()->rd_kafka_headers_destroy($hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $src rd_kafka_headers_t_ptr
     * @return \FFI\CData|null rd_kafka_headers_t_ptr
     */
    public static function rd_kafka_headers_copy(?\FFI\CData $src): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_headers_copy($src);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     * @param string|null $name string
     * @param int|null $name_size int
     * @param \FFI\CData|string|null $value void_ptr
     * @param int|null $value_size int
     * @return int|null int
     */
    public static function rd_kafka_header_add(?\FFI\CData $hdrs, ?string $name, ?int $name_size,  $value, ?int $value_size): ?int 
    {
        return static::getFFI()->rd_kafka_header_add($hdrs, $name, $name_size, $value, $value_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     * @param string|null $name string
     * @return int|null int
     */
    public static function rd_kafka_header_remove(?\FFI\CData $hdrs, ?string $name): ?int 
    {
        return static::getFFI()->rd_kafka_header_remove($hdrs, $name);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     * @param string|null $name string
     * @param \FFI\CData|null $valuep void_ptr_ptr
     * @param \FFI\CData|null $sizep int_ptr
     * @return int|null int
     */
    public static function rd_kafka_header_get_last(?\FFI\CData $hdrs, ?string $name, ?\FFI\CData $valuep, ?\FFI\CData $sizep): ?int 
    {
        return static::getFFI()->rd_kafka_header_get_last($hdrs, $name, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     * @param int|null $idx int
     * @param string|null $name string
     * @param \FFI\CData|null $valuep void_ptr_ptr
     * @param \FFI\CData|null $sizep int_ptr
     * @return int|null int
     */
    public static function rd_kafka_header_get(?\FFI\CData $hdrs, ?int $idx, ?string $name, ?\FFI\CData $valuep, ?\FFI\CData $sizep): ?int 
    {
        return static::getFFI()->rd_kafka_header_get($hdrs, $idx, $name, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     * @param int|null $idx int
     * @param \FFI\CData|null $namep string_ptr_ptr
     * @param \FFI\CData|null $valuep void_ptr_ptr
     * @param \FFI\CData|null $sizep int_ptr
     * @return int|null int
     */
    public static function rd_kafka_header_get_all(?\FFI\CData $hdrs, ?int $idx, ?\FFI\CData $namep, ?\FFI\CData $valuep, ?\FFI\CData $sizep): ?int 
    {
        return static::getFFI()->rd_kafka_header_get_all($hdrs, $idx, $namep, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     */
    public static function rd_kafka_message_destroy(?\FFI\CData $rkmessage): void 
    {
        static::getFFI()->rd_kafka_message_destroy($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     * @param \FFI\CData|null $tstype int_ptr
     * @return int|null int
     */
    public static function rd_kafka_message_timestamp(?\FFI\CData $rkmessage, ?\FFI\CData $tstype): ?int 
    {
        return static::getFFI()->rd_kafka_message_timestamp($rkmessage, $tstype);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_message_latency(?\FFI\CData $rkmessage): ?int 
    {
        return static::getFFI()->rd_kafka_message_latency($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     * @param \FFI\CData|null $hdrsp rd_kafka_headers_t_ptr_ptr
     * @return int|null int
     */
    public static function rd_kafka_message_headers(?\FFI\CData $rkmessage, ?\FFI\CData $hdrsp): ?int 
    {
        return static::getFFI()->rd_kafka_message_headers($rkmessage, $hdrsp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     * @param \FFI\CData|null $hdrsp rd_kafka_headers_t_ptr_ptr
     * @return int|null int
     */
    public static function rd_kafka_message_detach_headers(?\FFI\CData $rkmessage, ?\FFI\CData $hdrsp): ?int 
    {
        return static::getFFI()->rd_kafka_message_detach_headers($rkmessage, $hdrsp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     */
    public static function rd_kafka_message_set_headers(?\FFI\CData $rkmessage, ?\FFI\CData $hdrs): void 
    {
        static::getFFI()->rd_kafka_message_set_headers($rkmessage, $hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $hdrs rd_kafka_headers_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_header_cnt(?\FFI\CData $hdrs): ?int 
    {
        return static::getFFI()->rd_kafka_header_cnt($hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_message_status(?\FFI\CData $rkmessage): ?int 
    {
        return static::getFFI()->rd_kafka_message_status($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return \FFI\CData|null rd_kafka_conf_t_ptr
     */
    public static function rd_kafka_conf_new(): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_conf_new();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     */
    public static function rd_kafka_conf_destroy(?\FFI\CData $conf): void 
    {
        static::getFFI()->rd_kafka_conf_destroy($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @return \FFI\CData|null rd_kafka_conf_t_ptr
     */
    public static function rd_kafka_conf_dup(?\FFI\CData $conf): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_conf_dup($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param int|null $filter_cnt int
     * @param \FFI\CData|null $filter string_ptr_ptr
     * @return \FFI\CData|null rd_kafka_conf_t_ptr
     */
    public static function rd_kafka_conf_dup_filter(?\FFI\CData $conf, ?int $filter_cnt, ?\FFI\CData $filter): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_conf_dup_filter($conf, $filter_cnt, $filter);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_conf_set(?\FFI\CData $conf, ?string $name, ?string $value, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_conf_set($conf, $name, $value, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param int|null $events int
     */
    public static function rd_kafka_conf_set_events(?\FFI\CData $conf, ?int $events): void 
    {
        static::getFFI()->rd_kafka_conf_set_events($conf, $events);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $event_cb callable
     */
    public static function rd_kafka_conf_set_background_event_cb(?\FFI\CData $conf, ?callable $event_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_background_event_cb($conf, $event_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $dr_cb callable
     */
    public static function rd_kafka_conf_set_dr_cb(?\FFI\CData $conf, ?callable $dr_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_dr_cb($conf, $dr_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $dr_msg_cb callable
     */
    public static function rd_kafka_conf_set_dr_msg_cb(?\FFI\CData $conf, ?callable $dr_msg_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_dr_msg_cb($conf, $dr_msg_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $consume_cb callable
     */
    public static function rd_kafka_conf_set_consume_cb(?\FFI\CData $conf, ?callable $consume_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_consume_cb($conf, $consume_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $rebalance_cb callable
     */
    public static function rd_kafka_conf_set_rebalance_cb(?\FFI\CData $conf, ?callable $rebalance_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_rebalance_cb($conf, $rebalance_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $offset_commit_cb callable
     */
    public static function rd_kafka_conf_set_offset_commit_cb(?\FFI\CData $conf, ?callable $offset_commit_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_offset_commit_cb($conf, $offset_commit_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $error_cb callable
     */
    public static function rd_kafka_conf_set_error_cb(?\FFI\CData $conf, ?callable $error_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_error_cb($conf, $error_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $throttle_cb callable
     */
    public static function rd_kafka_conf_set_throttle_cb(?\FFI\CData $conf, ?callable $throttle_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_throttle_cb($conf, $throttle_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $log_cb callable
     */
    public static function rd_kafka_conf_set_log_cb(?\FFI\CData $conf, ?callable $log_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_log_cb($conf, $log_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $stats_cb callable
     */
    public static function rd_kafka_conf_set_stats_cb(?\FFI\CData $conf, ?callable $stats_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_stats_cb($conf, $stats_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $socket_cb callable
     */
    public static function rd_kafka_conf_set_socket_cb(?\FFI\CData $conf, ?callable $socket_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_socket_cb($conf, $socket_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $connect_cb callable
     */
    public static function rd_kafka_conf_set_connect_cb(?\FFI\CData $conf, ?callable $connect_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_connect_cb($conf, $connect_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $closesocket_cb callable
     */
    public static function rd_kafka_conf_set_closesocket_cb(?\FFI\CData $conf, ?callable $closesocket_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_closesocket_cb($conf, $closesocket_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param \FFI\CData|string|null $opaque void_ptr
     */
    public static function rd_kafka_conf_set_opaque(?\FFI\CData $conf,  $opaque): void 
    {
        static::getFFI()->rd_kafka_conf_set_opaque($conf, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|string|null void_ptr
     */
    public static function rd_kafka_opaque(?\FFI\CData $rk) 
    {
        return static::getFFI()->rd_kafka_opaque($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param \FFI\CData|null $tconf rd_kafka_topic_conf_t_ptr
     */
    public static function rd_kafka_conf_set_default_topic_conf(?\FFI\CData $conf, ?\FFI\CData $tconf): void 
    {
        static::getFFI()->rd_kafka_conf_set_default_topic_conf($conf, $tconf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param string|null $name string
     * @param \FFI\CData|null $dest string_ptr
     * @param \FFI\CData|null $dest_size int_ptr
     * @return int|null int
     */
    public static function rd_kafka_conf_get(?\FFI\CData $conf, ?string $name, ?\FFI\CData $dest, ?\FFI\CData $dest_size): ?int 
    {
        return static::getFFI()->rd_kafka_conf_get($conf, $name, $dest, $dest_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param string|null $name string
     * @param \FFI\CData|null $dest string_ptr
     * @param \FFI\CData|null $dest_size int_ptr
     * @return int|null int
     */
    public static function rd_kafka_topic_conf_get(?\FFI\CData $conf, ?string $name, ?\FFI\CData $dest, ?\FFI\CData $dest_size): ?int 
    {
        return static::getFFI()->rd_kafka_topic_conf_get($conf, $name, $dest, $dest_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null string_ptr
     */
    public static function rd_kafka_conf_dump(?\FFI\CData $conf, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_conf_dump($conf, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null string_ptr
     */
    public static function rd_kafka_topic_conf_dump(?\FFI\CData $conf, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_conf_dump($conf, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $arr string_ptr_ptr
     * @param int|null $cnt int
     */
    public static function rd_kafka_conf_dump_free(?\FFI\CData $arr, ?int $cnt): void 
    {
        static::getFFI()->rd_kafka_conf_dump_free($arr, $cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $fp FILE_ptr
     */
    public static function rd_kafka_conf_properties_show(?\FFI\CData $fp): void 
    {
        static::getFFI()->rd_kafka_conf_properties_show($fp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return \FFI\CData|null rd_kafka_topic_conf_t_ptr
     */
    public static function rd_kafka_topic_conf_new(): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_conf_new();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_topic_conf_t_ptr
     * @return \FFI\CData|null rd_kafka_topic_conf_t_ptr
     */
    public static function rd_kafka_topic_conf_dup(?\FFI\CData $conf): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_conf_dup($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_topic_conf_t_ptr
     */
    public static function rd_kafka_default_topic_conf_dup(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_default_topic_conf_dup($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $topic_conf rd_kafka_topic_conf_t_ptr
     */
    public static function rd_kafka_topic_conf_destroy(?\FFI\CData $topic_conf): void 
    {
        static::getFFI()->rd_kafka_topic_conf_destroy($topic_conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_topic_conf_set(?\FFI\CData $conf, ?string $name, ?string $value, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_topic_conf_set($conf, $name, $value, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param \FFI\CData|string|null $opaque void_ptr
     */
    public static function rd_kafka_topic_conf_set_opaque(?\FFI\CData $conf,  $opaque): void 
    {
        static::getFFI()->rd_kafka_topic_conf_set_opaque($conf, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $topic_conf rd_kafka_topic_conf_t_ptr
     * @param callable|null $partitioner callable
     */
    public static function rd_kafka_topic_conf_set_partitioner_cb(?\FFI\CData $topic_conf, ?callable $partitioner): void 
    {
        static::getFFI()->rd_kafka_topic_conf_set_partitioner_cb($topic_conf, $partitioner);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $topic_conf rd_kafka_topic_conf_t_ptr
     * @param callable|null $msg_order_cmp callable
     */
    public static function rd_kafka_topic_conf_set_msg_order_cmp(?\FFI\CData $topic_conf, ?callable $msg_order_cmp): void 
    {
        static::getFFI()->rd_kafka_topic_conf_set_msg_order_cmp($topic_conf, $msg_order_cmp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @return int|null int
     */
    public static function rd_kafka_topic_partition_available(?\FFI\CData $rkt, ?int $partition): ?int 
    {
        return static::getFFI()->rd_kafka_topic_partition_available($rkt, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param \FFI\CData|string|null $opaque void_ptr
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_msg_partitioner_random(?\FFI\CData $rkt,  $key, ?int $keylen, ?int $partition_cnt,  $opaque,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_msg_partitioner_random($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param \FFI\CData|string|null $opaque void_ptr
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_msg_partitioner_consistent(?\FFI\CData $rkt,  $key, ?int $keylen, ?int $partition_cnt,  $opaque,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_msg_partitioner_consistent($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param \FFI\CData|string|null $opaque void_ptr
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_msg_partitioner_consistent_random(?\FFI\CData $rkt,  $key, ?int $keylen, ?int $partition_cnt,  $opaque,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_msg_partitioner_consistent_random($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param \FFI\CData|string|null $rkt_opaque void_ptr
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_msg_partitioner_murmur2(?\FFI\CData $rkt,  $key, ?int $keylen, ?int $partition_cnt,  $rkt_opaque,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_msg_partitioner_murmur2($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param \FFI\CData|string|null $rkt_opaque void_ptr
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_msg_partitioner_murmur2_random(?\FFI\CData $rkt,  $key, ?int $keylen, ?int $partition_cnt,  $rkt_opaque,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_msg_partitioner_murmur2_random($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $type int
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return \FFI\CData|null rd_kafka_t_ptr
     */
    public static function rd_kafka_new(?int $type, ?\FFI\CData $conf, ?\FFI\CData $errstr, ?int $errstr_size): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_new($type, $conf, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     */
    public static function rd_kafka_destroy(?\FFI\CData $rk): void 
    {
        static::getFFI()->rd_kafka_destroy($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $flags int
     */
    public static function rd_kafka_destroy_flags(?\FFI\CData $rk, ?int $flags): void 
    {
        static::getFFI()->rd_kafka_destroy_flags($rk, $flags);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_name(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_name($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_type(?\FFI\CData $rk): ?int 
    {
        return static::getFFI()->rd_kafka_type($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null string_ptr
     */
    public static function rd_kafka_memberid(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_memberid($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null string_ptr
     */
    public static function rd_kafka_clusterid(?\FFI\CData $rk, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_clusterid($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_controllerid(?\FFI\CData $rk, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_controllerid($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param \FFI\CData|null $conf rd_kafka_topic_conf_t_ptr
     * @return \FFI\CData|null rd_kafka_topic_t_ptr
     */
    public static function rd_kafka_topic_new(?\FFI\CData $rk, ?string $topic, ?\FFI\CData $conf): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_new($rk, $topic, $conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     */
    public static function rd_kafka_topic_destroy(?\FFI\CData $rkt): void 
    {
        static::getFFI()->rd_kafka_topic_destroy($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_topic_name(?\FFI\CData $rkt): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_name($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @return \FFI\CData|string|null void_ptr
     */
    public static function rd_kafka_topic_opaque(?\FFI\CData $rkt) 
    {
        return static::getFFI()->rd_kafka_topic_opaque($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_poll(?\FFI\CData $rk, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_poll($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     */
    public static function rd_kafka_yield(?\FFI\CData $rk): void 
    {
        static::getFFI()->rd_kafka_yield($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_pause_partitions(?\FFI\CData $rk, ?\FFI\CData $partitions): ?int 
    {
        return static::getFFI()->rd_kafka_pause_partitions($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_resume_partitions(?\FFI\CData $rk, ?\FFI\CData $partitions): ?int 
    {
        return static::getFFI()->rd_kafka_resume_partitions($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @param \FFI\CData|null $low int_ptr
     * @param \FFI\CData|null $high int_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_query_watermark_offsets(?\FFI\CData $rk, ?string $topic, ?int $partition, ?\FFI\CData $low, ?\FFI\CData $high, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_query_watermark_offsets($rk, $topic, $partition, $low, $high, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @param \FFI\CData|null $low int_ptr
     * @param \FFI\CData|null $high int_ptr
     * @return int|null int
     */
    public static function rd_kafka_get_watermark_offsets(?\FFI\CData $rk, ?string $topic, ?int $partition, ?\FFI\CData $low, ?\FFI\CData $high): ?int 
    {
        return static::getFFI()->rd_kafka_get_watermark_offsets($rk, $topic, $partition, $low, $high);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_offsets_for_times(?\FFI\CData $rk, ?\FFI\CData $offsets, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_offsets_for_times($rk, $offsets, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|string|null $ptr void_ptr
     */
    public static function rd_kafka_mem_free(?\FFI\CData $rk,  $ptr): void 
    {
        static::getFFI()->rd_kafka_mem_free($rk, $ptr);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_queue_new(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_queue_new($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_queue_destroy(?\FFI\CData $rkqu): void 
    {
        static::getFFI()->rd_kafka_queue_destroy($rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_queue_get_main(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_queue_get_main($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_queue_get_consumer(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_queue_get_consumer($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return \FFI\CData|null rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_queue_get_partition(?\FFI\CData $rk, ?string $topic, ?int $partition): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_queue_get_partition($rk, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_queue_get_background(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_queue_get_background($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $src rd_kafka_queue_t_ptr
     * @param \FFI\CData|null $dst rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_queue_forward(?\FFI\CData $src, ?\FFI\CData $dst): void 
    {
        static::getFFI()->rd_kafka_queue_forward($src, $dst);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_set_log_queue(?\FFI\CData $rk, ?\FFI\CData $rkqu): ?int 
    {
        return static::getFFI()->rd_kafka_set_log_queue($rk, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_queue_length(?\FFI\CData $rkqu): ?int 
    {
        return static::getFFI()->rd_kafka_queue_length($rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $fd int
     * @param \FFI\CData|string|null $payload void_ptr
     * @param int|null $size int
     */
    public static function rd_kafka_queue_io_event_enable(?\FFI\CData $rkqu, ?int $fd,  $payload, ?int $size): void 
    {
        static::getFFI()->rd_kafka_queue_io_event_enable($rkqu, $fd, $payload, $size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param callable|null $event_cb callable
     * @param \FFI\CData|string|null $opaque void_ptr
     */
    public static function rd_kafka_queue_cb_event_enable(?\FFI\CData $rkqu, ?callable $event_cb,  $opaque): void 
    {
        static::getFFI()->rd_kafka_queue_cb_event_enable($rkqu, $event_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @return int|null int
     */
    public static function rd_kafka_consume_start(?\FFI\CData $rkt, ?int $partition, ?int $offset): ?int 
    {
        return static::getFFI()->rd_kafka_consume_start($rkt, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_consume_start_queue(?\FFI\CData $rkt, ?int $partition, ?int $offset, ?\FFI\CData $rkqu): ?int 
    {
        return static::getFFI()->rd_kafka_consume_start_queue($rkt, $partition, $offset, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @return int|null int
     */
    public static function rd_kafka_consume_stop(?\FFI\CData $rkt, ?int $partition): ?int 
    {
        return static::getFFI()->rd_kafka_consume_stop($rkt, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_seek(?\FFI\CData $rkt, ?int $partition, ?int $offset, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_seek($rkt, $partition, $offset, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_message_t_ptr
     */
    public static function rd_kafka_consume(?\FFI\CData $rkt, ?int $partition, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_consume($rkt, $partition, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $timeout_ms int
     * @param \FFI\CData|null $rkmessages rd_kafka_message_t_ptr_ptr
     * @param int|null $rkmessages_size int
     * @return int|null int
     */
    public static function rd_kafka_consume_batch(?\FFI\CData $rkt, ?int $partition, ?int $timeout_ms, ?\FFI\CData $rkmessages, ?int $rkmessages_size): ?int 
    {
        return static::getFFI()->rd_kafka_consume_batch($rkt, $partition, $timeout_ms, $rkmessages, $rkmessages_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $timeout_ms int
     * @param callable|null $consume_cb callable
     * @param \FFI\CData|string|null $opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_consume_callback(?\FFI\CData $rkt, ?int $partition, ?int $timeout_ms, ?callable $consume_cb,  $opaque): ?int 
    {
        return static::getFFI()->rd_kafka_consume_callback($rkt, $partition, $timeout_ms, $consume_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_message_t_ptr
     */
    public static function rd_kafka_consume_queue(?\FFI\CData $rkqu, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_consume_queue($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @param \FFI\CData|null $rkmessages rd_kafka_message_t_ptr_ptr
     * @param int|null $rkmessages_size int
     * @return int|null int
     */
    public static function rd_kafka_consume_batch_queue(?\FFI\CData $rkqu, ?int $timeout_ms, ?\FFI\CData $rkmessages, ?int $rkmessages_size): ?int 
    {
        return static::getFFI()->rd_kafka_consume_batch_queue($rkqu, $timeout_ms, $rkmessages, $rkmessages_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @param callable|null $consume_cb callable
     * @param \FFI\CData|string|null $opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_consume_callback_queue(?\FFI\CData $rkqu, ?int $timeout_ms, ?callable $consume_cb,  $opaque): ?int 
    {
        return static::getFFI()->rd_kafka_consume_callback_queue($rkqu, $timeout_ms, $consume_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @return int|null int
     */
    public static function rd_kafka_offset_store(?\FFI\CData $rkt, ?int $partition, ?int $offset): ?int 
    {
        return static::getFFI()->rd_kafka_offset_store($rkt, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_offsets_store(?\FFI\CData $rk, ?\FFI\CData $offsets): ?int 
    {
        return static::getFFI()->rd_kafka_offsets_store($rk, $offsets);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $topics rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_subscribe(?\FFI\CData $rk, ?\FFI\CData $topics): ?int 
    {
        return static::getFFI()->rd_kafka_subscribe($rk, $topics);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_unsubscribe(?\FFI\CData $rk): ?int 
    {
        return static::getFFI()->rd_kafka_unsubscribe($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $topics rd_kafka_topic_partition_list_t_ptr_ptr
     * @return int|null int
     */
    public static function rd_kafka_subscription(?\FFI\CData $rk, ?\FFI\CData $topics): ?int 
    {
        return static::getFFI()->rd_kafka_subscription($rk, $topics);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_message_t_ptr
     */
    public static function rd_kafka_consumer_poll(?\FFI\CData $rk, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_consumer_poll($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_consumer_close(?\FFI\CData $rk): ?int 
    {
        return static::getFFI()->rd_kafka_consumer_close($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_assign(?\FFI\CData $rk, ?\FFI\CData $partitions): ?int 
    {
        return static::getFFI()->rd_kafka_assign($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $partitions rd_kafka_topic_partition_list_t_ptr_ptr
     * @return int|null int
     */
    public static function rd_kafka_assignment(?\FFI\CData $rk, ?\FFI\CData $partitions): ?int 
    {
        return static::getFFI()->rd_kafka_assignment($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param int|null $async int
     * @return int|null int
     */
    public static function rd_kafka_commit(?\FFI\CData $rk, ?\FFI\CData $offsets, ?int $async): ?int 
    {
        return static::getFFI()->rd_kafka_commit($rk, $offsets, $async);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $rkmessage rd_kafka_message_t_ptr
     * @param int|null $async int
     * @return int|null int
     */
    public static function rd_kafka_commit_message(?\FFI\CData $rk, ?\FFI\CData $rkmessage, ?int $async): ?int 
    {
        return static::getFFI()->rd_kafka_commit_message($rk, $rkmessage, $async);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param callable|null $cb callable
     * @param \FFI\CData|string|null $opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_commit_queue(?\FFI\CData $rk, ?\FFI\CData $offsets, ?\FFI\CData $rkqu, ?callable $cb,  $opaque): ?int 
    {
        return static::getFFI()->rd_kafka_commit_queue($rk, $offsets, $rkqu, $cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_committed(?\FFI\CData $rk, ?\FFI\CData $partitions, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_committed($rk, $partitions, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_position(?\FFI\CData $rk, ?\FFI\CData $partitions): ?int 
    {
        return static::getFFI()->rd_kafka_position($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $msgflags int
     * @param \FFI\CData|string|null $payload void_ptr
     * @param int|null $len int
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_produce(?\FFI\CData $rkt, ?int $partition, ?int $msgflags,  $payload, ?int $len,  $key, ?int $keylen,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_produce($rkt, $partition, $msgflags, $payload, $len, $key, $keylen, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param mixed ...$params
     * @return int|null int
     */
    public static function rd_kafka_producev(?\FFI\CData $rk, ...$params): ?int 
    {
        return static::getFFI()->rd_kafka_producev($rk, ...$params);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $msgflags int
     * @param \FFI\CData|null $rkmessages rd_kafka_message_t_ptr
     * @param int|null $message_cnt int
     * @return int|null int
     */
    public static function rd_kafka_produce_batch(?\FFI\CData $rkt, ?int $partition, ?int $msgflags, ?\FFI\CData $rkmessages, ?int $message_cnt): ?int 
    {
        return static::getFFI()->rd_kafka_produce_batch($rkt, $partition, $msgflags, $rkmessages, $message_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_flush(?\FFI\CData $rk, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_flush($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $purge_flags int
     * @return int|null int
     */
    public static function rd_kafka_purge(?\FFI\CData $rk, ?int $purge_flags): ?int 
    {
        return static::getFFI()->rd_kafka_purge($rk, $purge_flags);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $all_topics int
     * @param \FFI\CData|null $only_rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|null $metadatap rd_kafka_metadata_ptr_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_metadata(?\FFI\CData $rk, ?int $all_topics, ?\FFI\CData $only_rkt, ?\FFI\CData $metadatap, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_metadata($rk, $all_topics, $only_rkt, $metadatap, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $metadata rd_kafka_metadata_ptr
     */
    public static function rd_kafka_metadata_destroy(?\FFI\CData $metadata): void 
    {
        static::getFFI()->rd_kafka_metadata_destroy($metadata);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $group string
     * @param \FFI\CData|null $grplistp rd_kafka_group_list_ptr_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_list_groups(?\FFI\CData $rk, ?string $group, ?\FFI\CData $grplistp, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_list_groups($rk, $group, $grplistp, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $grplist rd_kafka_group_list_ptr
     */
    public static function rd_kafka_group_list_destroy(?\FFI\CData $grplist): void 
    {
        static::getFFI()->rd_kafka_group_list_destroy($grplist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $brokerlist string
     * @return int|null int
     */
    public static function rd_kafka_brokers_add(?\FFI\CData $rk, ?string $brokerlist): ?int 
    {
        return static::getFFI()->rd_kafka_brokers_add($rk, $brokerlist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param callable|null $func callable
     */
    public static function rd_kafka_set_logger(?\FFI\CData $rk, ?callable $func): void 
    {
        static::getFFI()->rd_kafka_set_logger($rk, $func);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $level int
     */
    public static function rd_kafka_set_log_level(?\FFI\CData $rk, ?int $level): void 
    {
        static::getFFI()->rd_kafka_set_log_level($rk, $level);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $level int
     * @param string|null $fac string
     * @param string|null $buf string
     */
    public static function rd_kafka_log_print(?\FFI\CData $rk, ?int $level, ?string $fac, ?string $buf): void 
    {
        static::getFFI()->rd_kafka_log_print($rk, $level, $fac, $buf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_outq_len(?\FFI\CData $rk): ?int 
    {
        return static::getFFI()->rd_kafka_outq_len($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $fp FILE_ptr
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     */
    public static function rd_kafka_dump(?\FFI\CData $fp, ?\FFI\CData $rk): void 
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
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_poll_set_consumer(?\FFI\CData $rk): ?int 
    {
        return static::getFFI()->rd_kafka_poll_set_consumer($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_event_type(?\FFI\CData $rkev): ?int 
    {
        return static::getFFI()->rd_kafka_event_type($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_event_name(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_name($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     */
    public static function rd_kafka_event_destroy(?\FFI\CData $rkev): void 
    {
        static::getFFI()->rd_kafka_event_destroy($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_message_t_ptr
     */
    public static function rd_kafka_event_message_next(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_message_next($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @param \FFI\CData|null $rkmessages rd_kafka_message_t_ptr_ptr
     * @param int|null $size int
     * @return int|null int
     */
    public static function rd_kafka_event_message_array(?\FFI\CData $rkev, ?\FFI\CData $rkmessages, ?int $size): ?int 
    {
        return static::getFFI()->rd_kafka_event_message_array($rkev, $rkmessages, $size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_event_message_count(?\FFI\CData $rkev): ?int 
    {
        return static::getFFI()->rd_kafka_event_message_count($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_event_error(?\FFI\CData $rkev): ?int 
    {
        return static::getFFI()->rd_kafka_event_error($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_event_error_string(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_error_string($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_event_error_is_fatal(?\FFI\CData $rkev): ?int 
    {
        return static::getFFI()->rd_kafka_event_error_is_fatal($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|string|null void_ptr
     */
    public static function rd_kafka_event_opaque(?\FFI\CData $rkev) 
    {
        return static::getFFI()->rd_kafka_event_opaque($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @param \FFI\CData|null $fac string_ptr_ptr
     * @param \FFI\CData|null $str string_ptr_ptr
     * @param \FFI\CData|null $level int_ptr
     * @return int|null int
     */
    public static function rd_kafka_event_log(?\FFI\CData $rkev, ?\FFI\CData $fac, ?\FFI\CData $str, ?\FFI\CData $level): ?int 
    {
        return static::getFFI()->rd_kafka_event_log($rkev, $fac, $str, $level);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_event_stats(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_stats($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_topic_partition_list_t_ptr
     */
    public static function rd_kafka_event_topic_partition_list(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_topic_partition_list($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_topic_partition_t_ptr
     */
    public static function rd_kafka_event_topic_partition(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_topic_partition($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_CreateTopics_result_t_ptr
     */
    public static function rd_kafka_event_CreateTopics_result(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_CreateTopics_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_DeleteTopics_result_t_ptr
     */
    public static function rd_kafka_event_DeleteTopics_result(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_DeleteTopics_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_CreatePartitions_result_t_ptr
     */
    public static function rd_kafka_event_CreatePartitions_result(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_CreatePartitions_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_AlterConfigs_result_t_ptr
     */
    public static function rd_kafka_event_AlterConfigs_result(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_AlterConfigs_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null rd_kafka_DescribeConfigs_result_t_ptr
     */
    public static function rd_kafka_event_DescribeConfigs_result(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_DescribeConfigs_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_event_t_ptr
     */
    public static function rd_kafka_queue_poll(?\FFI\CData $rkqu, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_queue_poll($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public static function rd_kafka_queue_poll_callback(?\FFI\CData $rkqu, ?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_queue_poll_callback($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $topicres rd_kafka_topic_result_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_topic_result_error(?\FFI\CData $topicres): ?int 
    {
        return static::getFFI()->rd_kafka_topic_result_error($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $topicres rd_kafka_topic_result_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_topic_result_error_string(?\FFI\CData $topicres): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_result_error_string($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $topicres rd_kafka_topic_result_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_topic_result_name(?\FFI\CData $topicres): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_topic_result_name($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $for_api int
     * @return \FFI\CData|null rd_kafka_AdminOptions_t_ptr
     */
    public static function rd_kafka_AdminOptions_new(?\FFI\CData $rk, ?int $for_api): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_AdminOptions_new($rk, $for_api);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     */
    public static function rd_kafka_AdminOptions_destroy(?\FFI\CData $options): void 
    {
        static::getFFI()->rd_kafka_AdminOptions_destroy($options);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $timeout_ms int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_AdminOptions_set_request_timeout(?\FFI\CData $options, ?int $timeout_ms, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_request_timeout($options, $timeout_ms, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $timeout_ms int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_AdminOptions_set_operation_timeout(?\FFI\CData $options, ?int $timeout_ms, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_operation_timeout($options, $timeout_ms, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $true_or_false int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_AdminOptions_set_validate_only(?\FFI\CData $options, ?int $true_or_false, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_validate_only($options, $true_or_false, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $broker_id int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_AdminOptions_set_broker(?\FFI\CData $options, ?int $broker_id, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_broker($options, $broker_id, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param \FFI\CData|string|null $opaque void_ptr
     */
    public static function rd_kafka_AdminOptions_set_opaque(?\FFI\CData $options,  $opaque): void 
    {
        static::getFFI()->rd_kafka_AdminOptions_set_opaque($options, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic string
     * @param int|null $num_partitions int
     * @param int|null $replication_factor int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return \FFI\CData|null rd_kafka_NewTopic_t_ptr
     */
    public static function rd_kafka_NewTopic_new(?string $topic, ?int $num_partitions, ?int $replication_factor, ?\FFI\CData $errstr, ?int $errstr_size): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_NewTopic_new($topic, $num_partitions, $replication_factor, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $new_topic rd_kafka_NewTopic_t_ptr
     */
    public static function rd_kafka_NewTopic_destroy(?\FFI\CData $new_topic): void 
    {
        static::getFFI()->rd_kafka_NewTopic_destroy($new_topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $new_topics rd_kafka_NewTopic_t_ptr_ptr
     * @param int|null $new_topic_cnt int
     */
    public static function rd_kafka_NewTopic_destroy_array(?\FFI\CData $new_topics, ?int $new_topic_cnt): void 
    {
        static::getFFI()->rd_kafka_NewTopic_destroy_array($new_topics, $new_topic_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $new_topic rd_kafka_NewTopic_t_ptr
     * @param int|null $partition int
     * @param \FFI\CData|null $broker_ids int_ptr
     * @param int|null $broker_id_cnt int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_NewTopic_set_replica_assignment(?\FFI\CData $new_topic, ?int $partition, ?\FFI\CData $broker_ids, ?int $broker_id_cnt, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_NewTopic_set_replica_assignment($new_topic, $partition, $broker_ids, $broker_id_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $new_topic rd_kafka_NewTopic_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @return int|null int
     */
    public static function rd_kafka_NewTopic_set_config(?\FFI\CData $new_topic, ?string $name, ?string $value): ?int 
    {
        return static::getFFI()->rd_kafka_NewTopic_set_config($new_topic, $name, $value);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $new_topics rd_kafka_NewTopic_t_ptr_ptr
     * @param int|null $new_topic_cnt int
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_CreateTopics(?\FFI\CData $rk, ?\FFI\CData $new_topics, ?int $new_topic_cnt, ?\FFI\CData $options, ?\FFI\CData $rkqu): void 
    {
        static::getFFI()->rd_kafka_CreateTopics($rk, $new_topics, $new_topic_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $result rd_kafka_CreateTopics_result_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null rd_kafka_topic_result_t_ptr_ptr
     */
    public static function rd_kafka_CreateTopics_result_topics(?\FFI\CData $result, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_CreateTopics_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic string
     * @return \FFI\CData|null rd_kafka_DeleteTopic_t_ptr
     */
    public static function rd_kafka_DeleteTopic_new(?string $topic): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_DeleteTopic_new($topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $del_topic rd_kafka_DeleteTopic_t_ptr
     */
    public static function rd_kafka_DeleteTopic_destroy(?\FFI\CData $del_topic): void 
    {
        static::getFFI()->rd_kafka_DeleteTopic_destroy($del_topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $del_topics rd_kafka_DeleteTopic_t_ptr_ptr
     * @param int|null $del_topic_cnt int
     */
    public static function rd_kafka_DeleteTopic_destroy_array(?\FFI\CData $del_topics, ?int $del_topic_cnt): void 
    {
        static::getFFI()->rd_kafka_DeleteTopic_destroy_array($del_topics, $del_topic_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $del_topics rd_kafka_DeleteTopic_t_ptr_ptr
     * @param int|null $del_topic_cnt int
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_DeleteTopics(?\FFI\CData $rk, ?\FFI\CData $del_topics, ?int $del_topic_cnt, ?\FFI\CData $options, ?\FFI\CData $rkqu): void 
    {
        static::getFFI()->rd_kafka_DeleteTopics($rk, $del_topics, $del_topic_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $result rd_kafka_DeleteTopics_result_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null rd_kafka_topic_result_t_ptr_ptr
     */
    public static function rd_kafka_DeleteTopics_result_topics(?\FFI\CData $result, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_DeleteTopics_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic string
     * @param int|null $new_total_cnt int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return \FFI\CData|null rd_kafka_NewPartitions_t_ptr
     */
    public static function rd_kafka_NewPartitions_new(?string $topic, ?int $new_total_cnt, ?\FFI\CData $errstr, ?int $errstr_size): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_NewPartitions_new($topic, $new_total_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $new_parts rd_kafka_NewPartitions_t_ptr
     */
    public static function rd_kafka_NewPartitions_destroy(?\FFI\CData $new_parts): void 
    {
        static::getFFI()->rd_kafka_NewPartitions_destroy($new_parts);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $new_parts rd_kafka_NewPartitions_t_ptr_ptr
     * @param int|null $new_parts_cnt int
     */
    public static function rd_kafka_NewPartitions_destroy_array(?\FFI\CData $new_parts, ?int $new_parts_cnt): void 
    {
        static::getFFI()->rd_kafka_NewPartitions_destroy_array($new_parts, $new_parts_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $new_parts rd_kafka_NewPartitions_t_ptr
     * @param int|null $new_partition_idx int
     * @param \FFI\CData|null $broker_ids int_ptr
     * @param int|null $broker_id_cnt int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_NewPartitions_set_replica_assignment(?\FFI\CData $new_parts, ?int $new_partition_idx, ?\FFI\CData $broker_ids, ?int $broker_id_cnt, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_NewPartitions_set_replica_assignment($new_parts, $new_partition_idx, $broker_ids, $broker_id_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $new_parts rd_kafka_NewPartitions_t_ptr_ptr
     * @param int|null $new_parts_cnt int
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_CreatePartitions(?\FFI\CData $rk, ?\FFI\CData $new_parts, ?int $new_parts_cnt, ?\FFI\CData $options, ?\FFI\CData $rkqu): void 
    {
        static::getFFI()->rd_kafka_CreatePartitions($rk, $new_parts, $new_parts_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $result rd_kafka_CreatePartitions_result_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null rd_kafka_topic_result_t_ptr_ptr
     */
    public static function rd_kafka_CreatePartitions_result_topics(?\FFI\CData $result, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_CreatePartitions_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $confsource int
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_ConfigSource_name(?int $confsource): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigSource_name($confsource);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_ConfigEntry_name(?\FFI\CData $entry): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_name($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_ConfigEntry_value(?\FFI\CData $entry): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_value($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_source(?\FFI\CData $entry): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_source($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_read_only(?\FFI\CData $entry): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_read_only($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_default(?\FFI\CData $entry): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_default($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_sensitive(?\FFI\CData $entry): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_sensitive($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_ConfigEntry_is_synonym(?\FFI\CData $entry): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_synonym($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null rd_kafka_ConfigEntry_t_ptr_ptr
     */
    public static function rd_kafka_ConfigEntry_synonyms(?\FFI\CData $entry, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigEntry_synonyms($entry, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $restype int
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_ResourceType_name(?int $restype): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ResourceType_name($restype);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $restype int
     * @param string|null $resname string
     * @return \FFI\CData|null rd_kafka_ConfigResource_t_ptr
     */
    public static function rd_kafka_ConfigResource_new(?int $restype, ?string $resname): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigResource_new($restype, $resname);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr
     */
    public static function rd_kafka_ConfigResource_destroy(?\FFI\CData $config): void 
    {
        static::getFFI()->rd_kafka_ConfigResource_destroy($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr_ptr
     * @param int|null $config_cnt int
     */
    public static function rd_kafka_ConfigResource_destroy_array(?\FFI\CData $config, ?int $config_cnt): void 
    {
        static::getFFI()->rd_kafka_ConfigResource_destroy_array($config, $config_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @return int|null int
     */
    public static function rd_kafka_ConfigResource_set_config(?\FFI\CData $config, ?string $name, ?string $value): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigResource_set_config($config, $name, $value);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null rd_kafka_ConfigEntry_t_ptr_ptr
     */
    public static function rd_kafka_ConfigResource_configs(?\FFI\CData $config, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigResource_configs($config, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_ConfigResource_type(?\FFI\CData $config): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigResource_type($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_ConfigResource_name(?\FFI\CData $config): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigResource_name($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_ConfigResource_error(?\FFI\CData $config): ?int 
    {
        return static::getFFI()->rd_kafka_ConfigResource_error($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_ConfigResource_error_string(?\FFI\CData $config): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_ConfigResource_error_string($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $configs rd_kafka_ConfigResource_t_ptr_ptr
     * @param int|null $config_cnt int
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_AlterConfigs(?\FFI\CData $rk, ?\FFI\CData $configs, ?int $config_cnt, ?\FFI\CData $options, ?\FFI\CData $rkqu): void 
    {
        static::getFFI()->rd_kafka_AlterConfigs($rk, $configs, $config_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $result rd_kafka_AlterConfigs_result_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null rd_kafka_ConfigResource_t_ptr_ptr
     */
    public static function rd_kafka_AlterConfigs_result_resources(?\FFI\CData $result, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_AlterConfigs_result_resources($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $configs rd_kafka_ConfigResource_t_ptr_ptr
     * @param int|null $config_cnt int
     * @param \FFI\CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param \FFI\CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public static function rd_kafka_DescribeConfigs(?\FFI\CData $rk, ?\FFI\CData $configs, ?int $config_cnt, ?\FFI\CData $options, ?\FFI\CData $rkqu): void 
    {
        static::getFFI()->rd_kafka_DescribeConfigs($rk, $configs, $config_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param \FFI\CData|null $result rd_kafka_DescribeConfigs_result_t_ptr
     * @param \FFI\CData|null $cntp int_ptr
     * @return \FFI\CData|null rd_kafka_ConfigResource_t_ptr_ptr
     */
    public static function rd_kafka_DescribeConfigs_result_resources(?\FFI\CData $result, ?\FFI\CData $cntp): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_DescribeConfigs_result_resources($result, $cntp);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_conf_t_ptr
     */
    public static function rd_kafka_conf(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_conf($rk);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $oauthbearer_token_refresh_cb callable
     */
    public static function rd_kafka_conf_set_oauthbearer_token_refresh_cb(?\FFI\CData $conf, ?callable $oauthbearer_token_refresh_cb): void 
    {
        static::getFFI()->rd_kafka_conf_set_oauthbearer_token_refresh_cb($conf, $oauthbearer_token_refresh_cb);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $ssl_cert_verify_cb callable
     * @return int|null int
     */
    public static function rd_kafka_conf_set_ssl_cert_verify_cb(?\FFI\CData $conf, ?callable $ssl_cert_verify_cb): ?int 
    {
        return static::getFFI()->rd_kafka_conf_set_ssl_cert_verify_cb($conf, $ssl_cert_verify_cb);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param \FFI\CData|null $conf rd_kafka_conf_t_ptr
     * @param int|null $cert_type int
     * @param int|null $cert_enc int
     * @param \FFI\CData|string|null $buffer void_ptr
     * @param int|null $size int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_conf_set_ssl_cert(?\FFI\CData $conf, ?int $cert_type, ?int $cert_enc,  $buffer, ?int $size, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_conf_set_ssl_cert($conf, $cert_type, $cert_enc, $buffer, $size, $errstr, $errstr_size);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param \FFI\CData|null $rkev rd_kafka_event_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_event_config_string(?\FFI\CData $rkev): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_event_config_string($rkev);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $token_value string
     * @param int|null $md_lifetime_ms int
     * @param string|null $md_principal_name string
     * @param \FFI\CData|null $extensions string_ptr_ptr
     * @param int|null $extension_size int
     * @param \FFI\CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public static function rd_kafka_oauthbearer_set_token(?\FFI\CData $rk, ?string $token_value, ?int $md_lifetime_ms, ?string $md_principal_name, ?\FFI\CData $extensions, ?int $extension_size, ?\FFI\CData $errstr, ?int $errstr_size): ?int 
    {
        return static::getFFI()->rd_kafka_oauthbearer_set_token($rk, $token_value, $md_lifetime_ms, $md_principal_name, $extensions, $extension_size, $errstr, $errstr_size);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param string|null $errstr string
     * @return int|null int
     */
    public static function rd_kafka_oauthbearer_set_token_failure(?\FFI\CData $rk, ?string $errstr): ?int 
    {
        return static::getFFI()->rd_kafka_oauthbearer_set_token_failure($rk, $errstr);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_error_code(?\FFI\CData $error): ?int 
    {
        return static::getFFI()->rd_kafka_error_code($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $error rd_kafka_error_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_error_name(?\FFI\CData $error): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_error_name($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $error rd_kafka_error_t_ptr
     * @return \FFI\CData|null string
     */
    public static function rd_kafka_error_string(?\FFI\CData $error): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_error_string($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_error_is_fatal(?\FFI\CData $error): ?int 
    {
        return static::getFFI()->rd_kafka_error_is_fatal($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_error_is_retriable(?\FFI\CData $error): ?int 
    {
        return static::getFFI()->rd_kafka_error_is_retriable($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public static function rd_kafka_error_txn_requires_abort(?\FFI\CData $error): ?int 
    {
        return static::getFFI()->rd_kafka_error_txn_requires_abort($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $error rd_kafka_error_t_ptr
     */
    public static function rd_kafka_error_destroy(?\FFI\CData $error): void 
    {
        static::getFFI()->rd_kafka_error_destroy($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param int|null $code int
     * @param string|null $fmt string
     * @param mixed ...$params
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_error_new(?int $code, ?string $fmt, ...$params): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_error_new($code, $fmt, ...$params);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param \FFI\CData|string|null $rkt_opaque void_ptr
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_msg_partitioner_fnv1a(?\FFI\CData $rkt,  $key, ?int $keylen, ?int $partition_cnt,  $rkt_opaque,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_msg_partitioner_fnv1a($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rkt rd_kafka_topic_t_ptr
     * @param \FFI\CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param \FFI\CData|string|null $rkt_opaque void_ptr
     * @param \FFI\CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public static function rd_kafka_msg_partitioner_fnv1a_random(?\FFI\CData $rkt,  $key, ?int $keylen, ?int $partition_cnt,  $rkt_opaque,  $msg_opaque): ?int 
    {
        return static::getFFI()->rd_kafka_msg_partitioner_fnv1a_random($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_consumer_group_metadata_t_ptr
     */
    public static function rd_kafka_consumer_group_metadata(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata($rk);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param string|null $group_id string
     * @return \FFI\CData|null rd_kafka_consumer_group_metadata_t_ptr
     */
    public static function rd_kafka_consumer_group_metadata_new(?string $group_id): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_new($group_id);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rd_kafka_consumer_group_metadata_t_ptr rd_kafka_consumer_group_metadata_t_ptr
     */
    public static function rd_kafka_consumer_group_metadata_destroy(?\FFI\CData $rd_kafka_consumer_group_metadata_t_ptr): void 
    {
        static::getFFI()->rd_kafka_consumer_group_metadata_destroy($rd_kafka_consumer_group_metadata_t_ptr);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $cgmd rd_kafka_consumer_group_metadata_t_ptr
     * @param \FFI\CData|null $bufferp void_ptr_ptr
     * @param \FFI\CData|null $sizep int_ptr
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_consumer_group_metadata_write(?\FFI\CData $cgmd, ?\FFI\CData $bufferp, ?\FFI\CData $sizep): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_write($cgmd, $bufferp, $sizep);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $cgmdp rd_kafka_consumer_group_metadata_t_ptr_ptr
     * @param \FFI\CData|string|null $buffer void_ptr
     * @param int|null $size int
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_consumer_group_metadata_read(?\FFI\CData $cgmdp,  $buffer, ?int $size): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_read($cgmdp, $buffer, $size);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_init_transactions(?\FFI\CData $rk, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_init_transactions($rk, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_begin_transaction(?\FFI\CData $rk): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_begin_transaction($rk);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param \FFI\CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param \FFI\CData|null $cgmetadata rd_kafka_consumer_group_metadata_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_send_offsets_to_transaction(?\FFI\CData $rk, ?\FFI\CData $offsets, ?\FFI\CData $cgmetadata, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_send_offsets_to_transaction($rk, $offsets, $cgmetadata, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_commit_transaction(?\FFI\CData $rk, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_commit_transaction($rk, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param \FFI\CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return \FFI\CData|null rd_kafka_error_t_ptr
     */
    public static function rd_kafka_abort_transaction(?\FFI\CData $rk, ?int $timeout_ms): ?\FFI\CData 
    {
        return static::getFFI()->rd_kafka_abort_transaction($rk, $timeout_ms);
    }
}
