<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use PHPUnit\Framework\TestCase;
use RdKafka\FFI\Api;

/**
 * @covers \RdKafka\FFI\Api
 *
 * @group ffiOnly
 */
class ApiTest extends TestCase
{
    public function testGetFFI(): void
    {
        $ffi = Api::getFFI();

        $this->assertInstanceOf(FFI::class, $ffi);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', $ffi->rd_kafka_version_str());
    }

    public function testPreload(): void
    {
        $ffi = Api::preload();

        $this->assertInstanceOf(FFI::class, $ffi);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', $ffi->rd_kafka_version_str());
    }

    public function testPreloadWithInvalidCdef(): void
    {
        $this->expectException(\FFI\Exception::class);
        Api::preload('', 'Any', null, 'invalid');
    }
}
