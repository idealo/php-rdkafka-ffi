<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use PHPUnit\Framework\TestCase;
use RequireVersionTrait;

/**
 * @covers \RdKafka\FFI\Library
 *
 * @group ffiOnly
 */
class LibraryPreloadTest extends TestCase
{
    use RequireVersionTrait;

    protected function tearDown(): void
    {
        Library::init(
            Library::VERSION_AUTODETECT,
            'RdKafka',
            LIBRDKAFKA_LIBRARY_PATH
        );
    }

    public function testPreloadWithInvalidCdef(): void
    {
        $this->expectException(\FFI\Exception::class);
        Library::preload(Library::getLibraryVersion(), __METHOD__, LIBRDKAFKA_LIBRARY_PATH, 'invalid');
    }

    /**
     * @depends testPreloadWithInvalidCdef
     */
    public function testPreload(): void
    {
        $ffi = Library::preload(Library::getLibraryVersion(), __METHOD__, LIBRDKAFKA_LIBRARY_PATH);

        $this->assertInstanceOf(FFI::class, $ffi);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', $ffi->rd_kafka_version_str());
    }
}
