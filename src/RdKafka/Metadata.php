<?php

namespace RdKafka;

use RdKafka\Metadata\Broker;
use RdKafka\Metadata\Collection;
use RdKafka\Metadata\Partition;
use RdKafka\Metadata\Topic as MetadataTopic;

class Metadata extends Api
{
    private $metadata;

    public function __construct(\RdKafka $kafka, bool $all_topics, Topic $only_topic = null, int $timeout_ms)
    {
        parent::__construct();

        $this->metadata = self::$ffi->new('struct rd_kafka_metadata*');

        $err = (int)self::$ffi->rd_kafka_metadata(
            $kafka->getCData(),
            (int)$all_topics,
            $only_topic ? $only_topic->getCData() : null,
            \FFI::addr($this->metadata),
            $timeout_ms
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }
    }

    public function __destruct()
    {
        self::$ffi->rd_kafka_metadata_destroy($this->metadata);
    }

    /**
     * @return Collection|Broker[]
     */
    public function getBrokers(): Collection
    {
        return $this->mapBrokers($this->metadata);
    }

    private function mapBrokers($metadata)
    {
        $items = [];
        for ($i = 0; $i < $metadata->broker_cnt; $i++) {
            $data = $metadata->brokers[$i];
            $items[] = new Broker(
                (int)$data->id,
                \FFI::string($data->host),
                (int)$data->port
            );
        }
        return new Collection($items);
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->mapTopics($this->metadata);
    }

    private function mapTopics($metadata): Collection
    {
        $items = [];
        for ($i = 0; $i < $metadata->topic_cnt; $i++) {
            $data = $metadata->topics[$i];
            $items[] = new MetadataTopic(
                \FFI::string($data->topic),
                $this->mapPartitions($data),
                (int)$data->err
            );
        }
        return new Collection($items);
    }

    private function mapPartitions($topic): Collection
    {
        $items = [];
        for ($i = 0; $i < $topic->partition_cnt; $i++) {
            $data = $topic->partitions[$i];

            $items[] = new Partition(
                (int)$data->id,
                (int)$data->err,
                (int)$data->leader,
                $this->mapReplicas($data),
                $this->mapIsrs($data)
            );
        }
        return new Collection($items);
    }

    private function mapReplicas($partition)
    {
        $items = [];
        for ($i = 0; $i < $partition->replica_cnt; $i++) {
            $items[] = (int)$partition->replicas[$i];
        }
        return $items;
    }

    private function mapIsrs($partition)
    {
        $items = [];
        for ($i = 0; $i < $partition->isr_cnt; $i++) {
            $items[] = (int)$partition->isrs[$i];
        }
        return $items;
    }

    public function getOrigBrokerId(): int
    {
        return $this->metadata->orig_broker_id;
    }

    public function getOrigBrokerName(): string
    {
        return \FFI::string($this->metadata->orig_broker_name);
    }
}
