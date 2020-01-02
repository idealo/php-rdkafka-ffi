<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\FFI\CallbackProxy
 */
class CallbackProxyTest extends TestCase
{
    public function testCreateWithCallable()
    {
        $testCallback = new class() {
            function __invoke(string $value)
            {
                return $value;
            }
        };
        $this->assertNotInstanceOf(\Closure::class, $testCallback);

        $proxy = CallbackProxyStub::create($testCallback);

        $this->assertInstanceOf(\Closure::class, $proxy);
        $this->assertSame('test', $proxy('test'));
    }

    public function testCreateWithClosure()
    {
        $testCallback = function (string $value) {
            return $value;
        };
        $this->assertInstanceOf(\Closure::class, $testCallback);

        $proxy = CallbackProxyStub::create($testCallback);

        $this->assertInstanceOf(\Closure::class, $proxy);
        $this->assertSame('test', $proxy('test'));
    }
}
