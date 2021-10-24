<?php

declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\KafkaConsumerTopic
 * @covers \RdKafka\Topic
 */
class KafkaConsumerTopicTest extends TestCase
{
    public function testGetName(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('bootstrap.servers', KAFKA_BROKERS);

        $consumer = new KafkaConsumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC, new TopicConf());

        $name = $topic->getName();

        $this->assertSame(KAFKA_TEST_TOPIC, $name);
    }

    public function testOffsetStore(): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('enable.auto.offset.store', 'false');
        $conf->set('topic.metadata.refresh.interval.ms', (string) 900);
        $consumer = new KafkaConsumer($conf);

        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        // wait for meta data refresh and assignment
        sleep(1);

        $topicPartitions = $consumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertSame(-1001, $topicPartitions[0]->getOffset());

        $topic->offsetStore(0, 1);
        $consumer->commit();

        $topicPartitions = $consumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertSame(2, $topicPartitions[0]->getOffset());
    }

    public function testOffsetStoreWithInvalidPartitionShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $consumer = new KafkaConsumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->offsetStore(-111, 0);
    }
}
