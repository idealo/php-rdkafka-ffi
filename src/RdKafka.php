<?php

declare(strict_types=1);

use FFI\CData;
use RdKafka\Conf;
use RdKafka\Exception;
use RdKafka\FFI\Api;
use RdKafka\Metadata;
use RdKafka\Topic;

abstract class RdKafka extends Api
{
    protected ?CData $kafka;

    /**
     * @var WeakReference[]
     */
    private static array $instances = [];

    public static function resolveFromCData(?CData $kafka = null): ?self
    {
        if ($kafka === null) {
            return null;
        }

        foreach (self::$instances as $reference) {
            /** @var self $instance */
            $instance = $reference->get();
            if ($instance !== null && $kafka == $instance->getCData()) {
                return $instance;
            }
        }

        return null;
    }

    public function __construct(int $type, ?Conf $conf = null)
    {
        $errstr = FFI::new('char[512]');

        $this->kafka = self::getFFI()->rd_kafka_new(
            $type,
            $this->duplicateConfCData($conf),
            $errstr,
            FFI::sizeOf($errstr)
        );

        if ($this->kafka === null) {
            throw new Exception(FFI::string($errstr));
        }

        $this->initLogQueue($conf);

        self::$instances[] = WeakReference::create($this);
    }

    private function duplicateConfCData(?Conf $conf = null): ?CData
    {
        if ($conf === null) {
            return null;
        }

        return self::getFFI()->rd_kafka_conf_dup($conf->getCData());
    }

    private function initLogQueue(?Conf $conf): void
    {
        if ($conf === null || $conf->get('log.queue') !== 'true') {
            return;
        }

        $err = self::getFFI()->rd_kafka_set_log_queue($this->kafka, null);

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }
    }

    public function __destruct()
    {
        if ($this->kafka === null) {
            return;
        }

        self::getFFI()->rd_kafka_destroy($this->kafka);

        // clean up reference
        foreach (self::$instances as $i => $reference) {
            $instance = $reference->get();
            if ($instance === null || $instance === $this) {
                unset(self::$instances[$i]);
                continue;
            }
        }
    }

    public function getCData(): CData
    {
        return $this->kafka;
    }

    /**
     * @throws Exception
     */
    public function getMetadata(bool $all_topics, ?Topic $only_topic, int $timeout_ms): Metadata
    {
        return new Metadata($this, $all_topics, $only_topic, $timeout_ms);
    }

    /**
     * @return int Number of triggered events
     */
    protected function poll(int $timeout_ms): int
    {
        return self::getFFI()->rd_kafka_poll($this->kafka, $timeout_ms);
    }

    protected function getOutQLen(): int
    {
        return self::getFFI()->rd_kafka_outq_len($this->kafka);
    }

    /**
     * @deprecated Set via Conf parameter log_level instead
     */
    public function setLogLevel(int $level): void
    {
        self::getFFI()->rd_kafka_set_log_level($this->kafka, $level);
    }

    /**
     * @throws \Exception
     * @deprecated Use Conf::setLogCb instead
     */
    public function setLogger(int $logger): void
    {
        throw new \Exception('Not implemented');
    }

    public function queryWatermarkOffsets(string $topic, int $partition, int &$low, int &$high, int $timeout_ms): void
    {
        $lowResult = FFI::new('int64_t');
        $highResult = FFI::new('int64_t');

        $err = self::getFFI()->rd_kafka_query_watermark_offsets(
            $this->kafka,
            $topic,
            $partition,
            FFI::addr($lowResult),
            FFI::addr($highResult),
            $timeout_ms
        );

        if ($err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw new Exception(self::err2str($err));
        }

        $low = (int) $lowResult->cdata;
        $high = (int) $highResult->cdata;
    }
}
