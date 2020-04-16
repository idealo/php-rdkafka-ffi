<?php
/**
 * This file is generated! Do not edit directly.
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

// librdkafka overall constants
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const _STDIO_H = 0;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const _INTTYPES_H = 0;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const _SYS_TYPES_H = 0;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const _SYS_SOCKET_H = 0;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const LIBRDKAFKA_TYPECHECKS = 1;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_DESTROY_F_NO_CONSUMER_CLOSE = 8;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PARTITION_UA = -1;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_OFFSET_BEGINNING = -2;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_OFFSET_END = -1;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_OFFSET_STORED = -1000;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_OFFSET_INVALID = -1001;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_OFFSET_TAIL_BASE = -2000;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_F_FREE = 1;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_F_COPY = 2;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_F_BLOCK = 4;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_F_PARTITION = 8;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PURGE_F_QUEUE = 1;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PURGE_F_INFLIGHT = 2;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PURGE_F_NON_BLOCKING = 4;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_NONE = 0;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_DR = 1;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_FETCH = 2;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_LOG = 4;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_ERROR = 8;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_REBALANCE = 16;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_OFFSET_COMMIT = 32;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_STATS = 64;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_CREATETOPICS_RESULT = 100;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_DELETETOPICS_RESULT = 101;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_CREATEPARTITIONS_RESULT = 102;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_ALTERCONFIGS_RESULT = 103;
/**
 * #define
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_EVENT_DESCRIBECONFIGS_RESULT = 104;
/**
 * typedefenum rd_kafka_type_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_PRODUCER = 0;
/**
 * typedefenum rd_kafka_type_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONSUMER = 1;
/**
 * typedefenum rd_kafka_timestamp_type_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_TIMESTAMP_NOT_AVAILABLE = 0;
/**
 * typedefenum rd_kafka_timestamp_type_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_TIMESTAMP_CREATE_TIME = 1;
/**
 * typedefenum rd_kafka_timestamp_type_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_TIMESTAMP_LOG_APPEND_TIME = 2;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__BEGIN = -200;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__BAD_MSG = -199;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__BAD_COMPRESSION = -198;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__DESTROY = -197;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__FAIL = -196;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__TRANSPORT = -195;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__CRIT_SYS_RESOURCE = -194;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__RESOLVE = -193;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__MSG_TIMED_OUT = -192;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PARTITION_EOF = -191;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_PARTITION = -190;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__FS = -189;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_TOPIC = -188;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__ALL_BROKERS_DOWN = -187;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__INVALID_ARG = -186;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__TIMED_OUT = -185;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__QUEUE_FULL = -184;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__ISR_INSUFF = -183;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__NODE_UPDATE = -182;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__SSL = -181;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__WAIT_COORD = -180;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_GROUP = -179;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__IN_PROGRESS = -178;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PREV_IN_PROGRESS = -177;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__EXISTING_SUBSCRIPTION = -176;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS = -175;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS = -174;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__CONFLICT = -173;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__STATE = -172;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_PROTOCOL = -171;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__NOT_IMPLEMENTED = -170;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__AUTHENTICATION = -169;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__NO_OFFSET = -168;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__OUTDATED = -167;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__TIMED_OUT_QUEUE = -166;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNSUPPORTED_FEATURE = -165;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__WAIT_CACHE = -164;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__INTR = -163;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__KEY_SERIALIZATION = -162;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__VALUE_SERIALIZATION = -161;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__KEY_DESERIALIZATION = -160;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__VALUE_DESERIALIZATION = -159;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PARTIAL = -158;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__READ_ONLY = -157;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__NOENT = -156;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNDERFLOW = -155;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__INVALID_TYPE = -154;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__RETRY = -153;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PURGE_QUEUE = -152;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__PURGE_INFLIGHT = -151;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__FATAL = -150;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__INCONSISTENT = -149;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__GAPLESS_GUARANTEE = -148;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__MAX_POLL_EXCEEDED = -147;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__END = -100;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNKNOWN = -1;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NO_ERROR = 0;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OFFSET_OUT_OF_RANGE = 1;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_MSG = 2;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART = 3;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_MSG_SIZE = 4;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_LEADER_NOT_AVAILABLE = 5;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NOT_LEADER_FOR_PARTITION = 6;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_REQUEST_TIMED_OUT = 7;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE = 8;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_REPLICA_NOT_AVAILABLE = 9;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_MSG_SIZE_TOO_LARGE = 10;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_STALE_CTRL_EPOCH = 11;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OFFSET_METADATA_TOO_LARGE = 12;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NETWORK_EXCEPTION = 13;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_LOAD_IN_PROGRESS = 14;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_COORDINATOR_NOT_AVAILABLE = 15;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NOT_COORDINATOR_FOR_GROUP = 16;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TOPIC_EXCEPTION = 17;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_RECORD_LIST_TOO_LARGE = 18;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS = 19;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS_AFTER_APPEND = 20;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_REQUIRED_ACKS = 21;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_ILLEGAL_GENERATION = 22;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INCONSISTENT_GROUP_PROTOCOL = 23;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_GROUP_ID = 24;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_MEMBER_ID = 25;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_SESSION_TIMEOUT = 26;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_REBALANCE_IN_PROGRESS = 27;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_COMMIT_OFFSET_SIZE = 28;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TOPIC_AUTHORIZATION_FAILED = 29;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_AUTHORIZATION_FAILED = 30;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_CLUSTER_AUTHORIZATION_FAILED = 31;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_TIMESTAMP = 32;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_SASL_MECHANISM = 33;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_ILLEGAL_SASL_STATE = 34;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_VERSION = 35;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS = 36;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_PARTITIONS = 37;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_REPLICATION_FACTOR = 38;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_REPLICA_ASSIGNMENT = 39;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_CONFIG = 40;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NOT_CONTROLLER = 41;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_REQUEST = 42;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_FOR_MESSAGE_FORMAT = 43;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_POLICY_VIOLATION = 44;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OUT_OF_ORDER_SEQUENCE_NUMBER = 45;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DUPLICATE_SEQUENCE_NUMBER = 46;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_PRODUCER_EPOCH = 47;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_TXN_STATE = 48;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_PRODUCER_ID_MAPPING = 49;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_TRANSACTION_TIMEOUT = 50;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_CONCURRENT_TRANSACTIONS = 51;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TRANSACTION_COORDINATOR_FENCED = 52;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TRANSACTIONAL_ID_AUTHORIZATION_FAILED = 53;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_SECURITY_DISABLED = 54;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OPERATION_NOT_ATTEMPTED = 55;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_KAFKA_STORAGE_ERROR = 56;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_LOG_DIR_NOT_FOUND = 57;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_SASL_AUTHENTICATION_FAILED = 58;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_PRODUCER_ID = 59;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_REASSIGNMENT_IN_PROGRESS = 60;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTH_DISABLED = 61;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_NOT_FOUND = 62;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_OWNER_MISMATCH = 63;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_REQUEST_NOT_ALLOWED = 64;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTHORIZATION_FAILED = 65;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_EXPIRED = 66;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_PRINCIPAL_TYPE = 67;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NON_EMPTY_GROUP = 68;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_ID_NOT_FOUND = 69;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_FETCH_SESSION_ID_NOT_FOUND = 70;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_INVALID_FETCH_SESSION_EPOCH = 71;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_LISTENER_NOT_FOUND = 72;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_TOPIC_DELETION_DISABLED = 73;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_END = 0;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_TOPIC = 1;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_RKT = 2;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_PARTITION = 3;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_VALUE = 4;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_KEY = 5;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_OPAQUE = 6;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_MSGFLAGS = 7;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_TIMESTAMP = 8;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_HEADER = 9;
/**
 * typedefenum rd_kafka_vtype_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_VTYPE_HEADERS = 10;
/**
 * typedefenum rd_kafka_msg_status_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_STATUS_NOT_PERSISTED = 0;
/**
 * typedefenum rd_kafka_msg_status_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_STATUS_POSSIBLY_PERSISTED = 1;
/**
 * typedefenum rd_kafka_msg_status_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_MSG_STATUS_PERSISTED = 2;
/**
 * typedefenum rd_kafka_conf_res_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONF_UNKNOWN = -2;
/**
 * typedefenum rd_kafka_conf_res_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONF_INVALID = -1;
/**
 * typedefenum rd_kafka_conf_res_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONF_OK = 0;
/**
 * typedefenum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_ANY = 0;
/**
 * typedefenum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_CREATETOPICS = 1;
/**
 * typedefenum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_DELETETOPICS = 2;
/**
 * typedefenum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_CREATEPARTITIONS = 3;
/**
 * typedefenum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_ALTERCONFIGS = 4;
/**
 * typedefenum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP_DESCRIBECONFIGS = 5;
/**
 * typedefenum rd_kafka_admin_op_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_ADMIN_OP__CNT = 6;
/**
 * typedefenum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_UNKNOWN_CONFIG = 0;
/**
 * typedefenum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_TOPIC_CONFIG = 1;
/**
 * typedefenum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_BROKER_CONFIG = 2;
/**
 * typedefenum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DYNAMIC_DEFAULT_BROKER_CONFIG = 3;
/**
 * typedefenum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_STATIC_BROKER_CONFIG = 4;
/**
 * typedefenum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE_DEFAULT_CONFIG = 5;
/**
 * typedefenum rd_kafka_ConfigSource_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_CONFIG_SOURCE__CNT = 6;
/**
 * typedefenum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_UNKNOWN = 0;
/**
 * typedefenum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_ANY = 1;
/**
 * typedefenum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_TOPIC = 2;
/**
 * typedefenum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_GROUP = 3;
/**
 * typedefenum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE_BROKER = 4;
/**
 * typedefenum rd_kafka_ResourceType_t
 * @since 1.0.0 of librdkafka
 */
