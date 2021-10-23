<?php

declare(strict_types=1);

namespace RdKafka\Admin;

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
use RdKafka\TopicPartition;

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
     * @return ConfigResourceResult[]
     * @throws Exception
     */
    public function alterConfigs(array $resources, ?AlterConfigsOptions $options = null): array
    {
        $this->assertArray($resources, 'resources', ConfigResource::class);

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
     * @return ConfigResourceResult[]
     * @throws Exception
     */
    public function describeConfigs(array $resources, ?DescribeConfigsOptions $options = null): array
    {
        $this->assertArray($resources, 'resources', ConfigResource::class);

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
     * @return TopicResult[]
     * @throws Exception
     */
    public function createPartitions(array $partitions, ?CreatePartitionsOptions $options = null): array
    {
        $this->assertArray($partitions, 'partitions', NewPartitions::class);

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
     * @return TopicResult[]
     * @throws Exception
     */
    public function createTopics(array $topics, ?CreateTopicsOptions $options = null): array
    {
        $this->assertArray($topics, 'topics', NewTopic::class);

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
     * @return TopicResult[]
     * @throws Exception
     */
    public function deleteTopics(array $topics, ?DeleteTopicsOptions $options = null): array
    {
        $this->assertArray($topics, 'topics', DeleteTopic::class);

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
     * @param DeleteRecords[] $records
     * @return TopicPartition[]
     * @throws Exception
     * @since 1.6.0 of librdkafka
     */
    public function deleteRecords(array $records, ?DeleteRecordsOptions $options = null): array
    {
        Library::requireVersion('>=', '1.6.0');

        $this->assertArray($records, 'records', DeleteRecords::class);

        $queue = Queue::fromRdKafka($this->kafka);

        $records_ptr = Library::new('rd_kafka_DeleteRecords_t*[' . count($records) . ']');
        foreach (array_values($records) as $i => $topic) {
            $records_ptr[$i] = $topic->getCData();
        }

        Library::rd_kafka_DeleteRecords(
            $this->kafka->getCData(),
            $records_ptr,
            count($records),
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_DELETERECORDS_RESULT);

        $eventResult = Library::rd_kafka_event_DeleteRecords_result($event->getCData());

        $result = Library::rd_kafka_DeleteRecords_result_offsets($eventResult);
        $topicPartitionList = RdKafka\TopicPartitionList::fromCData($result);

        return $topicPartitionList->asArray();
    }

    /**
     * @return GroupResult[]
     * @throws Exception
     * @since 1.6.0 of librdkafka
     */
    public function deleteConsumerGroupOffsets(DeleteConsumerGroupOffsets $offsets, ?DeleteConsumerGroupOffsetsOptions $options = null): array
    {
        Library::requireVersion('>=', '1.6.0');

        $queue = Queue::fromRdKafka($this->kafka);

        $offsets_ptr = Library::new('rd_kafka_DeleteConsumerGroupOffsets_t*[1]');
        $offsets_ptr[0] = $offsets->getCData();

        Library::rd_kafka_DeleteConsumerGroupOffsets(
            $this->kafka->getCData(),
            $offsets_ptr,
            1,
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_DELETECONSUMERGROUPOFFSETS_RESULT);

        $eventResult = Library::rd_kafka_event_DeleteConsumerGroupOffsets_result($event->getCData());

        $size = Library::new('size_t');
        $result = Library::rd_kafka_DeleteConsumerGroupOffsets_result_groups($eventResult, FFI::addr($size));

        $groupResults = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $groupResults[] = new GroupResult($result[$i]);
        }

        return $groupResults;
    }

    /**
     * @param DeleteGroup[] $groups
     * @return GroupResult[]
     * @throws Exception
     * @since 1.6.0 of librdkafka
     */
    public function deleteGroups(array $groups, ?DeleteGroupsOptions $options = null): array
    {
        Library::requireVersion('>=', '1.6.0');

        $this->assertArray($groups, 'groups', DeleteGroup::class);

        $queue = Queue::fromRdKafka($this->kafka);

        $groups_ptr = Library::new('rd_kafka_DeleteGroup_t*[' . count($groups) . ']');
        foreach (array_values($groups) as $i => $topic) {
            $groups_ptr[$i] = $topic->getCData();
        }

        Library::rd_kafka_DeleteGroups(
            $this->kafka->getCData(),
            $groups_ptr,
            count($groups),
            $options ? $options->getCData() : null,
            $queue->getCData()
        );

        $event = $this->waitForResultEvent($queue, RD_KAFKA_EVENT_DELETEGROUPS_RESULT);

        $eventResult = Library::rd_kafka_event_DeleteGroups_result($event->getCData());

        $size = Library::new('size_t');
        $result = Library::rd_kafka_DeleteGroups_result_groups($eventResult, FFI::addr($size));

        $groupResults = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $groupResults[] = new GroupResult($result[$i]);
        }

        return $groupResults;
    }

    /**
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

    public function newDeleteRecordsOptions(): DeleteRecordsOptions
    {
        return new DeleteRecordsOptions($this->kafka);
    }

    public function newDeleteConsumerGroupOffsetsOptions(): DeleteConsumerGroupOffsetsOptions
    {
        return new DeleteConsumerGroupOffsetsOptions($this->kafka);
    }

    public function newDeleteGroupsOptions(): DeleteGroupsOptions
    {
        return new DeleteGroupsOptions($this->kafka);
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

    private function assertArray(array $var, string $varName, string $instanceOf): void
    {
        if (empty($var) === true) {
            throw new \InvalidArgumentException(sprintf('%s array must not be empty', $varName));
        }

        foreach ($var as $key => $value) {
            if (($value instanceof $instanceOf) === false) {
                throw new \InvalidArgumentException(
                    sprintf('%s array element %s must be instance of %s', $varName, $key, ConfigResource::class)
                );
            }
        }
    }
}
