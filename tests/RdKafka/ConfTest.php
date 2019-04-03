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

    public function testGet()
    {
        $conf = new Conf();
        $conf->set('client.id', 'abc');

        $value = $conf->get('client.id');

        $this->assertEquals('abc', $value);
    }

    public function testGetWithUnknownProperty()
    {
        $conf = new Conf();

        $this->expectException(Exception::class);
        $this->expectExceptionCode(RD_KAFKA_CONF_UNKNOWN);
        $conf->get('unknown.property');
    }
}
