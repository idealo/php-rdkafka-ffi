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
 * <p>Flags for rd_kafka_destroy_flags() </p>
 * <p>Don't call consumer_close() to leave group and commit final offsets.</p>
 * <p>This also disables consumer callbacks to be called from rd_kafka_destroy*(), such as rebalance_cb.</p>
 * <p>The consumer group handler is still closed internally, but from an application perspective none of the functionality from consumer_close() is performed. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#af2a79b2f2bef22e06ed9fade159f42d4
 */
const RD_KAFKA_DESTROY_F_NO_CONSUMER_CLOSE = 8;

/**
 * <p>Unassigned partition. </p>
 * <p>The unassigned partition is used by the producer API for messages that should be partitioned using the configured or default partitioner. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a3002d1858385de283ea004893e352863
 */
const RD_KAFKA_PARTITION_UA = -1;

/**
 * <p>Start consuming from beginning of \ kafka partition queue: oldest msg </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a32dc6dd93c16e3aac9b89804c4817fba
 */
const RD_KAFKA_OFFSET_BEGINNING = -2;

/**
 * <p>Start consuming from end of kafka \ partition queue: next msg </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aa7aaaf16e5bd7c0a8a8cb014275c3e06
 */
const RD_KAFKA_OFFSET_END = -1;

/**
 * <p>Start consuming from offset retrieved \ from offset store </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a727dc7080140da43adbd5d0b170d49be
 */
const RD_KAFKA_OFFSET_STORED = -1000;

/**
 * <p>Invalid offset </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ac2e48c4fef9e959ab43cad60ade84af1
 */
const RD_KAFKA_OFFSET_INVALID = -1001;

/**
 * define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_OFFSET_TAIL_BASE = -2000;

/**
 * <p>Producer message flags. </p>
 * <p>Delegate freeing of payload to rdkafka. \ </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a21be13f8a4cb1d5aff01419f333e5ea7
 */
const RD_KAFKA_MSG_F_FREE = 1;

/**
 * <p>rdkafka will make a copy of the payload. \ </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad7468ab0ece73cc9cb6253a3dcfe702d
 */
const RD_KAFKA_MSG_F_COPY = 2;

/**
 * <p>Block produce*() on message queue full. \ WARNING: If a delivery report callback \ is used the application MUST \ call rd_kafka_poll() (or equiv.) \ to make sure delivered messages \ are drained from the internal \ delivery report queue. \ Failure to do so will result \ in indefinately blocking on \ the produce() call when the \ message queue is full. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aca3cdf1c55668f4aa1c2391ddd39c9c2
 */
const RD_KAFKA_MSG_F_BLOCK = 4;

/**
 * <p>produce_batch() will honor \ per-message partition. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a991bd9378d2fc5b2102ce3a29805b345
 */
const RD_KAFKA_MSG_F_PARTITION = 8;

/**
 * <p>Flags for rd_kafka_purge() </p>
 * <p>Purge messages in internal queues. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad5bcdab21e406a23d50cdb1c68e95a34
 */
const RD_KAFKA_PURGE_F_QUEUE = 1;

/**
 * <p>Purge messages in-flight to or from the broker. Purging these messages will void any future acknowledgements from the broker, making it impossible for the application to know if these messages were successfully delivered or not. Retrying these messages may lead to duplicates. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#af232512144175a21b5bda2a1fcbe1f00
 */
const RD_KAFKA_PURGE_F_INFLIGHT = 2;

/**
 * <p>Don't wait for background thread queue purging to finish. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aef197fd7fd6dfa02d70563e359b8281f
 */
const RD_KAFKA_PURGE_F_NON_BLOCKING = 4;

/**
 * <p>Unset value </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aa2707dd1a6225e7649fd5d825284da4d
 */
const RD_KAFKA_EVENT_NONE = 0;

/**
 * <p>Producer Delivery report batch </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#abfe880d05ff52138b26dbe8b8e0d2132
 */
const RD_KAFKA_EVENT_DR = 1;

/**
 * <p>Fetched message (consumer) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acfddfd9f3d49591dcd9e7f323dbcd865
 */
const RD_KAFKA_EVENT_FETCH = 2;

/**
 * <p>Log message </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a6265a9eeee57e83eb9f3bbd33d92700f
 */
const RD_KAFKA_EVENT_LOG = 4;

/**
 * <p>Error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a080a7ad60de643f47424031ee95da103
 */
const RD_KAFKA_EVENT_ERROR = 8;

/**
 * <p>Group rebalance (consumer) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a271e6a5984932015585dd5248535aa2b
 */
const RD_KAFKA_EVENT_REBALANCE = 16;

/**
 * <p>Offset commit result </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a73a29f22b22433a93253a5f77c866437
 */
const RD_KAFKA_EVENT_OFFSET_COMMIT = 32;

/**
 * <p>Stats </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a67070a77150f54039273097c57da5965
 */
const RD_KAFKA_EVENT_STATS = 64;

/**
 * <p>CreateTopics_result_t </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ae0622aab30c391aed6c8b57d1aa5d0a8
 */
const RD_KAFKA_EVENT_CREATETOPICS_RESULT = 100;

/**
 * <p>DeleteTopics_result_t </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#af69b2889c6e9cc2ebb03c607efade311
 */
const RD_KAFKA_EVENT_DELETETOPICS_RESULT = 101;

/**
 * <p>CreatePartitions_result_t </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a82de17d7d0eb7ac80761a35695b1f971
 */
const RD_KAFKA_EVENT_CREATEPARTITIONS_RESULT = 102;

/**
 * <p>AlterConfigs_result_t </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a25ded37b0459f4207e033ead15d30909
 */
const RD_KAFKA_EVENT_ALTERCONFIGS_RESULT = 103;

/**
 * <p>DescribeConfigs_result_t </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a5918e726a9b2828c3051e48d6a747259
 */
const RD_KAFKA_EVENT_DESCRIBECONFIGS_RESULT = 104;

/**
 * <p>Producer client </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ac6f9c3cb01cbaf3013689c4f2731b831
 */
