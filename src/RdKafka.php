<?php

use RdKafka\Api;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\Metadata;
use RdKafka\Queue;
use RdKafka\Topic;
use RdKafka\TopicConf;

abstract class RdKafka extends Api
{
    protected $kafka;

    /**
     * @var Queue
     */
    protected $logQueue;

    /**
     * @var self[]
     */
    private static $instances = [];

    public static function resolveFromCData($producer)
    {
        foreach (self::$instances as $instance) {
            if ($producer == $instance->getCData()) {
                return $instance;
            }
        }
        return null;
    }

    public function __construct(int $type, Conf $conf = null)
    {
        parent::__construct();

        $errstr = \FFI::new("char[512]");

        $this->kafka = self::$ffi->rd_kafka_new(
            $type,
            $conf ? $conf->getCData() : null,
            $errstr,
            \FFI::sizeOf($errstr)
        );

        if ($this->kafka === null) {
            throw new Exception($errstr);
        }

        if ($conf->hasLoggerCb()) {
            $this->initLogQueue();
        }

        self::$instances[] = $this;
    }

    private function initLogQueue()
    {
        $this->logQueue = $this->newQueue();
        $err = self::$ffi->rd_kafka_set_log_queue($this->kafka, $this->logQueue->getCData());

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

    public function getCData()
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
     * @throws Exception
     * @return Metadata
     */
    public function getMetadata(bool $all_topics, Topic $only_topic = null, int $timeout_ms): Metadata
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
    public function poll(int $timeout_ms): int
    {
        $this->consumeLogQueue();

        return self::$ffi->rd_kafka_poll($this->kafka, $timeout_ms);
    }

    private function consumeLogQueue()
    {
        if ($this->logQueue !== null) {
            // trigger log callback
            $this->logQueue->consume(0);
        }
    }

    /**
     * @return int
     */
    public function getOutQLen(): int
    {
        return self::$ffi->rd_kafka_outq_len($this->kafka);
    }

    public function newQueue(): Queue
    {
        return new Queue($this);
    }

    public function setLogLevel(int $level)
    {
        self::$ffi->rd_kafka_set_log_level($this->kafka, $level);
    }
}
