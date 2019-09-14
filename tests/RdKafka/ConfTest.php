<?php
declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Conf
 */
class ConfTest extends TestCase
{
    public function testDump()
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
        $properties = array_keys($conf->dump());

        $this->assertEquals($expectedProperties, $properties);
    }

    public function testSet()
    {
        $conf = new Conf();
        $conf->set('client.id', 'abc');

        $dump = $conf->dump();

        $this->assertEquals('abc', $dump['client.id']);
    }

    public function testSetUnknownPropertyShouldFail()
    {
        $conf = new Conf();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('/any.unknown/');
        $conf->set('any.unknown', 'property');
    }

    /**
     * @group ffiOnly
     */
    public function testGet()
    {
        $conf = new Conf();
        $conf->set('client.id', 'abc');

        $value = $conf->get('client.id');

        $this->assertEquals('abc', $value);
    }

    /**
     * @group ffiOnly
     */
    public function testGetWithUnknownProperty()
    {
        $conf = new Conf();

        $this->expectException(Exception::class);
        $this->expectExceptionCode(RD_KAFKA_CONF_UNKNOWN);
        $conf->get('unknown.property');
    }

    public function testSetLogCb()
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->set('log_level', (string)LOG_DEBUG);
        $conf->setLogCb(function (Consumer $consumer, int $level, string $fac, string $buf) use (&$loggerCallbacks) {
            $loggerCallbacks++;
        });

        $consumer = new Consumer($conf);
        do {
            $consumer->poll(0);
        } while ($loggerCallbacks === 0);

        $this->assertEquals(1, $loggerCallbacks, 'Expected debug level log callback');
    }

    public function testSetErrorCb()
    {
        $errorCallbackStack = [];

        $conf = new Conf();
        $conf->setErrorCb(function (Consumer $consumer, $err, $reason, $opaque) use (&$errorCallbackStack) {
            $errorCallbackStack[] = $err;
        });

        $consumer = new Consumer($conf);
        $consumer->addBrokers('unknown');
        do {
            $consumer->poll(0);
        } while (count($errorCallbackStack) < 2);

        $this->assertEquals(RD_KAFKA_RESP_ERR__RESOLVE, $errorCallbackStack[0]);
        $this->assertEquals(RD_KAFKA_RESP_ERR__ALL_BROKERS_DOWN, $errorCallbackStack[1]);
    }

    public function testSetStatsCb()
    {
        $statsJson = '';

        $conf = new Conf();
        $conf->set('client.id', 'some_id');
        $conf->set('statistics.interval.ms', (string)1);
        $conf->setStatsCb(function (Consumer $consumer, $json, $json_len, $opaque) use (&$statsJson) {
            $statsJson = $json;
        });

        $consumer = new Consumer($conf);
        do {
            $consumer->poll(0);
        } while (empty($statsJson));

        $stats = json_decode($statsJson, true);

        $this->assertEquals('some_id', $stats['client_id']);
        $this->assertEquals('consumer', $stats['type']);
        $this->assertEquals([], $stats['brokers']);
    }

    public function testSetRebalanceCb()
    {
        $rebalanceCallbackStack = [];

        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->setRebalanceCb(
            function (KafkaConsumer $consumer, $err, $topicPartitionList, $opaque) use (&$rebalanceCallbackStack) {
                $rebalanceCallbackStack[] = [
                    'consumer' => $consumer,
                    'err' => $err,
                    'partitions' => $topicPartitionList,
                ];
                switch ($err) {
                    case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
                        $consumer->assign($topicPartitionList);
                        break;

                    case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
                        $consumer->assign(NULL);
                        break;

                    default:
                        throw new \Exception($err);
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

        do {
            $consumer1->consume(0);
            $consumer2->consume(0);
            $consumer3->consume(0);
        } while (count($rebalanceCallbackStack) < 3);

        // revoke
        $consumer1->close();
        $consumer2->close();
        $consumer3->close();

        do {
            usleep((int)KAFKA_TEST_TIMEOUT_MS * 1000);
        } while (count($rebalanceCallbackStack) < 6);

        $this->assertEquals(RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS, $rebalanceCallbackStack[0]['err']);
        $this->assertEquals($consumer1, $rebalanceCallbackStack[0]['consumer']);
        $this->assertEquals(1, count($rebalanceCallbackStack[0]['partitions']));

        $this->assertEquals(RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS, $rebalanceCallbackStack[1]['err']);
        $this->assertEquals($consumer2, $rebalanceCallbackStack[1]['consumer']);
        $this->assertEquals(1, count($rebalanceCallbackStack[1]['partitions']));

        $this->assertEquals(RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS, $rebalanceCallbackStack[2]['err']);
        $this->assertEquals($consumer3, $rebalanceCallbackStack[2]['consumer']);
        $this->assertEquals(1, count($rebalanceCallbackStack[2]['partitions']));

        $this->assertEquals(RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS, $rebalanceCallbackStack[3]['err']);
        $this->assertEquals($consumer1, $rebalanceCallbackStack[3]['consumer']);
        $this->assertEquals(1, count($rebalanceCallbackStack[3]['partitions']));

        $this->assertEquals(RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS, $rebalanceCallbackStack[4]['err']);
        $this->assertEquals($consumer2, $rebalanceCallbackStack[4]['consumer']);
        $this->assertEquals(1, count($rebalanceCallbackStack[4]['partitions']));

        $this->assertEquals(RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS, $rebalanceCallbackStack[5]['err']);
        $this->assertEquals($consumer3, $rebalanceCallbackStack[5]['consumer']);
        $this->assertEquals(1, count($rebalanceCallbackStack[5]['partitions']));
    }
}
