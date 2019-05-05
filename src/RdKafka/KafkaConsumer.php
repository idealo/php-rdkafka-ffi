<?php
declare(strict_types=1);

namespace RdKafka;

use FFI;
use InvalidArgumentException;
use RdKafka;

class KafkaConsumer extends RdKafka
{
    public function __construct(Conf $conf)
    {
        try {
            $conf->get('group.id');
        } catch (Exception $exception) {
            throw new Exception('"group.id" must be configured.');
        }

        parent::__construct(RD_KAFKA_CONSUMER, $conf);

        self::$ffi->rd_kafka_poll_set_consumer($this->kafka);
    }

    public function __destruct()
    {
        $err = self::$ffi->rd_kafka_consumer_close($this->kafka);
        if ($err) {
            trigger_error(sprintf("rd_kafka_consumer_close failed: %s", self::err2str($err)), E_WARNING);
        }

        parent::__destruct();
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
     * @throws Exception
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
        $this->commitInternal($message_or_offsets, false);
    }

    /**
     * @param null|Message|TopicPartition[] $message_or_offsets
     *
     * @return void
     * @throws Exception
     */
    public function commitAsync($message_or_offsets = null)
    {
        $this->commitInternal($message_or_offsets, true);
    }

    private function commitInternal($message_or_offsets, bool $isAsync)
    {
        if ($message_or_offsets === null) {
            $nativeTopicPartitionList = null;

        } elseif ($message_or_offsets instanceof Message) {
            // todo assert message properties needed? already typed

            $nativeTopicPartitionList = self::$ffi->rd_kafka_topic_partition_list_new(1);
            $nativeTopicPartition = self::$ffi->rd_kafka_topic_partition_list_add(
                $nativeTopicPartitionList,
                $message_or_offsets->topic_name,
                $message_or_offsets->partition
            );
            $nativeTopicPartition->offset = $message_or_offsets->offset + 1;

        } elseif (is_array($message_or_offsets)) {
            $topicPartitionList = new TopicPartitionList(...$message_or_offsets);
            $nativeTopicPartitionList = $topicPartitionList->getCData();

        } else {
            throw new InvalidArgumentException(sprintf(
                "%s::%s expects parameter %d to be %s, %s given",
                __CLASS__,
                $isAsync ? 'commitAsync' : 'commit',
                1,
                "an instance of RdKafka\\Message or an array of RdKafka\\TopicPartition",
                is_object($message_or_offsets) ? get_class($message_or_offsets) : gettype($message_or_offsets)
            ));
        }

        $err = self::$ffi->rd_kafka_commit($this->kafka, $nativeTopicPartitionList, $isAsync ? 1 : 0);

        if ($nativeTopicPartitionList !== null) {
            self::$ffi->rd_kafka_topic_partition_list_destroy($nativeTopicPartitionList);
        }

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }

    /**
     * @param string $timeout_ms
     *
     * @return Message
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function consume(int $timeout_ms)
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
        $nativeTopicPartitionList = self::$ffi->rd_kafka_topic_partition_list_new(count($topics));

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
    public function newTopic(string $topic_name, TopicConf $topic_conf = null)
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
}
