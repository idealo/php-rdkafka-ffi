<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @covers ::rd_kafka_err2str
 * @covers ::rd_kafka_errno2err
 * @covers ::rd_kafka_errno
 * @covers ::rd_kafka_offset_tail
 * @covers ::rd_kafka_version
 * @covers \RdKafka\Api
 */
class FunctionsTest extends TestCase
{
    public function testErr2str()
    {
        $this->assertEquals('Success', rd_kafka_err2str(RD_KAFKA_RESP_ERR_NO_ERROR));
    }

    public function testErrno2err()
    {
        $this->assertEquals(RD_KAFKA_RESP_ERR__FAIL, rd_kafka_errno2err(999));
    }

    public function testErrno()
    {
        $this->assertEquals(0, rd_kafka_errno());
    }

    public function testThreadCount()
    {
        $this->assertEquals(0, rd_kafka_thread_cnt());
    }

    /**
     * @group ffiOnly
     */
    public function testVersion()
    {
        $this->assertRegExp('/^\d+\.\d+\./', rd_kafka_version());
    }
}
