<?php

declare(strict_types=1);

trait RequireVersionTrait
{
    abstract public static function markTestSkipped(string $message = ''): void;

    /**
     * Require specific librdkafka version
     */
    protected function requiresLibrdkafkaVersion(string $operator, string $version): void
    {
        if (function_exists('rd_kafka_version')) {
            $runtimeVersion = rd_kafka_version();
        } elseif (defined('RD_KAFKA_VERSION')) {
            $runtimeVersion = sprintf(
                '%u.%u.%u',
                (RD_KAFKA_VERSION & 0xFF000000) >> 24,
                (RD_KAFKA_VERSION & 0x00FF0000) >> 16,
                (RD_KAFKA_VERSION & 0x0000FF00) >> 8
            );
        } else {
            $this->markTestSkipped('Requires librdkafka. Cannot detect current version.');
        }

        if (version_compare($runtimeVersion, $version, $operator) === false) {
            $this->markTestSkipped(
                sprintf(
                    'Requires librdkafka %s %s. Current version is %s.',
                    $operator,
                    $version,
                    $runtimeVersion
                )
            );
        }
    }

    /**
     * Require specific rdkafka extension version if installed
     */
    protected function requiresRdKafkaExtensionVersion(string $operator, string $version): void
    {
        $runtimeVersion = phpversion('rdkafka');
        if ($runtimeVersion === false) {
            return;
        }

        if (version_compare($runtimeVersion, $version, $operator) === false) {
            $this->markTestSkipped(
                sprintf(
                    'Requires rdkafka extension %s %s. Current version is %s.',
                    $operator,
                    $version,
                    $runtimeVersion
                )
            );
        }
    }
}
