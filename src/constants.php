<?php
/**
 * This file is generated! Do not edit directly.
 *
 * Description of librdkafka methods and constants is extracted from the official documentation.
 * @link https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
 */

declare(strict_types=1);

// rdkafka ext constants
const RD_KAFKA_LOG_PRINT = 100;
const RD_KAFKA_LOG_SYSLOG = 101;
const RD_KAFKA_LOG_SYSLOG_PRINT = 102;
const RD_KAFKA_MSG_PARTITIONER_RANDOM = 2;
const RD_KAFKA_MSG_PARTITIONER_CONSISTENT = 3;
const RD_KAFKA_MSG_PARTITIONER_CONSISTENT_RANDOM = 4;
const RD_KAFKA_MSG_PARTITIONER_MURMUR2 = 5;
const RD_KAFKA_MSG_PARTITIONER_MURMUR2_RANDOM = 6;
const RD_KAFKA_MSG_PARTITIONER_FNV1A = 7;
const RD_KAFKA_MSG_PARTITIONER_FNV1A_RANDOM = 8;

// librdkafka overall constants
/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_DESTROY_F_NO_CONSUMER_CLOSE = 8;

/**
 * <p>Unassigned partition. </p>
 * <p>The unassigned partition is used by the producer API for messages that should be partitioned using the configured or default partitioner. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a3002d1858385de283ea004893e352863
 */
const RD_KAFKA_PARTITION_UA = -1;

/**
 * <p>Start consuming from beginning of kafka partition queue: oldest msg </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a32dc6dd93c16e3aac9b89804c4817fba
 */
const RD_KAFKA_OFFSET_BEGINNING = -2;

/**
 * <p>Start consuming from end of kafka partition queue: next msg </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#aa7aaaf16e5bd7c0a8a8cb014275c3e06
 */
const RD_KAFKA_OFFSET_END = -1;

/**
 * <p>Start consuming from offset retrieved from offset store </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a727dc7080140da43adbd5d0b170d49be
 */
const RD_KAFKA_OFFSET_STORED = -1000;

/**
 * <p>Invalid offset </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#ac2e48c4fef9e959ab43cad60ade84af1
 */
const RD_KAFKA_OFFSET_INVALID = -1001;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_OFFSET_TAIL_BASE = -2000;

/**
 * <p>Producer message flags. </p>
 * <p>Delegate freeing of payload to rdkafka. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a21be13f8a4cb1d5aff01419f333e5ea7
 */
const RD_KAFKA_MSG_F_FREE = 1;

/**
 * <p>rdkafka will make a copy of the payload. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#ad7468ab0ece73cc9cb6253a3dcfe702d
 */
const RD_KAFKA_MSG_F_COPY = 2;

/**
 * <p>Block produce*() on message queue full. WARNING: If a delivery report callback is used the application MUST call rd_kafka_poll() (or equiv.) to make sure delivered messages are drained from the internal delivery report queue. Failure to do so will result in indefinately blocking on the produce() call when the message queue is full. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#aca3cdf1c55668f4aa1c2391ddd39c9c2
 */
const RD_KAFKA_MSG_F_BLOCK = 4;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_F_PARTITION = 8;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PURGE_F_QUEUE = 1;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PURGE_F_INFLIGHT = 2;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PURGE_F_NON_BLOCKING = 4;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_NONE = 0;

/**
 * <p>Producer Delivery report batch </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#abfe880d05ff52138b26dbe8b8e0d2132
 */
const RD_KAFKA_EVENT_DR = 1;

/**
 * <p>Fetched message (consumer) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#acfddfd9f3d49591dcd9e7f323dbcd865
 */
const RD_KAFKA_EVENT_FETCH = 2;

/**
 * <p>Log message </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a6265a9eeee57e83eb9f3bbd33d92700f
 */
const RD_KAFKA_EVENT_LOG = 4;

/**
 * <p>Error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a080a7ad60de643f47424031ee95da103
 */
const RD_KAFKA_EVENT_ERROR = 8;

/**
 * <p>Group rebalance (consumer) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a271e6a5984932015585dd5248535aa2b
 */
const RD_KAFKA_EVENT_REBALANCE = 16;

/**
 * <p>Offset commit result </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a73a29f22b22433a93253a5f77c866437
 */
const RD_KAFKA_EVENT_OFFSET_COMMIT = 32;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_STATS = 64;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_CREATETOPICS_RESULT = 100;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_DELETETOPICS_RESULT = 101;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_CREATEPARTITIONS_RESULT = 102;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_ALTERCONFIGS_RESULT = 103;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_DESCRIBECONFIGS_RESULT = 104;

/**
 * <p>Producer client </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#ac6f9c3cb01cbaf3013689c4f2731b831
 */
const RD_KAFKA_PRODUCER = 0;

/**
 * <p>Consumer client </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#ac6f9c3cb01cbaf3013689c4f2731b831
 */
const RD_KAFKA_CONSUMER = 1;

