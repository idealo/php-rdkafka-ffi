<?php

declare(strict_types=1);

namespace RdKafka\Test;

use FFI\CData;
use RdKafka;
use RdKafka\Conf;
use RdKafka\FFI\Library;
use RdKafka\Producer;

/**
 * Note: MockCluster is experimental - even in librdkafka!
 * Expect breaking changes within minor versions of this library.
 *
 * @since 1.3.0 of librdkafka
 */
class MockCluster
{
    private Producer $producer;
    private ?CData $cluster;
    private bool $isDerived;

    private function __construct(Producer $producer, CData $cluster)
    {
        $this->producer = $producer;
        $this->cluster = $cluster;
    }

    public function __destruct()
    {
        if ($this->isDerived === false) {
            Library::rd_kafka_mock_cluster_destroy($this->cluster);
            $this->producer->flush(0);
        }
    }

    public static function create(int $brokerCount, ?Conf $conf = null): self
    {
        Library::requireVersion('>=', '1.3.0');

        if ($brokerCount < 1) {
            throw new \InvalidArgumentException(
                sprintf('Invalid value %s for brokerCount. Must be 1 or greater', $brokerCount)
            );
        }

        $producer = new Producer($conf);
        $cluster = Library::rd_kafka_mock_cluster_new($producer->getCData(), $brokerCount);

        $instance = new static($producer, $cluster);
        $instance->isDerived = false;
        return $instance;
    }

    /**
     * Derive mock cluster from Producer created by setting
     * the `test.mock.num.brokers` configuration property.
     *
     * @throws RdKafka\Exception
     * @since 1.4.0 of librdkafka
     */
    public static function fromProducer(Producer $producer): self
    {
        Library::requireVersion('>=', '1.4.0');

        $cluster = Library::rd_kafka_handle_mock_cluster($producer->getCData());
        if ($cluster === null) {
            throw new RdKafka\Exception(
                'Mock cluster instance not found. The instance must be created by setting the `test.mock.num.brokers` configuration property'
            );
        }

        $instance = new static($producer, $cluster);
        $instance->isDerived = true;
        return $instance;
    }

    /**
     * @return string the mock cluster's bootstrap.servers list
     */
    public function getBootstraps(): string
    {
        return Library::rd_kafka_mock_cluster_bootstraps($this->cluster);
    }

    /**
     * Push cnt errors onto the cluster's error stack for the given apiKey.
     *
     * ApiKey is the Kafka protocol request type, e.g., Produce (0).
     *
     * The following cnt protocol requests matching apiKey will fail with the
     * provided error code and removed from the stack, starting with
     * the first error code, then the second, etc.
     *
     * @since 1.3.0 of librdkafka
     * @since 1.4.0 of librdkafka - adds support for Produce request types
     * @since 1.7.0 of librdkafka - you may also use {@link MockCluster::pushRequestErrorsArray()}
     */
    public function pushRequestErrors(int $apiKey, int $count, int ...$errorCodes): void
    {
        Library::rd_kafka_mock_push_request_errors($this->cluster, $apiKey, $count, ...$errorCodes);
    }

    /**
     * See {@link MockCluster::pushRequestErrors()}
     *
     * @param int[] $errorCodes
     * @since 1.7.0 of librdkafka
     */
    public function pushRequestErrorsArray(int $apiKey, int $count, array $errorCodes): void
    {
        Library::requireVersion('>=', '1.7.0');

        $errorCodesNative = Library::new('rd_kafka_resp_err_t[' . count($errorCodes) . ']', false, true);
        foreach ($errorCodes as $i => $errorCode) {
            $errorCodesNative[$i] = $errorCode;
        }
        $errorCodesPointer = Library::cast('rd_kafka_resp_err_t*', $errorCodesNative);

        Library::rd_kafka_mock_push_request_errors_array($this->cluster, $apiKey, $count, $errorCodesPointer);
    }

    /**
     * Set the topic error to return in protocol requests.
     *
     * Currently only used for TopicMetadataRequest and AddPartitionsToTxnRequest.
     */
    public function setTopicError(string $topic, int $errorCode): void
    {
        Library::rd_kafka_mock_topic_set_error($this->cluster, $topic, $errorCode);
    }

