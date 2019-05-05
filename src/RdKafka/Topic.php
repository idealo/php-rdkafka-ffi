<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use RdKafka;

abstract class Topic extends Api
{
    protected CData $topic;

    private string $name;

    protected RdKafka $kafka;

    public function __construct(RdKafka $kafka, string $name, TopicConf $conf = null)
    {
        parent::__construct();

        $this->name = $name;
        $this->kafka = $kafka;

        $this->topic = self::$ffi->rd_kafka_topic_new(
            $kafka->getCData(),
            $name,
            $conf ? $conf->getCData() : null,
            );

        if ($this->topic === null) {
            $err = self::$ffi->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }
    }

    public function __destruct()
    {
        self::$ffi->rd_kafka_topic_destroy($this->topic);
    }

    public function getCData(): CData
    {
        return $this->topic;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
