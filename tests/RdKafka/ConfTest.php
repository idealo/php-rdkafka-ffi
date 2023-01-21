<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use RdKafka\FFI\Library;
use RequireVersionTrait;

/**
 * @covers \RdKafka\Conf
 * @covers \RdKafka\Exception
 * @covers \RdKafka\FFI\DrMsgCallbackProxy
 * @covers \RdKafka\FFI\ErrorCallbackProxy
 * @covers \RdKafka\FFI\LogCallbackProxy
 * @covers \RdKafka\FFI\OffsetCommitCallbackProxy
 * @covers \RdKafka\FFI\RebalanceCallbackProxy
 * @covers \RdKafka\FFI\StatsCallbackProxy
 */
class ConfTest extends TestCase
{
    use RequireVersionTrait;

    public function testDump(): void
    {
        $expectedProperties = [
            'builtin.features',
            'client.id',
            'message.max.bytes',
            'message.copy.max.bytes',
            'receive.message.max.bytes',
            'max.in.flight.requests.per.connection',
            'metadata.request.timeout.ms',
            'topic.metadata.refresh.interval.ms',
            'metadata.max.age.ms',
            'topic.metadata.refresh.fast.interval.ms',
            'topic.metadata.refresh.fast.cnt',
            'topic.metadata.refresh.sparse',
            'debug',
            'socket.timeout.ms',
            'socket.blocking.max.ms',
            'socket.send.buffer.bytes',
            'socket.receive.buffer.bytes',
            'socket.keepalive.enable',
            'socket.nagle.disable',
            'socket.max.fails',
            'broker.address.ttl',
            'broker.address.family',
            'enable.sparse.connections',
            'reconnect.backoff.jitter.ms',
            'reconnect.backoff.ms',
            'reconnect.backoff.max.ms',
            'statistics.interval.ms',
            'enabled_events',
            'log_cb',
            'log_level',
            'log.queue',
            'log.thread.name',
            'log.connection.close',
            'socket_cb',
            'open_cb',
            'internal.termination.signal',
            'api.version.request',
            'api.version.request.timeout.ms',
            'api.version.fallback.ms',
            'broker.version.fallback',
            'security.protocol',
            'sasl.mechanisms',
            'sasl.kerberos.service.name',
            'sasl.kerberos.principal',
            'sasl.kerberos.kinit.cmd',
            'sasl.kerberos.min.time.before.relogin',
            'partition.assignment.strategy',
            'session.timeout.ms',
            'heartbeat.interval.ms',
            'group.protocol.type',
            'coordinator.query.interval.ms',
            'max.poll.interval.ms',
            'enable.auto.commit',
            'auto.commit.interval.ms',
            'enable.auto.offset.store',
            'queued.min.messages',
            'queued.max.messages.kbytes',
            'fetch.wait.max.ms',
            'fetch.message.max.bytes',
            'fetch.max.bytes',
            'fetch.min.bytes',
            'fetch.error.backoff.ms',
            'offset.store.method',
            'enable.partition.eof',
            'check.crcs',
            'enable.idempotence',
            'enable.gapless.guarantee',
            'queue.buffering.max.messages',
            'queue.buffering.max.kbytes',
            'queue.buffering.max.ms',
            'message.send.max.retries',
            'retry.backoff.ms',
            'queue.buffering.backpressure.threshold',
            'compression.codec',
            'batch.num.messages',
            'delivery.report.only.error',
        ];

        $conf = new Conf();
        $properties = $conf->dump();

        foreach ($expectedProperties as $expectedProperty) {
            $this->assertArrayHasKey($expectedProperty, $properties);
        }
    }

    public function testSet(): void
    {
        $conf = new Conf();
        $conf->set('client.id', 'abc');

        $dump = $conf->dump();

        $this->assertSame('abc', $dump['client.id']);
    }

    public function testSetWithUnknownPropertyShouldFail(): void
    {
        $conf = new Conf();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/configuration property.+any.unknown/');
        $conf->set('any.unknown', 'property');
    }

    public function testSetWithInvalidValueShouldFail(): void
    {
        $conf = new Conf();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Invalid value.+debug/');
        $conf->set('debug', 'any.unknown');
    }

    /**
     * @group ffiOnly
     */
    public function testClientSoftwareNameAndVersionForKIP511(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');

        $conf = new Conf();

        $params = $conf->dump();
        $this->assertSame('php-rdkafka-ffi', $params['client.software.name']);
        $this->assertSame(Library::getClientVersion(), $params['client.software.version']);
    }

