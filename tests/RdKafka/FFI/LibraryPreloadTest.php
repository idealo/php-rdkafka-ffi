<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\FFI\Library
 *
 * @group ffiOnly
 */
class LibraryPreloadTest extends TestCase
{
    use \RequireVersionTrait;

    protected function tearDown(): void
    {
        Library::init();
    }

    public function testPreloadWithInvalidCdef(): void
    {
        $this->expectException(\FFI\Exception::class);
        Library::preload(Library::getLibraryVersion(), 'Any', null, 'invalid');
    }

    /**
     * @depends testPreloadWithInvalidCdef
     */
    public function testPreload(): void
    {
        $ffi = Library::preload();

        $this->assertInstanceOf(FFI::class, $ffi);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', $ffi->rd_kafka_version_str());
    }
}