/**
 * <p>Timestamp not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#af7cb459a230a61489234823da2beb3f3
 */
const RD_KAFKA_TIMESTAMP_NOT_AVAILABLE = 0;

/**
 * <p>Message creation time </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#af7cb459a230a61489234823da2beb3f3
 */
const RD_KAFKA_TIMESTAMP_CREATE_TIME = 1;

/**
 * <p>Log append time </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#af7cb459a230a61489234823da2beb3f3
 */
const RD_KAFKA_TIMESTAMP_LOG_APPEND_TIME = 2;

/**
 * <p>Begin internal error codes </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__BEGIN = -200;

/**
 * <p>Received message is incorrect </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__BAD_MSG = -199;

/**
 * <p>Bad/unknown compression </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__BAD_COMPRESSION = -198;

/**
 * <p>Broker is going away </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__DESTROY = -197;

/**
 * <p>Generic failure </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__FAIL = -196;

/**
 * <p>Broker transport failure </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__TRANSPORT = -195;

/**
 * <p>Critical system resource </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__CRIT_SYS_RESOURCE = -194;

/**
 * <p>Failed to resolve broker </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__RESOLVE = -193;

/**
 * <p>Produced message timed out </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__MSG_TIMED_OUT = -192;

/**
 * <p>Reached the end of the topic+partition queue on the broker. Not really an error. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__PARTITION_EOF = -191;

/**
 * <p>Permanent: Partition does not exist in cluster. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_PARTITION = -190;

/**
 * <p>File or filesystem error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__FS = -189;

/**
 * <p>Permanent: Topic does not exist in cluster. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_TOPIC = -188;

/**
 * <p>All broker connections are down. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__ALL_BROKERS_DOWN = -187;

/**
 * <p>Invalid argument, or invalid configuration </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__INVALID_ARG = -186;

/**
 * <p>Operation timed out </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__TIMED_OUT = -185;

/**
 * <p>Queue is full </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__QUEUE_FULL = -184;

/**
 * <p>ISR count &lt; required.acks </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__ISR_INSUFF = -183;

/**
 * <p>Broker node update </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NODE_UPDATE = -182;

/**
 * <p>SSL error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__SSL = -181;

/**
 * <p>Waiting for coordinator to become available. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__WAIT_COORD = -180;

/**
 * <p>Unknown client group </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_GROUP = -179;

/**
 * <p>Operation in progress </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__IN_PROGRESS = -178;

/**
 * <p>Previous operation in progress, wait for it to finish. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__PREV_IN_PROGRESS = -177;

/**
 * <p>This operation would interfere with an existing subscription </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__EXISTING_SUBSCRIPTION = -176;

/**
 * <p>Assigned partitions (rebalance_cb) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS = -175;

/**
 * <p>Revoked partitions (rebalance_cb) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS = -174;

/**
 * <p>Conflicting use </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__CONFLICT = -173;

/**
 * <p>Wrong state </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__STATE = -172;

/**
 * <p>Unknown protocol </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_PROTOCOL = -171;

/**
 * <p>Not implemented </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NOT_IMPLEMENTED = -170;

/**
 * <p>Authentication failure </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__AUTHENTICATION = -169;

/**
 * <p>No stored offset </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NO_OFFSET = -168;

/**
 * <p>Outdated </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__OUTDATED = -167;

/**
 * <p>Timed out in queue </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__TIMED_OUT_QUEUE = -166;

/**
 * <p>Feature not supported by broker </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNSUPPORTED_FEATURE = -165;

/**
 * <p>Awaiting cache update </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__WAIT_CACHE = -164;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__INTR = -163;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__KEY_SERIALIZATION = -162;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__VALUE_SERIALIZATION = -161;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__KEY_DESERIALIZATION = -160;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__VALUE_DESERIALIZATION = -159;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PARTIAL = -158;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__READ_ONLY = -157;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__NOENT = -156;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNDERFLOW = -155;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__INVALID_TYPE = -154;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__RETRY = -153;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PURGE_QUEUE = -152;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PURGE_INFLIGHT = -151;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__FATAL = -150;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__INCONSISTENT = -149;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__GAPLESS_GUARANTEE = -148;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__MAX_POLL_EXCEEDED = -147;

/**
 * <p>End internal error codes </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__END = -100;

/**
 * <p>Unknown broker error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN = -1;

/**
 * <p>Success </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NO_ERROR = 0;

/**
 * <p>Offset out of range </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_OFFSET_OUT_OF_RANGE = 1;

/**
 * <p>Invalid message </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_MSG = 2;

/**
 * <p>Unknown topic or partition </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART = 3;

/**
 * <p>Invalid message size </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_MSG_SIZE = 4;

/**
 * <p>Leader not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_LEADER_NOT_AVAILABLE = 5;

/**
 * <p>Not leader for partition </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_LEADER_FOR_PARTITION = 6;

/**
 * <p>Request timed out </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_REQUEST_TIMED_OUT = 7;

/**
 * <p>Broker not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE = 8;

/**
 * <p>Replica not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_REPLICA_NOT_AVAILABLE = 9;

/**
 * <p>Message size too large </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_MSG_SIZE_TOO_LARGE = 10;

/**
 * <p>StaleControllerEpochCode </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_STALE_CTRL_EPOCH = 11;

/**
 * <p>Offset metadata string too large </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_OFFSET_METADATA_TOO_LARGE = 12;

/**
 * <p>Broker disconnected before response received </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NETWORK_EXCEPTION = 13;

/**
 * <p>Group coordinator load in progress </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_GROUP_LOAD_IN_PROGRESS = 14;

/**
 * <p>Group coordinator not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_GROUP_COORDINATOR_NOT_AVAILABLE = 15;

/**
 * <p>Not coordinator for group </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_COORDINATOR_FOR_GROUP = 16;

/**
 * <p>Invalid topic </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TOPIC_EXCEPTION = 17;

/**
 * <p>Message batch larger than configured server segment size </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_RECORD_LIST_TOO_LARGE = 18;

/**
 * <p>Not enough in-sync replicas </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS = 19;

/**
 * <p>Message(s) written to insufficient number of in-sync replicas </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS_AFTER_APPEND = 20;

/**
 * <p>Invalid required acks value </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REQUIRED_ACKS = 21;

/**
 * <p>Specified group generation id is not valid </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_ILLEGAL_GENERATION = 22;

/**
 * <p>Inconsistent group protocol </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INCONSISTENT_GROUP_PROTOCOL = 23;

/**
 * <p>Invalid group.id </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_GROUP_ID = 24;

/**
 * <p>Unknown member </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_MEMBER_ID = 25;

/**
 * <p>Invalid session timeout </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_SESSION_TIMEOUT = 26;

/**
 * <p>Group rebalance in progress </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_REBALANCE_IN_PROGRESS = 27;

/**
 * <p>Commit offset data size is not valid </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_COMMIT_OFFSET_SIZE = 28;

/**
 * <p>Topic authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TOPIC_AUTHORIZATION_FAILED = 29;

/**
 * <p>Group authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_GROUP_AUTHORIZATION_FAILED = 30;

/**
 * <p>Cluster authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_CLUSTER_AUTHORIZATION_FAILED = 31;

/**
 * <p>Invalid timestamp </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_TIMESTAMP = 32;

/**
 * <p>Unsupported SASL mechanism </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_SASL_MECHANISM = 33;

/**
 * <p>Illegal SASL state </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_ILLEGAL_SASL_STATE = 34;

/**
 * <p>Unuspported version </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_VERSION = 35;

/**
 * <p>Topic already exists </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS = 36;

/**
 * <p>Invalid number of partitions </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_PARTITIONS = 37;

/**
 * <p>Invalid replication factor </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REPLICATION_FACTOR = 38;

/**
 * <p>Invalid replica assignment </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REPLICA_ASSIGNMENT = 39;

/**
 * <p>Invalid config </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_CONFIG = 40;

/**
 * <p>Not controller for cluster </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_CONTROLLER = 41;

/**
 * <p>Invalid request </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REQUEST = 42;

/**
 * <p>Message format on broker does not support request </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_FOR_MESSAGE_FORMAT = 43;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_POLICY_VIOLATION = 44;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OUT_OF_ORDER_SEQUENCE_NUMBER = 45;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DUPLICATE_SEQUENCE_NUMBER = 46;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_PRODUCER_EPOCH = 47;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_TXN_STATE = 48;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_PRODUCER_ID_MAPPING = 49;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_TRANSACTION_TIMEOUT = 50;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_CONCURRENT_TRANSACTIONS = 51;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TRANSACTION_COORDINATOR_FENCED = 52;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TRANSACTIONAL_ID_AUTHORIZATION_FAILED = 53;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_SECURITY_DISABLED = 54;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OPERATION_NOT_ATTEMPTED = 55;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_KAFKA_STORAGE_ERROR = 56;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_LOG_DIR_NOT_FOUND = 57;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_SASL_AUTHENTICATION_FAILED = 58;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_PRODUCER_ID = 59;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_REASSIGNMENT_IN_PROGRESS = 60;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTH_DISABLED = 61;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_NOT_FOUND = 62;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_OWNER_MISMATCH = 63;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_REQUEST_NOT_ALLOWED = 64;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTHORIZATION_FAILED = 65;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_EXPIRED = 66;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_PRINCIPAL_TYPE = 67;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NON_EMPTY_GROUP = 68;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_ID_NOT_FOUND = 69;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_FETCH_SESSION_ID_NOT_FOUND = 70;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_FETCH_SESSION_EPOCH = 71;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_LISTENER_NOT_FOUND = 72;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TOPIC_DELETION_DISABLED = 73;

/**
 * <p>va-arg sentinel </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a03c74ceba678b4e7a624310160a02165
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_END = 0;

/**
 * <p>(const char *) Topic name </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_TOPIC = 1;

/**
 * <p>(rd_kafka_topic_t *) Topic handle </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_RKT = 2;

/**
 * <p>(int32_t) Partition </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_PARTITION = 3;

/**
 * <p>(void *, size_t) Message value (payload) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_VALUE = 4;

/**
 * <p>(void *, size_t) Message key </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_KEY = 5;

/**
 * <p>(void *) Application opaque </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_OPAQUE = 6;

/**
 * <p>(int) RD_KAFKA_MSG_F_.. flags </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_MSGFLAGS = 7;

/**
 * <p>(int64_t) Milliseconds since epoch UTC </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_TIMESTAMP = 8;

/**
 * enum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_HEADER = 9;

/**
 * enum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_HEADERS = 10;

/**
 * enum rd_kafka_msg_status_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_STATUS_NOT_PERSISTED = 0;

/**
 * enum rd_kafka_msg_status_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_STATUS_POSSIBLY_PERSISTED = 1;

/**
 * enum rd_kafka_msg_status_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_STATUS_PERSISTED = 2;

/**
 * <p>Unknown configuration name. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#ad8306a08e59e8e2cbc6abdb84f9689f4
 */
