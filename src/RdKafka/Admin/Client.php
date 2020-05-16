<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use Assert\Assert;
use FFI;
use RdKafka;
use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Event;
use RdKafka\Exception;
use RdKafka\FFI\Library;
use RdKafka\Metadata;
use RdKafka\Producer;
use RdKafka\Queue;
use RdKafka\Topic;

use function array_values;
use function count;
use function sprintf;

class Client
{
    private RdKafka $kafka;
    private int $waitForResultEventTimeoutMs = 50;

    private function __construct(RdKafka $kafka)
    {
        $this->kafka = $kafka;
    }

    /**
     * @return Client
     * @throws Exception
     */
    public static function fromConf(Conf $conf): self
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
     * @throws Exception
     */
    public function alterConfigs(array $resources, ?AlterConfigsOptions $options = null): array
    {
        Assert::that($resources)->notEmpty()->all()->isInstanceOf(ConfigResource::class);

        $queue = Queue::fromRdKafka($this->kafka);

        $resourcesCount = count($resources);
        $resourcesPtr = Library::new('rd_kafka_ConfigResource_t*[' . $resourcesCount . ']');
        foreach (array_values($resources) as $i => $resource) {
            $resourcesPtr[$i] = $resource->getCData();
        }

        Library::rd_kafka_AlterConfigs(
            $this->kafka->getCData(),
            $resourcesPtr,
            $resourcesCount,
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_ALTERCONFIGS_RESULT);

        $eventResult = Library::rd_kafka_event_AlterConfigs_result($event->getCData());

        $size = Library::new('size_t');
        $result = Library::rd_kafka_AlterConfigs_result_resources($eventResult, FFI::addr($size));

        $topicResult = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $topicResult[] = new ConfigResourceResult($result[$i]);
        }

