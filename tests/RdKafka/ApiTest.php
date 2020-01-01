<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Api
 *
 * @group ffiOnly
 */
class ApiTest extends TestCase
{
    public function testGetFFI(): void
    {
        $ffi = Api::getFFI();

        $this->assertInstanceOf(\FFI::class, $ffi);
        $this->assertRegExp('/^\d+\.\d+\./', \FFI::string($ffi->rd_kafka_version_str()));
    }

    public function testPreload(): void
    {
        $ffi = Api::preload();

        $this->assertInstanceOf(\FFI::class, $ffi);
        $this->assertRegExp('/^\d+\.\d+\./', \FFI::string($ffi->rd_kafka_version_str()));
    }

    public function testPreloadWithInvalidCdef(): void
    {
        Api::$cdef = 'invalid';

        $this->expectException(\FFI\Exception::class);
        Api::preload();
    }
}
