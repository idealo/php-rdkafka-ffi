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
//    public function testGetCData()
//    {
//        $conf = new Conf();
//        $conf->set('group.id', __METHOD__);
//        $conf->set('metadata.broker.list', KAFKA_BROKERS);
//
//        $consumer = new KafkaConsumer($conf);
//
//        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);
//
//        $cData = $topic->getCData();
//
//        $this->assertInstanceOf(CData::class, $cData);
//    }

    public function testGetName()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->setDefaultTopicConf(new TopicConf());

        $consumer = new KafkaConsumer($conf);
//        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        sleep(1);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC, new TopicConf());

        $name = $topic->getName();

        $this->assertEquals(KAFKA_TEST_TOPIC, $name);
    }
}
