<?php

declare(strict_types=1);

namespace RdKafka\Test;

use PHPUnit\Framework\TestCase;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\KafkaConsumer;
use RdKafka\Metadata;
use RdKafka\Producer;
use RdKafka\TopicPartition;
use RequireVersionTrait;

/**
 * @covers \RdKafka\Test\MockCluster
 * @group ffiOnly
 */
class MockClusterTest extends TestCase
{
    use RequireVersionTrait;

    protected function setUp(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.3.0');
    }

    public function testCreateWithProducingAndConsuming(): void
    {
        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);

        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumerConfig = new Conf();
        $consumerConfig->set('log_level', (string) LOG_EMERG);
        $consumerConfig->set('bootstrap.servers', $cluster->getBootstraps());
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
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');

        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('test.mock.num.brokers', (string) 3);
        $producer = new Producer($producerConfig);

        $cluster = MockCluster::fromProducer($producer);

        $this->assertCount(3, explode(',', $cluster->getBootstraps()));
    }

    public function testFromProducerWithMissingConfigShouldFail(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');

        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producer = new Producer($producerConfig);

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/instance.+not found/');
        MockCluster::fromProducer($producer);
    }

    public function testGetBootstraps(): void
    {
        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(3, $clusterConfig);

        $bootstrap = $cluster->getBootstraps();

        $this->assertCount(3, explode(',', $bootstrap));
    }

    public function testSetApiVersion(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');

        $logStack = [];

        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);

        $cluster->setApiVersion(ApiKey::Produce, 4, 6);
        $cluster->setApiVersion(ApiKey::Fetch, 6, 10);

        $producerConfig = new Conf();
        $producerConfig->set('debug', 'feature');
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
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
        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(2, $clusterConfig);

        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
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
        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(3, $clusterConfig);

        $cluster->setPartitionLeader(KAFKA_TEST_TOPIC, 0, 1);
        $cluster->setPartitionFollower(KAFKA_TEST_TOPIC, 0, 2);

        // produce 10 msgs
        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producerConfig->set('batch.num.messages', (string) 1);
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        for ($i = 0; $i < 10; $i++) {
            $producerTopic->produce(0, 0, __METHOD__ . $i, __METHOD__ . $i);
        }
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        // prepare consumer
        $consumerConfig = new Conf();
        $consumerConfig->set('log_level', (string) LOG_EMERG);
        $consumerConfig->set('group.id', __METHOD__);
        $consumerConfig->set('auto.offset.reset', 'earliest');
        $consumerConfig->set('fetch.message.max.bytes', (string) 100);
        $consumerConfig->set('bootstrap.servers', $cluster->getBootstraps());
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
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');

        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);

        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producerConfig->set('reconnect.backoff.max.ms', (string) 1000);
        $producer = new Producer($producerConfig);

        $cluster->setBrokerDown(1);
        sleep(1);

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
        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);

        // produce msg
        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        // first error is retriable, second fatal
        $cluster->pushRequestErrors(
            ApiKey::Fetch,
            2,
            RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE,
            RD_KAFKA_RESP_ERR__AUTHENTICATION
        );

        // try to consume msg
        $consumerConfig = new Conf();
        $consumerConfig->set('log_level', (string) LOG_EMERG);
        $consumerConfig->set('group.id', __METHOD__);
//        $consumerConfig->set('debug', 'fetch');
        $consumerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $consumer = new KafkaConsumer($consumerConfig);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0, rd_kafka_offset_tail(1))]);

        // try to consume msg
        $message1 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);
        $message2 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(RD_KAFKA_RESP_ERR__AUTHENTICATION, $message1->err);
        $this->assertSame(__METHOD__, $message2->payload);
    }

    public function testPushRequestErrorsArray(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.7.0');

        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);

        // produce msg
        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        // first error is retriable, second fatal
        $cluster->pushRequestErrorsArray(
            ApiKey::Fetch,
            2,
            [
                RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE,
                RD_KAFKA_RESP_ERR__AUTHENTICATION,
            ]
        );

        // try to consume msg
        $consumerConfig = new Conf();
        $consumerConfig->set('log_level', (string) LOG_EMERG);
        $consumerConfig->set('group.id', __METHOD__);
//        $consumerConfig->set('debug', 'fetch');
        $consumerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $consumer = new KafkaConsumer($consumerConfig);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0, rd_kafka_offset_tail(1))]);

        // try to consume msg
        $message1 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);
        $message2 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(RD_KAFKA_RESP_ERR__AUTHENTICATION, $message1->err);
        $this->assertSame(__METHOD__, $message2->payload);
    }

    public function testCreateTopic(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');

        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);
        $cluster->createTopic(KAFKA_TEST_TOPIC, 12, 1);

        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $metadata = $producer->getMetadata(false, $producerTopic, KAFKA_TEST_TIMEOUT_MS);

        /** @var Metadata\Topic $topic */
        $topic = $metadata->getTopics()->current();

        $this->assertSame(KAFKA_TEST_TOPIC, $topic->getTopic());
        $this->assertCount(12, $topic->getPartitions());
    }

    public function testPushBrokerRequestErrors(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.5.0');
        $this->requiresLibrdkafkaVersion('<', '1.7.0');

        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);

        // produce msg
        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        // first error is retriable, second fatal
        $cluster->pushBrokerRequestErrors(
            1,
            ApiKey::Fetch,
            2,
            RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE,
            RD_KAFKA_RESP_ERR__AUTHENTICATION
        );

        // try to consume msg
        $consumerConfig = new Conf();
        $consumerConfig->set('log_level', (string) LOG_EMERG);
        $consumerConfig->set('group.id', __METHOD__);
//        $consumerConfig->set('debug', 'fetch');
        $consumerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $consumer = new KafkaConsumer($consumerConfig);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0, rd_kafka_offset_tail(1))]);

        // try to consume msg
        $message1 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);
        $message2 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(RD_KAFKA_RESP_ERR__AUTHENTICATION, $message1->err);
        $this->assertSame(__METHOD__, $message2->payload);
    }

    public function testPushBrokerRequestErrorRtts(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.7.0');

        $clusterConfig = new Conf();
        $clusterConfig->set('log_level', (string) LOG_EMERG);
        $cluster = MockCluster::create(1, $clusterConfig);

        // produce msg
        $producerConfig = new Conf();
        $producerConfig->set('log_level', (string) LOG_EMERG);
        $producerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $producer = new Producer($producerConfig);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        // first error is retriable, second fatal
        $cluster->pushBrokerRequestErrorRtts(
            1,
            ApiKey::Fetch,
            2,
            RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE,
            100,
            RD_KAFKA_RESP_ERR__AUTHENTICATION,
            100
        );

        // try to consume msg
        $consumerConfig = new Conf();
        $consumerConfig->set('log_level', (string) LOG_EMERG);
        $consumerConfig->set('group.id', __METHOD__);
//        $consumerConfig->set('debug', 'fetch');
        $consumerConfig->set('bootstrap.servers', $cluster->getBootstraps());
        $consumer = new KafkaConsumer($consumerConfig);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0, rd_kafka_offset_tail(1))]);

        // try to consume msg
        $message1 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);
        $message2 = $consumer->consume(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(RD_KAFKA_RESP_ERR__AUTHENTICATION, $message1->err);
        $this->assertSame(__METHOD__, $message2->payload);
    }
}
