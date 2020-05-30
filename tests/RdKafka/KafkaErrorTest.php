<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use RequireRdKafkaVersionTrait;

/**
 * @covers \RdKafka\KafkaError
 * @group ffiOnly
 */
class KafkaErrorTest extends TestCase
{
    use RequireRdKafkaVersionTrait;

    protected function setUp(): void
    {
        $this->requiresRdKafkaVersion('>=', '1.4.0');
    }

    public function testNewFatal(): void
    {
        $error = KafkaError::newFatal(123456, 'something', ' else');

        $this->assertTrue($error->isFatal());
        $this->assertFalse($error->isRetriable());
        $this->assertFalse($error->transactionRequiresAbort());
        $this->assertSame(123456, $error->getCode());
        $this->assertSame('something', $error->getMessage());
        $this->assertSame('ERR_123456?', $error->getName());
    }

    public function testNewRetriable(): void
    {
        $error = KafkaError::newRetriable(123456, 'something', ' else');

        $this->assertFalse($error->isFatal());
        $this->assertTrue($error->isRetriable());
        $this->assertFalse($error->transactionRequiresAbort());
        $this->assertSame(123456, $error->getCode());
        $this->assertSame('something', $error->getMessage());
        $this->assertSame('ERR_123456?', $error->getName());
    }

    public function testNewTransactionRequiresAbort(): void
    {
        $error = KafkaError::newTransactionRequiresAbort(123456, 'something', ' else');

        $this->assertFalse($error->isFatal());
        $this->assertFalse($error->isRetriable());
        $this->assertTrue($error->transactionRequiresAbort());
        $this->assertSame(123456, $error->getCode());
        $this->assertSame('something', $error->getMessage());
        $this->assertSame('ERR_123456?', $error->getName());
    }
}
