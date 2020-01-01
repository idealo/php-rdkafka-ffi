<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @covers \RdKafka\Topic
 */
class TopicTest extends TestCase
{
    public function testClassIsAbstract(): void
    {
        $reflector = new ReflectionClass(Topic::class);

        $this->assertTrue($reflector->isAbstract());
    }
}
