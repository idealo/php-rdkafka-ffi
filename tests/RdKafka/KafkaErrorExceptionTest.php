<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use RdKafka\FFI\Library;
use RequireVersionTrait;

/**
 * @covers \RdKafka\KafkaErrorException
 */
class KafkaErrorExceptionTest extends TestCase
{
    use RequireVersionTrait;

    protected function setUp(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.4.0');
        $this->requiresRdKafkaExtensionVersion('>=', '4.1.0');
    }

    /**
     * @group ffiOnly
     */
    public function testFromCData(): void
    {
        $cdata = Library::rd_kafka_error_new(RD_KAFKA_RESP_ERR__NOT_CONFIGURED, 'something');

        $exception = KafkaErrorException::fromCData($cdata);

        $this->assertSame('_NOT_CONFIGURED', $exception->getMessage());
        $this->assertSame(-145, $exception->getCode());
        $this->assertSame('something', $exception->getErrorString());
        $this->assertFalse($exception->isFatal());
        $this->assertFalse($exception->isRetriable());
        $this->assertFalse($exception->transactionRequiresAbort());
    }

    public function testGetter(): void
    {
        $exception = new KafkaErrorException('name', 123456, 'description', true, true, true);

        $this->assertSame('name', $exception->getMessage());
        $this->assertSame(123456, $exception->getCode());
        $this->assertSame('description', $exception->getErrorString());
        $this->assertTrue($exception->isFatal());
        $this->assertTrue($exception->isRetriable());
        $this->assertTrue($exception->transactionRequiresAbort());
    }
}