const RD_KAFKA_CONF_UNKNOWN = -2;

/**
 * <p>Invalid configuration value. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#ad8306a08e59e8e2cbc6abdb84f9689f4
 */
const RD_KAFKA_CONF_INVALID = -1;

/**
 * <p>Configuration okay </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html#ad8306a08e59e8e2cbc6abdb84f9689f4
 */
const RD_KAFKA_CONF_OK = 0;

/**
 * enum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_ANY = 0;

/**
 * enum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_CREATETOPICS = 1;

/**
 * enum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_DELETETOPICS = 2;

/**
 * enum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_CREATEPARTITIONS = 3;

/**
 * enum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_ALTERCONFIGS = 4;

/**
 * enum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_DESCRIBECONFIGS = 5;

/**
 * enum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP__CNT = 6;

/**
 * enum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_UNKNOWN_CONFIG = 0;

/**
 * enum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_TOPIC_CONFIG = 1;

/**
 * enum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_BROKER_CONFIG = 2;

/**
 * enum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_DEFAULT_BROKER_CONFIG = 3;

/**
 * enum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_STATIC_BROKER_CONFIG = 4;

/**
 * enum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DEFAULT_CONFIG = 5;

/**
 * enum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE__CNT = 6;

/**
 * enum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_UNKNOWN = 0;

/**
 * enum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_ANY = 1;

/**
 * enum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_TOPIC = 2;

/**
 * enum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_GROUP = 3;

/**
 * enum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_BROKER = 4;

/**
 * enum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE__CNT = 5;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_FENCED_LEADER_EPOCH = 74;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_LEADER_EPOCH = 75;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_STALE_BROKER_EPOCH = 77;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OFFSET_NOT_AVAILABLE = 78;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_MEMBER_ID_REQUIRED = 79;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_PREFERRED_LEADER_NOT_AVAILABLE = 80;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_MAX_SIZE_REACHED = 81;

/**
 * define
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_EVENT_OAUTHBEARER_TOKEN_REFRESH = 256;

/**
 * enum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_PUBLIC_KEY = 0;

/**
 * enum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_PRIVATE_KEY = 1;

/**
 * enum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_CA = 2;

/**
 * enum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT__CNT = 3;

/**
 * enum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC_PKCS12 = 0;

/**
 * enum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC_DER = 1;

/**
 * enum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC_PEM = 2;

/**
 * enum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC__CNT = 3;

/**
 * enum rd_kafka_thread_type_t
 * @since 1.2.0 of librdkafka
 */
