<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;
use RdKafka\FFI\DrMsgCallbackProxy;
use RdKafka\FFI\ErrorCallbackProxy;
use RdKafka\FFI\Library;
use RdKafka\FFI\LogCallbackProxy;
use RdKafka\FFI\OffsetCommitCallbackProxy;
use RdKafka\FFI\OpaqueMap;
use RdKafka\FFI\RebalanceCallbackProxy;
use RdKafka\FFI\StatsCallbackProxy;

/**
 * @link https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md Configuration reference for librdkafka
 */
class Conf
{
    private CData $conf;
    private ?CData $cOpaque;

    public function __construct()
    {
        $this->conf = Library::rd_kafka_conf_new();

        if (Library::versionMatches('>=', '1.4.0')) {
            $this->set('client.software.name', 'php-rdkafka-ffi');
            $this->set('client.software.version', Library::getClientVersion());
        }

        $this->cOpaque = null;
    }

    public function __destruct()
    {
        Library::rd_kafka_conf_destroy($this->conf);
    }

    public function getCData(): CData
    {
        return $this->conf;
    }

    public function dump(): array
    {
        $count = Library::new('size_t');
        $dump = Library::rd_kafka_conf_dump($this->conf, FFI::addr($count));
        $count = (int) $count->cdata;

        $result = [];
        for ($i = 0; $i < $count; $i += 2) {
            $key = FFI::string($dump[$i]);
            $val = FFI::string($dump[$i + 1]);
            $result[$key] = $val;
        }

        Library::rd_kafka_conf_dump_free($dump, $count);

        return $result;
    }

    /**
     * Setting non string values like callbacks or `default_topic_conf` TopicConf objects is not supported.
     * For callbacks and `default_topic_conf` use corresponding methods directly.
     *
     * @throws Exception
     * @see Conf::setLogCb()
     * @see Conf::setErrorCb()
     * @see Conf::setOffsetCommitCb()
     * @see Conf::setRebalanceCb()
     * @see Conf::setStatsCb()
     * @see Conf::setDrMsgCb()
     * @see Conf::setDefaultTopicConf()
     */
    public function set(string $name, string $value): void
    {
        $errstr = Library::new('char[512]');
        $result = Library::rd_kafka_conf_set($this->conf, $name, $value, $errstr, FFI::sizeOf($errstr));

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
        $value = Library::new('char[512]');
        $valueSize = Library::new('size_t');

        $result = Library::rd_kafka_conf_get($this->conf, $name, $value, FFI::addr($valueSize));
        if ($result === RD_KAFKA_CONF_UNKNOWN) {
            throw new Exception('Unknown property name.', $result);
        }

        return FFI::string($value);
    }

    /**
     * @deprecated Set custom TopicConf explicitly in `Producer::newTopic()`, `Consumer::newTopic()` or `KafkaConsumer::newTopic()`.
     * Note: Topic config properties can be also set directly via Conf.
     * @see Producer::newTopic()
     * @see Consumer::newTopic()
     * @see KafkaConsumer::newTopic()
     */
    public function setDefaultTopicConf(TopicConf $topic_conf): void
    {
        $topic_conf_dup = Library::rd_kafka_topic_conf_dup($topic_conf->getCData());

        Library::rd_kafka_conf_set_default_topic_conf($this->conf, $topic_conf_dup);
    }

    /**
     * @param callable $callback function(Producer $producer, Message $message, ?mixed $opaque = null)
     * @throws Exception
     */
    public function setDrMsgCb(callable $callback): void
    {
        Library::rd_kafka_conf_set_dr_msg_cb(
            $this->conf,
            DrMsgCallbackProxy::create($callback)
        );
    }

    /**
     * @param ?callable $callback function($consumerOrProducer, int $level, string $facility, string $message) or null to disable logging
     * @throws Exception
     */
    public function setLogCb(?callable $callback): void
    {
        if ($callback === null) {
            $this->set('log.queue', 'false');
            Library::rd_kafka_conf_set_log_cb($this->conf, null);
        } else {
            $this->set('log.queue', 'true');
            Library::rd_kafka_conf_set_log_cb(
                $this->conf,
                LogCallbackProxy::create($callback)
            );
        }
    }

    /**
     * @param callable $callback function($consumerOrProducer, int $err, string $reason, ?mixed $opaque = null)
     */
    public function setErrorCb(callable $callback): void
    {
        Library::rd_kafka_conf_set_error_cb(
            $this->conf,
            ErrorCallbackProxy::create($callback)
        );
    }

    /**
     * @param callable $callback function(KafkaConsumer $consumer, int $err, array $topicPartitions, ?mixed $opaque = null)
     */
    public function setRebalanceCb(callable $callback): void
    {
        Library::rd_kafka_conf_set_rebalance_cb(
            $this->conf,
            RebalanceCallbackProxy::create($callback)
        );
    }

    /**
     * @param callable $callback function($consumerOrProducer, string $json, int $jsonLength, ?mixed $opaque = null)
     */
    public function setStatsCb(callable $callback): void
    {
        Library::rd_kafka_conf_set_stats_cb(
            $this->conf,
            StatsCallbackProxy::create($callback)
        );
    }

    /**
     * @param callable $callback function(KafkaConsumer $consumer, int $err, array $topicPartitions, ?mixed $opaque = null)
     */
    public function setOffsetCommitCb(callable $callback): void
    {
        Library::rd_kafka_conf_set_offset_commit_cb(
            $this->conf,
            OffsetCommitCallbackProxy::create($callback)
        );
    }

    /**
     * @param mixed $opaque
     */
    public function setOpaque($opaque): void
    {
        if ($this->cOpaque !== null) {
            OpaqueMap::pull($this->cOpaque);
        }

        $this->cOpaque = OpaqueMap::push($opaque);
        Library::rd_kafka_conf_set_opaque($this->conf, FFI::addr($this->cOpaque));
    }
}
