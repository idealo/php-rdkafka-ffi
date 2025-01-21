<?php

declare(strict_types=1);

use RdKafka\ConsumerTopic;
use RdKafka\KafkaConsumer;
use RdKafka\Queue;

trait ConsumeTrait
{
    public static $MAX_CONSUME_TIMEOUT_MS = 30_000;

    protected function consumeMessages(
        Closure $consumeCallback,
        int $numberOfMessages,
        bool $continueOnNull = false
    ): array {
        $messages = [];
        $time = time();
        do {
            if (time() - $time > self::$MAX_CONSUME_TIMEOUT_MS) {
                $this->fail(sprintf('Consume Kafka Message timeout %s ms exceeded', self::$MAX_CONSUME_TIMEOUT_MS));
            }
            $message = $consumeCallback();
            if ($message === null) {
                if ($continueOnNull) {
                    continue;
                }
                break;
            }
            if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
                break;
            }
            $messages[] = $message;
        } while (count($messages) < $numberOfMessages);

        return $messages;
    }

    protected function consumeMessagesWitQueue(
        Queue $queue,
        int $numberOfMessages,
        int $timeoutMs = KAFKA_TEST_SHORT_TIMEOUT_MS
    ): array {
        return $this->consumeMessages(
            function () use ($queue, $timeoutMs) {
                return $queue->consume($timeoutMs);
            },
            $numberOfMessages
        );
    }

    protected function consumeMessagesWithConsumerTopic(
        ConsumerTopic $topic,
        int $partition,
        int $numberOfMessages,
        int $timeoutMs = KAFKA_TEST_SHORT_TIMEOUT_MS
    ): array {
        return $this->consumeMessages(
            function () use ($topic, $partition, $timeoutMs) {
                return $topic->consume($partition, $timeoutMs);
            },
            $numberOfMessages,
            true
        );
    }

    protected function consumeMessagesWithKafkaConsumer(
        KafkaConsumer $consumer,
        int $numberOfMessages,
        int $timeoutMs = KAFKA_TEST_SHORT_TIMEOUT_MS
    ): array {
        return $this->consumeMessages(
            function () use ($consumer, $timeoutMs) {
                return $consumer->consume($timeoutMs);
            },
            $numberOfMessages
        );
    }
}