const RD_KAFKA_PRODUCER = 0;

/**
 * <p>Consumer client </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ac6f9c3cb01cbaf3013689c4f2731b831
 */
const RD_KAFKA_CONSUMER = 1;

/**
 * <p>Timestamp not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#af7cb459a230a61489234823da2beb3f3
 */
const RD_KAFKA_TIMESTAMP_NOT_AVAILABLE = 0;

/**
 * <p>Message creation time </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#af7cb459a230a61489234823da2beb3f3
 */
const RD_KAFKA_TIMESTAMP_CREATE_TIME = 1;

/**
 * <p>Log append time </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#af7cb459a230a61489234823da2beb3f3
 */
const RD_KAFKA_TIMESTAMP_LOG_APPEND_TIME = 2;

/**
 * <p>Begin internal error codes </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__BEGIN = -200;

/**
 * <p>Received message is incorrect </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__BAD_MSG = -199;

/**
 * <p>Bad/unknown compression </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__BAD_COMPRESSION = -198;

/**
 * <p>Broker is going away </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__DESTROY = -197;

/**
 * <p>Generic failure </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__FAIL = -196;

/**
 * <p>Broker transport failure </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__TRANSPORT = -195;

/**
 * <p>Critical system resource </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__CRIT_SYS_RESOURCE = -194;

/**
 * <p>Failed to resolve broker </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__RESOLVE = -193;

/**
 * <p>Produced message timed out </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__MSG_TIMED_OUT = -192;

/**
 * <p>Reached the end of the topic+partition queue on the broker. Not really an error. This event is disabled by default, see the <code>enable.partition.eof</code> configuration property. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__PARTITION_EOF = -191;

/**
 * <p>Permanent: Partition does not exist in cluster. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_PARTITION = -190;

/**
 * <p>File or filesystem error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__FS = -189;

/**
 * <p>Permanent: Topic does not exist in cluster. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_TOPIC = -188;

/**
 * <p>All broker connections are down. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__ALL_BROKERS_DOWN = -187;

/**
 * <p>Invalid argument, or invalid configuration </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__INVALID_ARG = -186;

/**
 * <p>Operation timed out </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__TIMED_OUT = -185;

/**
 * <p>Queue is full </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__QUEUE_FULL = -184;

/**
 * <p>ISR count &lt; required.acks </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__ISR_INSUFF = -183;

/**
 * <p>Broker node update </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NODE_UPDATE = -182;

/**
 * <p>SSL error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__SSL = -181;

/**
 * <p>Waiting for coordinator to become available. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__WAIT_COORD = -180;

/**
 * <p>Unknown client group </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_GROUP = -179;

/**
 * <p>Operation in progress </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__IN_PROGRESS = -178;

/**
 * <p>Previous operation in progress, wait for it to finish. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__PREV_IN_PROGRESS = -177;

/**
 * <p>This operation would interfere with an existing subscription </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__EXISTING_SUBSCRIPTION = -176;

/**
 * <p>Assigned partitions (rebalance_cb) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS = -175;

/**
 * <p>Revoked partitions (rebalance_cb) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS = -174;

/**
 * <p>Conflicting use </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__CONFLICT = -173;

/**
 * <p>Wrong state </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__STATE = -172;

/**
 * <p>Unknown protocol </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_PROTOCOL = -171;

/**
 * <p>Not implemented </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NOT_IMPLEMENTED = -170;

/**
 * <p>Authentication failure </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__AUTHENTICATION = -169;

/**
 * <p>No stored offset </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NO_OFFSET = -168;

/**
 * <p>Outdated </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__OUTDATED = -167;

/**
 * <p>Timed out in queue </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__TIMED_OUT_QUEUE = -166;

/**
 * <p>Feature not supported by broker </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNSUPPORTED_FEATURE = -165;

/**
 * <p>Awaiting cache update </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__WAIT_CACHE = -164;

/**
 * <p>Operation interrupted (e.g., due to yield)) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__INTR = -163;

/**
 * <p>Key serialization error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__KEY_SERIALIZATION = -162;

/**
 * <p>Value serialization error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__VALUE_SERIALIZATION = -161;

/**
 * <p>Key deserialization error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__KEY_DESERIALIZATION = -160;

/**
 * <p>Value deserialization error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__VALUE_DESERIALIZATION = -159;

/**
 * <p>Partial response </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__PARTIAL = -158;

/**
 * <p>Modification attempted on read-only object </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__READ_ONLY = -157;

/**
 * <p>No such entry / item not found </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NOENT = -156;

/**
 * <p>Read underflow </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNDERFLOW = -155;

/**
 * <p>Invalid type </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__INVALID_TYPE = -154;

/**
 * <p>Retry operation </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__RETRY = -153;

/**
 * <p>Purged in queue </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__PURGE_QUEUE = -152;

/**
 * <p>Purged in flight </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__PURGE_INFLIGHT = -151;

/**
 * <p>Fatal error: see rd_kafka_fatal_error() </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__FATAL = -150;

/**
 * <p>Inconsistent state </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__INCONSISTENT = -149;

/**
 * <p>Gap-less ordering would not be guaranteed if proceeding </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__GAPLESS_GUARANTEE = -148;

/**
 * <p>Maximum poll interval exceeded </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__MAX_POLL_EXCEEDED = -147;

/**
 * <p>End internal error codes </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__END = -100;

/**
 * <p>Unknown broker error </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN = -1;

/**
 * <p>Success </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NO_ERROR = 0;

/**
 * <p>Offset out of range </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_OFFSET_OUT_OF_RANGE = 1;

/**
 * <p>Invalid message </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_MSG = 2;

/**
 * <p>Unknown topic or partition </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART = 3;

/**
 * <p>Invalid message size </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_MSG_SIZE = 4;

/**
 * <p>Leader not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_LEADER_NOT_AVAILABLE = 5;

/**
 * <p>Not leader for partition </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_LEADER_FOR_PARTITION = 6;

/**
 * <p>Request timed out </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_REQUEST_TIMED_OUT = 7;

/**
 * <p>Broker not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE = 8;

/**
 * <p>Replica not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_REPLICA_NOT_AVAILABLE = 9;

/**
 * <p>Message size too large </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_MSG_SIZE_TOO_LARGE = 10;

/**
 * <p>StaleControllerEpochCode </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_STALE_CTRL_EPOCH = 11;

/**
 * <p>Offset metadata string too large </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_OFFSET_METADATA_TOO_LARGE = 12;

/**
 * <p>Broker disconnected before response received </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NETWORK_EXCEPTION = 13;

/**
 * <p>Group coordinator load in progress </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#afa695eee077bfd031e5bb637b899cfd8
 */
