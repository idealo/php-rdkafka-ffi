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
     * @var self[]
     */
    private static $instances = [];

    public static function resolveFromCData($producer)
    {
        foreach (self::$instances as $instance) {
            if ($producer === $instance->getCData()) {
                return $instance;
            }
        }
        return null;
    }

    public function __construct(int $type, Conf $conf)
    {
        parent::__construct();

        $errstr = \FFI::new("char[512]");

        // todo: handle default conf
        $this->kafka = self::$ffi->rd_kafka_new(
            $type,
            $conf->getCData(),
            $errstr,
            \FFI::sizeOf($errstr)
        );

        if ($this->kafka === NULL) {
            throw new Exception($errstr);
        }

        self::$instances[] = $this;
    }

    public function __destruct()
    {
        while ($this->getOutQLen() > 0) {
            $this->poll(1);
        }

        self::$ffi->rd_kafka_destroy($this->kafka);
        self::$ffi->rd_kafka_wait_destroyed(1000);
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
    public function getMetadata(bool $all_topics, Topic $only_topic = null, int $timeout_ms)
    {
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
     * @return void
     */
    public function poll(int $timeout_ms)
    {
        return self::$ffi->rd_kafka_poll($this->kafka, $timeout_ms);
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
        return new Queue($this->kafka);
    }

    public function setLogLevel(int $level)
    {
        self::$ffi->rd_kafka_set_log_level($this->kafka, $level);
    }
}
