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
        $this->conf = self::getFFI()->rd_kafka_conf_new();
    }

    public function __destruct()
    {
        self::getFFI()->rd_kafka_conf_destroy($this->conf);
    }

    public function getCData(): CData
    {
        return $this->conf;
    }

    public function dump(): array
    {
        $count = FFI::new('size_t');
        $dump = self::getFFI()->rd_kafka_conf_dump($this->conf, FFI::addr($count));
        $count = (int) $count->cdata;

        $result = [];
        for ($i = 0; $i < $count; $i += 2) {
            $key = FFI::string($dump[$i]);
            $val = FFI::string($dump[$i + 1]);
            $result[$key] = $val;
        }

        self::getFFI()->rd_kafka_conf_dump_free($dump, $count);

        return $result;
    }

    /**
     * Setting non string values like callbacks or default_topic_conf TopicConf objects is not supported.
     * For callbacks use corresponding methods directly. For default_topic_conf use custom Topic in newTopic calls
     * or set default topic conf properties directly via Conf.
     *
     * @throws Exception
     */
    public function set(string $name, string $value): void
    {
        $errstr = FFI::new('char[512]');
        $result = self::getFFI()->rd_kafka_conf_set($this->conf, $name, $value, $errstr, FFI::sizeOf($errstr));

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
     * @return string|null
     * @throws Exception
     */
    public function get(string $name): string
    {
        $value = FFI::new('char[512]');
        $valueSize = FFI::new('size_t');

        $result = self::getFFI()->rd_kafka_conf_get($this->conf, $name, $value, FFI::addr($valueSize));
        if ($result === RD_KAFKA_CONF_UNKNOWN) {
            throw new Exception('Unknown property name.', $result);
        }

        return FFI::string($value);
    }

    /**
     * @deprecated Use a custom TopicConf directly in newTopics calls. You also can set topic config properties directly via Conf as default TopicConf properties.
     */
    public function setDefaultTopicConf(TopicConf $topic_conf): void
    {
        $topic_conf_dup = self::getFFI()->rd_kafka_topic_conf_dup($topic_conf->getCData());

        self::getFFI()->rd_kafka_conf_set_default_topic_conf($this->conf, $topic_conf_dup);
    }

    public function setDrMsgCb(callable $callback): void
    {
        $proxyCallback = function ($producer, $nativeMessage, $opaque = null) use ($callback): void {
            $callback(
                RdKafka::resolveFromCData($producer),
                new Message($nativeMessage),
                $opaque
            );
        };

        self::getFFI()->rd_kafka_conf_set_dr_msg_cb($this->conf, $proxyCallback);
    }

    /**
     * @throws Exception
     */
    public function setLogCb(callable $callback): void
    {
        $this->set('log.queue', 'true');

        $proxyCallback = function ($consumerOrProducer, $level, $fac, $buf) use ($callback): void {
            $callback(
                RdKafka::resolveFromCData($consumerOrProducer),
                (int) $level,
                FFI::string($fac),
                FFI::string($buf)
            );
        };

        self::getFFI()->rd_kafka_conf_set_log_cb($this->conf, $proxyCallback);
    }

    public function setErrorCb(callable $callback): void
    {
        $proxyCallback = function ($consumerOrProducer, $err, $reason, $opaque = null) use ($callback): void {
            $callback(
                RdKafka::resolveFromCData($consumerOrProducer),
                (int) $err,
                FFI::string($reason),
                $opaque
            );
        };

        self::getFFI()->rd_kafka_conf_set_error_cb($this->conf, $proxyCallback);
    }

    public function setRebalanceCb(callable $callback): void
    {
        $proxyCallback = function ($consumer, $err, $nativeTopicPartitionList, $opaque = null) use ($callback): void {
            $callback(
                RdKafka::resolveFromCData($consumer),
                (int) $err,
                TopicPartitionList::fromCData($nativeTopicPartitionList)->asArray(),
                $opaque
            );
        };

        self::getFFI()->rd_kafka_conf_set_rebalance_cb($this->conf, $proxyCallback);
    }

    public function setStatsCb(callable $callback): void
    {
        $proxyCallback = function ($consumerOrProducer, $json, $json_len, $opaque = null) use ($callback): void {
            $callback(
                RdKafka::resolveFromCData($consumerOrProducer),
                FFI::string($json, $json_len),
                (int) $json_len,
                $opaque
            );
        };

        self::getFFI()->rd_kafka_conf_set_stats_cb($this->conf, $proxyCallback);
    }

    /**
     * @param callable $callback function(KafkaConsumer $consumer, int $err, TopicPartition[], mixed $opaque = null)
     */
    public function setOffsetCommitCb(callable $callback): void
    {
        $proxyCallback = function ($consumer, $err, $nativeTopicPartitionList, $opaque = null) use ($callback): void {
            $callback(
                RdKafka::resolveFromCData($consumer),
                (int) $err,
                TopicPartitionList::fromCData($nativeTopicPartitionList)->asArray(),
                $opaque
            );
        };

        self::getFFI()->rd_kafka_conf_set_offset_commit_cb($this->conf, $proxyCallback);
    }
}
