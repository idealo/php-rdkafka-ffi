<?php

declare(strict_types=1);

use RdKafka\FFI\Api;

/**
 * @Groups({"Api", "ffi"})
 */
class ApiBench
{
    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchVersionAutoDetection(): void
    {
        Api::init();
        Api::rd_kafka_version();
    }

    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchVersionFix(): void
    {
        Api::init('1.0.0');
        Api::rd_kafka_version();
    }
}