const RD_KAFKA_THREAD_MAIN = 0;

/**
 * enum rd_kafka_thread_type_t
 * @since 1.2.0 of librdkafka
 */
const RD_KAFKA_THREAD_BACKGROUND = 1;

/**
 * enum rd_kafka_thread_type_t
 * @since 1.2.0 of librdkafka
 */
const RD_KAFKA_THREAD_BROKER = 2;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_BROKER = -146;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_COORDINATOR_LOAD_IN_PROGRESS = 14;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_COORDINATOR_NOT_AVAILABLE = 15;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NOT_COORDINATOR = 16;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__NOT_CONFIGURED = -145;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__FENCED = -144;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__APPLICATION = -143;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_FENCED_INSTANCE_ID = 82;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.5.2 of librdkafka
 */
const RD_KAFKA_RESP_ERR_ELIGIBLE_LEADERS_NOT_AVAILABLE = 83;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.5.2 of librdkafka
 */
const RD_KAFKA_RESP_ERR_ELECTION_NOT_NEEDED = 84;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.5.2 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NO_REASSIGNMENT_IN_PROGRESS = 85;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.5.2 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_SUBSCRIBED_TO_TOPIC = 86;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.5.2 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_RECORD = 87;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.5.2 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNSTABLE_OFFSET_COMMIT = 88;

