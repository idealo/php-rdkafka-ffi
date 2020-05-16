<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use FFI\CData;
use RdKafka;
use RdKafka\FFI\Library;
use RdKafka\Metadata\Collection;

class Metadata
{
    private CData $metadata;

    public function __construct(RdKafka $kafka, bool $all_topics, ?Topic $only_topic, int $timeout_ms)
    {
        $this->metadata = Library::new('struct rd_kafka_metadata*');

        $err = (int) Library::rd_kafka_metadata(
            $kafka->getCData(),
            (int) $all_topics,
            $only_topic ? $only_topic->getCData() : null,
            FFI::addr($this->metadata),
            $timeout_ms
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw Exception::fromError($err);
        }
    }

    public function __destruct()
    {
        Library::rd_kafka_metadata_destroy($this->metadata);
    }

    /**
     * @return Collection|Metadata\Broker[]
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
            $items[] = new Metadata\Broker(
                (int) $data->id,
                FFI::string($data->host),
                (int) $data->port
            );
        }
        return new Collection($items);
    }

    /**
     * @return Collection|Metadata\Topic[]
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
            $items[] = new Metadata\Topic(
                FFI::string($data->topic),
                $this->mapPartitions($data),
                (int) $data->err
            );
        }
        return new Collection($items);
    }

    private function mapPartitions($topic): Collection
    {
        $items = [];
        for ($i = 0; $i < $topic->partition_cnt; $i++) {
            $data = $topic->partitions[$i];

            $items[] = new Metadata\Partition(
                (int) $data->id,
                (int) $data->err,
                (int) $data->leader,
                $this->mapReplicas($data),
                $this->mapIsrs($data)
            );
        }
        return new Collection($items);
    }

    private function mapReplicas($partition): Collection
    {
        $items = [];
        for ($i = 0; $i < $partition->replica_cnt; $i++) {
            $items[] = (int) $partition->replicas[$i];
        }
        return new Collection($items);
    }

    private function mapIsrs($partition): Collection
    {
        $items = [];
        for ($i = 0; $i < $partition->isr_cnt; $i++) {
            $items[] = (int) $partition->isrs[$i];
        }
        return new Collection($items);
    }

    public function getOrigBrokerId(): int
    {
        return $this->metadata->orig_broker_id;
    }

    public function getOrigBrokerName(): string
    {
        return FFI::string($this->metadata->orig_broker_name);
    }
}
