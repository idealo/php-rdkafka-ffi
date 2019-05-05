<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\KafkaConsumerTopic
 * @covers \RdKafka\Topic
 */
class KafkaConsumerTopicTest extends TestCase
{
    public function testGetCData()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $consumer = new KafkaConsumer($conf);
        $consumer->addBrokers(KAFKA_BROKERS);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $cData = $topic->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testGetName()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $consumer = new KafkaConsumer($conf);
        $consumer->addBrokers(KAFKA_BROKERS);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $name = $topic->getName();

        $this->assertEquals(KAFKA_TEST_TOPIC, $name);
    }
}
