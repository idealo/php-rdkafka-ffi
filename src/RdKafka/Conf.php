<?php
declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;
use RdKafka;

/**
 * Configuration reference: https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md
 */
class Conf extends Api
{
    private CData $conf;

    public function __construct()
    {
        parent::__construct();
        $this->conf = self::$ffi->rd_kafka_conf_new();
    }

    public function __destruct()
    {
        self::$ffi->rd_kafka_conf_destroy($this->conf);
    }

    /**
     * @return CData
     */
    public function getCData(): CData
    {
        return $this->conf;
    }

    /**
     * @return array
     */
    public function dump(): array
    {
        $count = FFI::new('size_t');
        $dump = self::$ffi->rd_kafka_conf_dump($this->conf, FFI::addr($count));

        $result = [];
        for ($i = 0; $i < $count; $i += 2) {
            $key = $dump[$i];
            $val = $dump[$i + 1];
            $result[$key] = $val;
        }

        self::$ffi->rd_kafka_conf_dump_free($dump, $count);

        return $result;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     * @throws Exception
     */
    public function set(string $name, string $value)
    {
        $errstr = FFI::new("char[512]");
        $result = self::$ffi->rd_kafka_conf_set($this->conf, $name, $value, $errstr, FFI::sizeOf($errstr));

        switch ($result) {
            case RD_KAFKA_CONF_UNKNOWN:
            case RD_KAFKA_CONF_INVALID:
                throw new Exception(FFI::string($errstr), $result);
                break;
            case RD_KAFKA_CONF_OK:
            default:
                break;
        }
    }

    /**
     * @param string $name
     *
     * @return string|null
     * @throws Exception
     */
    public function get(string $name): string
    {
        $value = FFI::new("char[512]");
        $valueSize = FFI::new('size_t');

        $result = self::$ffi->rd_kafka_conf_get($this->conf, $name, $value, FFI::addr($valueSize));
        if ($result === RD_KAFKA_CONF_UNKNOWN) {
            throw new Exception('Unknown property name.', $result);
        }

        return FFI::string($value);
    }

    /**
     * @param TopicConf $topic_conf
     *
     * @return void
     */
    public function setDefaultTopicConf(TopicConf $topic_conf)
    {
        $topic_conf_dup = self::$ffi->rd_kafka_topic_conf_dup($topic_conf->getCData());

        self::$ffi->rd_kafka_conf_set_default_topic_conf($this->conf, $topic_conf_dup);
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setDrMsgCb(callable $callback)
    {
        $proxyCallback = function ($producer, $nativeMessage, $opaque = null) use ($callback) {
            $callback(
                RdKafka::resolveFromCData($producer),
                new Message($nativeMessage),
                $opaque
            );
        };

        self::$ffi->rd_kafka_conf_set_dr_msg_cb($this->conf, $proxyCallback);
    }

    /**
     * @param callable $callback
     *
     * @return void
     * @throws Exception
     */
    public function setLoggerCb(callable $callback)
    {
        $this->set('log.queue', 'true');

        $proxyCallback = function ($consumerOrProducer, $level, $fac, $buf) use ($callback) {
            $callback(
                RdKafka::resolveFromCData($consumerOrProducer),
                (int)$level,
                (string)$fac,
                (string)$buf
            );
        };

        self::$ffi->rd_kafka_conf_set_log_cb($this->conf, $proxyCallback);
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setErrorCb(callable $callback)
    {
        $proxyCallback = function ($consumerOrProducer, $err, $reason, $opaque = null) use ($callback) {
            $callback(
                RdKafka::resolveFromCData($consumerOrProducer),
                (int)$err,
                (string)$reason,
                $opaque
            );
        };

        self::$ffi->rd_kafka_conf_set_error_cb($this->conf, $proxyCallback);
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setRebalanceCb(callable $callback)
    {
        $proxyCallback = function ($consumer, $err, $nativeTopicPartitionList, $opaque = null) use ($callback) {
            $callback(
                RdKafka::resolveFromCData($consumer),
                (int)$err,
                TopicPartitionList::fromCData($nativeTopicPartitionList)->asArray(),
                $opaque
            );
        };

        self::$ffi->rd_kafka_conf_set_error_cb($this->conf, $proxyCallback);
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setStatsCb(callable $callback)
    {
        $proxyCallback = function ($consumerOrProducer, $json, $json_len, $opaque = null) use ($callback) {
            $callback(
                RdKafka::resolveFromCData($consumerOrProducer),
                FFI::string($json, $json_len),
                (int)$json_len,
                $opaque
            );
        };

        self::$ffi->rd_kafka_conf_set_stats_cb($this->conf, $proxyCallback);
    }

    /**
     * @param callable $callback function(Consumer $consumer, int $err, TopicPartition[], mixed $opaque = null)
     *
     * @return void
     */
    public function setOffsetCommitCb(callable $callback)
    {
        $proxyCallback = function ($consumer, $err, $nativeTopicPartitionList, $opaque = null) use ($callback) {
            $callback(
                RdKafka::resolveFromCData($consumer),
                (int)$err,
                TopicPartitionList::fromCData($nativeTopicPartitionList)->asArray(),
                $opaque
            );
        };

        self::$ffi->rd_kafka_conf_set_offset_commit_cb($this->conf, $proxyCallback);
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setThrottleCb(callable $callback)
    {
        throw new \Exception('Not implemented.');
    }
}
