<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Admin\NewTopic
 *
 * @group ffiOnly
 */
class NewTopicsTest extends TestCase
{
    public function testsetReplicaAssignmentWithEmptyBrokerIdsShouldFail(): void
    {
        $new = new NewTopic('any', 1, 1);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/broker_ids/');
        $this->expectExceptionMessageMatches('/empty/');
        $new->setReplicaAssignment(0, []);
    }

    public function testsetReplicaAssignmentWithInvalidBrokerIdsShouldFail(): void
    {
        $new = new NewTopic('any', 1, 1);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/broker_ids/');
        $this->expectExceptionMessageMatches('/int/');
        $new->setReplicaAssignment(0, [new \stdClass()]);
    }
}
