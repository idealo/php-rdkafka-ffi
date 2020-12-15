<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\FFI\OpaqueMap
 * @group ffiOnly
 */
class OpaqueMapTest extends TestCase
{
    public function testPushGetAndPull(): void
    {
        $opaque = new \stdClass();

        $cOpaque = OpaqueMap::push($opaque);
        $this->assertInstanceOf(CData::class, $cOpaque);

        $this->assertSame($opaque, OpaqueMap::get($cOpaque));
        $this->assertSame($opaque, OpaqueMap::pull($cOpaque));

        $this->assertNull(OpaqueMap::get($cOpaque));
        $this->assertNull(OpaqueMap::pull($cOpaque));
    }

    public function testPushGetAndPullWithNull(): void
    {
        $this->assertNull(OpaqueMap::push(null));
        $this->assertNull(OpaqueMap::pull(null));
        $this->assertNull(OpaqueMap::get(null));
    }

    public function testGetWithUnsetOpaqueShouldReturnOpaque(): void
    {
        $opaque = new \stdClass();

        $cOpaque = OpaqueMap::push($opaque);
        $this->assertInstanceOf(CData::class, $cOpaque);

        unset($opaque);
        $this->assertNotNull(OpaqueMap::get($cOpaque));
    }

    public function testPullWithUnsetOpaqueShouldReturnOpaque(): void
    {
        $opaque = new \stdClass();

        $cOpaque = OpaqueMap::push($opaque);
        $this->assertInstanceOf(CData::class, $cOpaque);

        unset($opaque);
        $this->assertNotNull(OpaqueMap::pull($cOpaque));
    }
}