const RD_KAFKA_RESP_ERR_GROUP_LOAD_IN_PROGRESS = 14;

/**
 * <p>Group coordinator not available </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a23a154df5190e1fc072199737f39bd87
 */
const RD_KAFKA_RESP_ERR_GROUP_COORDINATOR_NOT_AVAILABLE = 15;

/**
 * <p>Not coordinator for group </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a7755c1901da130a937be67a1c66e2c1f
 */
const RD_KAFKA_RESP_ERR_NOT_COORDINATOR_FOR_GROUP = 16;

/**
 * <p>Invalid topic </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TOPIC_EXCEPTION = 17;

/**
 * <p>Message batch larger than configured server segment size </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_RECORD_LIST_TOO_LARGE = 18;

/**
 * <p>Not enough in-sync replicas </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS = 19;

/**
 * <p>Message(s) written to insufficient number of in-sync replicas </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS_AFTER_APPEND = 20;

/**
 * <p>Invalid required acks value </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REQUIRED_ACKS = 21;

/**
 * <p>Specified group generation id is not valid </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_ILLEGAL_GENERATION = 22;

/**
 * <p>Inconsistent group protocol </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INCONSISTENT_GROUP_PROTOCOL = 23;

/**
 * <p>Invalid group.id </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_GROUP_ID = 24;

/**
 * <p>Unknown member </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_MEMBER_ID = 25;

/**
 * <p>Invalid session timeout </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_SESSION_TIMEOUT = 26;

/**
 * <p>Group rebalance in progress </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_REBALANCE_IN_PROGRESS = 27;

/**
 * <p>Commit offset data size is not valid </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_COMMIT_OFFSET_SIZE = 28;

/**
 * <p>Topic authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TOPIC_AUTHORIZATION_FAILED = 29;

/**
 * <p>Group authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_GROUP_AUTHORIZATION_FAILED = 30;

/**
 * <p>Cluster authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_CLUSTER_AUTHORIZATION_FAILED = 31;

/**
 * <p>Invalid timestamp </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_TIMESTAMP = 32;

/**
 * <p>Unsupported SASL mechanism </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_SASL_MECHANISM = 33;

/**
 * <p>Illegal SASL state </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_ILLEGAL_SASL_STATE = 34;

/**
 * <p>Unuspported version </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_VERSION = 35;

/**
 * <p>Topic already exists </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS = 36;

/**
 * <p>Invalid number of partitions </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_PARTITIONS = 37;

/**
 * <p>Invalid replication factor </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REPLICATION_FACTOR = 38;

/**
 * <p>Invalid replica assignment </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REPLICA_ASSIGNMENT = 39;

/**
 * <p>Invalid config </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_CONFIG = 40;

/**
 * <p>Not controller for cluster </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_CONTROLLER = 41;

/**
 * <p>Invalid request </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_REQUEST = 42;

/**
 * <p>Message format on broker does not support request </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_FOR_MESSAGE_FORMAT = 43;

/**
 * <p>Policy violation </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_POLICY_VIOLATION = 44;

/**
 * <p>Broker received an out of order sequence number </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_OUT_OF_ORDER_SEQUENCE_NUMBER = 45;

/**
 * <p>Broker received a duplicate sequence number </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DUPLICATE_SEQUENCE_NUMBER = 46;

/**
 * <p>Producer attempted an operation with an old epoch </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_PRODUCER_EPOCH = 47;

/**
 * <p>Producer attempted a transactional operation in an invalid state </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_TXN_STATE = 48;

/**
 * <p>Producer attempted to use a producer id which is not currently assigned to its transactional id </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_PRODUCER_ID_MAPPING = 49;

/**
 * <p>Transaction timeout is larger than the maximum value allowed by the broker's max.transaction.timeout.ms </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_TRANSACTION_TIMEOUT = 50;

/**
 * <p>Producer attempted to update a transaction while another concurrent operation on the same transaction was ongoing </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_CONCURRENT_TRANSACTIONS = 51;

/**
 * <p>Indicates that the transaction coordinator sending a WriteTxnMarker is no longer the current coordinator for a given producer </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TRANSACTION_COORDINATOR_FENCED = 52;

/**
 * <p>Transactional Id authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TRANSACTIONAL_ID_AUTHORIZATION_FAILED = 53;

/**
 * <p>Security features are disabled </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_SECURITY_DISABLED = 54;

/**
 * <p>Operation not attempted </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_OPERATION_NOT_ATTEMPTED = 55;

/**
 * <p>Disk error when trying to access log file on the disk </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_KAFKA_STORAGE_ERROR = 56;

/**
 * <p>The user-specified log directory is not found in the broker config </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_LOG_DIR_NOT_FOUND = 57;

/**
 * <p>SASL Authentication failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_SASL_AUTHENTICATION_FAILED = 58;

/**
 * <p>Unknown Producer Id </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_PRODUCER_ID = 59;

/**
 * <p>Partition reassignment is in progress </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_REASSIGNMENT_IN_PROGRESS = 60;

/**
 * <p>Delegation Token feature is not enabled </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTH_DISABLED = 61;

/**
 * <p>Delegation Token is not found on server </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_NOT_FOUND = 62;

/**
 * <p>Specified Principal is not valid Owner/Renewer </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_OWNER_MISMATCH = 63;

/**
 * <p>Delegation Token requests are not allowed on this connection </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_REQUEST_NOT_ALLOWED = 64;

/**
 * <p>Delegation Token authorization failed </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTHORIZATION_FAILED = 65;

/**
 * <p>Delegation Token is expired </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_EXPIRED = 66;

/**
 * <p>Supplied principalType is not supported </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_PRINCIPAL_TYPE = 67;

/**
 * <p>The group is not empty </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NON_EMPTY_GROUP = 68;

/**
 * <p>The group id does not exist </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_GROUP_ID_NOT_FOUND = 69;

/**
 * <p>The fetch session ID was not found </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_FETCH_SESSION_ID_NOT_FOUND = 70;

/**
 * <p>The fetch session epoch is invalid </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_FETCH_SESSION_EPOCH = 71;

/**
 * <p>No matching listener </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_LISTENER_NOT_FOUND = 72;

/**
 * <p>Topic deletion is disabled </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_TOPIC_DELETION_DISABLED = 73;

/**
 * <p>va-arg sentinel </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03c74ceba678b4e7a624310160a02165
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_END = 0;

/**
 * <p>(const char *) Topic name </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_TOPIC = 1;

/**
 * <p>(rd_kafka_topic_t *) Topic handle </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_RKT = 2;

/**
 * <p>(int32_t) Partition </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_PARTITION = 3;

/**
 * <p>(void *, size_t) Message value (payload) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_VALUE = 4;

/**
 * <p>(void *, size_t) Message key </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_KEY = 5;

/**
 * <p>(void *) Per-message application opaque value. This is the same as the _private field in rd_kafka_message_t, also known as the msg_opaque. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_OPAQUE = 6;

/**
 * <p>(int) RD_KAFKA_MSG_F_.. flags </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_MSGFLAGS = 7;

/**
 * <p>(int64_t) Milliseconds since epoch UTC </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_TIMESTAMP = 8;

/**
 * <p>(const char *, const void *, ssize_t) Message Header </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_HEADER = 9;

/**
 * <p>(rd_kafka_headers_t *) Headers list </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a9aac65afa4c30e6d75550e39f6c1ea6b
 */
