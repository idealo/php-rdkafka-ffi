<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @covers \RdKafka\FFI\Library
 *
 * @group ffiOnly
 */
class LibraryTest extends TestCase
{
    use \RequireVersionTrait;

    protected function tearDown(): void
    {
        Library::init();
    }

    public function testGetFFI(): void
    {
        $ffi = Library::getFFI();

        $this->assertInstanceOf(FFI::class, $ffi);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\./', $ffi->rd_kafka_version_str());
    }

    public function testHasMethodWithValidMethod(): void
    {
        $this->assertTrue(Library::hasMethod('rd_kafka_version'));
    }

    public function testHasMethodWithUnknownMethod(): void
    {
        $this->assertFalse(Library::hasMethod('unknown'));
    }

    public function testHasMethodWithNotSupportedMethod(): void
    {
        $this->requiresLibrdkafkaVersion('<', '1.4.0');

        $this->assertFalse(Library::hasMethod('rd_kafka_msg_partitioner_fnv1a_random'));
    }

    public function testRequireMethodWithUnknownMethod(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/unknown/');
        Library::requireMethod('unknown');
    }

    public function testRequireMethodWithNotSupportedMethod(): void
    {
        $this->requiresLibrdkafkaVersion('<', '1.4.0');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/rd_kafka_msg_partitioner_fnv1a_random/');
        Library::requireMethod('rd_kafka_msg_partitioner_fnv1a_random');
    }

    public function testRequireVersion(): void
    {
        $this->requiresLibrdkafkaVersion('>', '1.0.0');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/<= 1\.0\.0/');
        Library::requireVersion('<=', '1.0.0');
    }

    public function testVersionMatches(): void
    {
        $this->requiresLibrdkafkaVersion('>', '1.0.0');

        $this->assertFalse(Library::versionMatches('<=', '1.0.0'));
        $this->assertTrue(Library::versionMatches('=', Library::getVersion()));
    }

    public function testInit(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/1\.999\.0\-pre1/');
        Library::init('1.999.0-pre1');
    }

    public function testGetClientVersion(): void
    {
        $this->assertMatchesRegularExpression(
            '/
                v(?<phpLibVersion>\d+\.\d+\.[\w\d\-]+?)-
                v(?<bindingVersion>\d+\.\d+\.[\w\d\-]+?)-
                librdkafka-v(?<librdkafkaVersion>\d+\.\d+\.[\w\d\-]+)
                /x',
            Library::getClientVersion()
        );
    }
}
