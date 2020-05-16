<?php

declare(strict_types=1);

namespace RdKafka;

use FFI;
use PHPUnit\Framework\TestCase;
use RdKafka\FFI\Library;

/**
 * @covers \RdKafka\FFI\Library
 *
 * @group ffiOnly
 */
class LibraryTest extends TestCase
{
    public function testGetFFI(): void
    {
        $ffi = Library::getFFI();

        $this->assertInstanceOf(FFI::class, $ffi);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', $ffi->rd_kafka_version_str());
    }

    public function testPreload(): void
    {
        $ffi = Library::preload();

        $this->assertInstanceOf(FFI::class, $ffi);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', $ffi->rd_kafka_version_str());
    }

    public function testPreloadWithInvalidCdef(): void
    {
        $this->expectException(\FFI\Exception::class);
        Library::preload('', 'Any', null, 'invalid');
    }
}