const RD_KAFKA_VTYPE_HEADERS = 10;

/**
 * <p>Message was never transmitted to the broker, or failed with an error indicating it was not written to the log. Application retry risks ordering, but not duplication. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad46cb2b6064fcfbe2451aca8df802517
 */
const RD_KAFKA_MSG_STATUS_NOT_PERSISTED = 0;

/**
 * <p>Message was transmitted to broker, but no acknowledgement was received. Application retry risks ordering and duplication. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad46cb2b6064fcfbe2451aca8df802517
 */
const RD_KAFKA_MSG_STATUS_POSSIBLY_PERSISTED = 1;

/**
 * <p>Message was written to the log and acknowledged by the broker. No reason for application to retry. Note: this value should only be trusted with <code>acks=all</code>. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad46cb2b6064fcfbe2451aca8df802517
 */
const RD_KAFKA_MSG_STATUS_PERSISTED = 2;

/**
 * <p>Unknown configuration name. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad8306a08e59e8e2cbc6abdb84f9689f4
 */
const RD_KAFKA_CONF_UNKNOWN = -2;

/**
 * <p>Invalid configuration value or property or value not supported in this build. </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad8306a08e59e8e2cbc6abdb84f9689f4
 */
const RD_KAFKA_CONF_INVALID = -1;

/**
 * <p>Configuration okay </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad8306a08e59e8e2cbc6abdb84f9689f4
 */
const RD_KAFKA_CONF_OK = 0;

/**
 * <p>Default value </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_ANY = 0;

/**
 * <p>CreateTopics </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_CREATETOPICS = 1;

/**
 * <p>DeleteTopics </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_DELETETOPICS = 2;

/**
 * <p>CreatePartitions </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_CREATEPARTITIONS = 3;

/**
 * <p>AlterConfigs </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_ALTERCONFIGS = 4;

/**
 * <p>DescribeConfigs </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_DESCRIBECONFIGS = 5;

/**
 * <p>Source unknown, e.g., in the ConfigEntry used for alter requests where source is not set </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aab84b4178e74bd4319721ee0c68ae62c
 */
const RD_KAFKA_CONFIG_SOURCE_UNKNOWN_CONFIG = 0;

/**
 * <p>Dynamic topic config that is configured for a specific topic </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aab84b4178e74bd4319721ee0c68ae62c
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_TOPIC_CONFIG = 1;

/**
 * <p>Dynamic broker config that is configured for a specific broker </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aab84b4178e74bd4319721ee0c68ae62c
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_BROKER_CONFIG = 2;

/**
 * <p>Dynamic broker config that is configured as default for all brokers in the cluster </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aab84b4178e74bd4319721ee0c68ae62c
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_DEFAULT_BROKER_CONFIG = 3;

/**
 * <p>Static broker config provided as broker properties at startup (e.g. from server.properties file) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aab84b4178e74bd4319721ee0c68ae62c
 */
const RD_KAFKA_CONFIG_SOURCE_STATIC_BROKER_CONFIG = 4;

/**
 * <p>Built-in default configuration for configs that have a default value </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aab84b4178e74bd4319721ee0c68ae62c
 */
const RD_KAFKA_CONFIG_SOURCE_DEFAULT_CONFIG = 5;

/**
 * <p>Number of source types defined </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aab84b4178e74bd4319721ee0c68ae62c
 */
const RD_KAFKA_CONFIG_SOURCE__CNT = 6;

/**
 * <p>Unknown </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acca83a66d7783ff7683ed2691cc907c9
 */
const RD_KAFKA_RESOURCE_UNKNOWN = 0;

/**
 * <p>Any (used for lookups) </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acca83a66d7783ff7683ed2691cc907c9
 */
const RD_KAFKA_RESOURCE_ANY = 1;

/**
 * <p>Topic </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acca83a66d7783ff7683ed2691cc907c9
 */
const RD_KAFKA_RESOURCE_TOPIC = 2;