const RD_KAFKA_SUPPORTED_METHODS = [
    'rd_kafka_version' => '1.0.0',
    'rd_kafka_version_str' => '1.0.0',
    'rd_kafka_get_debug_contexts' => '1.0.0',
    'rd_kafka_get_err_descs' => '1.0.0',
    'rd_kafka_err2str' => '1.0.0',
    'rd_kafka_err2name' => '1.0.0',
    'rd_kafka_last_error' => '1.0.0',
    'rd_kafka_errno2err' => '1.0.0',
    'rd_kafka_errno' => '1.0.0',
    'rd_kafka_fatal_error' => '1.0.0',
    'rd_kafka_test_fatal_error' => '1.0.0',
    'rd_kafka_topic_partition_destroy' => '1.0.0',
    'rd_kafka_topic_partition_list_new' => '1.0.0',
    'rd_kafka_topic_partition_list_destroy' => '1.0.0',
    'rd_kafka_topic_partition_list_add' => '1.0.0',
    'rd_kafka_topic_partition_list_add_range' => '1.0.0',
    'rd_kafka_topic_partition_list_del' => '1.0.0',
    'rd_kafka_topic_partition_list_del_by_idx' => '1.0.0',
    'rd_kafka_topic_partition_list_copy' => '1.0.0',
    'rd_kafka_topic_partition_list_set_offset' => '1.0.0',
    'rd_kafka_topic_partition_list_find' => '1.0.0',
    'rd_kafka_topic_partition_list_sort' => '1.0.0',
    'rd_kafka_headers_new' => '1.0.0',
    'rd_kafka_headers_destroy' => '1.0.0',
    'rd_kafka_headers_copy' => '1.0.0',
    'rd_kafka_header_add' => '1.0.0',
    'rd_kafka_header_remove' => '1.0.0',
    'rd_kafka_header_get_last' => '1.0.0',
    'rd_kafka_header_get' => '1.0.0',
    'rd_kafka_header_get_all' => '1.0.0',
    'rd_kafka_message_destroy' => '1.0.0',
    'rd_kafka_message_timestamp' => '1.0.0',
    'rd_kafka_message_latency' => '1.0.0',
    'rd_kafka_message_headers' => '1.0.0',
    'rd_kafka_message_detach_headers' => '1.0.0',
    'rd_kafka_message_set_headers' => '1.0.0',
    'rd_kafka_header_cnt' => '1.0.0',
    'rd_kafka_message_status' => '1.0.0',
    'rd_kafka_conf_new' => '1.0.0',
    'rd_kafka_conf_destroy' => '1.0.0',
    'rd_kafka_conf_dup' => '1.0.0',
    'rd_kafka_conf_dup_filter' => '1.0.0',
    'rd_kafka_conf_set' => '1.0.0',
    'rd_kafka_conf_set_events' => '1.0.0',
    'rd_kafka_conf_set_background_event_cb' => '1.0.0',
    'rd_kafka_conf_set_dr_cb' => '1.0.0',
    'rd_kafka_conf_set_dr_msg_cb' => '1.0.0',
    'rd_kafka_conf_set_consume_cb' => '1.0.0',
    'rd_kafka_conf_set_rebalance_cb' => '1.0.0',
    'rd_kafka_conf_set_offset_commit_cb' => '1.0.0',
    'rd_kafka_conf_set_error_cb' => '1.0.0',
    'rd_kafka_conf_set_throttle_cb' => '1.0.0',
    'rd_kafka_conf_set_log_cb' => '1.0.0',
    'rd_kafka_conf_set_stats_cb' => '1.0.0',
    'rd_kafka_conf_set_socket_cb' => '1.0.0',
    'rd_kafka_conf_set_connect_cb' => '1.0.0',
    'rd_kafka_conf_set_closesocket_cb' => '1.0.0',
    'rd_kafka_conf_set_opaque' => '1.0.0',
    'rd_kafka_opaque' => '1.0.0',
    'rd_kafka_conf_set_default_topic_conf' => '1.0.0',
    'rd_kafka_conf_get' => '1.0.0',
    'rd_kafka_topic_conf_get' => '1.0.0',
    'rd_kafka_conf_dump' => '1.0.0',
    'rd_kafka_topic_conf_dump' => '1.0.0',
    'rd_kafka_conf_dump_free' => '1.0.0',
    'rd_kafka_conf_properties_show' => '1.0.0',
    'rd_kafka_topic_conf_new' => '1.0.0',
    'rd_kafka_topic_conf_dup' => '1.0.0',
    'rd_kafka_default_topic_conf_dup' => '1.0.0',
    'rd_kafka_topic_conf_destroy' => '1.0.0',
    'rd_kafka_topic_conf_set' => '1.0.0',
    'rd_kafka_topic_conf_set_opaque' => '1.0.0',
    'rd_kafka_topic_conf_set_partitioner_cb' => '1.0.0',
    'rd_kafka_topic_conf_set_msg_order_cmp' => '1.0.0',
    'rd_kafka_topic_partition_available' => '1.0.0',
    'rd_kafka_msg_partitioner_random' => '1.0.0',
    'rd_kafka_msg_partitioner_consistent' => '1.0.0',
    'rd_kafka_msg_partitioner_consistent_random' => '1.0.0',
    'rd_kafka_msg_partitioner_murmur2' => '1.0.0',
    'rd_kafka_msg_partitioner_murmur2_random' => '1.0.0',
    'rd_kafka_new' => '1.0.0',
    'rd_kafka_destroy' => '1.0.0',
    'rd_kafka_destroy_flags' => '1.0.0',
    'rd_kafka_name' => '1.0.0',
    'rd_kafka_type' => '1.0.0',
    'rd_kafka_memberid' => '1.0.0',
    'rd_kafka_clusterid' => '1.0.0',
    'rd_kafka_controllerid' => '1.0.0',
    'rd_kafka_topic_new' => '1.0.0',
    'rd_kafka_topic_destroy' => '1.0.0',
    'rd_kafka_topic_name' => '1.0.0',
    'rd_kafka_topic_opaque' => '1.0.0',
    'rd_kafka_poll' => '1.0.0',
    'rd_kafka_yield' => '1.0.0',
    'rd_kafka_pause_partitions' => '1.0.0',
    'rd_kafka_resume_partitions' => '1.0.0',
    'rd_kafka_query_watermark_offsets' => '1.0.0',
    'rd_kafka_get_watermark_offsets' => '1.0.0',
    'rd_kafka_offsets_for_times' => '1.0.0',
    'rd_kafka_mem_free' => '1.0.0',
    'rd_kafka_queue_new' => '1.0.0',
    'rd_kafka_queue_destroy' => '1.0.0',
    'rd_kafka_queue_get_main' => '1.0.0',
    'rd_kafka_queue_get_consumer' => '1.0.0',
    'rd_kafka_queue_get_partition' => '1.0.0',
    'rd_kafka_queue_get_background' => '1.0.0',
    'rd_kafka_queue_forward' => '1.0.0',
    'rd_kafka_set_log_queue' => '1.0.0',
    'rd_kafka_queue_length' => '1.0.0',
    'rd_kafka_queue_io_event_enable' => '1.0.0',
    'rd_kafka_queue_cb_event_enable' => '1.0.0',
    'rd_kafka_consume_start' => '1.0.0',
    'rd_kafka_consume_start_queue' => '1.0.0',
    'rd_kafka_consume_stop' => '1.0.0',
    'rd_kafka_seek' => '1.0.0',
    'rd_kafka_consume' => '1.0.0',
    'rd_kafka_consume_batch' => '1.0.0',
    'rd_kafka_consume_callback' => '1.0.0',
    'rd_kafka_consume_queue' => '1.0.0',
    'rd_kafka_consume_batch_queue' => '1.0.0',
    'rd_kafka_consume_callback_queue' => '1.0.0',
    'rd_kafka_offset_store' => '1.0.0',
    'rd_kafka_offsets_store' => '1.0.0',
    'rd_kafka_subscribe' => '1.0.0',
    'rd_kafka_unsubscribe' => '1.0.0',
    'rd_kafka_subscription' => '1.0.0',
    'rd_kafka_consumer_poll' => '1.0.0',
    'rd_kafka_consumer_close' => '1.0.0',
    'rd_kafka_assign' => '1.0.0',
    'rd_kafka_assignment' => '1.0.0',
    'rd_kafka_commit' => '1.0.0',
    'rd_kafka_commit_message' => '1.0.0',
    'rd_kafka_commit_queue' => '1.0.0',
    'rd_kafka_committed' => '1.0.0',
    'rd_kafka_position' => '1.0.0',
    'rd_kafka_produce' => '1.0.0',
    'rd_kafka_producev' => '1.0.0',
    'rd_kafka_produce_batch' => '1.0.0',
    'rd_kafka_flush' => '1.0.0',
    'rd_kafka_purge' => '1.0.0',
    'rd_kafka_metadata' => '1.0.0',
    'rd_kafka_metadata_destroy' => '1.0.0',
    'rd_kafka_list_groups' => '1.0.0',
    'rd_kafka_group_list_destroy' => '1.0.0',
    'rd_kafka_brokers_add' => '1.0.0',
    'rd_kafka_set_logger' => '1.0.0',
    'rd_kafka_set_log_level' => '1.0.0',
    'rd_kafka_log_print' => '1.0.0',
    'rd_kafka_log_syslog' => '1.0.0',
    'rd_kafka_outq_len' => '1.0.0',
    'rd_kafka_dump' => '1.0.0',
    'rd_kafka_thread_cnt' => '1.0.0',
    'rd_kafka_wait_destroyed' => '1.0.0',
    'rd_kafka_unittest' => '1.0.0',
    'rd_kafka_poll_set_consumer' => '1.0.0',
    'rd_kafka_event_type' => '1.0.0',
    'rd_kafka_event_name' => '1.0.0',
    'rd_kafka_event_destroy' => '1.0.0',
    'rd_kafka_event_message_next' => '1.0.0',
    'rd_kafka_event_message_array' => '1.0.0',
    'rd_kafka_event_message_count' => '1.0.0',
    'rd_kafka_event_error' => '1.0.0',
    'rd_kafka_event_error_string' => '1.0.0',
    'rd_kafka_event_error_is_fatal' => '1.0.0',
    'rd_kafka_event_opaque' => '1.0.0',
    'rd_kafka_event_log' => '1.0.0',
    'rd_kafka_event_stats' => '1.0.0',
    'rd_kafka_event_topic_partition_list' => '1.0.0',
    'rd_kafka_event_topic_partition' => '1.0.0',
    'rd_kafka_event_CreateTopics_result' => '1.0.0',
    'rd_kafka_event_DeleteTopics_result' => '1.0.0',
    'rd_kafka_event_CreatePartitions_result' => '1.0.0',
    'rd_kafka_event_AlterConfigs_result' => '1.0.0',
    'rd_kafka_event_DescribeConfigs_result' => '1.0.0',
    'rd_kafka_queue_poll' => '1.0.0',
    'rd_kafka_queue_poll_callback' => '1.0.0',
    'rd_kafka_plugin_f_conf_init_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_conf_set_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_conf_dup_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_conf_destroy_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_new_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_destroy_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_send_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_acknowledgement_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_consume_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_commit_t' => '1.0.0',
    'rd_kafka_interceptor_f_on_request_sent_t' => '1.0.0',
    'rd_kafka_conf_interceptor_add_on_conf_set' => '1.0.0',
    'rd_kafka_conf_interceptor_add_on_conf_dup' => '1.0.0',
    'rd_kafka_conf_interceptor_add_on_conf_destroy' => '1.0.0',
    'rd_kafka_conf_interceptor_add_on_new' => '1.0.0',
    'rd_kafka_interceptor_add_on_destroy' => '1.0.0',
    'rd_kafka_interceptor_add_on_send' => '1.0.0',
    'rd_kafka_interceptor_add_on_acknowledgement' => '1.0.0',
    'rd_kafka_interceptor_add_on_consume' => '1.0.0',
    'rd_kafka_interceptor_add_on_commit' => '1.0.0',
    'rd_kafka_interceptor_add_on_request_sent' => '1.0.0',
    'rd_kafka_topic_result_error' => '1.0.0',
    'rd_kafka_topic_result_error_string' => '1.0.0',
    'rd_kafka_topic_result_name' => '1.0.0',
    'rd_kafka_AdminOptions_new' => '1.0.0',
    'rd_kafka_AdminOptions_destroy' => '1.0.0',
    'rd_kafka_AdminOptions_set_request_timeout' => '1.0.0',
    'rd_kafka_AdminOptions_set_operation_timeout' => '1.0.0',
    'rd_kafka_AdminOptions_set_validate_only' => '1.0.0',
    'rd_kafka_AdminOptions_set_broker' => '1.0.0',
    'rd_kafka_AdminOptions_set_opaque' => '1.0.0',
    'rd_kafka_NewTopic_new' => '1.0.0',
    'rd_kafka_NewTopic_destroy' => '1.0.0',
    'rd_kafka_NewTopic_destroy_array' => '1.0.0',
    'rd_kafka_NewTopic_set_replica_assignment' => '1.0.0',
    'rd_kafka_NewTopic_set_config' => '1.0.0',
    'rd_kafka_CreateTopics' => '1.0.0',
    'rd_kafka_CreateTopics_result_topics' => '1.0.0',
    'rd_kafka_DeleteTopic_new' => '1.0.0',
    'rd_kafka_DeleteTopic_destroy' => '1.0.0',
    'rd_kafka_DeleteTopic_destroy_array' => '1.0.0',
    'rd_kafka_DeleteTopics' => '1.0.0',
    'rd_kafka_DeleteTopics_result_topics' => '1.0.0',
    'rd_kafka_NewPartitions_new' => '1.0.0',
    'rd_kafka_NewPartitions_destroy' => '1.0.0',
    'rd_kafka_NewPartitions_destroy_array' => '1.0.0',
    'rd_kafka_NewPartitions_set_replica_assignment' => '1.0.0',
    'rd_kafka_CreatePartitions' => '1.0.0',
    'rd_kafka_CreatePartitions_result_topics' => '1.0.0',
    'rd_kafka_ConfigSource_name' => '1.0.0',
    'rd_kafka_ConfigEntry_name' => '1.0.0',
    'rd_kafka_ConfigEntry_value' => '1.0.0',
    'rd_kafka_ConfigEntry_source' => '1.0.0',
    'rd_kafka_ConfigEntry_is_read_only' => '1.0.0',
    'rd_kafka_ConfigEntry_is_default' => '1.0.0',
    'rd_kafka_ConfigEntry_is_sensitive' => '1.0.0',
    'rd_kafka_ConfigEntry_is_synonym' => '1.0.0',
    'rd_kafka_ConfigEntry_synonyms' => '1.0.0',
    'rd_kafka_ResourceType_name' => '1.0.0',
    'rd_kafka_ConfigResource_new' => '1.0.0',
    'rd_kafka_ConfigResource_destroy' => '1.0.0',
    'rd_kafka_ConfigResource_destroy_array' => '1.0.0',
    'rd_kafka_ConfigResource_set_config' => '1.0.0',
    'rd_kafka_ConfigResource_configs' => '1.0.0',
    'rd_kafka_ConfigResource_type' => '1.0.0',
    'rd_kafka_ConfigResource_name' => '1.0.0',
    'rd_kafka_ConfigResource_error' => '1.0.0',
    'rd_kafka_ConfigResource_error_string' => '1.0.0',
    'rd_kafka_AlterConfigs' => '1.0.0',
    'rd_kafka_AlterConfigs_result_resources' => '1.0.0',
    'rd_kafka_DescribeConfigs' => '1.0.0',
    'rd_kafka_DescribeConfigs_result_resources' => '1.0.0',
    'rd_kafka_conf' => '1.1.0',
    'rd_kafka_conf_set_oauthbearer_token_refresh_cb' => '1.1.0',
    'rd_kafka_conf_set_ssl_cert_verify_cb' => '1.1.0',
    'rd_kafka_conf_set_ssl_cert' => '1.1.0',
    'rd_kafka_event_config_string' => '1.1.0',
    'rd_kafka_oauthbearer_set_token' => '1.1.0',
    'rd_kafka_oauthbearer_set_token_failure' => '1.1.0',
    'rd_kafka_interceptor_f_on_thread_start_t' => '1.2.0',
    'rd_kafka_interceptor_f_on_thread_exit_t' => '1.2.0',
    'rd_kafka_interceptor_add_on_thread_start' => '1.2.0',
    'rd_kafka_interceptor_add_on_thread_exit' => '1.2.0',
    'rd_kafka_mock_cluster_new' => '1.3.0',
    'rd_kafka_mock_cluster_destroy' => '1.3.0',
    'rd_kafka_mock_cluster_handle' => '1.3.0',
    'rd_kafka_mock_cluster_bootstraps' => '1.3.0',
    'rd_kafka_mock_push_request_errors' => '1.3.0',
    'rd_kafka_mock_topic_set_error' => '1.3.0',
    'rd_kafka_mock_partition_set_leader' => '1.3.0',
    'rd_kafka_mock_partition_set_follower' => '1.3.0',
    'rd_kafka_mock_partition_set_follower_wmarks' => '1.3.0',
    'rd_kafka_mock_broker_set_rack' => '1.3.0',
    'rd_kafka_error_code' => '1.4.0',
    'rd_kafka_error_name' => '1.4.0',
    'rd_kafka_error_string' => '1.4.0',
    'rd_kafka_error_is_fatal' => '1.4.0',
    'rd_kafka_error_is_retriable' => '1.4.0',
    'rd_kafka_error_txn_requires_abort' => '1.4.0',
    'rd_kafka_error_destroy' => '1.4.0',
    'rd_kafka_error_new' => '1.4.0',
    'rd_kafka_msg_partitioner_fnv1a' => '1.4.0',
    'rd_kafka_msg_partitioner_fnv1a_random' => '1.4.0',
    'rd_kafka_consumer_group_metadata' => '1.4.0',
    'rd_kafka_consumer_group_metadata_new' => '1.4.0',
    'rd_kafka_consumer_group_metadata_destroy' => '1.4.0',
    'rd_kafka_consumer_group_metadata_write' => '1.4.0',
    'rd_kafka_consumer_group_metadata_read' => '1.4.0',
    'rd_kafka_init_transactions' => '1.4.0',
    'rd_kafka_begin_transaction' => '1.4.0',
    'rd_kafka_send_offsets_to_transaction' => '1.4.0',
    'rd_kafka_commit_transaction' => '1.4.0',
    'rd_kafka_abort_transaction' => '1.4.0',
    'rd_kafka_handle_mock_cluster' => '1.4.0',
    'rd_kafka_mock_topic_create' => '1.4.0',
    'rd_kafka_mock_broker_set_down' => '1.4.0',
    'rd_kafka_mock_broker_set_up' => '1.4.0',
    'rd_kafka_mock_coordinator_set' => '1.4.0',
    'rd_kafka_mock_set_apiversion' => '1.4.0',
    'rd_kafka_mock_broker_set_rtt' => '1.4.4',
    'rd_kafka_message_errstr' => '1.5.0',
    'rd_kafka_message_broker_id' => '1.5.0',
    'rd_kafka_produceva' => '1.5.0',
    'rd_kafka_event_debug_contexts' => '1.5.0',
    'rd_kafka_mock_broker_push_request_errors' => '1.5.0'
];
