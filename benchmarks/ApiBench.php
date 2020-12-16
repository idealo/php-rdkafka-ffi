<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

/**
 * @Groups({"Library"})
 */
class ApiBench
{
    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchVersionAutoDetection(): void
    {
        Library::init();
        Library::rd_kafka_version();
    }

    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchVersionFix(): void
    {
        Library::init('1.0.0');
        Library::rd_kafka_version();
    }
}