/**
 * <p>Group </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acca83a66d7783ff7683ed2691cc907c9
 */
const RD_KAFKA_RESOURCE_GROUP = 3;

/**
 * <p>Broker </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acca83a66d7783ff7683ed2691cc907c9
 */
const RD_KAFKA_RESOURCE_BROKER = 4;

/**
 * <p>Number of resource types defined </p>
 * @since 1.0.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acca83a66d7783ff7683ed2691cc907c9
 */
const RD_KAFKA_RESOURCE__CNT = 5;

/**
 * <p>Leader epoch is older than broker epoch </p>
 * @since 1.0.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_FENCED_LEADER_EPOCH = 74;

/**
 * <p>Leader epoch is newer than broker epoch </p>
 * @since 1.0.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_LEADER_EPOCH = 75;

/**
 * <p>Broker epoch has changed </p>
 * @since 1.0.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_STALE_BROKER_EPOCH = 77;

/**
 * <p>Leader high watermark is not caught up </p>
 * @since 1.0.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_OFFSET_NOT_AVAILABLE = 78;

/**
 * <p>Group member needs a valid member ID </p>
 * @since 1.0.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_MEMBER_ID_REQUIRED = 79;

/**
 * <p>Preferred leader was not available </p>
 * @since 1.0.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_PREFERRED_LEADER_NOT_AVAILABLE = 80;

/**
 * <p>Consumer group has reached maximum size </p>
 * @since 1.0.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_GROUP_MAX_SIZE_REACHED = 81;

/**
 * <p>SASL/OAUTHBEARER token needs to be refreshed </p>
 * @since 1.1.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a63e097de934fac48b93411ac91564db1
 */
const RD_KAFKA_EVENT_OAUTHBEARER_TOKEN_REFRESH = 256;

/**
 * <p>Client's public key </p>
 * @since 1.1.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a5f0ba54591c0ffa725cb1a5eafe8b180
 */
const RD_KAFKA_CERT_PUBLIC_KEY = 0;

/**
 * <p>Client's private key </p>
 * @since 1.1.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a5f0ba54591c0ffa725cb1a5eafe8b180
 */
const RD_KAFKA_CERT_PRIVATE_KEY = 1;

/**
 * <p>CA certificate </p>
 * @since 1.1.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a5f0ba54591c0ffa725cb1a5eafe8b180
 */
const RD_KAFKA_CERT_CA = 2;

/**
 * enum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT__CNT = 3;

/**
 * <p>PKCS#12 </p>
 * @since 1.1.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab7a624d3a484453f4abe5955bb6a45eb
 */
const RD_KAFKA_CERT_ENC_PKCS12 = 0;

/**
 * <p>DER / binary X.509 ASN1 </p>
 * @since 1.1.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab7a624d3a484453f4abe5955bb6a45eb
 */
const RD_KAFKA_CERT_ENC_DER = 1;

/**
 * <p>PEM </p>
 * @since 1.1.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab7a624d3a484453f4abe5955bb6a45eb
 */
const RD_KAFKA_CERT_ENC_PEM = 2;

/**
 * enum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC__CNT = 3;

/**
 * <p>librdkafka's internal main thread </p>
 * @since 1.2.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab327ca8929b6895de7b300970ad59745
 */
const RD_KAFKA_THREAD_MAIN = 0;

/**
 * <p>Background thread (if enabled) </p>
 * @since 1.2.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab327ca8929b6895de7b300970ad59745
 */
const RD_KAFKA_THREAD_BACKGROUND = 1;

/**
 * <p>Per-broker thread </p>
 * @since 1.2.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab327ca8929b6895de7b300970ad59745
 */
const RD_KAFKA_THREAD_BROKER = 2;

/**
 * <p>Unknown broker </p>
 * @since 1.3.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_BROKER = -146;

/**
 * <p>Coordinator load in progress </p>
 * @since 1.3.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#afa695eee077bfd031e5bb637b899cfd8
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_COORDINATOR_LOAD_IN_PROGRESS = 14;

/**
 * <p>Coordinator not available </p>
 * @since 1.3.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a23a154df5190e1fc072199737f39bd87
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_COORDINATOR_NOT_AVAILABLE = 15;

/**
 * <p>Not coordinator </p>
 * @since 1.3.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a7755c1901da130a937be67a1c66e2c1f
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NOT_COORDINATOR = 16;

/**
 * <p>Functionality not configured </p>
 * @since 1.4.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NOT_CONFIGURED = -145;

/**
 * <p>Instance has been fenced </p>
 * @since 1.4.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__FENCED = -144;

/**
 * <p>Application generated error </p>
 * @since 1.4.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__APPLICATION = -143;

/**
 * <p>Static consumer fenced by other consumer with same group.instance.id. </p>
 * @since 1.4.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_FENCED_INSTANCE_ID = 82;

/**
 * <p>Eligible partition leaders are not available </p>
 * @since 1.5.2 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_ELIGIBLE_LEADERS_NOT_AVAILABLE = 83;

/**
 * <p>Leader election not needed for topic partition </p>
 * @since 1.5.2 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_ELECTION_NOT_NEEDED = 84;

/**
 * <p>No partition reassignment is in progress </p>
 * @since 1.5.2 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_NO_REASSIGNMENT_IN_PROGRESS = 85;

/**
 * <p>Deleting offsets of a topic while the consumer group is subscribed to it </p>
 * @since 1.5.2 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_GROUP_SUBSCRIBED_TO_TOPIC = 86;

/**
 * <p>Broker failed to validate record </p>
 * @since 1.5.2 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_RECORD = 87;

/**
 * <p>There are unstable offsets that need to be cleared </p>
 * @since 1.5.2 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSTABLE_OFFSET_COMMIT = 88;

/**
 * <p>DeleteRecords_result_t </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab572fd50785847b03c96af744ceffaf1
 */
const RD_KAFKA_EVENT_DELETERECORDS_RESULT = 105;

/**
 * <p>DeleteGroups_result_t </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a6d2f3f1797ba2241c707b077ddc2c1b3
 */
