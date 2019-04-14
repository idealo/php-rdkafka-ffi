<?php
declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Queue
 */
class QueueTest extends TestCase
{
    public function testConsumeViaQueue()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, 'payload-consumer-via-queue');

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);

        $queue = $consumer->newQueue();

        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeQueueStart(0, rd_kafka_offset_tail(1), $queue);

        $message = $queue->consume(KAFKA_TEST_TIMEOUT_MS);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals('payload-consumer-via-queue', $message->payload);
    }
}
