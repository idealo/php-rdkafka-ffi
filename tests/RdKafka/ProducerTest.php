<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use RdKafka;
use RequireVersionTrait;

/**
 * @covers \RdKafka\Producer
 * @covers \RdKafka
 */
class ProducerTest extends TestCase
{
    use RequireVersionTrait;

    private Producer $producer;

    private string $callbackPayload;

    protected function setUp(): void
    {
        $this->callbackPayload = '';
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message, $opaque = null): void {
                $this->callbackPayload = $message->payload;
            }
        );

        $this->producer = new Producer($conf);
    }

    public function testAddBrokers(): void
    {
        $addedBrokersNumber = $this->producer->addBrokers(KAFKA_BROKERS);

        self::assertSame(1, $addedBrokersNumber);
    }

    public function testGetMetadata(): void
    {
        $metadata = $this->producer->getMetadata(true, null, KAFKA_TEST_TIMEOUT_MS);

        self::assertInstanceOf(Metadata::class, $metadata);
    }

    public function testGetOutQLen(): void
    {
        $outQLen = $this->producer->getOutQLen();

        self::assertSame(0, $outQLen);
    }

    public function testNewTopic(): void
    {
        $topic = $this->producer->newTopic(KAFKA_TEST_TOPIC);

        self::assertInstanceOf(ProducerTopic::class, $topic);
    }

    public function testPoll(): void
    {
        $topic = $this->producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, __METHOD__);

        $this->producer->poll(100);

        self::assertSame(__METHOD__, $this->callbackPayload);
    }

    /**
     * @group ffiOnly
     */
    public function testResolveFromCData(): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);

        $producer1 = new Producer($conf);
        $cData1 = $producer1->getCData();

        $producer2 = new Producer($conf);
        $cData2 = $producer2->getCData();

        $this->assertSame($producer1, Producer::resolveFromCData($cData1));
        $this->assertSame($producer2, Producer::resolveFromCData($cData2));

        unset($producer1);

        $this->assertNull(Producer::resolveFromCData($cData1));
        $this->assertSame($producer2, Producer::resolveFromCData($cData2));
    }

    public function testFlush(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $res = $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(0, $res);
    }

    public function testTransactionNotConfiguresShouldFail(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');
        $this->requiresRdKafkaExtensionVersion('>=', '4.1.0');

        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', KAFKA_BROKERS);

        $producer = new Producer($producerConf);

        $this->expectException(KafkaErrorException::class);
        $this->expectExceptionCode(RD_KAFKA_RESP_ERR__NOT_CONFIGURED);
        $producer->initTransactions(KAFKA_TEST_TIMEOUT_MS);
    }

    public function testTransaction(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');
        $this->requiresRdKafkaExtensionVersion('>=', '4.1.0');

        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $producerConf->set('transactional.id', __METHOD__);

        $producer = new Producer($producerConf);

        $producer->initTransactions(KAFKA_TEST_TIMEOUT_MS);

        // produce and commit
        $producer->beginTransaction();

        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->produce(0, 0, __METHOD__ . '1');
        $topic->produce(0, 0, __METHOD__ . '2');
        $topic->produce(0, 0, __METHOD__ . '3');

        $producer->commitTransaction(KAFKA_TEST_TIMEOUT_MS);
        $producer->poll(KAFKA_TEST_TIMEOUT_MS);

        // produce and abort
        $producer->beginTransaction();

        $topic->produce(0, 0, __METHOD__ . '4');
        $topic->produce(0, 0, __METHOD__ . '5');
        $topic->produce(0, 0, __METHOD__ . '6');

        $producer->abortTransaction(KAFKA_TEST_TIMEOUT_MS);
        $producer->poll(KAFKA_TEST_TIMEOUT_MS);

        $consumerConf = new Conf();
        $consumerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($consumerConf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(4));

        $messages = [];
        do {
            $message = $consumerTopic->consume(0, KAFKA_TEST_TIMEOUT_MS);
            if ($message === null) {
                break;
            }
            $messages[] = $message;
        } while (true);

        $consumerTopic->consumeStop(0);

        $this->assertCount(3, $messages);
        $this->assertSame(__METHOD__ . '1', $messages[0]->payload);
        $this->assertSame(__METHOD__ . '2', $messages[1]->payload);
        $this->assertSame(__METHOD__ . '3', $messages[2]->payload);
    }

    /**
     * @group ffiOnly
     */
    public function testGetOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->setOpaque($expectedOpaque);

        $producer = new Producer($conf);
        $this->assertSame($expectedOpaque, $producer->getOpaque());
    }
}
