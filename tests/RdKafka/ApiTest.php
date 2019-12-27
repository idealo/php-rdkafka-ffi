<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Api
 */
class ApiTest extends TestCase
{
    public function testGetFFI()
    {
        $ffi = Api::getFFI();

        $this->assertInstanceOf(\FFI::class, $ffi);
        $this->assertRegExp('/^\d+\.\d+\./', \FFI::string($ffi->rd_kafka_version_str()));
    }

    public function testPreload()
    {
        Api::preload();
        Api::preload();

        $this->assertInstanceOf(\FFI::class, new \stdClass);
    }
}
