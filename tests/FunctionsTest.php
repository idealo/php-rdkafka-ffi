<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @covers ::rd_kafka_err2str
 * @covers ::rd_kafka_errno2err
 * @covers ::rd_kafka_errno
 * @covers ::rd_kafka_offset_tail
 * @covers ::rd_kafka_version
 * @covers ::rd_kafka_thread_cnt
 * @covers \RdKafka\FFI\Library
 */
class FunctionsTest extends TestCase
{
    use RequireVersionTrait;

    public function testErr2name(): void
    {
        $this->requiresRdKafkaExtensionVersion('>=', '5.1');

        $this->assertSame('NO_ERROR', rd_kafka_err2name(RD_KAFKA_RESP_ERR_NO_ERROR));
    }

    public function testErr2str(): void
    {
        $this->assertSame('Success', rd_kafka_err2str(RD_KAFKA_RESP_ERR_NO_ERROR));
    }

    public function testErrno2err(): void
    {
        $this->requiresRdKafkaExtensionVersion('<', '5');

        $this->assertSame(RD_KAFKA_RESP_ERR__FAIL, rd_kafka_errno2err(999));
    }

    public function testErrno(): void
    {
        $this->requiresRdKafkaExtensionVersion('<', '5');

        $this->assertGreaterThanOrEqual(0, rd_kafka_errno());
    }

    public function testThreadCount(): void
    {
        $this->assertSame(0, rd_kafka_thread_cnt());
    }

    public function testOffsetTail(): void
    {
        $this->assertSame(-2000 /*RD_KAFKA_OFFSET_TAIL_BASE*/, rd_kafka_offset_tail(0));
        $this->assertSame(-2000 - 100, rd_kafka_offset_tail(100));
    }

    /**
     * @group ffiOnly
     */
    public function testVersion(): void
    {
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', rd_kafka_version());
    }
}
