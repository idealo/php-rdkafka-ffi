<?php
declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;

class KafkaConsumer
{
    /**
     * @param Conf $conf
     */
    public function __construct(Conf $conf)
    {
        throw new \Exception('Not implemented.');
    }

    /**
     * @param TopicPartition[] $topic_partitions
     *
     * @return void
     * @throws Exception
     */
    public function assign($topic_partitions = null)
    {
    }

    /**
     * @param null|Message|TopicPartition[] $message_or_offsets
     *
     * @return void
     * @throws Exception
     */
    public function commit($message_or_offsets = null)
    {
    }

    /**
     * @param string $message_or_offsets
     *
     * @return void
     * @throws Exception
     */
    public function commitAsync($message_or_offsets = null)
    {
    }

    /**
     * @param string $timeout_ms
     *
     * @return Message
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function consume($timeout_ms)
    {
    }

    /**
     * @return TopicPartition[]
     * @throws Exception
     */
    public function getAssignment()
    {
    }

    /**
     * @param bool $all_topics
     * @param KafkaConsumerTopic $only_topic
     * @param int $timeout_ms
     *
     * @return Metadata
     * @throws Exception
     */
    public function getMetadata($all_topics, $only_topic = null, $timeout_ms)
    {
    }

    /**
     * @return array
     */
    public function getSubscription()
    {
    }

    /**
     * @param array $topics
     *
     * @return void
     * @throws Exception
     */
    public function subscribe($topics)
    {
    }

    /**
     * @return void
     * @throws Exception
     */
    public function unsubscribe()
    {
    }
}
