<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use InvalidArgumentException;
use RdKafka;
use TypeError;

class KafkaConsumer extends RdKafka
{
    private bool $closed;

    public function __construct(Conf $conf)
    {
        try {
            $conf->get('group.id');
        } catch (Exception $exception) {
            throw new Exception('"group.id" must be configured.');
        }

        $this->closed = false;

        parent::__construct(RD_KAFKA_CONSUMER, $conf);

        self::$ffi->rd_kafka_poll_set_consumer($this->kafka);
    }

    public function __destruct()
    {
        $this->close();

        parent::__destruct();
    }

    public function close()
    {
        if ($this->closed) {
            return;
        }

        $err = (int)self::$ffi->rd_kafka_consumer_close($this->kafka);

        if ($err != RD_KAFKA_RESP_ERR_NO_ERROR) {
            trigger_error(sprintf("rd_kafka_consumer_close failed: %s", self::err2str($err)), E_USER_WARNING);
        }

        $this->closed = true;
    }

    /**
     * @param TopicPartition[] $topic_partitions
     *
     * @return void
     * @throws Exception
     */
    public function assign(array $topic_partitions = null)
    {
        $nativeTopicPartitionList = null;

        if ($topic_partitions !== null) {
            $topicPartitionList = new TopicPartitionList(...$topic_partitions);
            $nativeTopicPartitionList = $topicPartitionList->getCData();
        }

        $err = self::$ffi->rd_kafka_assign($this->kafka, $nativeTopicPartitionList);

        if ($nativeTopicPartitionList !== null) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
        }

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }

    /**
     * @return TopicPartition[]
     */
    public function getAssignment(): array
    {
        $nativeTopicPartitionList = self::$ffi->rd_kafka_topic_partition_list_new(0);

        self::$ffi->rd_kafka_assignment($this->kafka, FFI::addr($nativeTopicPartitionList));

        $topicPartitionList = TopicPartitionList::fromCData($nativeTopicPartitionList);

        self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);

        return $topicPartitionList->asArray();
    }

    /**
     * @param null|Message|TopicPartition[] $message_or_offsets
     *
     * @return void
     * @throws Exception
     */
    public function commit($message_or_offsets = null)
    {
        try {
            $topicPartitionList = $this->createTopicPartitionList($message_or_offsets);
        } catch (TypeError $exception) {
            throw new InvalidArgumentException(
                sprintf(
                    "%s expects parameter %d to be %s, %s given",
                    __METHOD__,
                    1,
                    "an instance of RdKafka\\Message, an array of RdKafka\\TopicPartition or null",
                    gettype($message_or_offsets)
                )
            );
        }
        $this->commitInternal($topicPartitionList, false);
    }

    /**
     * @param null|Message|TopicPartition[] $message_or_offsets
     *
     * @return void
     * @throws Exception
     */
    public function commitAsync($message_or_offsets = null)
    {
        try {
            $topicPartitionList = $this->createTopicPartitionList($message_or_offsets);
        } catch (TypeError $exception) {
            throw new InvalidArgumentException(
                sprintf(
                    "%s expects parameter %d to be %s, %s given",
                    __METHOD__,
                    1,
                    "an instance of RdKafka\\Message, an array of RdKafka\\TopicPartition or null",
                    gettype($message_or_offsets)
                )
            );
        }
        $this->commitInternal($topicPartitionList, true);
    }

    private function commitInternal(?TopicPartitionList $topicPartitionList, bool $isAsync)
    {
        $nativeTopicPartitionList = null;
        if ($topicPartitionList !== null) {
            $nativeTopicPartitionList = $topicPartitionList->getCData();
        }

        $err = self::$ffi->rd_kafka_commit($this->kafka, $nativeTopicPartitionList, $isAsync ? 1 : 0);

        if ($nativeTopicPartitionList !== null) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
        }

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }

    private function createTopicPartitionList($message_or_offsets): ?TopicPartitionList
    {
        if ($message_or_offsets === null) {
            return null;
        }
        if ($message_or_offsets instanceof Message) {
            return $this->createTopicPartitionListFromMessage($message_or_offsets);
        }
        if (\is_array($message_or_offsets) === true) {
            return new TopicPartitionList(...$message_or_offsets);
        }

        throw new TypeError(
            sprintf(
                'Argument 1 passed to %s must be an instance of RdKafka\\Message, an array of RdKafka\\TopicPartition or null',
                __METHOD__
            )
        );
    }

    private function createTopicPartitionListFromMessage(Message $message): TopicPartitionList
    {
        if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception('Invalid argument: Specified Message has an error');
        }
        if (\is_string($message->topic_name) === false) {
            throw new Exception('Invalid argument: Specified Message\'s topic_name is not a string');
        }
        if (\is_int($message->partition) === false) {
            throw new Exception('Invalid argument: Specified Message\'s partition is not an int');
        }
        if (\is_int($message->offset) === false) {
            throw new Exception('Invalid argument: Specified Message\'s offset is not an int');
        }

        return new TopicPartitionList(
            new TopicPartition($message->topic_name, $message->partition, $message->offset + 1)
        );
    }

    /**
     * @param int $timeout_ms
     *
     * @return Message
     * @throws InvalidArgumentException
     */
    public function consume(int $timeout_ms): Message
    {
        $nativeMessage = self::$ffi->rd_kafka_consumer_poll($this->kafka, $timeout_ms);

        if ($nativeMessage === null) {
            $nativeMessage = self::$ffi->new('rd_kafka_message_t');
            $nativeMessage->err = RD_KAFKA_RESP_ERR__TIMED_OUT;

            $message = new Message(FFI::addr($nativeMessage));
        } else {
            $message = new Message($nativeMessage);

            self::$ffi->rd_kafka_message_destroy($nativeMessage);
        }

        return $message;
    }

    /**
     * @param array $topics
     *
     * @return void
     * @throws Exception
     */
    public function subscribe(array $topics)
    {
        $nativeTopicPartitionList = self::$ffi->rd_kafka_topic_partition_list_new(\count($topics));

        foreach ($topics as $topic) {
            self::$ffi->rd_kafka_topic_partition_list_add(
                $nativeTopicPartitionList,
                (string)$topic,
                RD_KAFKA_PARTITION_UA
            );
        }

        $err = self::$ffi->rd_kafka_subscribe($this->kafka, $nativeTopicPartitionList);

        self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function unsubscribe()
    {
        $err = self::$ffi->rd_kafka_unsubscribe($this->kafka);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getSubscription(): array
    {
        $nativeTopicPartitionList = self::$ffi->rd_kafka_topic_partition_list_new(0);

        $err = self::$ffi->rd_kafka_subscription($this->kafka, FFI::addr($nativeTopicPartitionList));

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
            throw new Exception(self::err2str($err));
        }

        $topicPartitionList = TopicPartitionList::fromCData($nativeTopicPartitionList);

        self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);

        $topics = [];
        foreach ($topicPartitionList as $topicPartition) {
            $topics[] = $topicPartition->getTopic();
        }

        return $topics;
    }

    /**
     * @param string $topic_name
     * @param TopicConf|null $topic_conf
     *
     * @return KafkaConsumerTopic
     * @throws \Exception
     */
    public function newTopic(string $topic_name, TopicConf $topic_conf = null): KafkaConsumerTopic
    {
        return new KafkaConsumerTopic($this, $topic_name, $topic_conf);
    }

    /**
     * @param TopicPartition[] $topics
     * @param int $timeout_ms
     * @return TopicPartition[]
     * @throws Exception
     */
    public function getCommittedOffsets(array $topics, int $timeout_ms): array
    {
        $topicPartitionList = new TopicPartitionList(...$topics);
        $nativeTopicPartitionList = $topicPartitionList->getCData();

        $err = self::$ffi->rd_kafka_committed($this->kafka, $nativeTopicPartitionList, $timeout_ms);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
            throw new Exception(self::err2str($err));
        }

        $topicPartitionList = TopicPartitionList::fromCData($nativeTopicPartitionList);

        if ($nativeTopicPartitionList !== null) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
        }

        return $topicPartitionList->asArray();
    }

    /**
     * @param TopicPartition[] $topicPartitions
     * @param int $timeout_ms
     * @return TopicPartition[]
     * @throws Exception
     */
    public function offsetsForTimes(array $topicPartitions, int $timeout_ms): array
    {
        $topicPartitionList = new TopicPartitionList(...$topicPartitions);
        $nativeTopicPartitionList = $topicPartitionList->getCData();

        $err = self::$ffi->rd_kafka_offsets_for_times($this->kafka, $nativeTopicPartitionList, $timeout_ms);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
            throw new Exception(self::err2str($err));
        }

        $topicPartitionList = TopicPartitionList::fromCData($nativeTopicPartitionList);

        if ($nativeTopicPartitionList !== null) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
        }

        return $topicPartitionList->asArray();
    }
}
