<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\KafkaConsumerTopic
 * @covers \RdKafka\Topic
 */
class KafkaConsumerTopicTest extends TestCase
{
    public function testGetName()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $consumer = new KafkaConsumer($conf);

        sleep(1);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC, new TopicConf());

        $name = $topic->getName();

        $this->assertEquals(KAFKA_TEST_TOPIC, $name);
    }
}
