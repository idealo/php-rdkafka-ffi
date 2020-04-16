<?php
/**
 * This file is generated! Do not edit directly.
 */

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use FFI\CData;

trait Methods
{
    abstract public static function getFFI(): FFI;
    
    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public function rd_kafka_version(): ?int 
    {
        return static::getFFI()->rd_kafka_version();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return string|null string
     */
    public function rd_kafka_version_str(): ?string 
    {
        return static::getFFI()->rd_kafka_version_str();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return string|null string
     */
    public function rd_kafka_get_debug_contexts(): ?string 
    {
        return static::getFFI()->rd_kafka_get_debug_contexts();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $errdescs rd_kafka_err_desc_ptr_ptr
     * @param CData|null $cntp int_ptr
     */
    public function rd_kafka_get_err_descs(?CData $errdescs, ?CData $cntp)
    {
        static::getFFI()->rd_kafka_get_err_descs($errdescs, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $err int
     * @return string|null string
     */
    public function rd_kafka_err2str(?int $err): ?string 
    {
        return static::getFFI()->rd_kafka_err2str($err);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $err int
     * @return string|null string
     */
    public function rd_kafka_err2name(?int $err): ?string 
    {
        return static::getFFI()->rd_kafka_err2name($err);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public function rd_kafka_last_error(): ?int 
    {
        return static::getFFI()->rd_kafka_last_error();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $errnox int
     * @return int|null int
     */
    public function rd_kafka_errno2err(?int $errnox): ?int 
    {
        return static::getFFI()->rd_kafka_errno2err($errnox);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public function rd_kafka_errno(): ?int 
    {
        return static::getFFI()->rd_kafka_errno();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_fatal_error(?CData $rk, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_fatal_error($rk, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $err int
     * @param string|null $reason string
     * @return int|null int
     */
    public function rd_kafka_test_fatal_error(?CData $rk, ?int $err, ?string $reason): ?int
    {
        return static::getFFI()->rd_kafka_test_fatal_error($rk, $err, $reason);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktpar rd_kafka_topic_partition_t_ptr
     */
    public function rd_kafka_topic_partition_destroy(?CData $rktpar)
    {
        static::getFFI()->rd_kafka_topic_partition_destroy($rktpar);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $size int
     * @return CData|null rd_kafka_topic_partition_list_t_ptr
     */
    public function rd_kafka_topic_partition_list_new(?int $size): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_new($size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkparlist rd_kafka_topic_partition_list_t_ptr
     */
    public function rd_kafka_topic_partition_list_destroy(?CData $rkparlist)
    {
        static::getFFI()->rd_kafka_topic_partition_list_destroy($rkparlist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return CData|null rd_kafka_topic_partition_t_ptr
     */
    public function rd_kafka_topic_partition_list_add(?CData $rktparlist, ?string $topic, ?int $partition): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_add($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $start int
     * @param int|null $stop int
     */
    public function rd_kafka_topic_partition_list_add_range(?CData $rktparlist, ?string $topic, ?int $start, ?int $stop)
    {
        static::getFFI()->rd_kafka_topic_partition_list_add_range($rktparlist, $topic, $start, $stop);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return int|null int
     */
    public function rd_kafka_topic_partition_list_del(?CData $rktparlist, ?string $topic, ?int $partition): ?int
    {
        return static::getFFI()->rd_kafka_topic_partition_list_del($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param int|null $idx int
     * @return int|null int
     */
    public function rd_kafka_topic_partition_list_del_by_idx(?CData $rktparlist, ?int $idx): ?int
    {
        return static::getFFI()->rd_kafka_topic_partition_list_del_by_idx($rktparlist, $idx);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $src rd_kafka_topic_partition_list_t_ptr
     * @return CData|null rd_kafka_topic_partition_list_t_ptr
     */
    public function rd_kafka_topic_partition_list_copy(?CData $src): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_copy($src);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @param int|null $offset int
     * @return int|null int
     */
    public function rd_kafka_topic_partition_list_set_offset(?CData $rktparlist, ?string $topic, ?int $partition, ?int $offset): ?int
    {
        return static::getFFI()->rd_kafka_topic_partition_list_set_offset($rktparlist, $topic, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return CData|null rd_kafka_topic_partition_t_ptr
     */
    public function rd_kafka_topic_partition_list_find(?CData $rktparlist, ?string $topic, ?int $partition): ?CData
    {
        return static::getFFI()->rd_kafka_topic_partition_list_find($rktparlist, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rktparlist rd_kafka_topic_partition_list_t_ptr
     * @param callable|null $cmp callable
     * @param CData|string|null $opaque void_ptr
     */
    public function rd_kafka_topic_partition_list_sort(?CData $rktparlist, ?callable $cmp, $opaque)
    {
        static::getFFI()->rd_kafka_topic_partition_list_sort($rktparlist, $cmp, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $initial_count int
     * @return CData|null rd_kafka_headers_t_ptr
     */
    public function rd_kafka_headers_new(?int $initial_count): ?CData
    {
        return static::getFFI()->rd_kafka_headers_new($initial_count);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     */
    public function rd_kafka_headers_destroy(?CData $hdrs)
    {
        static::getFFI()->rd_kafka_headers_destroy($hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $src rd_kafka_headers_t_ptr
     * @return CData|null rd_kafka_headers_t_ptr
     */
    public function rd_kafka_headers_copy(?CData $src): ?CData
    {
        return static::getFFI()->rd_kafka_headers_copy($src);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     * @param string|null $name string
     * @param int|null $name_size int
     * @param CData|string|null $value void_ptr
     * @param int|null $value_size int
     * @return int|null int
     */
    public function rd_kafka_header_add(?CData $hdrs, ?string $name, ?int $name_size, $value, ?int $value_size): ?int
    {
        return static::getFFI()->rd_kafka_header_add($hdrs, $name, $name_size, $value, $value_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     * @param string|null $name string
     * @return int|null int
     */
    public function rd_kafka_header_remove(?CData $hdrs, ?string $name): ?int
    {
        return static::getFFI()->rd_kafka_header_remove($hdrs, $name);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     * @param string|null $name string
     * @param CData|null $valuep void_ptr_ptr
     * @param CData|null $sizep int_ptr
     * @return int|null int
     */
    public function rd_kafka_header_get_last(?CData $hdrs, ?string $name, ?CData $valuep, ?CData $sizep): ?int
    {
        return static::getFFI()->rd_kafka_header_get_last($hdrs, $name, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     * @param int|null $idx int
     * @param string|null $name string
     * @param CData|null $valuep void_ptr_ptr
     * @param CData|null $sizep int_ptr
     * @return int|null int
     */
    public function rd_kafka_header_get(?CData $hdrs, ?int $idx, ?string $name, ?CData $valuep, ?CData $sizep): ?int
    {
        return static::getFFI()->rd_kafka_header_get($hdrs, $idx, $name, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     * @param int|null $idx int
     * @param CData|null $namep string_ptr_ptr
     * @param CData|null $valuep void_ptr_ptr
     * @param CData|null $sizep int_ptr
     * @return int|null int
     */
    public function rd_kafka_header_get_all(?CData $hdrs, ?int $idx, ?CData $namep, ?CData $valuep, ?CData $sizep): ?int
    {
        return static::getFFI()->rd_kafka_header_get_all($hdrs, $idx, $namep, $valuep, $sizep);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     */
    public function rd_kafka_message_destroy(?CData $rkmessage)
    {
        static::getFFI()->rd_kafka_message_destroy($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     * @param CData|null $tstype int_ptr
     * @return int|null int
     */
    public function rd_kafka_message_timestamp(?CData $rkmessage, ?CData $tstype): ?int
    {
        return static::getFFI()->rd_kafka_message_timestamp($rkmessage, $tstype);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     * @return int|null int
     */
    public function rd_kafka_message_latency(?CData $rkmessage): ?int
    {
        return static::getFFI()->rd_kafka_message_latency($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     * @param CData|null $hdrsp rd_kafka_headers_t_ptr_ptr
     * @return int|null int
     */
    public function rd_kafka_message_headers(?CData $rkmessage, ?CData $hdrsp): ?int
    {
        return static::getFFI()->rd_kafka_message_headers($rkmessage, $hdrsp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     * @param CData|null $hdrsp rd_kafka_headers_t_ptr_ptr
     * @return int|null int
     */
    public function rd_kafka_message_detach_headers(?CData $rkmessage, ?CData $hdrsp): ?int
    {
        return static::getFFI()->rd_kafka_message_detach_headers($rkmessage, $hdrsp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     */
    public function rd_kafka_message_set_headers(?CData $rkmessage, ?CData $hdrs)
    {
        static::getFFI()->rd_kafka_message_set_headers($rkmessage, $hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $hdrs rd_kafka_headers_t_ptr
     * @return int|null int
     */
    public function rd_kafka_header_cnt(?CData $hdrs): ?int
    {
        return static::getFFI()->rd_kafka_header_cnt($hdrs);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     * @return int|null int
     */
    public function rd_kafka_message_status(?CData $rkmessage): ?int
    {
        return static::getFFI()->rd_kafka_message_status($rkmessage);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return CData|null rd_kafka_conf_t_ptr
     */
    public function rd_kafka_conf_new(): ?CData
    {
        return static::getFFI()->rd_kafka_conf_new();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     */
    public function rd_kafka_conf_destroy(?CData $conf)
    {
        static::getFFI()->rd_kafka_conf_destroy($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @return CData|null rd_kafka_conf_t_ptr
     */
    public function rd_kafka_conf_dup(?CData $conf): ?CData
    {
        return static::getFFI()->rd_kafka_conf_dup($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param int|null $filter_cnt int
     * @param CData|null $filter string_ptr_ptr
     * @return CData|null rd_kafka_conf_t_ptr
     */
    public function rd_kafka_conf_dup_filter(?CData $conf, ?int $filter_cnt, ?CData $filter): ?CData
    {
        return static::getFFI()->rd_kafka_conf_dup_filter($conf, $filter_cnt, $filter);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_conf_set(?CData $conf, ?string $name, ?string $value, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_conf_set($conf, $name, $value, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param int|null $events int
     */
    public function rd_kafka_conf_set_events(?CData $conf, ?int $events)
    {
        static::getFFI()->rd_kafka_conf_set_events($conf, $events);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $event_cb callable
     */
    public function rd_kafka_conf_set_background_event_cb(?CData $conf, ?callable $event_cb)
    {
        static::getFFI()->rd_kafka_conf_set_background_event_cb($conf, $event_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $dr_cb callable
     */
    public function rd_kafka_conf_set_dr_cb(?CData $conf, ?callable $dr_cb)
    {
        static::getFFI()->rd_kafka_conf_set_dr_cb($conf, $dr_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $dr_msg_cb callable
     */
    public function rd_kafka_conf_set_dr_msg_cb(?CData $conf, ?callable $dr_msg_cb)
    {
        static::getFFI()->rd_kafka_conf_set_dr_msg_cb($conf, $dr_msg_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $consume_cb callable
     */
    public function rd_kafka_conf_set_consume_cb(?CData $conf, ?callable $consume_cb)
    {
        static::getFFI()->rd_kafka_conf_set_consume_cb($conf, $consume_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $rebalance_cb callable
     */
    public function rd_kafka_conf_set_rebalance_cb(?CData $conf, ?callable $rebalance_cb)
    {
        static::getFFI()->rd_kafka_conf_set_rebalance_cb($conf, $rebalance_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $offset_commit_cb callable
     */
    public function rd_kafka_conf_set_offset_commit_cb(?CData $conf, ?callable $offset_commit_cb)
    {
        static::getFFI()->rd_kafka_conf_set_offset_commit_cb($conf, $offset_commit_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $error_cb callable
     */
    public function rd_kafka_conf_set_error_cb(?CData $conf, ?callable $error_cb)
    {
        static::getFFI()->rd_kafka_conf_set_error_cb($conf, $error_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $throttle_cb callable
     */
    public function rd_kafka_conf_set_throttle_cb(?CData $conf, ?callable $throttle_cb)
    {
        static::getFFI()->rd_kafka_conf_set_throttle_cb($conf, $throttle_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $log_cb callable
     */
    public function rd_kafka_conf_set_log_cb(?CData $conf, ?callable $log_cb)
    {
        static::getFFI()->rd_kafka_conf_set_log_cb($conf, $log_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $stats_cb callable
     */
    public function rd_kafka_conf_set_stats_cb(?CData $conf, ?callable $stats_cb)
    {
        static::getFFI()->rd_kafka_conf_set_stats_cb($conf, $stats_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $socket_cb callable
     */
    public function rd_kafka_conf_set_socket_cb(?CData $conf, ?callable $socket_cb)
    {
        static::getFFI()->rd_kafka_conf_set_socket_cb($conf, $socket_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $connect_cb callable
     */
    public function rd_kafka_conf_set_connect_cb(?CData $conf, ?callable $connect_cb)
    {
        static::getFFI()->rd_kafka_conf_set_connect_cb($conf, $connect_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $closesocket_cb callable
     */
    public function rd_kafka_conf_set_closesocket_cb(?CData $conf, ?callable $closesocket_cb)
    {
        static::getFFI()->rd_kafka_conf_set_closesocket_cb($conf, $closesocket_cb);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param CData|string|null $opaque void_ptr
     */
    public function rd_kafka_conf_set_opaque(?CData $conf, $opaque)
    {
        static::getFFI()->rd_kafka_conf_set_opaque($conf, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|string|null void_ptr
     */
    public function rd_kafka_opaque(?CData $rk)
    {
        return static::getFFI()->rd_kafka_opaque($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param CData|null $tconf rd_kafka_topic_conf_t_ptr
     */
    public function rd_kafka_conf_set_default_topic_conf(?CData $conf, ?CData $tconf)
    {
        static::getFFI()->rd_kafka_conf_set_default_topic_conf($conf, $tconf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param string|null $name string
     * @param CData|null $dest string_ptr
     * @param CData|null $dest_size int_ptr
     * @return int|null int
     */
    public function rd_kafka_conf_get(?CData $conf, ?string $name, ?CData $dest, ?CData $dest_size): ?int
    {
        return static::getFFI()->rd_kafka_conf_get($conf, $name, $dest, $dest_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param string|null $name string
     * @param CData|null $dest string_ptr
     * @param CData|null $dest_size int_ptr
     * @return int|null int
     */
    public function rd_kafka_topic_conf_get(?CData $conf, ?string $name, ?CData $dest, ?CData $dest_size): ?int
    {
        return static::getFFI()->rd_kafka_topic_conf_get($conf, $name, $dest, $dest_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null string_ptr
     */
    public function rd_kafka_conf_dump(?CData $conf, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_conf_dump($conf, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null string_ptr
     */
    public function rd_kafka_topic_conf_dump(?CData $conf, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_topic_conf_dump($conf, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $arr string_ptr_ptr
     * @param int|null $cnt int
     */
    public function rd_kafka_conf_dump_free(?CData $arr, ?int $cnt)
    {
        static::getFFI()->rd_kafka_conf_dump_free($arr, $cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $fp FILE_ptr
     */
    public function rd_kafka_conf_properties_show(?CData $fp)
    {
        static::getFFI()->rd_kafka_conf_properties_show($fp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return CData|null rd_kafka_topic_conf_t_ptr
     */
    public function rd_kafka_topic_conf_new(): ?CData
    {
        return static::getFFI()->rd_kafka_topic_conf_new();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t_ptr
     * @return CData|null rd_kafka_topic_conf_t_ptr
     */
    public function rd_kafka_topic_conf_dup(?CData $conf): ?CData
    {
        return static::getFFI()->rd_kafka_topic_conf_dup($conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_topic_conf_t_ptr
     */
    public function rd_kafka_default_topic_conf_dup(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_default_topic_conf_dup($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topic_conf rd_kafka_topic_conf_t_ptr
     */
    public function rd_kafka_topic_conf_destroy(?CData $topic_conf)
    {
        static::getFFI()->rd_kafka_topic_conf_destroy($topic_conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_topic_conf_set(?CData $conf, ?string $name, ?string $value, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_topic_conf_set($conf, $name, $value, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $conf rd_kafka_topic_conf_t_ptr
     * @param CData|string|null $opaque void_ptr
     */
    public function rd_kafka_topic_conf_set_opaque(?CData $conf, $opaque)
    {
        static::getFFI()->rd_kafka_topic_conf_set_opaque($conf, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topic_conf rd_kafka_topic_conf_t_ptr
     * @param callable|null $partitioner callable
     */
    public function rd_kafka_topic_conf_set_partitioner_cb(?CData $topic_conf, ?callable $partitioner)
    {
        static::getFFI()->rd_kafka_topic_conf_set_partitioner_cb($topic_conf, $partitioner);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topic_conf rd_kafka_topic_conf_t_ptr
     * @param callable|null $msg_order_cmp callable
     */
    public function rd_kafka_topic_conf_set_msg_order_cmp(?CData $topic_conf, ?callable $msg_order_cmp)
    {
        static::getFFI()->rd_kafka_topic_conf_set_msg_order_cmp($topic_conf, $msg_order_cmp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @return int|null int
     */
    public function rd_kafka_topic_partition_available(?CData $rkt, ?int $partition): ?int
    {
        return static::getFFI()->rd_kafka_topic_partition_available($rkt, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param CData|string|null $opaque void_ptr
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_msg_partitioner_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_random($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param CData|string|null $opaque void_ptr
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_msg_partitioner_consistent(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_consistent($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param CData|string|null $opaque void_ptr
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_msg_partitioner_consistent_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_consistent_random($rkt, $key, $keylen, $partition_cnt, $opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param CData|string|null $rkt_opaque void_ptr
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_msg_partitioner_murmur2(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_murmur2($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param CData|string|null $rkt_opaque void_ptr
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_msg_partitioner_murmur2_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_murmur2_random($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $type int
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return CData|null rd_kafka_t_ptr
     */
    public function rd_kafka_new(?int $type, ?CData $conf, ?CData $errstr, ?int $errstr_size): ?CData
    {
        return static::getFFI()->rd_kafka_new($type, $conf, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     */
    public function rd_kafka_destroy(?CData $rk)
    {
        static::getFFI()->rd_kafka_destroy($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $flags int
     */
    public function rd_kafka_destroy_flags(?CData $rk, ?int $flags)
    {
        static::getFFI()->rd_kafka_destroy_flags($rk, $flags);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return string|null string
     */
    public function rd_kafka_name(?CData $rk): ?string
    {
        return static::getFFI()->rd_kafka_name($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public function rd_kafka_type(?CData $rk): ?int
    {
        return static::getFFI()->rd_kafka_type($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null string_ptr
     */
    public function rd_kafka_memberid(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_memberid($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null string_ptr
     */
    public function rd_kafka_clusterid(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_clusterid($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_controllerid(?CData $rk, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_controllerid($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param CData|null $conf rd_kafka_topic_conf_t_ptr
     * @return CData|null rd_kafka_topic_t_ptr
     */
    public function rd_kafka_topic_new(?CData $rk, ?string $topic, ?CData $conf): ?CData
    {
        return static::getFFI()->rd_kafka_topic_new($rk, $topic, $conf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     */
    public function rd_kafka_topic_destroy(?CData $rkt)
    {
        static::getFFI()->rd_kafka_topic_destroy($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @return string|null string
     */
    public function rd_kafka_topic_name(?CData $rkt): ?string
    {
        return static::getFFI()->rd_kafka_topic_name($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @return CData|string|null void_ptr
     */
    public function rd_kafka_topic_opaque(?CData $rkt)
    {
        return static::getFFI()->rd_kafka_topic_opaque($rkt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_poll(?CData $rk, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_poll($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     */
    public function rd_kafka_yield(?CData $rk)
    {
        static::getFFI()->rd_kafka_yield($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public function rd_kafka_pause_partitions(?CData $rk, ?CData $partitions): ?int
    {
        return static::getFFI()->rd_kafka_pause_partitions($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public function rd_kafka_resume_partitions(?CData $rk, ?CData $partitions): ?int
    {
        return static::getFFI()->rd_kafka_resume_partitions($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @param CData|null $low int_ptr
     * @param CData|null $high int_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_query_watermark_offsets(?CData $rk, ?string $topic, ?int $partition, ?CData $low, ?CData $high, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_query_watermark_offsets($rk, $topic, $partition, $low, $high, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @param CData|null $low int_ptr
     * @param CData|null $high int_ptr
     * @return int|null int
     */
    public function rd_kafka_get_watermark_offsets(?CData $rk, ?string $topic, ?int $partition, ?CData $low, ?CData $high): ?int
    {
        return static::getFFI()->rd_kafka_get_watermark_offsets($rk, $topic, $partition, $low, $high);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_offsets_for_times(?CData $rk, ?CData $offsets, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_offsets_for_times($rk, $offsets, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|string|null $ptr void_ptr
     */
    public function rd_kafka_mem_free(?CData $rk, $ptr)
    {
        static::getFFI()->rd_kafka_mem_free($rk, $ptr);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_queue_t_ptr
     */
    public function rd_kafka_queue_new(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_new($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public function rd_kafka_queue_destroy(?CData $rkqu)
    {
        static::getFFI()->rd_kafka_queue_destroy($rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_queue_t_ptr
     */
    public function rd_kafka_queue_get_main(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_main($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_queue_t_ptr
     */
    public function rd_kafka_queue_get_consumer(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_consumer($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $topic string
     * @param int|null $partition int
     * @return CData|null rd_kafka_queue_t_ptr
     */
    public function rd_kafka_queue_get_partition(?CData $rk, ?string $topic, ?int $partition): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_partition($rk, $topic, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_queue_t_ptr
     */
    public function rd_kafka_queue_get_background(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_queue_get_background($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $src rd_kafka_queue_t_ptr
     * @param CData|null $dst rd_kafka_queue_t_ptr
     */
    public function rd_kafka_queue_forward(?CData $src, ?CData $dst)
    {
        static::getFFI()->rd_kafka_queue_forward($src, $dst);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @return int|null int
     */
    public function rd_kafka_set_log_queue(?CData $rk, ?CData $rkqu): ?int
    {
        return static::getFFI()->rd_kafka_set_log_queue($rk, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @return int|null int
     */
    public function rd_kafka_queue_length(?CData $rkqu): ?int
    {
        return static::getFFI()->rd_kafka_queue_length($rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $fd int
     * @param CData|string|null $payload void_ptr
     * @param int|null $size int
     */
    public function rd_kafka_queue_io_event_enable(?CData $rkqu, ?int $fd, $payload, ?int $size)
    {
        static::getFFI()->rd_kafka_queue_io_event_enable($rkqu, $fd, $payload, $size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param callable|null $event_cb callable
     * @param CData|string|null $opaque void_ptr
     */
    public function rd_kafka_queue_cb_event_enable(?CData $rkqu, ?callable $event_cb, $opaque)
    {
        static::getFFI()->rd_kafka_queue_cb_event_enable($rkqu, $event_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @return int|null int
     */
    public function rd_kafka_consume_start(?CData $rkt, ?int $partition, ?int $offset): ?int
    {
        return static::getFFI()->rd_kafka_consume_start($rkt, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @return int|null int
     */
    public function rd_kafka_consume_start_queue(?CData $rkt, ?int $partition, ?int $offset, ?CData $rkqu): ?int
    {
        return static::getFFI()->rd_kafka_consume_start_queue($rkt, $partition, $offset, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @return int|null int
     */
    public function rd_kafka_consume_stop(?CData $rkt, ?int $partition): ?int
    {
        return static::getFFI()->rd_kafka_consume_stop($rkt, $partition);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_seek(?CData $rkt, ?int $partition, ?int $offset, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_seek($rkt, $partition, $offset, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_message_t_ptr
     */
    public function rd_kafka_consume(?CData $rkt, ?int $partition, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_consume($rkt, $partition, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $timeout_ms int
     * @param CData|null $rkmessages rd_kafka_message_t_ptr_ptr
     * @param int|null $rkmessages_size int
     * @return int|null int
     */
    public function rd_kafka_consume_batch(?CData $rkt, ?int $partition, ?int $timeout_ms, ?CData $rkmessages, ?int $rkmessages_size): ?int
    {
        return static::getFFI()->rd_kafka_consume_batch($rkt, $partition, $timeout_ms, $rkmessages, $rkmessages_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $timeout_ms int
     * @param callable|null $consume_cb callable
     * @param CData|string|null $opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_consume_callback(?CData $rkt, ?int $partition, ?int $timeout_ms, ?callable $consume_cb, $opaque): ?int
    {
        return static::getFFI()->rd_kafka_consume_callback($rkt, $partition, $timeout_ms, $consume_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_message_t_ptr
     */
    public function rd_kafka_consume_queue(?CData $rkqu, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_consume_queue($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @param CData|null $rkmessages rd_kafka_message_t_ptr_ptr
     * @param int|null $rkmessages_size int
     * @return int|null int
     */
    public function rd_kafka_consume_batch_queue(?CData $rkqu, ?int $timeout_ms, ?CData $rkmessages, ?int $rkmessages_size): ?int
    {
        return static::getFFI()->rd_kafka_consume_batch_queue($rkqu, $timeout_ms, $rkmessages, $rkmessages_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @param callable|null $consume_cb callable
     * @param CData|string|null $opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_consume_callback_queue(?CData $rkqu, ?int $timeout_ms, ?callable $consume_cb, $opaque): ?int
    {
        return static::getFFI()->rd_kafka_consume_callback_queue($rkqu, $timeout_ms, $consume_cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $offset int
     * @return int|null int
     */
    public function rd_kafka_offset_store(?CData $rkt, ?int $partition, ?int $offset): ?int
    {
        return static::getFFI()->rd_kafka_offset_store($rkt, $partition, $offset);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public function rd_kafka_offsets_store(?CData $rk, ?CData $offsets): ?int
    {
        return static::getFFI()->rd_kafka_offsets_store($rk, $offsets);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $topics rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public function rd_kafka_subscribe(?CData $rk, ?CData $topics): ?int
    {
        return static::getFFI()->rd_kafka_subscribe($rk, $topics);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public function rd_kafka_unsubscribe(?CData $rk): ?int
    {
        return static::getFFI()->rd_kafka_unsubscribe($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $topics rd_kafka_topic_partition_list_t_ptr_ptr
     * @return int|null int
     */
    public function rd_kafka_subscription(?CData $rk, ?CData $topics): ?int
    {
        return static::getFFI()->rd_kafka_subscription($rk, $topics);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_message_t_ptr
     */
    public function rd_kafka_consumer_poll(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_poll($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public function rd_kafka_consumer_close(?CData $rk): ?int
    {
        return static::getFFI()->rd_kafka_consumer_close($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public function rd_kafka_assign(?CData $rk, ?CData $partitions): ?int
    {
        return static::getFFI()->rd_kafka_assign($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $partitions rd_kafka_topic_partition_list_t_ptr_ptr
     * @return int|null int
     */
    public function rd_kafka_assignment(?CData $rk, ?CData $partitions): ?int
    {
        return static::getFFI()->rd_kafka_assignment($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param int|null $async int
     * @return int|null int
     */
    public function rd_kafka_commit(?CData $rk, ?CData $offsets, ?int $async): ?int
    {
        return static::getFFI()->rd_kafka_commit($rk, $offsets, $async);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $rkmessage rd_kafka_message_t_ptr
     * @param int|null $async int
     * @return int|null int
     */
    public function rd_kafka_commit_message(?CData $rk, ?CData $rkmessage, ?int $async): ?int
    {
        return static::getFFI()->rd_kafka_commit_message($rk, $rkmessage, $async);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param callable|null $cb callable
     * @param CData|string|null $opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_commit_queue(?CData $rk, ?CData $offsets, ?CData $rkqu, ?callable $cb, $opaque): ?int
    {
        return static::getFFI()->rd_kafka_commit_queue($rk, $offsets, $rkqu, $cb, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_committed(?CData $rk, ?CData $partitions, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_committed($rk, $partitions, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $partitions rd_kafka_topic_partition_list_t_ptr
     * @return int|null int
     */
    public function rd_kafka_position(?CData $rk, ?CData $partitions): ?int
    {
        return static::getFFI()->rd_kafka_position($rk, $partitions);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $msgflags int
     * @param CData|string|null $payload void_ptr
     * @param int|null $len int
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_produce(?CData $rkt, ?int $partition, ?int $msgflags, $payload, ?int $len, $key, ?int $keylen, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_produce($rkt, $partition, $msgflags, $payload, $len, $key, $keylen, $msg_opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param mixed ...$args 
     * @return int|null int
     */
    public function rd_kafka_producev(?CData $rk, ...$args): ?int
    {
        return static::getFFI()->rd_kafka_producev($rk, ...$args);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param int|null $partition int
     * @param int|null $msgflags int
     * @param CData|null $rkmessages rd_kafka_message_t_ptr
     * @param int|null $message_cnt int
     * @return int|null int
     */
    public function rd_kafka_produce_batch(?CData $rkt, ?int $partition, ?int $msgflags, ?CData $rkmessages, ?int $message_cnt): ?int
    {
        return static::getFFI()->rd_kafka_produce_batch($rkt, $partition, $msgflags, $rkmessages, $message_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_flush(?CData $rk, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_flush($rk, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $purge_flags int
     * @return int|null int
     */
    public function rd_kafka_purge(?CData $rk, ?int $purge_flags): ?int
    {
        return static::getFFI()->rd_kafka_purge($rk, $purge_flags);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $all_topics int
     * @param CData|null $only_rkt rd_kafka_topic_t_ptr
     * @param CData|null $metadatap rd_kafka_metadata_ptr_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_metadata(?CData $rk, ?int $all_topics, ?CData $only_rkt, ?CData $metadatap, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_metadata($rk, $all_topics, $only_rkt, $metadatap, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $metadata rd_kafka_metadata_ptr
     */
    public function rd_kafka_metadata_destroy(?CData $metadata)
    {
        static::getFFI()->rd_kafka_metadata_destroy($metadata);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $group string
     * @param CData|null $grplistp rd_kafka_group_list_ptr_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_list_groups(?CData $rk, ?string $group, ?CData $grplistp, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_list_groups($rk, $group, $grplistp, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $grplist rd_kafka_group_list_ptr
     */
    public function rd_kafka_group_list_destroy(?CData $grplist)
    {
        static::getFFI()->rd_kafka_group_list_destroy($grplist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $brokerlist string
     * @return int|null int
     */
    public function rd_kafka_brokers_add(?CData $rk, ?string $brokerlist): ?int
    {
        return static::getFFI()->rd_kafka_brokers_add($rk, $brokerlist);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param callable|null $func callable
     */
    public function rd_kafka_set_logger(?CData $rk, ?callable $func)
    {
        static::getFFI()->rd_kafka_set_logger($rk, $func);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $level int
     */
    public function rd_kafka_set_log_level(?CData $rk, ?int $level)
    {
        static::getFFI()->rd_kafka_set_log_level($rk, $level);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $level int
     * @param string|null $fac string
     * @param string|null $buf string
     */
    public function rd_kafka_log_print(?CData $rk, ?int $level, ?string $fac, ?string $buf)
    {
        static::getFFI()->rd_kafka_log_print($rk, $level, $fac, $buf);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public function rd_kafka_outq_len(?CData $rk): ?int
    {
        return static::getFFI()->rd_kafka_outq_len($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $fp FILE_ptr
     * @param CData|null $rk rd_kafka_t_ptr
     */
    public function rd_kafka_dump(?CData $fp, ?CData $rk)
    {
        static::getFFI()->rd_kafka_dump($fp, $rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public function rd_kafka_thread_cnt(): ?int 
    {
        return static::getFFI()->rd_kafka_thread_cnt();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_wait_destroyed(?int $timeout_ms): ?int 
    {
        return static::getFFI()->rd_kafka_wait_destroyed($timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @return int|null int
     */
    public function rd_kafka_unittest(): ?int 
    {
        return static::getFFI()->rd_kafka_unittest();
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return int|null int
     */
    public function rd_kafka_poll_set_consumer(?CData $rk): ?int
    {
        return static::getFFI()->rd_kafka_poll_set_consumer($rk);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public function rd_kafka_event_type(?CData $rkev): ?int
    {
        return static::getFFI()->rd_kafka_event_type($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return string|null string
     */
    public function rd_kafka_event_name(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_name($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     */
    public function rd_kafka_event_destroy(?CData $rkev)
    {
        static::getFFI()->rd_kafka_event_destroy($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_message_t_ptr
     */
    public function rd_kafka_event_message_next(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_message_next($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @param CData|null $rkmessages rd_kafka_message_t_ptr_ptr
     * @param int|null $size int
     * @return int|null int
     */
    public function rd_kafka_event_message_array(?CData $rkev, ?CData $rkmessages, ?int $size): ?int
    {
        return static::getFFI()->rd_kafka_event_message_array($rkev, $rkmessages, $size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public function rd_kafka_event_message_count(?CData $rkev): ?int
    {
        return static::getFFI()->rd_kafka_event_message_count($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public function rd_kafka_event_error(?CData $rkev): ?int
    {
        return static::getFFI()->rd_kafka_event_error($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return string|null string
     */
    public function rd_kafka_event_error_string(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_error_string($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return int|null int
     */
    public function rd_kafka_event_error_is_fatal(?CData $rkev): ?int
    {
        return static::getFFI()->rd_kafka_event_error_is_fatal($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|string|null void_ptr
     */
    public function rd_kafka_event_opaque(?CData $rkev)
    {
        return static::getFFI()->rd_kafka_event_opaque($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @param CData|null $fac string_ptr_ptr
     * @param CData|null $str string_ptr_ptr
     * @param CData|null $level int_ptr
     * @return int|null int
     */
    public function rd_kafka_event_log(?CData $rkev, ?CData $fac, ?CData $str, ?CData $level): ?int
    {
        return static::getFFI()->rd_kafka_event_log($rkev, $fac, $str, $level);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return string|null string
     */
    public function rd_kafka_event_stats(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_stats($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_topic_partition_list_t_ptr
     */
    public function rd_kafka_event_topic_partition_list(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_topic_partition_list($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_topic_partition_t_ptr
     */
    public function rd_kafka_event_topic_partition(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_topic_partition($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_CreateTopics_result_t_ptr
     */
    public function rd_kafka_event_CreateTopics_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_CreateTopics_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_DeleteTopics_result_t_ptr
     */
    public function rd_kafka_event_DeleteTopics_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_DeleteTopics_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_CreatePartitions_result_t_ptr
     */
    public function rd_kafka_event_CreatePartitions_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_CreatePartitions_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_AlterConfigs_result_t_ptr
     */
    public function rd_kafka_event_AlterConfigs_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_AlterConfigs_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return CData|null rd_kafka_DescribeConfigs_result_t_ptr
     */
    public function rd_kafka_event_DescribeConfigs_result(?CData $rkev): ?CData
    {
        return static::getFFI()->rd_kafka_event_DescribeConfigs_result($rkev);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_event_t_ptr
     */
    public function rd_kafka_queue_poll(?CData $rkqu, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_queue_poll($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     * @param int|null $timeout_ms int
     * @return int|null int
     */
    public function rd_kafka_queue_poll_callback(?CData $rkqu, ?int $timeout_ms): ?int
    {
        return static::getFFI()->rd_kafka_queue_poll_callback($rkqu, $timeout_ms);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topicres rd_kafka_topic_result_t_ptr
     * @return int|null int
     */
    public function rd_kafka_topic_result_error(?CData $topicres): ?int
    {
        return static::getFFI()->rd_kafka_topic_result_error($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topicres rd_kafka_topic_result_t_ptr
     * @return string|null string
     */
    public function rd_kafka_topic_result_error_string(?CData $topicres): ?string
    {
        return static::getFFI()->rd_kafka_topic_result_error_string($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $topicres rd_kafka_topic_result_t_ptr
     * @return string|null string
     */
    public function rd_kafka_topic_result_name(?CData $topicres): ?string
    {
        return static::getFFI()->rd_kafka_topic_result_name($topicres);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $for_api int
     * @return CData|null rd_kafka_AdminOptions_t_ptr
     */
    public function rd_kafka_AdminOptions_new(?CData $rk, ?int $for_api): ?CData
    {
        return static::getFFI()->rd_kafka_AdminOptions_new($rk, $for_api);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     */
    public function rd_kafka_AdminOptions_destroy(?CData $options)
    {
        static::getFFI()->rd_kafka_AdminOptions_destroy($options);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $timeout_ms int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_AdminOptions_set_request_timeout(?CData $options, ?int $timeout_ms, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_request_timeout($options, $timeout_ms, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $timeout_ms int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_AdminOptions_set_operation_timeout(?CData $options, ?int $timeout_ms, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_operation_timeout($options, $timeout_ms, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $true_or_false int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_AdminOptions_set_validate_only(?CData $options, ?int $true_or_false, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_validate_only($options, $true_or_false, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param int|null $broker_id int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_AdminOptions_set_broker(?CData $options, ?int $broker_id, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_AdminOptions_set_broker($options, $broker_id, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param CData|string|null $opaque void_ptr
     */
    public function rd_kafka_AdminOptions_set_opaque(?CData $options, $opaque)
    {
        static::getFFI()->rd_kafka_AdminOptions_set_opaque($options, $opaque);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic string
     * @param int|null $num_partitions int
     * @param int|null $replication_factor int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return CData|null rd_kafka_NewTopic_t_ptr
     */
    public function rd_kafka_NewTopic_new(?string $topic, ?int $num_partitions, ?int $replication_factor, ?CData $errstr, ?int $errstr_size): ?CData
    {
        return static::getFFI()->rd_kafka_NewTopic_new($topic, $num_partitions, $replication_factor, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topic rd_kafka_NewTopic_t_ptr
     */
    public function rd_kafka_NewTopic_destroy(?CData $new_topic)
    {
        static::getFFI()->rd_kafka_NewTopic_destroy($new_topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topics rd_kafka_NewTopic_t_ptr_ptr
     * @param int|null $new_topic_cnt int
     */
    public function rd_kafka_NewTopic_destroy_array(?CData $new_topics, ?int $new_topic_cnt)
    {
        static::getFFI()->rd_kafka_NewTopic_destroy_array($new_topics, $new_topic_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topic rd_kafka_NewTopic_t_ptr
     * @param int|null $partition int
     * @param CData|null $broker_ids int_ptr
     * @param int|null $broker_id_cnt int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_NewTopic_set_replica_assignment(?CData $new_topic, ?int $partition, ?CData $broker_ids, ?int $broker_id_cnt, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_NewTopic_set_replica_assignment($new_topic, $partition, $broker_ids, $broker_id_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_topic rd_kafka_NewTopic_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @return int|null int
     */
    public function rd_kafka_NewTopic_set_config(?CData $new_topic, ?string $name, ?string $value): ?int
    {
        return static::getFFI()->rd_kafka_NewTopic_set_config($new_topic, $name, $value);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $new_topics rd_kafka_NewTopic_t_ptr_ptr
     * @param int|null $new_topic_cnt int
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public function rd_kafka_CreateTopics(?CData $rk, ?CData $new_topics, ?int $new_topic_cnt, ?CData $options, ?CData $rkqu)
    {
        static::getFFI()->rd_kafka_CreateTopics($rk, $new_topics, $new_topic_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result rd_kafka_CreateTopics_result_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null rd_kafka_topic_result_t_ptr_ptr
     */
    public function rd_kafka_CreateTopics_result_topics(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_CreateTopics_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic string
     * @return CData|null rd_kafka_DeleteTopic_t_ptr
     */
    public function rd_kafka_DeleteTopic_new(?string $topic): ?CData
    {
        return static::getFFI()->rd_kafka_DeleteTopic_new($topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $del_topic rd_kafka_DeleteTopic_t_ptr
     */
    public function rd_kafka_DeleteTopic_destroy(?CData $del_topic)
    {
        static::getFFI()->rd_kafka_DeleteTopic_destroy($del_topic);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $del_topics rd_kafka_DeleteTopic_t_ptr_ptr
     * @param int|null $del_topic_cnt int
     */
    public function rd_kafka_DeleteTopic_destroy_array(?CData $del_topics, ?int $del_topic_cnt)
    {
        static::getFFI()->rd_kafka_DeleteTopic_destroy_array($del_topics, $del_topic_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $del_topics rd_kafka_DeleteTopic_t_ptr_ptr
     * @param int|null $del_topic_cnt int
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public function rd_kafka_DeleteTopics(?CData $rk, ?CData $del_topics, ?int $del_topic_cnt, ?CData $options, ?CData $rkqu)
    {
        static::getFFI()->rd_kafka_DeleteTopics($rk, $del_topics, $del_topic_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result rd_kafka_DeleteTopics_result_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null rd_kafka_topic_result_t_ptr_ptr
     */
    public function rd_kafka_DeleteTopics_result_topics(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_DeleteTopics_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param string|null $topic string
     * @param int|null $new_total_cnt int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return CData|null rd_kafka_NewPartitions_t_ptr
     */
    public function rd_kafka_NewPartitions_new(?string $topic, ?int $new_total_cnt, ?CData $errstr, ?int $errstr_size): ?CData
    {
        return static::getFFI()->rd_kafka_NewPartitions_new($topic, $new_total_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_parts rd_kafka_NewPartitions_t_ptr
     */
    public function rd_kafka_NewPartitions_destroy(?CData $new_parts)
    {
        static::getFFI()->rd_kafka_NewPartitions_destroy($new_parts);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_parts rd_kafka_NewPartitions_t_ptr_ptr
     * @param int|null $new_parts_cnt int
     */
    public function rd_kafka_NewPartitions_destroy_array(?CData $new_parts, ?int $new_parts_cnt)
    {
        static::getFFI()->rd_kafka_NewPartitions_destroy_array($new_parts, $new_parts_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $new_parts rd_kafka_NewPartitions_t_ptr
     * @param int|null $new_partition_idx int
     * @param CData|null $broker_ids int_ptr
     * @param int|null $broker_id_cnt int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_NewPartitions_set_replica_assignment(?CData $new_parts, ?int $new_partition_idx, ?CData $broker_ids, ?int $broker_id_cnt, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_NewPartitions_set_replica_assignment($new_parts, $new_partition_idx, $broker_ids, $broker_id_cnt, $errstr, $errstr_size);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $new_parts rd_kafka_NewPartitions_t_ptr_ptr
     * @param int|null $new_parts_cnt int
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public function rd_kafka_CreatePartitions(?CData $rk, ?CData $new_parts, ?int $new_parts_cnt, ?CData $options, ?CData $rkqu)
    {
        static::getFFI()->rd_kafka_CreatePartitions($rk, $new_parts, $new_parts_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result rd_kafka_CreatePartitions_result_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null rd_kafka_topic_result_t_ptr_ptr
     */
    public function rd_kafka_CreatePartitions_result_topics(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_CreatePartitions_result_topics($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $confsource int
     * @return string|null string
     */
    public function rd_kafka_ConfigSource_name(?int $confsource): ?string 
    {
        return static::getFFI()->rd_kafka_ConfigSource_name($confsource);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return string|null string
     */
    public function rd_kafka_ConfigEntry_name(?CData $entry): ?string
    {
        return static::getFFI()->rd_kafka_ConfigEntry_name($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return string|null string
     */
    public function rd_kafka_ConfigEntry_value(?CData $entry): ?string
    {
        return static::getFFI()->rd_kafka_ConfigEntry_value($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public function rd_kafka_ConfigEntry_source(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_source($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public function rd_kafka_ConfigEntry_is_read_only(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_read_only($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public function rd_kafka_ConfigEntry_is_default(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_default($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public function rd_kafka_ConfigEntry_is_sensitive(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_sensitive($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @return int|null int
     */
    public function rd_kafka_ConfigEntry_is_synonym(?CData $entry): ?int
    {
        return static::getFFI()->rd_kafka_ConfigEntry_is_synonym($entry);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $entry rd_kafka_ConfigEntry_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null rd_kafka_ConfigEntry_t_ptr_ptr
     */
    public function rd_kafka_ConfigEntry_synonyms(?CData $entry, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_ConfigEntry_synonyms($entry, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $restype int
     * @return string|null string
     */
    public function rd_kafka_ResourceType_name(?int $restype): ?string 
    {
        return static::getFFI()->rd_kafka_ResourceType_name($restype);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param int|null $restype int
     * @param string|null $resname string
     * @return CData|null rd_kafka_ConfigResource_t_ptr
     */
    public function rd_kafka_ConfigResource_new(?int $restype, ?string $resname): ?CData
    {
        return static::getFFI()->rd_kafka_ConfigResource_new($restype, $resname);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr
     */
    public function rd_kafka_ConfigResource_destroy(?CData $config)
    {
        static::getFFI()->rd_kafka_ConfigResource_destroy($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr_ptr
     * @param int|null $config_cnt int
     */
    public function rd_kafka_ConfigResource_destroy_array(?CData $config, ?int $config_cnt)
    {
        static::getFFI()->rd_kafka_ConfigResource_destroy_array($config, $config_cnt);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr
     * @param string|null $name string
     * @param string|null $value string
     * @return int|null int
     */
    public function rd_kafka_ConfigResource_set_config(?CData $config, ?string $name, ?string $value): ?int
    {
        return static::getFFI()->rd_kafka_ConfigResource_set_config($config, $name, $value);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null rd_kafka_ConfigEntry_t_ptr_ptr
     */
    public function rd_kafka_ConfigResource_configs(?CData $config, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_ConfigResource_configs($config, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return int|null int
     */
    public function rd_kafka_ConfigResource_type(?CData $config): ?int
    {
        return static::getFFI()->rd_kafka_ConfigResource_type($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return string|null string
     */
    public function rd_kafka_ConfigResource_name(?CData $config): ?string
    {
        return static::getFFI()->rd_kafka_ConfigResource_name($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return int|null int
     */
    public function rd_kafka_ConfigResource_error(?CData $config): ?int
    {
        return static::getFFI()->rd_kafka_ConfigResource_error($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $config rd_kafka_ConfigResource_t_ptr
     * @return string|null string
     */
    public function rd_kafka_ConfigResource_error_string(?CData $config): ?string
    {
        return static::getFFI()->rd_kafka_ConfigResource_error_string($config);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $configs rd_kafka_ConfigResource_t_ptr_ptr
     * @param int|null $config_cnt int
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public function rd_kafka_AlterConfigs(?CData $rk, ?CData $configs, ?int $config_cnt, ?CData $options, ?CData $rkqu)
    {
        static::getFFI()->rd_kafka_AlterConfigs($rk, $configs, $config_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result rd_kafka_AlterConfigs_result_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null rd_kafka_ConfigResource_t_ptr_ptr
     */
    public function rd_kafka_AlterConfigs_result_resources(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_AlterConfigs_result_resources($result, $cntp);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $configs rd_kafka_ConfigResource_t_ptr_ptr
     * @param int|null $config_cnt int
     * @param CData|null $options rd_kafka_AdminOptions_t_ptr
     * @param CData|null $rkqu rd_kafka_queue_t_ptr
     */
    public function rd_kafka_DescribeConfigs(?CData $rk, ?CData $configs, ?int $config_cnt, ?CData $options, ?CData $rkqu)
    {
        static::getFFI()->rd_kafka_DescribeConfigs($rk, $configs, $config_cnt, $options, $rkqu);
    }

    /**
     * @since 1.0.0 of librdkafka
     * @param CData|null $result rd_kafka_DescribeConfigs_result_t_ptr
     * @param CData|null $cntp int_ptr
     * @return CData|null rd_kafka_ConfigResource_t_ptr_ptr
     */
    public function rd_kafka_DescribeConfigs_result_resources(?CData $result, ?CData $cntp): ?CData
    {
        return static::getFFI()->rd_kafka_DescribeConfigs_result_resources($result, $cntp);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_conf_t_ptr
     */
    public function rd_kafka_conf(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_conf($rk);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $oauthbearer_token_refresh_cb callable
     */
    public function rd_kafka_conf_set_oauthbearer_token_refresh_cb(?CData $conf, ?callable $oauthbearer_token_refresh_cb)
    {
        static::getFFI()->rd_kafka_conf_set_oauthbearer_token_refresh_cb($conf, $oauthbearer_token_refresh_cb);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param callable|null $ssl_cert_verify_cb callable
     * @return int|null int
     */
    public function rd_kafka_conf_set_ssl_cert_verify_cb(?CData $conf, ?callable $ssl_cert_verify_cb): ?int
    {
        return static::getFFI()->rd_kafka_conf_set_ssl_cert_verify_cb($conf, $ssl_cert_verify_cb);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $conf rd_kafka_conf_t_ptr
     * @param int|null $cert_type int
     * @param int|null $cert_enc int
     * @param CData|string|null $buffer void_ptr
     * @param int|null $size int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_conf_set_ssl_cert(?CData $conf, ?int $cert_type, ?int $cert_enc, $buffer, ?int $size, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_conf_set_ssl_cert($conf, $cert_type, $cert_enc, $buffer, $size, $errstr, $errstr_size);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rkev rd_kafka_event_t_ptr
     * @return string|null string
     */
    public function rd_kafka_event_config_string(?CData $rkev): ?string
    {
        return static::getFFI()->rd_kafka_event_config_string($rkev);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $token_value string
     * @param int|null $md_lifetime_ms int
     * @param string|null $md_principal_name string
     * @param CData|null $extensions string_ptr_ptr
     * @param int|null $extension_size int
     * @param CData|null $errstr string_ptr
     * @param int|null $errstr_size int
     * @return int|null int
     */
    public function rd_kafka_oauthbearer_set_token(?CData $rk, ?string $token_value, ?int $md_lifetime_ms, ?string $md_principal_name, ?CData $extensions, ?int $extension_size, ?CData $errstr, ?int $errstr_size): ?int
    {
        return static::getFFI()->rd_kafka_oauthbearer_set_token($rk, $token_value, $md_lifetime_ms, $md_principal_name, $extensions, $extension_size, $errstr, $errstr_size);
    }

    /**
     * @since 1.1.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param string|null $errstr string
     * @return int|null int
     */
    public function rd_kafka_oauthbearer_set_token_failure(?CData $rk, ?string $errstr): ?int
    {
        return static::getFFI()->rd_kafka_oauthbearer_set_token_failure($rk, $errstr);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public function rd_kafka_error_code(?CData $error): ?int
    {
        return static::getFFI()->rd_kafka_error_code($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t_ptr
     * @return string|null string
     */
    public function rd_kafka_error_name(?CData $error): ?string
    {
        return static::getFFI()->rd_kafka_error_name($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t_ptr
     * @return string|null string
     */
    public function rd_kafka_error_string(?CData $error): ?string
    {
        return static::getFFI()->rd_kafka_error_string($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public function rd_kafka_error_is_fatal(?CData $error): ?int
    {
        return static::getFFI()->rd_kafka_error_is_fatal($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public function rd_kafka_error_is_retriable(?CData $error): ?int
    {
        return static::getFFI()->rd_kafka_error_is_retriable($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t_ptr
     * @return int|null int
     */
    public function rd_kafka_error_txn_requires_abort(?CData $error): ?int
    {
        return static::getFFI()->rd_kafka_error_txn_requires_abort($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $error rd_kafka_error_t_ptr
     */
    public function rd_kafka_error_destroy(?CData $error)
    {
        static::getFFI()->rd_kafka_error_destroy($error);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param int|null $code int
     * @param string|null $fmt string
     * @param mixed ...$args 
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_error_new(?int $code, ?string $fmt, ...$args): ?CData
    {
        return static::getFFI()->rd_kafka_error_new($code, $fmt, ...$args);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param CData|string|null $rkt_opaque void_ptr
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_msg_partitioner_fnv1a(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_fnv1a($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rkt rd_kafka_topic_t_ptr
     * @param CData|string|null $key void_ptr
     * @param int|null $keylen int
     * @param int|null $partition_cnt int
     * @param CData|string|null $rkt_opaque void_ptr
     * @param CData|string|null $msg_opaque void_ptr
     * @return int|null int
     */
    public function rd_kafka_msg_partitioner_fnv1a_random(?CData $rkt, $key, ?int $keylen, ?int $partition_cnt, $rkt_opaque, $msg_opaque): ?int
    {
        return static::getFFI()->rd_kafka_msg_partitioner_fnv1a_random($rkt, $key, $keylen, $partition_cnt, $rkt_opaque, $msg_opaque);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_consumer_group_metadata_t_ptr
     */
    public function rd_kafka_consumer_group_metadata(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata($rk);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param string|null $group_id string
     * @return CData|null rd_kafka_consumer_group_metadata_t_ptr
     */
    public function rd_kafka_consumer_group_metadata_new(?string $group_id): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_new($group_id);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rd_kafka_consumer_group_metadata_t_ptr rd_kafka_consumer_group_metadata_t_ptr
     */
    public function rd_kafka_consumer_group_metadata_destroy(?CData $rd_kafka_consumer_group_metadata_t_ptr)
    {
        static::getFFI()->rd_kafka_consumer_group_metadata_destroy($rd_kafka_consumer_group_metadata_t_ptr);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $cgmd rd_kafka_consumer_group_metadata_t_ptr
     * @param CData|null $bufferp void_ptr_ptr
     * @param CData|null $sizep int_ptr
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_consumer_group_metadata_write(?CData $cgmd, ?CData $bufferp, ?CData $sizep): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_write($cgmd, $bufferp, $sizep);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $cgmdp rd_kafka_consumer_group_metadata_t_ptr_ptr
     * @param CData|string|null $buffer void_ptr
     * @param int|null $size int
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_consumer_group_metadata_read(?CData $cgmdp, $buffer, ?int $size): ?CData
    {
        return static::getFFI()->rd_kafka_consumer_group_metadata_read($cgmdp, $buffer, $size);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_init_transactions(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_init_transactions($rk, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_begin_transaction(?CData $rk): ?CData
    {
        return static::getFFI()->rd_kafka_begin_transaction($rk);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param CData|null $offsets rd_kafka_topic_partition_list_t_ptr
     * @param CData|null $cgmetadata rd_kafka_consumer_group_metadata_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_send_offsets_to_transaction(?CData $rk, ?CData $offsets, ?CData $cgmetadata, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_send_offsets_to_transaction($rk, $offsets, $cgmetadata, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_commit_transaction(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_commit_transaction($rk, $timeout_ms);
    }

    /**
     * @since 1.4.0 of librdkafka
     * @param CData|null $rk rd_kafka_t_ptr
     * @param int|null $timeout_ms int
     * @return CData|null rd_kafka_error_t_ptr
     */
    public function rd_kafka_abort_transaction(?CData $rk, ?int $timeout_ms): ?CData
    {
        return static::getFFI()->rd_kafka_abort_transaction($rk, $timeout_ms);
    }

}
