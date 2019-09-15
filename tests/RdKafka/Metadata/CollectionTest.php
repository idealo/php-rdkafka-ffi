<?php
declare(strict_types=1);

namespace RdKafka\Metadata;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Metadata\Collection
 * @group ffiOnly
 */
class CollectionTest extends TestCase
{

    public function testRewind()
    {
        $collection = new Collection([1 => 1, 2 => 2, 3 => 3]);

        $collection->next();
        $collection->next();
        $third = $collection->current();

        $collection->rewind();
        $first = $collection->current();

        $this->assertEquals(3, $third);
        $this->assertEquals(1, $first);
    }

    public function testKey()
    {
        $collection = new Collection(['abc' => 1, 2 => 2, 3 => 3]);

        $first = $collection->key();

        $this->assertEquals('abc', $first);
    }

    public function testCurrent()
    {
        $collection = new Collection([1 => 'abc', 2 => 2, 3 => 3]);

        $first = $collection->current();

        $this->assertEquals('abc', $first);
    }

    public function testNext()
    {
        $collection = new Collection([1 => 1, 2 => 'abc', 3 => 3]);

        $collection->next();
        $next = $collection->current();

        $this->assertEquals('abc', $next);
    }

    public function testValid()
    {
        $collection = new Collection([1 => 1, 2 => 2, 3 => 3]);

        $collection->next();
        $collection->next();
        $third = $collection->valid();

        $collection->next();
        $forth = $collection->valid();

        $this->assertTrue($third);
        $this->assertFalse($forth);

    }

    public function testCount()
    {
        $collection = new Collection([1 => 1, 2 => 2, 3 => 3]);

        $this->assertEquals(3, $collection->count());
    }
}