    /**
     * Creates a topic.
     *
     * This is an alternative to automatic topic creation as performed by
     * the client itself.
     * The Topic Admin API (CreateTopics) is not supported by the
     * mock broker.
     *
     * @since 1.4.0 of librdkafka
     */
    public function createTopic(string $topic, int $partitionCount, int $replicationFactor): void
    {
        Library::requireVersion('>=', '1.4.0');

        $errorCode = Library::rd_kafka_mock_topic_create($this->cluster, $topic, $partitionCount, $replicationFactor);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Sets the partition leader.
     * The topic will be created if it does not exist.
     *
     * @param int $brokerId needs to be an existing broker
     * @throws RdKafka\Exception
     */
    public function setPartitionLeader(string $topic, int $partition, int $brokerId): void
    {
        $errorCode = Library::rd_kafka_mock_partition_set_leader($this->cluster, $topic, $partition, $brokerId);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Sets the partition's preferred replica / follower.
     * The topic will be created if it does not exist.
     *
     * @param int $brokerId does not need to point to an existing broker.
     * @throws RdKafka\Exception
     */
    public function setPartitionFollower(string $topic, int $partition, int $brokerId): void
    {
        $errorCode = Library::rd_kafka_mock_partition_set_follower($this->cluster, $topic, $partition, $brokerId);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Sets the partition's preferred replica / follower low and high watermarks.
     *
     * The topic will be created if it does not exist.
     * Setting an offset to -1 will revert back to the leader's corresponding watermark.
     *
     * @throws RdKafka\Exception
     */
    public function setPartitionFollowerWatermarks(string $topic, int $partition, int $low, int $high): void
    {
        $errorCode = Library::rd_kafka_mock_partition_set_follower_wmarks(
            $this->cluster,
            $topic,
            $partition,
            $low,
            $high
        );
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Disconnects the broker and disallows any new connections.
     * This does NOT trigger leader change.
     *
     * @throws RdKafka\Exception
     * @since 1.4.0 of librdkafka
     */
    public function setBrokerDown(int $brokerId): void
    {
        Library::requireVersion('>=', '1.4.0');

        $errorCode = Library::rd_kafka_mock_broker_set_down($this->cluster, $brokerId);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Makes the broker accept connections again.
     * This does NOT trigger leader change.
     *
     * @throws RdKafka\Exception
     * @since 1.4.0 of librdkafka
     */
    public function setBrokerUp(int $brokerId): void
    {
        Library::requireVersion('>=', '1.4.0');

        $errorCode = Library::rd_kafka_mock_broker_set_up($this->cluster, $brokerId);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Sets the broker's rack as reported in Metadata to the client.
     *
     * @throws RdKafka\Exception
     */
    public function setBrokerRack(int $brokerId, string $rack): void
    {
        $errorCode = Library::rd_kafka_mock_broker_set_rack($this->cluster, $brokerId, $rack);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Explicitly sets the coordinator.
     *
     * If this API is not a standard hashing scheme will be used.
     *
     * @param string $keyType "transaction" or "group"
     * @param string $key The transactional.id or group.id
     * @param int $brokerId The new coordinator, does not have to be a valid broker.
     * @throws RdKafka\Exception
     * @since 1.4.0 of librdkafka
     */
    public function setCoordinator(string $keyType, string $key, int $brokerId): void
    {
        Library::requireVersion('>=', '1.4.0');

        $errorCode = Library::rd_kafka_mock_coordinator_set($this->cluster, $keyType, $key, $brokerId);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Set the allowed ApiVersion range for apiKey.
     *
     * Set minVersion and maxVersion to -1 to disable the API completely.
     * MaxVersion MUST not exceed the maximum implemented value.
     *
     * @param int $apiKey Protocol request type/key
     * @param int $minVersion Minimum version supported (or -1 to disable).
     * @param int $maxVersion Maximum version supported (or -1 to disable).
     * @throws RdKafka\Exception
     * @since 1.4.0 of librdkafka
     */
    public function setApiVersion(int $apiKey, int $minVersion, int $maxVersion): void
    {
        Library::requireVersion('>=', '1.4.0');

        $errorCode = Library::rd_kafka_mock_set_apiversion($this->cluster, $apiKey, $minVersion, $maxVersion);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Set broker round-trip-time delay in milliseconds.
     *
     * @throws RdKafka\Exception
     * @since 1.4.4 of librdkafka
     */
    public function setRtt(int $brokerId, int $roundTripTimeDelayMs): void
    {
        Library::requireVersion('>=', '1.4.4');

        $errorCode = Library::rd_kafka_mock_broker_set_rtt($this->cluster, $brokerId, $roundTripTimeDelayMs);
        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Same as {@link MockCluster::pushRequestErrors()} but for a specific broker.
     * The broker errors take precedence over the cluster errors.
     *
     * @param int[] $errorCodes a list of error codes or 0
     * @throws RdKafka\Exception
     * @since 1.5.0 of librdkafka
     * @removed 1.7.0 of librdkafka - use {@link MockCluster::pushBrokerRequestErrorRtts()}
     */
    public function pushBrokerRequestErrors(int $brokerId, int $apiKey, int $count, int ...$errorCodes): void
    {
        Library::requireVersion('>=', '1.5.0');
        Library::requireVersion('<', '1.7.0');

        $errorCode = Library::rd_kafka_mock_broker_push_request_errors(
            $this->cluster,
            $brokerId,
            $apiKey,
            $count,
            ...$errorCodes
        );

        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }

    /**
     * Same as {@link MockCluster::pushBrokerRequestErrors()} but for a specific broker.
     * The broker errors take precedence over the cluster errors.
     *
     * @param int[] $errorCodeAndRttTuples plain tuples of error code or 0 (int) and response RTT/delay in millisecond (int)
     * @throws RdKafka\Exception
     * @since 1.7.0 of librdkafka
     */
    public function pushBrokerRequestErrorRtts(int $brokerId, int $apiKey, int $count, int ...$errorCodeAndRttTuples): void
    {
        Library::requireVersion('>=', '1.7.0');

        $errorCode = Library::rd_kafka_mock_broker_push_request_error_rtts(
            $this->cluster,
            $brokerId,
            $apiKey,
            $count,
            ...$errorCodeAndRttTuples
        );

        if ($errorCode !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            throw RdKafka\Exception::fromError($errorCode);
        }
    }
}
