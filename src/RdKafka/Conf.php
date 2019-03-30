<?php

namespace RdKafka;

/**
 * Configuration reference: https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md
 */
class Conf extends Api
{
    private $conf;

    /**
     * @var callable
     */
    private $drMsgCb;

    /**
     * @var callable
     */
    private $loggerCb;

    public function __construct()
    {
        parent::__construct();
        $this->conf = self::$ffi->rd_kafka_conf_new();
    }

    public function __destruct()
    {
        unset($this->drMsgCb);
        self::$ffi->rd_kafka_conf_destroy($this->conf);
    }

    /**
     * @return \FFI\CData
     */
    public function getCData()
    {
        return $this->conf;
    }

    /**
     * @return array
     */
    public function dump(): array
    {
        $count = \FFI::new('size_t');
        $dump = self::$ffi->rd_kafka_conf_dump($this->conf, \FFI::addr($count));

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
        $errstr = \FFI::new("char[512]");
        $result = self::$ffi->rd_kafka_conf_set($this->conf, $name, $value, $errstr, \FFI::sizeOf($errstr));

        switch ($result) {
            case RD_KAFKA_CONF_UNKNOWN:
            case RD_KAFKA_CONF_INVALID:
                throw new Exception(\FFI::string($errstr, \FFI::sizeOf($errstr)), $result);
                break;
            case RD_KAFKA_CONF_OK:
            default:
                break;
        }
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
        if ($this->drMsgCb === null) {
            self::$ffi->rd_kafka_conf_set_dr_msg_cb($this->conf, [$this, 'drMsgCbProxy']);
        }
        $this->drMsgCb = $callback;
    }

    public function drMsgCbProxy($nativeProducer, $nativeMessage, $opaque = null)
    {
        $producer = Producer::resolveFromCData($nativeProducer);
        $message = new Message($nativeMessage);

        $drMsgCb = $this->drMsgCb;
        $drMsgCb($producer, $message);
    }


    /**
     * @param callable $callback
     *
     * @return void
     * @throws Exception
     */
    public function setLoggerCb(callable $callback)
    {
        if ($this->loggerCb === null) {
            $this->set('log.queue', 'true');
            self::$ffi->rd_kafka_conf_set_log_cb($this->conf, [$this, 'loggerCbProxy']);
        }
        $this->loggerCb = $callback;
    }

    public function loggerCbProxy($nativeProducer, $level, $fac, $buf)
    {
        $loggerCb = $this->loggerCb;
        $loggerCb(Producer::resolveFromCData($nativeProducer), (int)$level, (string)$fac, (string)$buf);
    }

    public function hasLoggerCb(): bool
    {
        return ($this->loggerCb !== null);
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setErrorCb(callable $callback)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setRebalanceCb(callable $callback)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setStatsCb(callable $callback)
    {
        throw new \Exception('Not implemented.');
    }
}
