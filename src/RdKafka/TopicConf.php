<?php
declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;

/**
 * Configuration reference: https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md
 */
class TopicConf extends Api
{
    private CData $topicConf;

    public function __construct()
    {
        parent::__construct();
        $this->topicConf = self::$ffi->rd_kafka_topic_conf_new();
    }

    public function __destruct()
    {
        self::$ffi->rd_kafka_topic_conf_destroy($this->topicConf);
    }

    /**
     * @return CData
     */
    public function getCData(): CData
    {
        return $this->topicConf;
    }

    /**
     * @return array
     */
    public function dump(): array
    {
        $count = FFI::new('size_t');
        $dump = self::$ffi->rd_kafka_topic_conf_dump($this->topicConf, FFI::addr($count));
        $count = (int)$count->cdata;

        $result = [];
        for ($i = 0; $i < $count; $i += 2) {
            $key = (string)$dump[$i];
            $val = (string)$dump[$i + 1];
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

        $result = self::$ffi->rd_kafka_topic_conf_set($this->topicConf, $name, $value, $errstr, FFI::sizeOf($errstr));

        switch ($result) {
            case RD_KAFKA_CONF_UNKNOWN:
            case RD_KAFKA_CONF_INVALID:
                throw new Exception(FFI::string($errstr, FFI::sizeOf($errstr)), $result);
                break;
            case RD_KAFKA_CONF_OK:
            default:
                break;
        }
    }

    /**
     * @param int $partitioner
     *
     * @return void
     */
    public function setPartitioner(int $partitioner)
    {
        throw new \Exception('Not implemented.');
    }
}
