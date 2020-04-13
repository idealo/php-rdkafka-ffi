<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Exception
 * @group ffiOnly
 */
class ExceptionTest extends TestCase
{
    public function testFromError(): void
    {
        $exception = Exception::fromError(RD_KAFKA_RESP_ERR__ALL_BROKERS_DOWN);

        $this->assertSame(-187, $exception->getCode());
        $this->assertMatchesRegularExpression('/all broker/i', $exception->getMessage());
    }
}
