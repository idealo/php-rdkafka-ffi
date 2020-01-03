<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use RdKafka;
use RdKafka\FFI\Api;

abstract class Topic extends Api
{
    protected CData $topic;

    private string $name;

    protected RdKafka $kafka;

    public function __construct(RdKafka $kafka, string $name, ?TopicConf $conf = null)
    {
        $this->name = $name;
        $this->kafka = $kafka;

        $this->topic = self::getFFI()->rd_kafka_topic_new(
            $kafka->getCData(),
            $name,
            $this->duplicateConfCData($conf)
        );

        if ($this->topic === null) {
            $err = self::getFFI()->rd_kafka_last_error();
            throw new Exception(self::err2str($err));
        }
    }

    public function __destruct()
    {
        self::getFFI()->rd_kafka_topic_destroy($this->topic);
    }

    private function duplicateConfCData(?TopicConf $conf = null): ?CData
    {
        if ($conf === null) {
            return null;
        }

        return self::getFFI()->rd_kafka_topic_conf_dup($conf->getCData());
    }

    public function getCData(): CData
    {
        return $this->topic;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