const RD_KAFKA_EVENT_DELETEGROUPS_RESULT = 106;

/**
 * <p>DeleteConsumerGroupOffsets_result_t </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a16dee39b23bef225ad3bb902cf391659
 */
const RD_KAFKA_EVENT_DELETECONSUMERGROUPOFFSETS_RESULT = 107;

/**
 * <p>Assignment lost </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__ASSIGNMENT_LOST = -142;

/**
 * <p>No operation performed </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__NOOP = -141;

/**
 * <p>Throttling quota has been exceeded </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_THROTTLING_QUOTA_EXCEEDED = 89;

/**
 * <p>There is a newer producer with the same transactionalId which fences the current one </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_PRODUCER_FENCED = 90;

/**
 * <p>Request illegally referred to resource that does not exist </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_RESOURCE_NOT_FOUND = 91;

/**
 * <p>Request illegally referred to the same resource twice </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_DUPLICATE_RESOURCE = 92;

/**
 * <p>Requested credential would not meet criteria for acceptability </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNACCEPTABLE_CREDENTIAL = 93;

/**
 * <p>Indicates that the either the sender or recipient of a voter-only request is not one of the expected voters </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INCONSISTENT_VOTER_SET = 94;

/**
 * <p>Invalid update version </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_INVALID_UPDATE_VERSION = 95;

/**
 * <p>Unable to update finalized features due to server error </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_FEATURE_UPDATE_FAILED = 96;

/**
 * <p>Request principal deserialization failed during forwarding </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_PRINCIPAL_DESERIALIZATION_FAILURE = 97;

/**
 * <p>DeleteRecords </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_DELETERECORDS = 6;

/**
 * <p>DeleteGroups </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_DELETEGROUPS = 7;

/**
 * <p>DeleteConsumerGroupOffsets </p>
 * @since 1.6.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_DELETECONSUMERGROUPOFFSETS = 8;

/**
 * <p>No offset to automatically reset to </p>
 * @since 1.6.1 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR__AUTO_OFFSET_RESET = -140;

/**
 * <p>Enable background thread. </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ad6fc906cff51d7ed8bfc9597c2054190
 */
const RD_KAFKA_EVENT_BACKGROUND = 512;

/**
 * <p>CreateAcls_result_t </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ae09849fc4a1e0a1b4240fbf9e195f2b9
 */
const RD_KAFKA_EVENT_CREATEACLS_RESULT = 1024;

/**
 * <p>DescribeAcls_result_t </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#af4991ffb7e86a8344a7012d40e2124d8
 */
const RD_KAFKA_EVENT_DESCRIBEACLS_RESULT = 2048;

/**
 * <p>DeleteAcls_result_t </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aa44fa18142c943e305b48ae67c836cb4
 */
const RD_KAFKA_EVENT_DELETEACLS_RESULT = 4096;

/**
 * <p>CreateAcls </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_CREATEACLS = 9;

/**
 * <p>DescribeAcls </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_DESCRIBEACLS = 10;

/**
 * <p>DeleteAcls </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP_DELETEACLS = 11;

/**
 * <p>Unknown </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acbe0ed4347fe1bd085eef03ca7aadbdb
 */
const RD_KAFKA_RESOURCE_PATTERN_UNKNOWN = 0;

/**
 * <p>Any (used for lookups) </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acbe0ed4347fe1bd085eef03ca7aadbdb
 */
const RD_KAFKA_RESOURCE_PATTERN_ANY = 1;

/**
 * <p>Match: will perform pattern matching </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acbe0ed4347fe1bd085eef03ca7aadbdb
 */
const RD_KAFKA_RESOURCE_PATTERN_MATCH = 2;

/**
 * <p>Literal: A literal resource name </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acbe0ed4347fe1bd085eef03ca7aadbdb
 */
const RD_KAFKA_RESOURCE_PATTERN_LITERAL = 3;

/**
 * <p>Prefixed: A prefixed resource name </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#acbe0ed4347fe1bd085eef03ca7aadbdb
 */
const RD_KAFKA_RESOURCE_PATTERN_PREFIXED = 4;

/**
 * enum rd_kafka_ResourcePatternType_t
 * @since 1.9.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_PATTERN_TYPE__CNT = 5;

/**
 * <p>Unknown </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_UNKNOWN = 0;

/**
 * <p>In a filter, matches any AclOperation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_ANY = 1;

/**
 * <p>ALL operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_ALL = 2;

/**
 * <p>READ operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_READ = 3;

/**
 * <p>WRITE operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_WRITE = 4;

/**
 * <p>CREATE operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_CREATE = 5;

/**
 * <p>DELETE operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_DELETE = 6;

/**
 * <p>ALTER operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_ALTER = 7;

/**
 * <p>DESCRIBE operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_DESCRIBE = 8;

/**
 * <p>CLUSTER_ACTION operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_CLUSTER_ACTION = 9;

/**
 * <p>DESCRIBE_CONFIGS operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_DESCRIBE_CONFIGS = 10;

/**
 * <p>ALTER_CONFIGS operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_ALTER_CONFIGS = 11;

/**
 * <p>IDEMPOTENT_WRITE operation </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a526269d7fc5c9acd1b8b56e84895c2bb
 */
const RD_KAFKA_ACL_OPERATION_IDEMPOTENT_WRITE = 12;

/**
 * enum rd_kafka_AclOperation_t
 * @since 1.9.0 of librdkafka
 */
const RD_KAFKA_ACL_OPERATION__CNT = 13;

/**
 * <p>Unknown </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab2da1706fced5ccc7ac5566825ba44b8
 */
const RD_KAFKA_ACL_PERMISSION_TYPE_UNKNOWN = 0;

/**
 * <p>In a filter, matches any AclPermissionType </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab2da1706fced5ccc7ac5566825ba44b8
 */
const RD_KAFKA_ACL_PERMISSION_TYPE_ANY = 1;

/**
 * <p>Disallows access </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab2da1706fced5ccc7ac5566825ba44b8
 */
