<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use RdKafka;
use RdKafka\FFI\Library;

abstract class Topic
{
    protected CData $topic;

    private string $name;

    protected RdKafka $kafka;

    public function __construct(RdKafka $kafka, string $name, ?TopicConf $conf = null)
    {
        $this->name = $name;
        $this->kafka = $kafka;

        $topic = Library::rd_kafka_topic_new(
            $kafka->getCData(),
            $name,
            $this->duplicateConfCData($conf)
        );

        if ($topic === null) {
            $err = (int) Library::rd_kafka_last_error();
            throw Exception::fromError($err);
        }

        $this->topic = $topic;
    }

    public function __destruct()
    {
        Library::rd_kafka_topic_destroy($this->topic);
    }

    private function duplicateConfCData(?TopicConf $conf = null): ?CData
    {
        if ($conf === null) {
            return null;
        }

        return Library::rd_kafka_topic_conf_dup($conf->getCData());
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
