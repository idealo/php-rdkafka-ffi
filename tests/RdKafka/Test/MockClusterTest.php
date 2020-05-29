<?php

declare(strict_types=1);

namespace RdKafka\Test;

use PHPUnit\Framework\TestCase;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\KafkaConsumer;
use RdKafka\Message;
use RdKafka\Metadata;
use RdKafka\Producer;
use RdKafka\TopicPartition;
use RequireRdKafkaVersionTrait;

/**
 * @covers \RdKafka\Test\MockCluster
 * @group ffiOnly
 */
class MockClusterTest extends TestCase
{
    use RequireRdKafkaVersionTrait;

    protected function setUp(): void
    {
        $this->requiresRdKafkaVersion('>=', '1.3.0');
    }

    public function testCreateWithProducingAndConsuming(): void
    {
        $cluster = MockCluster::create(1);

        $producerConfig = new Conf();
        $producerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumerConfig = new Conf();
        $consumerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $consumerConfig->set('group.id', __METHOD__);
        $consumer = new KafkaConsumer($consumerConfig);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);
        $message = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(__METHOD__, $message->payload);
        $this->assertSame(__METHOD__, $message->key);
    }

    public function testCreateWithInvalidBrokerCount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/brokerCount/');
        MockCluster::create(0);
    }

    public function testFromProducer(): void
    {
        $this->requiresRdKafkaVersion('>=', '1.4.0');

        $producerConfig = new Conf();
        $producerConfig->set('test.mock.num.brokers', (string) 3);
        $producer = new Producer($producerConfig);

        $cluster = MockCluster::fromProducer($producer);

        $this->assertCount(3, explode(',', $cluster->getBootstraps()));
    }

    public function testFromProducerWithMissingConfigShouldFail(): void
    {
        $this->requiresRdKafkaVersion('>=', '1.4.0');

        $producer = new Producer();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/instance.+not found/');
        MockCluster::fromProducer($producer);
    }

    public function testGetBootstraps(): void
    {
        $cluster = MockCluster::create(3);

        $bootstrap = $cluster->getBootstraps();

        $this->assertCount(3, explode(',', $bootstrap));
    }

    public function testSetApiVersion(): void
    {
        $this->requiresRdKafkaVersion('>=', '1.4.0');

        $logStack = [];

        $cluster = MockCluster::create(1);

        $cluster->setApiVersion(ApiKey::Produce, 4, 6);
        $cluster->setApiVersion(ApiKey::Fetch, 6, 10);

        $producerConfig = new Conf();
        $producerConfig->set('debug', 'feature');
        $producerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $producerConfig->setLogCb(
            function (Producer $producer, int $level, string $fac, string $buf) use (&$logStack): void {
                if (strpos($buf, 'ApiKey') > 0) {
                    $logStack[] = $buf;
//                    echo $buf . PHP_EOL;
                }
            }
        );

        $producer = new Producer($producerConfig);

        do {
            $producer->poll(0);
        } while (count($logStack) < 2);

        $this->assertStringContainsString('Produce (0) Versions 4..6', $logStack[0]);
        $this->assertStringContainsString('Fetch (1) Versions 6..10', $logStack[1]);

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);
    }

    public function testSetPartitionFollowerAndLeader(): void
    {
        $cluster = MockCluster::create(2);

        $producerConfig = new Conf();
        $producerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $producerConfig->set('topic.metadata.refresh.interval.ms', (string) 50);
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $cluster->setPartitionLeader(KAFKA_TEST_TOPIC, 0, 2);
        $cluster->setPartitionFollower(KAFKA_TEST_TOPIC, 0, 1);

        $metadata = $producer->getMetadata(false, $producerTopic, KAFKA_TEST_TIMEOUT_MS);
        $leader = $metadata->getTopics()->current()->getPartitions()->current()->getLeader();

        $this->assertSame(2, $leader);

        $cluster->setPartitionLeader(KAFKA_TEST_TOPIC, 0, 1);
        $cluster->setPartitionFollower(KAFKA_TEST_TOPIC, 0, 2);

        $metadata = $producer->getMetadata(false, $producerTopic, KAFKA_TEST_TIMEOUT_MS);
        $leader = $metadata->getTopics()->current()->getPartitions()->current()->getLeader();

        $this->assertSame(1, $leader);
    }

    public function testSetPartitionFollowerWatermarks(): void
    {
        $cluster = MockCluster::create(3);
        $cluster->setPartitionLeader(KAFKA_TEST_TOPIC, 0, 1);
        $cluster->setPartitionFollower(KAFKA_TEST_TOPIC, 0, 2);

        // produce 10 msgs
        $producerConfig = new Conf();
        $producerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $producerConfig->set('batch.num.messages', (string) 1);
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        for ($i = 0; $i < 10; $i++) {
            $producerTopic->produce(0, 0, __METHOD__ . $i, __METHOD__ . $i);
        }
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        // prepare consumer
        $consumerConfig = new Conf();
        $consumerConfig->set('group.id', __METHOD__);
        $consumerConfig->set('auto.offset.reset', 'earliest');
        $consumerConfig->set('fetch.message.max.bytes', (string) 100);
        $consumerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $consumer = new KafkaConsumer($consumerConfig);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0, RD_KAFKA_OFFSET_INVALID)]);

        // set high watermark to 6
        $cluster->setPartitionFollowerWatermarks(KAFKA_TEST_TOPIC, 0, -1, 6);

        // consume until high watermark
        $consumedStack = [];
        do {
            $message = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);
            if ($message === null) {
                continue;
            }
            $consumedStack[] = $message->err ?: $message->payload;
            if ($message->err) {
                break;
            }
        } while (true);

        // expect 7 (0 - 6) msgs and one timeout
        $this->assertSame(
            [
                0 => __METHOD__ . '0',
                1 => __METHOD__ . '1',
                2 => __METHOD__ . '2',
                3 => __METHOD__ . '3',
                4 => __METHOD__ . '4',
                5 => __METHOD__ . '5',
                6 => __METHOD__ . '6',
                7 => -185,
            ],
            $consumedStack
        );

        // reset high watermark
        $cluster->setPartitionFollowerWatermarks(KAFKA_TEST_TOPIC, 0, -1, -1);

        // consume rest
        $consumedStack = [];
        do {
            $message = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);
            if ($message === null) {
                continue;
            }
            $consumedStack[] = $message->err ?: $message->payload;
            if ($message->err) {
                break;
            }
        } while (true);

        // expect 3 msgs and one timeout
        $this->assertSame(
            [
                0 => __METHOD__ . '7',
                1 => __METHOD__ . '8',
                2 => __METHOD__ . '9',
                3 => -185,
            ],
            $consumedStack
        );
    }

    public function testSetBrokerDownAndUp(): void
    {
        $this->requiresRdKafkaVersion('>=', '1.4.0');

        $cluster = MockCluster::create(1);

        $producerConfig = new Conf();
        $producerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);

        $cluster->setBrokerDown(1);
        try {
            $producer->getMetadata(false, null, KAFKA_TEST_TIMEOUT_MS);
            $errorCode = 0;
        } catch (Exception $exception) {
            $errorCode = $exception->getCode();
        }

        $this->assertSame(RD_KAFKA_RESP_ERR__TRANSPORT, $errorCode);

        $cluster->setBrokerUp(1);
        $metadata = $producer->getMetadata(false, null, KAFKA_TEST_TIMEOUT_MS);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    public function testPushRequestErrors(): void
    {
        $errorStack = [];

        $cluster = MockCluster::create(1);

        $producerConfig = new Conf();
        // $producerConfig->set('debug', 'msg');
        $producerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $producerConfig->setDrMsgCb(
            function (Producer $producer, Message $message, $opaque = null) use (&$errorStack): void {
                $errorStack[] = $message->err;
            }
        );
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);

        // first error is retryable, second permanent
        $cluster->pushRequestErrors(ApiKey::Produce, 2, RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS, RD_KAFKA_RESP_ERR__AUTHENTICATION);

        $producerTopic->produce(0, 0, __METHOD__, __METHOD__);
        do {
            $producer->poll(9);
        } while (empty($errorStack));
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame([RD_KAFKA_RESP_ERR__AUTHENTICATION], $errorStack);
    }

    public function testCreateTopic(): void
    {
        $this->requiresRdKafkaVersion('>=', '1.4.0');

        $cluster = MockCluster::create(1);
        $cluster->createTopic(KAFKA_TEST_TOPIC, 12, 1);

        $producerConfig = new Conf();
        $producerConfig->set('metadata.broker.list', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $metadata = $producer->getMetadata(false, $producerTopic, KAFKA_TEST_TIMEOUT_MS);

        /** @var Metadata\Topic $topic */
        $topic = $metadata->getTopics()->current();

        $this->assertSame(KAFKA_TEST_TOPIC, $topic->getTopic());
        $this->assertCount(12, $topic->getPartitions());
    }
}