    /**
     * @group ffiOnly
     */
    public function testGet(): void
    {
        $conf = new Conf();
        $conf->set('client.id', 'abc');

        $value = $conf->get('client.id');

        $this->assertSame('abc', $value);
    }

    /**
     * @group ffiOnly
     */
    public function testGetWithUnknownProperty(): void
    {
        $conf = new Conf();

        $this->expectException(Exception::class);
        $this->expectExceptionCode(RD_KAFKA_CONF_UNKNOWN);
        $conf->get('unknown.property');
    }

    public function testSetLogCb(): void
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'feature');
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->setLogCb(
            function (Consumer $consumer, int $level, string $facility, string $message) use (&$loggerCallbacks): void {
                $loggerCallbacks++;
            }
        );

        $consumer = new Consumer($conf);
        do {
            $consumer->poll(0);
        } while ($loggerCallbacks === 0);

        $params = $conf->dump();
        $this->assertSame('true', $params['log.queue']);
        $this->assertGreaterThan(0, $loggerCallbacks, 'Expected debug level log callback');
    }

    /**
     * @group ffiOnly
     */
    public function testSetLogCbWithNullShouldDisableLogging(): void
    {
        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->setLogCb(null);

        $this->assertSame('false', $conf->get('log.queue'));
    }

    public function testSetErrorCb(): void
    {
        $errorCallbackStack = [];

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('bootstrap.servers', 'unknown');
        $conf->setErrorCb(
            function (Consumer $consumer, $err, $reason, $opaque = null) use (&$errorCallbackStack): void {
                $errorCallbackStack[] = $err;
            }
        );

        $consumer = new Consumer($conf);
        do {
            $consumer->poll(0);
        } while (\count($errorCallbackStack) < 2);

        $this->assertSame(RD_KAFKA_RESP_ERR__RESOLVE, $errorCallbackStack[0]);
        $this->assertSame(RD_KAFKA_RESP_ERR__ALL_BROKERS_DOWN, $errorCallbackStack[1]);
    }

    /**
     * @group ffiOnly
     */
    public function testSetErrorCbWithOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $opaqueCallbackStack = [];

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('bootstrap.servers', 'unknown');
        $conf->setOpaque($expectedOpaque);
        $conf->setErrorCb(
            function (Consumer $consumer, int $err, string $reason, $opaque = null) use (&$opaqueCallbackStack): void {
                $opaqueCallbackStack[] = $opaque;
            }
        );

        $consumer = new Consumer($conf);
        do {
            $consumer->poll(0);
        } while (\count($opaqueCallbackStack) < 2);

        $this->assertSame($expectedOpaque, $opaqueCallbackStack[0]);
        $this->assertSame($expectedOpaque, $opaqueCallbackStack[1]);
    }

    public function testSetDrMsgCb(): void
    {
        $drMsgCallbackStack = [];

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('batch.num.messages', (string) 1);
        $conf->setDrMsgCb(
            function ($producer, $message) use (&$drMsgCallbackStack): void {
                $drMsgCallbackStack[] = [
                    'producer' => $producer,
                    'message' => $message,
                ];
            }
        );
        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__ . '1');
        $producer->poll(KAFKA_TEST_TIMEOUT_MS);
        $producerTopic->produce(0, 0, __METHOD__ . '2');
        $producer->poll(KAFKA_TEST_TIMEOUT_MS);

        $this->assertCount(2, $drMsgCallbackStack);
        $this->assertSame($producer, $drMsgCallbackStack[0]['producer']);
        $this->assertSame(__METHOD__ . '1', $drMsgCallbackStack[0]['message']->payload);
        $this->assertSame($producer, $drMsgCallbackStack[1]['producer']);
        $this->assertSame(__METHOD__ . '2', $drMsgCallbackStack[1]['message']->payload);

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);
    }

    /**
     * @group ffiOnly
     */
    public function testSetDrMsgCbWithOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $drMsgCallbackStack = [];

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('batch.num.messages', (string) 1);
        $conf->setOpaque($expectedOpaque);
        $conf->setDrMsgCb(
            function (Producer $producer, Message $message, $opaque = null) use (&$drMsgCallbackStack): void {
                $drMsgCallbackStack[] = [
                    'producer' => $producer,
                    'opaque' => $opaque,
                ];
            }
        );
        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__ . '1');
        $producer->poll(KAFKA_TEST_TIMEOUT_MS);
        $producerTopic->produce(0, 0, __METHOD__ . '2');
        $producer->poll(KAFKA_TEST_TIMEOUT_MS);

        $this->assertCount(2, $drMsgCallbackStack);
        $this->assertSame($producer, $drMsgCallbackStack[0]['producer']);
        $this->assertSame($expectedOpaque, $drMsgCallbackStack[0]['opaque']);
        $this->assertSame($producer, $drMsgCallbackStack[1]['producer']);
        $this->assertSame($expectedOpaque, $drMsgCallbackStack[1]['opaque']);

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);
    }

    public function testSetStatsCb(): void
    {
        $statsJson = '';

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('client.id', 'some_id');
        $conf->set('statistics.interval.ms', (string) 1);
        $conf->setStatsCb(
            function (Consumer $consumer, string $json, int $json_len, $opaque = null) use (&$statsJson): void {
                $statsJson = $json;
            }
        );

        $consumer = new Consumer($conf);
        do {
            $consumer->poll(0);
        } while (empty($statsJson));

        $stats = json_decode($statsJson, true);

        $this->assertSame('some_id', $stats['client_id']);
        $this->assertSame('consumer', $stats['type']);
        $this->assertSame([], $stats['brokers']);
    }

    /**
     * @group ffiOnly
     */
    public function testSetStatsCbWithOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $callbackOpaque = null;

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('client.id', 'some_id');
        $conf->set('statistics.interval.ms', (string) 1000);
        $conf->setOpaque($expectedOpaque);
        $conf->setStatsCb(
            function (Consumer $consumer, string $json, int $json_len, $opaque = null) use (&$callbackOpaque): void {
                $callbackOpaque = $opaque;
            }
        );

        $consumer = new Consumer($conf);
        do {
            $consumer->poll(0);
        } while ($callbackOpaque === null);

        $this->assertSame($expectedOpaque, $callbackOpaque);
    }

    /**
     * Note: if this tests runs too long it will fail
     */
    public function testSetRebalanceCb(): void
    {
        $rebalanceCallbackStack = [];
        $failedTimeoutSec = 30;

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setRebalanceCb(
            function (KafkaConsumer $consumer, int $err, array $topicPartitions, $opaque = null) use (&$rebalanceCallbackStack): void {
                $rebalanceCallbackStack[] = [
                    'consumer' => $consumer,
                    'err' => $err,
                    'partitions' => $topicPartitions,
                ];
                switch ($err) {
                    case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
                        $consumer->assign($topicPartitions);
                        break;

                    case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
                        $consumer->assign(null);
                        break;

                    default:
                        throw Exception::fromError($err);
                }
            }
        );

        // assign
        $consumer1 = new KafkaConsumer($conf);
        $consumer1->subscribe([KAFKA_TEST_TOPIC_PARTITIONS]);
        $consumer2 = new KafkaConsumer($conf);
        $consumer2->subscribe([KAFKA_TEST_TOPIC_PARTITIONS]);
        $consumer3 = new KafkaConsumer($conf);
        $consumer3->subscribe([KAFKA_TEST_TOPIC_PARTITIONS]);

        $startTime = time();
        do {
            $consumer1->consume((int) 50);
            $consumer2->consume((int) 50);
            $consumer3->consume((int) 50);
            $durationSec = time() - $startTime;
        } while (\count($rebalanceCallbackStack) < 3 && $durationSec < $failedTimeoutSec);

        $this->assertLessThan($failedTimeoutSec, $durationSec, 'adding consumer took too long');

        $assignedConsumers = array_column($rebalanceCallbackStack, 'consumer');
        $this->assertContains($consumer1, $assignedConsumers);
        $this->assertContains($consumer2, $assignedConsumers);
        $this->assertContains($consumer3, $assignedConsumers);

        $this->assertSame(RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS, $rebalanceCallbackStack[0]['err']);
        $this->assertGreaterThanOrEqual(1, $rebalanceCallbackStack[0]['partitions']);

        $this->assertSame(RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS, $rebalanceCallbackStack[1]['err']);
        $this->assertGreaterThanOrEqual(1, $rebalanceCallbackStack[1]['partitions']);

        $this->assertSame(RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS, $rebalanceCallbackStack[2]['err']);
        $this->assertGreaterThanOrEqual(1, $rebalanceCallbackStack[2]['partitions']);

        // reset stack
        $rebalanceCallbackStack = [];

        // revoke
        $consumer1->close();
        $consumer2->close();
        $consumer3->close();

        $startTime = time();
        do {
            usleep(50 * 1000);
            $durationSec = time() - $startTime;
        } while (\count($rebalanceCallbackStack) < 3 && $durationSec < $failedTimeoutSec);

        $this->assertLessThan($failedTimeoutSec, $durationSec, 'removing consumer took too long');

        $revokedConsumers = array_column($rebalanceCallbackStack, 'consumer');
        $this->assertContains($consumer1, $revokedConsumers);
        $this->assertContains($consumer2, $revokedConsumers);
        $this->assertContains($consumer3, $revokedConsumers);

        $this->assertSame(RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS, $rebalanceCallbackStack[0]['err']);
        $this->assertGreaterThanOrEqual(1, $rebalanceCallbackStack[0]['partitions']);

        $this->assertSame(RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS, $rebalanceCallbackStack[1]['err']);
        $this->assertGreaterThanOrEqual(1, $rebalanceCallbackStack[1]['partitions']);

        $this->assertSame(RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS, $rebalanceCallbackStack[2]['err']);
        $this->assertGreaterThanOrEqual(1, $rebalanceCallbackStack[2]['partitions']);
    }

    /**
     * Note: if this tests runs too long it will fail
     *
     * @group ffiOnly
     */
    public function testSetRebalanceCbWithOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $rebalanceCallbackStack = [];
        $failedTimeoutSec = 30;

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setOpaque($expectedOpaque);
        $conf->setRebalanceCb(
            function (KafkaConsumer $consumer, int $err, array $topicPartitions, $opaque = null) use (&$rebalanceCallbackStack): void {
                $rebalanceCallbackStack[] = $opaque;
                switch ($err) {
                    case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
                        $consumer->assign($topicPartitions);
                        break;

                    case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
                        $consumer->assign(null);
                        break;

                    default:
                        throw Exception::fromError($err);
                }
            }
        );

        // assign
        $consumer1 = new KafkaConsumer($conf);
        $consumer1->subscribe([KAFKA_TEST_TOPIC_PARTITIONS]);
        $consumer2 = new KafkaConsumer($conf);
        $consumer2->subscribe([KAFKA_TEST_TOPIC_PARTITIONS]);
        $consumer3 = new KafkaConsumer($conf);
        $consumer3->subscribe([KAFKA_TEST_TOPIC_PARTITIONS]);

        $startTime = time();
        do {
            $consumer1->consume((int) 50);
            $consumer2->consume((int) 50);
            $consumer3->consume((int) 50);
            $durationSec = time() - $startTime;
        } while (\count($rebalanceCallbackStack) < 3 && $durationSec < $failedTimeoutSec);

        $this->assertLessThan($failedTimeoutSec, $durationSec, 'adding consumer took too long');

        $this->assertSame($expectedOpaque, $rebalanceCallbackStack[0]);
        $this->assertSame($expectedOpaque, $rebalanceCallbackStack[1]);
        $this->assertSame($expectedOpaque, $rebalanceCallbackStack[2]);
    }

    public function testSetOffsetCommitCb(): void
    {
        $offsetCommitCallbackStack = [];

        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setOffsetCommitCb(
            function (
                KafkaConsumer $consumer,
                int $err,
                array $topicPartitions,
                $opaque = null
            ) use (&$offsetCommitCallbackStack): void {
                $offsetCommitCallbackStack[] = [
                    'consumer' => $consumer,
                    'err' => $err,
                    'topicPartitions' => $topicPartitions,
                ];
            }
        );
        $consumer = new KafkaConsumer($conf);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);

        $consumer->commit([new TopicPartition(KAFKA_TEST_TOPIC, 0, 20)]);

        // trigger callback
        $consumer->consume(0);

        $this->assertSame($consumer, $offsetCommitCallbackStack[0]['consumer']);
        $this->assertSame(0, $offsetCommitCallbackStack[0]['err']);
        $this->assertSame(20, $offsetCommitCallbackStack[0]['topicPartitions'][0]->getOffset());
    }

    /**
     * @group ffiOnly
     */
    public function testSetOffsetCommitCbWithOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $callbackOpaque = null;

        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setOpaque($expectedOpaque);
        $conf->setOffsetCommitCb(
            function (KafkaConsumer $consumer, int $err, array $topicPartitions, $opaque = null) use (&$callbackOpaque): void {
                $callbackOpaque = $opaque;
            }
        );
        $consumer = new KafkaConsumer($conf);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);

        $consumer->commit([new TopicPartition(KAFKA_TEST_TOPIC, 0, 20)]);

        // trigger callback
        $consumer->consume(0);

        $this->assertSame($expectedOpaque, $callbackOpaque);
    }
}
