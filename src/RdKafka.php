<?php
declare(strict_types=1);

use FFI\CData;
use RdKafka\Api;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\Metadata;
use RdKafka\Topic;
use RdKafka\TopicConf;

abstract class RdKafka extends Api
{
    protected CData $kafka;

    /**
     * @var self[]
     */
    private static array $instances = [];

    public static function resolveFromCData(CData $kafka = null): ?self
    {
        foreach (self::$instances as $instance) {
            if ($kafka == $instance->getCData()) {
                return $instance;
            }
        }

        return null;
    }

    public function __construct(int $type, Conf $conf = null)
    {
        parent::__construct();

        $errstr = FFI::new("char[512]");

        $this->kafka = self::$ffi->rd_kafka_new(
            $type,
            $this->duplicateConfCData($conf),
            $errstr,
            FFI::sizeOf($errstr)
        );

        if ($this->kafka === null) {
            throw new Exception($errstr);
        }

        $this->initLogQueue($conf);

        self::$instances[] = $this;
    }

    private function duplicateConfCData(Conf $conf = null): ?CData
    {
        if ($conf === null) {
            return null;
        }

        return self::$ffi->rd_kafka_conf_dup($conf->getCData());
    }

    private function initLogQueue(Conf $conf = null)
    {
        if ($conf === null || $conf->get('log.queue') !== 'true') {
            return;
        }

        $err = self::$ffi->rd_kafka_set_log_queue($this->kafka, null);

        if ($err != RD_KAFKA_RESP_ERR_NO_ERROR) {
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }
    }

    public function __destruct()
    {
        // like in php rdkafka extension
        while ($this->getOutQLen() > 0) {
            $this->poll(1);
        }

        self::$ffi->rd_kafka_destroy($this->kafka);
        self::$ffi->rd_kafka_wait_destroyed(1000);

        // clean up reference
        foreach (self::$instances as $i => $instance) {
            if ($this === $instance) {
                unset(self::$instances[$i]);
                break;
            }
        }
    }

    public function getCData(): CData
    {
        return $this->kafka;
    }

    /**
     * @param string $broker_list
     *
     * @return int
     */
    public function addBrokers(string $broker_list): int
    {
        return self::$ffi->rd_kafka_brokers_add($this->kafka, $broker_list);
    }

    /**
     * @param bool $all_topics
     * @param Topic $only_topic
     * @param int $timeout_ms
     *
     * @return Metadata
     * @throws Exception
     */
    public function getMetadata(bool $all_topics, ?Topic $only_topic, int $timeout_ms): Metadata
    {
        return new Metadata($this, $all_topics, $only_topic, $timeout_ms);
    }

    /**
     * @param string $topic_name
     * @param TopicConf $topic_conf
     *
     * @return Topic
     */
    abstract public function newTopic(string $topic_name, TopicConf $topic_conf = null);

    /**
     * @param int $timeout_ms
     *
     * @return int Number of triggered events
     */
    protected function poll(int $timeout_ms): int
    {
        return self::$ffi->rd_kafka_poll($this->kafka, $timeout_ms);
    }

    /**
     * @return int
     */
    protected function getOutQLen(): int
    {
        return self::$ffi->rd_kafka_outq_len($this->kafka);
    }

    public function setLogLevel(int $level)
    {
        self::$ffi->rd_kafka_set_log_level($this->kafka, $level);
    }
}
