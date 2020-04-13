<?php

declare(strict_types=1);

/**
 * @Groups({"Library"})
 */
class ApiBench
{
    /**
     * @Revs(1000)
     * @Iterations(5)
     */
    public function benchVersionAutoDetection(): void
    {
        \RdKafka\FFI\Api::init();
        \RdKafka\FFI\Api::getLibraryVersion();
    }

    /**
     * @Revs(1000)
     * @Iterations(5)
     */
    public function benchVersionFix(): void
    {
        \RdKafka\FFI\Api::init('1.0.0');
        \RdKafka\FFI\Api::getLibraryVersion();
    }
}
