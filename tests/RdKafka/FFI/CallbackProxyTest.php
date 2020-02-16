<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\FFI\CallbackProxy
 *
 * @group ffiOnly
 */
class CallbackProxyTest extends TestCase
{
    protected function createCallbackProxyStub()
    {
        return new class() extends CallbackProxy {
            public function __construct(?callable $callback = null)
            {
                if ($callback !== null) {
                    parent::__construct($callback);
                }
            }

            public function __invoke(...$args)
            {
                return ($this->callback)(...$args);
            }
        };
    }

    public function testCreateWithCallable(): void
    {
        $testCallback = new class() {
            public function __invoke(string $value)
            {
                return $value;
            }
        };
        $this->assertNotInstanceOf(\Closure::class, $testCallback);

        $stub = $this->createCallbackProxyStub();
        $proxy = $stub::create($testCallback);

        $this->assertInstanceOf(\Closure::class, $proxy);
        $this->assertSame('test', $proxy('test'));
    }

    public function testCreateWithClosure(): void
    {
        $testCallback = function (string $value) {
            return $value;
        };
        $this->assertInstanceOf(\Closure::class, $testCallback);

        $stub = $this->createCallbackProxyStub();
        $proxy = $stub::create($testCallback);

        $this->assertInstanceOf(\Closure::class, $proxy);
        $this->assertSame('test', $proxy('test'));
    }
}
