<?php
declare(strict_types=1);

namespace RdKafka\Admin;

use RdKafka;
use RdKafka\Api;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\Metadata;
use RdKafka\Producer;
use RdKafka\Topic;

class Client extends Api
{
    private RdKafka $kafka;

    private function __construct(RdKafka $kafka)
    {
        $this->kafka = $kafka;

        parent::__construct();
    }

    public static function fromConf(Conf $conf)
    {
        return new self(new Producer($conf));
    }

    public static function fromConsumer(Consumer $consumer): self
    {
        return new self($consumer);
    }

    public static function fromProducer(Producer $producer): self
    {
        return new self($producer);
    }

    /**
     * @param ConfigResource[] $resources
     * @param AlterConfigsOptions $options
     * @return ConfigResource[]
     */
    public function alterConfigs(array $resources, AlterConfigsOptions $options): array
    {
        // rd_kafka_AlterConfigs
    }

    /**
     * @param ConfigResource[] $resources
     * @param DescribeConfigsOptions $options
     * @return ConfigResource[]
     */
    public function describeConfigs(array $resources, DescribeConfigsOptions $options): array
    {
        // todo:
        // assert params
        // create queue
        // call rd_kafka_DescribeConfigs
        // wait for result event on queue - blocking!
        // convert result event to result
        // clean up
        // return result
    }

    /**
     * @param NewPartitions[] $partitions
     * @param CreatePartitionsOptions $options
     * @return TopicResult[]
     */
    public function createPartitions(array $partitions, CreatePartitionsOptions $options): array
    {
        // rd_kafka_CreatePartitions
    }

    /**
     * @param NewTopic[] $topics
     * @param CreateTopicsOptions $options
     * @return TopicResult[]
     */
    public function createTopics(array $topics, CreateTopicsOptions $options): array
    {
        // rd_kafka_CreateTopics
    }

    /**
     * @param string[] $topicNames
     * @param DeleteTopicsOptions $options
     * @return TopicResult[]
     */
    public function deleteTopics(array $topicNames, DeleteTopicsOptions $options): array
    {
        // rd_kafka_DeleteTopics
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
        return new Metadata($this->kafka, $all_topics, $only_topic, $timeout_ms);
    }

}
