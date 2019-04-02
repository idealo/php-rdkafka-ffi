<?php
declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\TopicConf
 */
class TopicConfTest extends TestCase
{
    public function testDump()
    {
        $conf = new TopicConf();

        $expectedKeys = [
            'request.required.acks',
            'request.timeout.ms',
            'message.timeout.ms',
            'queuing.strategy',
            'produce.offset.report',
            'partitioner',
            'compression.codec',
            'compression.level',
            'auto.commit.enable',
            'auto.commit.interval.ms',
            'auto.offset.reset',
            'offset.store.path',
            'offset.store.sync.interval.ms',
            'offset.store.method',
            'consume.callback.max.messages',
        ];

        $keys = array_keys($conf->dump());

        $this->assertEquals($expectedKeys, $keys);
    }
}