const RD_KAFKA_RESOURCE__CNT = 5;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_FENCED_LEADER_EPOCH = 74;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_UNKNOWN_LEADER_EPOCH = 75;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_STALE_BROKER_EPOCH = 77;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_OFFSET_NOT_AVAILABLE = 78;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_MEMBER_ID_REQUIRED = 79;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_PREFERRED_LEADER_NOT_AVAILABLE = 80;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.0.1 of librdkafka
 */
const RD_KAFKA_RESP_ERR_GROUP_MAX_SIZE_REACHED = 81;
/**
 * #define
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_EVENT_OAUTHBEARER_TOKEN_REFRESH = 256;
/**
 * typedefenum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_PUBLIC_KEY = 0;
/**
 * typedefenum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_PRIVATE_KEY = 1;
/**
 * typedefenum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_CA = 2;
/**
 * typedefenum rd_kafka_cert_type_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT__CNT = 3;
/**
 * typedefenum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC_PKCS12 = 0;
/**
 * typedefenum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC_DER = 1;
/**
 * typedefenum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC_PEM = 2;
/**
 * typedefenum rd_kafka_cert_enc_t
 * @since 1.1.0 of librdkafka
 */
const RD_KAFKA_CERT_ENC__CNT = 3;
/**
 * typedefenum rd_kafka_thread_type_t
 * @since 1.2.0 of librdkafka
 */
const RD_KAFKA_THREAD_MAIN = 0;
/**
 * typedefenum rd_kafka_thread_type_t
 * @since 1.2.0 of librdkafka
 */
const RD_KAFKA_THREAD_BACKGROUND = 1;
/**
 * typedefenum rd_kafka_thread_type_t
 * @since 1.2.0 of librdkafka
 */
const RD_KAFKA_THREAD_BROKER = 2;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__UNKNOWN_BROKER = -146;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_COORDINATOR_LOAD_IN_PROGRESS = 14;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_COORDINATOR_NOT_AVAILABLE = 15;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.3.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_NOT_COORDINATOR = 16;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__NOT_CONFIGURED = -145;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__FENCED = -144;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR__APPLICATION = -143;
/**
 * typedefenum rd_kafka_resp_err_t
 * @since 1.4.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_FENCED_INSTANCE_ID = 82;