const RD_KAFKA_ACL_PERMISSION_TYPE_DENY = 2;

/**
 * <p>Grants access. </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#ab2da1706fced5ccc7ac5566825ba44b8
 */
const RD_KAFKA_ACL_PERMISSION_TYPE_ALLOW = 3;

/**
 * enum rd_kafka_AclPermissionType_t
 * @since 1.9.0 of librdkafka
 */
const RD_KAFKA_ACL_PERMISSION_TYPE__CNT = 4;

/**
 * define
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_LISTCONSUMERGROUPS_RESULT = 8192;

/**
 * define
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_DESCRIBECONSUMERGROUPS_RESULT = 16384;

/**
 * define
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_LISTCONSUMERGROUPOFFSETS_RESULT = 32768;

/**
 * define
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_ALTERCONSUMERGROUPOFFSETS_RESULT = 65536;

/**
 * enum rd_kafka_consumer_group_state_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER_GROUP_STATE_UNKNOWN = 0;

/**
 * enum rd_kafka_consumer_group_state_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER_GROUP_STATE_PREPARING_REBALANCE = 1;

/**
 * enum rd_kafka_consumer_group_state_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER_GROUP_STATE_COMPLETING_REBALANCE = 2;

/**
 * enum rd_kafka_consumer_group_state_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER_GROUP_STATE_STABLE = 3;

/**
 * enum rd_kafka_consumer_group_state_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER_GROUP_STATE_DEAD = 4;

/**
 * enum rd_kafka_consumer_group_state_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER_GROUP_STATE_EMPTY = 5;

/**
 * enum rd_kafka_consumer_group_state_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER_GROUP_STATE__CNT = 6;

/**
 * enum rd_kafka_admin_op_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_LISTCONSUMERGROUPS = 12;

/**
 * enum rd_kafka_admin_op_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_DESCRIBECONSUMERGROUPS = 13;

/**
 * enum rd_kafka_admin_op_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_LISTCONSUMERGROUPOFFSETS = 14;

/**
 * enum rd_kafka_admin_op_t
 * @since 2.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_ALTERCONSUMERGROUPOFFSETS = 15;

const RD_KAFKA_SUPPORTED_METHODS = [
    'rd_kafka_version' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_version_str' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_get_debug_contexts' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_get_err_descs' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_err2str' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_err2name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_last_error' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_errno2err' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_errno' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_fatal_error' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_test_fatal_error' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_add' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_add_range' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_del' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_del_by_idx' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_copy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_set_offset' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_find' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_list_sort' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_headers_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_headers_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_headers_copy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_header_add' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_header_remove' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_header_get_last' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_header_get' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_header_get_all' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_timestamp' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_latency' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_headers' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_detach_headers' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_set_headers' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_header_cnt' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_status' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_dup' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_dup_filter' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_events' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_background_event_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_dr_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_dr_msg_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_consume_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_rebalance_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_offset_commit_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_error_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_throttle_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_log_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_stats_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_socket_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_connect_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_closesocket_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_opaque' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_opaque' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_default_topic_conf' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_get' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_get' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_dump' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_dump' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_dump_free' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_properties_show' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_dup' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_default_topic_conf_dup' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_set' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_set_opaque' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_set_partitioner_cb' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_conf_set_msg_order_cmp' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_partition_available' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_msg_partitioner_random' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_msg_partitioner_consistent' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_msg_partitioner_consistent_random' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_msg_partitioner_murmur2' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_msg_partitioner_murmur2_random' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_destroy_flags' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_type' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_memberid' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_clusterid' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_controllerid' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_opaque' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_poll' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_yield' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_pause_partitions' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_resume_partitions' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_query_watermark_offsets' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_get_watermark_offsets' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_offsets_for_times' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mem_free' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_get_main' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_get_consumer' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_get_partition' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_get_background' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_forward' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_set_log_queue' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_length' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_io_event_enable' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_cb_event_enable' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_start' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_start_queue' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_stop' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_seek' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_batch' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_callback' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_queue' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_batch_queue' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consume_callback_queue' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_offset_store' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_offsets_store' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_subscribe' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_unsubscribe' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_subscription' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_poll' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_close' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_assign' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_assignment' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_commit' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_commit_message' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_commit_queue' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_committed' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_position' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_produce' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_producev' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_produce_batch' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_flush' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_purge' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_metadata' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_metadata_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_list_groups' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_group_list_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_brokers_add' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_set_logger' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_set_log_level' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_log_print' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_log_syslog' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_outq_len' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_dump' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_thread_cnt' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_wait_destroyed' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_unittest' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_poll_set_consumer' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_type' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_message_next' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_message_array' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_message_count' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_error' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_error_string' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_error_is_fatal' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_opaque' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_log' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_stats' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_topic_partition_list' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_topic_partition' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_CreateTopics_result' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DeleteTopics_result' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_CreatePartitions_result' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_AlterConfigs_result' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DescribeConfigs_result' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_poll' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_poll_callback' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_plugin_f_conf_init_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_conf_set_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_conf_dup_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_conf_destroy_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_new_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_destroy_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_send_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_acknowledgement_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_consume_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_commit_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_request_sent_t' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_interceptor_add_on_conf_set' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_interceptor_add_on_conf_dup' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_interceptor_add_on_conf_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_interceptor_add_on_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_send' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_acknowledgement' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_consume' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_commit' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_request_sent' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_result_error' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_result_error_string' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_topic_result_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_set_request_timeout' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_set_operation_timeout' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_set_validate_only' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_set_broker' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_set_opaque' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewTopic_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewTopic_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewTopic_destroy_array' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewTopic_set_replica_assignment' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewTopic_set_config' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_CreateTopics' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_CreateTopics_result_topics' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteTopic_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteTopic_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteTopic_destroy_array' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteTopics' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteTopics_result_topics' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewPartitions_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewPartitions_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewPartitions_destroy_array' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_NewPartitions_set_replica_assignment' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_CreatePartitions' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_CreatePartitions_result_topics' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigSource_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_value' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_source' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_is_read_only' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_is_default' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_is_sensitive' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_is_synonym' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigEntry_synonyms' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ResourceType_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_new' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_destroy' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_destroy_array' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_set_config' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_configs' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_type' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_name' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_error' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConfigResource_error_string' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AlterConfigs' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AlterConfigs_result_resources' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DescribeConfigs' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DescribeConfigs_result_resources' => [
        'min' => '1.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf' => [
        'min' => '1.1.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_oauthbearer_token_refresh_cb' => [
        'min' => '1.1.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_ssl_cert_verify_cb' => [
        'min' => '1.1.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_ssl_cert' => [
        'min' => '1.1.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_config_string' => [
        'min' => '1.1.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_oauthbearer_set_token' => [
        'min' => '1.1.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_oauthbearer_set_token_failure' => [
        'min' => '1.1.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_thread_start_t' => [
        'min' => '1.2.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_thread_exit_t' => [
        'min' => '1.2.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_thread_start' => [
        'min' => '1.2.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_thread_exit' => [
        'min' => '1.2.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_cluster_new' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_cluster_destroy' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_cluster_handle' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_cluster_bootstraps' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_push_request_errors' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_topic_set_error' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_partition_set_leader' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_partition_set_follower' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_partition_set_follower_wmarks' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_broker_set_rack' => [
        'min' => '1.3.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_code' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_name' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_string' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_is_fatal' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_is_retriable' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_txn_requires_abort' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_destroy' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_error_new' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_msg_partitioner_fnv1a' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_msg_partitioner_fnv1a_random' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_metadata' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_metadata_new' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_metadata_destroy' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_metadata_write' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_metadata_read' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_init_transactions' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_begin_transaction' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_send_offsets_to_transaction' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_commit_transaction' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_abort_transaction' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_handle_mock_cluster' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_topic_create' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_broker_set_down' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_broker_set_up' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_coordinator_set' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_set_apiversion' => [
        'min' => '1.4.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_broker_set_rtt' => [
        'min' => '1.4.4',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_errstr' => [
        'min' => '1.5.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_message_broker_id' => [
        'min' => '1.5.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_produceva' => [
        'min' => '1.5.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_debug_contexts' => [
        'min' => '1.5.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_broker_push_request_errors' => [
        'min' => '1.5.0',
        'max' => '1.6.2'
    ],
    'rd_kafka_conf_get_default_topic_conf' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_yield' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_seek_partitions' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_incremental_assign' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_incremental_unassign' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_rebalance_protocol' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_assignment_lost' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_metadata_new_with_genid' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DeleteRecords_result' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DeleteGroups_result' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DeleteConsumerGroupOffsets_result' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_group_result_error' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_group_result_name' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_group_result_partitions' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteRecords_new' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteRecords_destroy' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteRecords_destroy_array' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteRecords' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteRecords_result_offsets' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteGroup_new' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteGroup_destroy' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteGroup_destroy_array' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteGroups' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteGroups_result_groups' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteConsumerGroupOffsets_new' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteConsumerGroupOffsets_destroy' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteConsumerGroupOffsets_destroy_array' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteConsumerGroupOffsets' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteConsumerGroupOffsets_result_groups' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_clear_request_errors' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_push_request_errors_array' => [
        'min' => '1.6.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_response_received_t' => [
        'min' => '1.6.1',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_response_received' => [
        'min' => '1.6.1',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_engine_callback_data' => [
        'min' => '1.7.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mem_calloc' => [
        'min' => '1.7.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mem_malloc' => [
        'min' => '1.7.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_broker_push_request_error_rtts' => [
        'min' => '1.7.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_enable_sasl_queue' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_queue_get_sasl' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_sasl_background_callbacks_enable' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_close_queue' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_closed' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_CreateAcls_result' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DescribeAcls_result' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DeleteAcls_result' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ResourcePatternType_name' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_acl_result_error' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclOperation_name' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclPermissionType_name' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_new' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBindingFilter_new' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_restype' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_name' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_principal' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_host' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_operation' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_permission_type' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_resource_pattern_type' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_error' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_destroy' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AclBinding_destroy_array' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_CreateAcls_result_acls' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_CreateAcls' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DescribeAcls_result_acls' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DescribeAcls' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteAcls_result_responses' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteAcls_result_response_error' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteAcls_result_response_matching_acls' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DeleteAcls' => [
        'min' => '1.9.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_conf_set_resolve_cb' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_sasl_set_credentials' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_Node_id' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_Node_host' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_Node_port' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_state_name' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_consumer_group_state_code' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_ListConsumerGroups_result' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_DescribeConsumerGroups_result' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_AlterConsumerGroupOffsets_result' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_event_ListConsumerGroupOffsets_result' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_f_on_broker_state_change_t' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_interceptor_add_on_broker_state_change' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_set_require_stable_offsets' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AdminOptions_set_match_consumer_group_states' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroups' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupListing_group_id' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupListing_is_simple_consumer_group' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupListing_state' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroups_result_valid' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroups_result_errors' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DescribeConsumerGroups' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_DescribeConsumerGroups_result_groups' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_group_id' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_error' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_is_simple_consumer_group' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_partition_assignor' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_state' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_coordinator' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_member_count' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ConsumerGroupDescription_member' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_MemberDescription_client_id' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_MemberDescription_group_instance_id' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_MemberDescription_consumer_id' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_MemberDescription_host' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_MemberDescription_assignment' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_MemberAssignment_partitions' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroupOffsets_new' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroupOffsets_destroy' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroupOffsets_destroy_array' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroupOffsets' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_ListConsumerGroupOffsets_result_groups' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AlterConsumerGroupOffsets_new' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AlterConsumerGroupOffsets_destroy' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AlterConsumerGroupOffsets_destroy_array' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AlterConsumerGroupOffsets' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_AlterConsumerGroupOffsets_result_groups' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ],
    'rd_kafka_mock_broker_error_stack_cnt' => [
        'min' => '2.0.0',
        'max' => '2.0.2'
    ]
];
