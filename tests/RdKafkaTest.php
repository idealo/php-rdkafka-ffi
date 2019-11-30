<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka
 */
class RdKafkaTest extends TestCase
{
    public function testRdKafkaClassIsAbstract()
    {
        $reflector = new ReflectionClass(RdKafka::class);

        $this->assertTrue($reflector->isAbstract());
    }
}