        return $topicResult;
    }

    /**
     * @param ConfigResource[] $resources
     * @param DescribeConfigsOptions $options
     * @return ConfigResourceResult[]
     * @throws Exception
     */
    public function describeConfigs(array $resources, ?DescribeConfigsOptions $options = null): array
    {
        Assert::that($resources)->notEmpty()->all()->isInstanceOf(ConfigResource::class);

        $queue = Queue::fromRdKafka($this->kafka);

        $resourcesCount = count($resources);
        $resourcesPtr = Library::new('rd_kafka_ConfigResource_t*[' . $resourcesCount . ']');
        foreach (array_values($resources) as $i => $resource) {
            $resourcesPtr[$i] = $resource->getCData();
        }

        Library::rd_kafka_DescribeConfigs(
            $this->kafka->getCData(),
            $resourcesPtr,
            $resourcesCount,
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_DESCRIBECONFIGS_RESULT);

        $eventResult = Library::rd_kafka_event_DescribeConfigs_result($event->getCData());

        $size = Library::new('size_t');
        $result = Library::rd_kafka_DescribeConfigs_result_resources($eventResult, FFI::addr($size));

        $topicResult = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $topicResult[] = new ConfigResourceResult($result[$i]);
        }

        return $topicResult;
    }

    /**
     * @param NewPartitions[] $partitions
     * @param CreatePartitionsOptions $options
     * @return TopicResult[]
     * @throws Exception
     */
    public function createPartitions(array $partitions, ?CreatePartitionsOptions $options = null): array
    {
        Assert::that($partitions)->notEmpty()->all()->isInstanceOf(NewPartitions::class);

        $queue = Queue::fromRdKafka($this->kafka);

        $partitions_ptr = Library::new('rd_kafka_NewPartitions_t*[' . count($partitions) . ']');
        foreach (array_values($partitions) as $i => $partition) {
            $partitions_ptr[$i] = $partition->getCData();
        }

        Library::rd_kafka_CreatePartitions(
            $this->kafka->getCData(),
            $partitions_ptr,
            count($partitions),
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_CREATEPARTITIONS_RESULT);

        $eventResult = Library::rd_kafka_event_CreatePartitions_result($event->getCData());

        $size = Library::new('size_t');
        $result = Library::rd_kafka_CreatePartitions_result_topics($eventResult, FFI::addr($size));

        $topicResult = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $topicResult[] = new TopicResult($result[$i]);
        }

        return $topicResult;
    }

    /**
     * @param NewTopic[] $topics
     * @param CreateTopicsOptions $options
     * @return TopicResult[]
     * @throws Exception
     */
    public function createTopics(array $topics, ?CreateTopicsOptions $options = null): array
    {
        Assert::that($topics)->notEmpty()->all()->isInstanceOf(NewTopic::class);

        $queue = Queue::fromRdKafka($this->kafka);

        $topics_ptr = Library::new('rd_kafka_NewTopic_t*[' . count($topics) . ']');
        foreach (array_values($topics) as $i => $topic) {
            $topics_ptr[$i] = $topic->getCData();
        }

        Library::rd_kafka_CreateTopics(
            $this->kafka->getCData(),
            $topics_ptr,
            count($topics),
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_CREATETOPICS_RESULT);

        $eventResult = Library::rd_kafka_event_CreateTopics_result($event->getCData());

        $size = Library::new('size_t');
        $result = Library::rd_kafka_CreateTopics_result_topics($eventResult, FFI::addr($size));

        $topicResult = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $topicResult[] = new TopicResult($result[$i]);
        }

        return $topicResult;
    }

    /**
     * @param DeleteTopic[] $topics
     * @param DeleteTopicsOptions $options
     * @return TopicResult[]
     * @throws Exception
     */
    public function deleteTopics(array $topics, ?DeleteTopicsOptions $options = null): array
    {
        Assert::that($topics)->notEmpty()->all()->isInstanceOf(DeleteTopic::class);

        $queue = Queue::fromRdKafka($this->kafka);

        $topics_ptr = Library::new('rd_kafka_DeleteTopic_t*[' . count($topics) . ']');
        foreach (array_values($topics) as $i => $topic) {
            $topics_ptr[$i] = $topic->getCData();
        }

        Library::rd_kafka_DeleteTopics(
            $this->kafka->getCData(),
            $topics_ptr,
            count($topics),
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_DELETETOPICS_RESULT);

        $eventResult = Library::rd_kafka_event_DeleteTopics_result($event->getCData());

        $size = Library::new('size_t');
        $result = Library::rd_kafka_DeleteTopics_result_topics($eventResult, FFI::addr($size));

        $topicResult = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $topicResult[] = new TopicResult($result[$i]);
        }

        return $topicResult;
    }

    /**
     * @param Topic $only_topic
     *
     * @throws Exception
     */
    public function getMetadata(bool $all_topics, ?Topic $only_topic, int $timeout_ms): Metadata
    {
        return $this->kafka->getMetadata($all_topics, $only_topic, $timeout_ms);
    }

    public function newCreateTopicsOptions(): CreateTopicsOptions
    {
        return new CreateTopicsOptions($this->kafka);
    }

    public function newCreatePartitionsOptions(): CreatePartitionsOptions
    {
        return new CreatePartitionsOptions($this->kafka);
    }

    public function newAlterConfigsOptions(): AlterConfigsOptions
    {
        return new AlterConfigsOptions($this->kafka);
    }

    public function newDeleteTopicsOptions(): DeleteTopicsOptions
    {
        return new DeleteTopicsOptions($this->kafka);
    }

    public function newDescribeConfigsOptions(): DescribeConfigsOptions
    {
        return new DescribeConfigsOptions($this->kafka);
    }

    private function waitForResultEvent(Queue $queue, int $eventType): Event
    {
        do {
            $event = $queue->poll($this->waitForResultEventTimeoutMs);
        } while ($event === null);

        if ($event->error() !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception($event->errorString());
        }

        if ($event->type() !== $eventType) {
            throw new Exception(
                sprintf(
                    'Expected %d result event, not %d.',
                    $eventType,
                    $event->type()
                )
            );
        }

        return $event;
    }

    public function setWaitForResultEventTimeout(int $timeoutMs): void
    {
        $this->waitForResultEventTimeoutMs = $timeoutMs;
    }
}
