<?php

declare(strict_types=1);

use FFI\CData;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\FFI\Library;
use RdKafka\FFI\OpaqueMap;
use RdKafka\Metadata;
use RdKafka\Topic;
use RdKafka\TopicPartition;
use RdKafka\TopicPartitionList;

abstract class RdKafka
{
    protected ?CData $kafka;

    /**
     * @var WeakReference[]
     */
    private static array $instances = [];

    public static function resolveFromCData(?CData $kafka = null): ?self
    {
        if ($kafka === null) {
            return null;
        }

        foreach (self::$instances as $reference) {
            /** @var self $instance */
            $instance = $reference->get();
            if ($instance !== null && $kafka == $instance->getCData()) {
                return $instance;
            }
        }

        return null;
    }

    public function __construct(int $type, ?Conf $conf = null)
    {
        $errstr = Library::new('char[512]');

        $this->kafka = Library::rd_kafka_new(
            $type,
            $this->duplicateConfCData($conf),
            $errstr,
            FFI::sizeOf($errstr)
        );

        if ($this->kafka === null) {
            throw new Exception(FFI::string($errstr));
        }

        $this->initLogQueue($conf);

        self::$instances[] = WeakReference::create($this);
    }

    private function duplicateConfCData(?Conf $conf = null): ?CData
    {
        if ($conf === null) {
            return null;
        }

        return Library::rd_kafka_conf_dup($conf->getCData());
    }

    private function initLogQueue(?Conf $conf): void
    {
        if ($conf === null || $conf->get('log.queue') !== 'true') {
            return;
        }

        // todo: check does this mess with messages > requires rd_kafka_queue_poll_callback support in queue
        $err = Library::rd_kafka_set_log_queue($this->kafka, null);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw Exception::fromError($err);
        }
    }

    public function __destruct()
    {
        if ($this->kafka === null) {
            return;
        }

        Library::rd_kafka_destroy($this->kafka);

        // clean up reference
        foreach (self::$instances as $i => $reference) {
            $instance = $reference->get();
            if ($instance === null || $instance === $this) {
                unset(self::$instances[$i]);
            }
        }
    }

    public function getCData(): CData
    {
        return $this->kafka;
    }

    /**
     * @throws Exception
     */
    public function getMetadata(bool $all_topics, ?Topic $only_topic, int $timeout_ms): Metadata
    {
        return new Metadata($this, $all_topics, $only_topic, $timeout_ms);
    }

    /**
     * @return int Number of triggered events
     */
    protected function poll(int $timeout_ms): int
    {
        return Library::rd_kafka_poll($this->kafka, $timeout_ms);
    }

    protected function getOutQLen(): int
    {
        return Library::rd_kafka_outq_len($this->kafka);
    }

    /**
     * @deprecated Set via Conf parameter log_level instead
     */
    public function setLogLevel(int $level): void
    {
        Library::rd_kafka_set_log_level($this->kafka, $level);
    }

    /**
     * @throws \Exception
     * @deprecated Use Conf::setLogCb instead
     */
    public function setLogger(int $logger): void
    {
        throw new \Exception('Not implemented');
    }

    public function queryWatermarkOffsets(string $topic, int $partition, int &$low, int &$high, int $timeout_ms): void
    {
        $lowResult = Library::new('int64_t');
        $highResult = Library::new('int64_t');

        $err = Library::rd_kafka_query_watermark_offsets(
            $this->kafka,
            $topic,
            $partition,
            FFI::addr($lowResult),
            FFI::addr($highResult),
            $timeout_ms
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw Exception::fromError($err);
        }

        $low = (int) $lowResult->cdata;
        $high = (int) $highResult->cdata;
    }

    /**
     * @return mixed|null
     */
    public function getOpaque()
    {
        $cOpaque = Library::rd_kafka_opaque($this->kafka);
        return OpaqueMap::get($cOpaque);
    }

    /**
     * @param TopicPartition[] $topicPartitions
     * @return TopicPartition[]
     * @throws Exception
     */
    public function pausePartitions(array $topicPartitions): array
    {
        $topicPartitionList = new TopicPartitionList(...$topicPartitions);
        $nativeTopicPartitionList = $topicPartitionList->getCData();

        $err = Library::rd_kafka_pause_partitions($this->kafka, $nativeTopicPartitionList);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            Library::rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
            throw Exception::fromError($err);
        }

        $topicPartitionList = TopicPartitionList::fromCData($nativeTopicPartitionList);

        if ($nativeTopicPartitionList !== null) {
            Library::rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
        }

        return $topicPartitionList->asArray();
    }

    /**
     * @param TopicPartition[] $topicPartitions
     * @return TopicPartition[]
     * @throws Exception
     */
    public function resumePartitions(array $topicPartitions): array
    {
        $topicPartitionList = new TopicPartitionList(...$topicPartitions);
        $nativeTopicPartitionList = $topicPartitionList->getCData();

        $err = Library::rd_kafka_resume_partitions($this->kafka, $nativeTopicPartitionList);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            Library::rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
            throw Exception::fromError($err);
        }

        $topicPartitionList = TopicPartitionList::fromCData($nativeTopicPartitionList);

        if ($nativeTopicPartitionList !== null) {
            Library::rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
        }

        return $topicPartitionList->asArray();
    }
}
