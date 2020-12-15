<?php

declare(strict_types=1);

namespace RdKafka;

use RdKafka;
use RdKafka\FFI\Library;

class Producer extends RdKafka
{
    /**
     * @throws Exception
     */
    public function __construct(?Conf $conf = null)
    {
        parent::__construct(RD_KAFKA_PRODUCER, $conf);
    }

    public function addBrokers(string $broker_list): int
    {
        return Library::rd_kafka_brokers_add($this->kafka, $broker_list);
    }

    public function poll(int $timeout_ms): int
    {
        return parent::poll($timeout_ms);
    }

    /**
     * @throws Exception
     */
    public function newTopic(string $topic_name, ?TopicConf $topic_conf = null): ProducerTopic
    {
        return new ProducerTopic($this, $topic_name, $topic_conf);
    }

    public function getOutQLen(): int
    {
        return parent::getOutQLen();
    }

    public function purge(int $purge_flags): int
    {
        return (int) Library::rd_kafka_purge($this->kafka, $purge_flags);
    }

    public function flush(int $timeout_ms): int
    {
        return (int) Library::rd_kafka_flush($this->kafka, $timeout_ms);
    }

    /**
     * Initializing transactions must be done before producing and starting a transaction
     */
    public function initTransactions(int $timeout_ms): void
    {
        $error = Library::rd_kafka_init_transactions($this->kafka, $timeout_ms);

        if ($error !== null) {
            throw KafkaErrorException::fromCData($error);
        }
    }

    public function beginTransaction(): void
    {
        $error = Library::rd_kafka_begin_transaction($this->kafka);

        if ($error !== null) {
            throw KafkaErrorException::fromCData($error);
        }
    }

    public function commitTransaction(int $timeout_ms): void
    {
        $error = Library::rd_kafka_commit_transaction($this->kafka, $timeout_ms);

        if ($error !== null) {
            throw KafkaErrorException::fromCData($error);
        }
    }

    public function abortTransaction(int $timeout_ms): void
    {
        $error = Library::rd_kafka_abort_transaction($this->kafka, $timeout_ms);

        if ($error !== null) {
            throw KafkaErrorException::fromCData($error);
        }
    }
}
