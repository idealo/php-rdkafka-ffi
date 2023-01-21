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
    public function testRewind(): void
    {
        $collection = new Collection([
            1 => 1,
            2 => 2,
            3 => 3,
        ]);

        $collection->next();
        $collection->next();
        $third = $collection->current();

        $collection->rewind();
        $first = $collection->current();

        $this->assertSame(3, $third);
        $this->assertSame(1, $first);
    }

    public function testKey(): void
    {
        $collection = new Collection([
            3 => 1,
            2 => 2,
            1 => 3,
        ]);

        $first = $collection->key();

        $this->assertSame(3, $first);
    }

    public function testCurrent(): void
    {
        $collection = new Collection([
            1 => 'abc',
            2 => 2,
            3 => 3,
        ]);

        $first = $collection->current();

        $this->assertSame('abc', $first);
    }

    public function testNext(): void
    {
        $collection = new Collection([
            1 => 1,
            2 => 'abc',
            3 => 3,
        ]);

        $collection->next();
        $next = $collection->current();

        $this->assertSame('abc', $next);
    }

    public function testValid(): void
    {
        $collection = new Collection([
            1 => 1,
            2 => 2,
            3 => 3,
        ]);

        $collection->next();
        $collection->next();
        $third = $collection->valid();

        $collection->next();
        $forth = $collection->valid();

        $this->assertTrue($third);
        $this->assertFalse($forth);
    }

    public function testCount(): void
    {
        $collection = new Collection([
            1 => 1,
            2 => 2,
            3 => 3,
        ]);

        $this->assertSame(3, $collection->count());
    }
}
