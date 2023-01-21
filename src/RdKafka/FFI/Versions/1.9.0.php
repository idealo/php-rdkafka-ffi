<?php
/**
 * This file is generated! Do not edit directly.
 *
 * Description of librdkafka methods and constants is extracted from the official documentation.
 * @link https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
 */

declare(strict_types=1);

// version specific constants
/**
 * <p>librdkafka version </p>
 * <p>Interpreted as hex <code>MM.mm.rr.xx</code>:</p><ul>
 * <li>MM = Major</li>
 * <li>mm = minor</li>
 * <li>rr = revision</li>
 * <li>xx = pre-release id (0xff is the final release)</li>
 * </ul>
 * <p>E.g.: <code>0x000801ff</code> = 0.8.1</p>
 * <dl class="section remark"><dt>Remarks</dt><dd>This value should only be used during compile time, for runtime checks of version use rd_kafka_version() </dd></dl>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#aa2e242fb8620a32b650a40575bc7f98e
 */
const RD_KAFKA_VERSION = 17367295;

/**
 * <p>Unsupported compression type </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a03509bab51072c72a8dcf52337e6d5cb
 */
const RD_KAFKA_RESP_ERR_UNSUPPORTED_COMPRESSION_TYPE = 76;

/**
 * enum rd_kafka_resp_err_t
 * @since 1.9.0 of librdkafka
 */
const RD_KAFKA_RESP_ERR_END_ALL = 98;

/**
 * <p>Number of ops defined </p>
 * @since 1.9.0 of librdkafka
 * @link https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html#a8041b7c45068283d95f54ee14c7362fe
 */
const RD_KAFKA_ADMIN_OP__CNT = 12;

/**
 * rdkafka.h, rdkafka_mock.h
 * @since 1.9.0 of librdkafka
 */
const RD_KAFKA_CDEF = 'typedef long int ssize_t;
typedef struct _IO_FILE FILE;
typedef long int mode_t;
typedef signed int int16_t;
typedef unsigned int uint16_t;
typedef signed int int32_t;
typedef signed long int int64_t;
int rd_kafka_version(void);
const char *rd_kafka_version_str(void);
typedef enum rd_kafka_type_t {
  RD_KAFKA_PRODUCER,
  RD_KAFKA_CONSUMER,
} rd_kafka_type_t;
typedef enum rd_kafka_timestamp_type_t {
  RD_KAFKA_TIMESTAMP_NOT_AVAILABLE,
  RD_KAFKA_TIMESTAMP_CREATE_TIME,
  RD_KAFKA_TIMESTAMP_LOG_APPEND_TIME,
} rd_kafka_timestamp_type_t;
const char *rd_kafka_get_debug_contexts(void);
typedef struct rd_kafka_s rd_kafka_t;
typedef struct rd_kafka_topic_s rd_kafka_topic_t;
typedef struct rd_kafka_conf_s rd_kafka_conf_t;
typedef struct rd_kafka_topic_conf_s rd_kafka_topic_conf_t;
typedef struct rd_kafka_queue_s rd_kafka_queue_t;
typedef struct rd_kafka_op_s rd_kafka_event_t;
typedef struct rd_kafka_topic_result_s rd_kafka_topic_result_t;
typedef struct rd_kafka_consumer_group_metadata_s rd_kafka_consumer_group_metadata_t;
typedef struct rd_kafka_error_s {
  unsigned int code;
  char *errstr;
  unsigned char fatal;
  unsigned char retriable;
  unsigned char txn_requires_abort;
} rd_kafka_error_t;
typedef struct rd_kafka_headers_s rd_kafka_headers_t;
typedef struct rd_kafka_group_result_s rd_kafka_group_result_t;
typedef struct rd_kafka_acl_result_s rd_kafka_acl_result_t;
typedef enum {
  RD_KAFKA_RESP_ERR__BEGIN = (- 200),
  RD_KAFKA_RESP_ERR__BAD_MSG = (- 199),
  RD_KAFKA_RESP_ERR__BAD_COMPRESSION = (- 198),
  RD_KAFKA_RESP_ERR__DESTROY = (- 197),
  RD_KAFKA_RESP_ERR__FAIL = (- 196),
  RD_KAFKA_RESP_ERR__TRANSPORT = (- 195),
  RD_KAFKA_RESP_ERR__CRIT_SYS_RESOURCE = (- 194),
  RD_KAFKA_RESP_ERR__RESOLVE = (- 193),
  RD_KAFKA_RESP_ERR__MSG_TIMED_OUT = (- 192),
  RD_KAFKA_RESP_ERR__PARTITION_EOF = (- 191),
  RD_KAFKA_RESP_ERR__UNKNOWN_PARTITION = (- 190),
  RD_KAFKA_RESP_ERR__FS = (- 189),
  RD_KAFKA_RESP_ERR__UNKNOWN_TOPIC = (- 188),
  RD_KAFKA_RESP_ERR__ALL_BROKERS_DOWN = (- 187),
  RD_KAFKA_RESP_ERR__INVALID_ARG = (- 186),
  RD_KAFKA_RESP_ERR__TIMED_OUT = (- 185),
  RD_KAFKA_RESP_ERR__QUEUE_FULL = (- 184),
  RD_KAFKA_RESP_ERR__ISR_INSUFF = (- 183),
  RD_KAFKA_RESP_ERR__NODE_UPDATE = (- 182),
  RD_KAFKA_RESP_ERR__SSL = (- 181),
  RD_KAFKA_RESP_ERR__WAIT_COORD = (- 180),
  RD_KAFKA_RESP_ERR__UNKNOWN_GROUP = (- 179),
  RD_KAFKA_RESP_ERR__IN_PROGRESS = (- 178),
  RD_KAFKA_RESP_ERR__PREV_IN_PROGRESS = (- 177),
  RD_KAFKA_RESP_ERR__EXISTING_SUBSCRIPTION = (- 176),
  RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS = (- 175),
  RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS = (- 174),
  RD_KAFKA_RESP_ERR__CONFLICT = (- 173),
  RD_KAFKA_RESP_ERR__STATE = (- 172),
  RD_KAFKA_RESP_ERR__UNKNOWN_PROTOCOL = (- 171),
  RD_KAFKA_RESP_ERR__NOT_IMPLEMENTED = (- 170),
  RD_KAFKA_RESP_ERR__AUTHENTICATION = (- 169),
  RD_KAFKA_RESP_ERR__NO_OFFSET = (- 168),
  RD_KAFKA_RESP_ERR__OUTDATED = (- 167),
  RD_KAFKA_RESP_ERR__TIMED_OUT_QUEUE = (- 166),
  RD_KAFKA_RESP_ERR__UNSUPPORTED_FEATURE = (- 165),
  RD_KAFKA_RESP_ERR__WAIT_CACHE = (- 164),
  RD_KAFKA_RESP_ERR__INTR = (- 163),
  RD_KAFKA_RESP_ERR__KEY_SERIALIZATION = (- 162),
  RD_KAFKA_RESP_ERR__VALUE_SERIALIZATION = (- 161),
  RD_KAFKA_RESP_ERR__KEY_DESERIALIZATION = (- 160),
  RD_KAFKA_RESP_ERR__VALUE_DESERIALIZATION = (- 159),
  RD_KAFKA_RESP_ERR__PARTIAL = (- 158),
  RD_KAFKA_RESP_ERR__READ_ONLY = (- 157),
  RD_KAFKA_RESP_ERR__NOENT = (- 156),
  RD_KAFKA_RESP_ERR__UNDERFLOW = (- 155),
  RD_KAFKA_RESP_ERR__INVALID_TYPE = (- 154),
  RD_KAFKA_RESP_ERR__RETRY = (- 153),
  RD_KAFKA_RESP_ERR__PURGE_QUEUE = (- 152),
  RD_KAFKA_RESP_ERR__PURGE_INFLIGHT = (- 151),
  RD_KAFKA_RESP_ERR__FATAL = (- 150),
  RD_KAFKA_RESP_ERR__INCONSISTENT = (- 149),
  RD_KAFKA_RESP_ERR__GAPLESS_GUARANTEE = (- 148),
  RD_KAFKA_RESP_ERR__MAX_POLL_EXCEEDED = (- 147),
  RD_KAFKA_RESP_ERR__UNKNOWN_BROKER = (- 146),
  RD_KAFKA_RESP_ERR__NOT_CONFIGURED = (- 145),
  RD_KAFKA_RESP_ERR__FENCED = (- 144),
  RD_KAFKA_RESP_ERR__APPLICATION = (- 143),
  RD_KAFKA_RESP_ERR__ASSIGNMENT_LOST = (- 142),
  RD_KAFKA_RESP_ERR__NOOP = (- 141),
  RD_KAFKA_RESP_ERR__AUTO_OFFSET_RESET = (- 140),
  RD_KAFKA_RESP_ERR__END = (- 100),
  RD_KAFKA_RESP_ERR_UNKNOWN = (- 1),
  RD_KAFKA_RESP_ERR_NO_ERROR = 0,
  RD_KAFKA_RESP_ERR_OFFSET_OUT_OF_RANGE = 1,
  RD_KAFKA_RESP_ERR_INVALID_MSG = 2,
  RD_KAFKA_RESP_ERR_UNKNOWN_TOPIC_OR_PART = 3,
  RD_KAFKA_RESP_ERR_INVALID_MSG_SIZE = 4,
  RD_KAFKA_RESP_ERR_LEADER_NOT_AVAILABLE = 5,
  RD_KAFKA_RESP_ERR_NOT_LEADER_FOR_PARTITION = 6,
  RD_KAFKA_RESP_ERR_REQUEST_TIMED_OUT = 7,
  RD_KAFKA_RESP_ERR_BROKER_NOT_AVAILABLE = 8,
  RD_KAFKA_RESP_ERR_REPLICA_NOT_AVAILABLE = 9,
  RD_KAFKA_RESP_ERR_MSG_SIZE_TOO_LARGE = 10,
  RD_KAFKA_RESP_ERR_STALE_CTRL_EPOCH = 11,
  RD_KAFKA_RESP_ERR_OFFSET_METADATA_TOO_LARGE = 12,
  RD_KAFKA_RESP_ERR_NETWORK_EXCEPTION = 13,
  RD_KAFKA_RESP_ERR_COORDINATOR_LOAD_IN_PROGRESS = 14,
  RD_KAFKA_RESP_ERR_COORDINATOR_NOT_AVAILABLE = 15,
  RD_KAFKA_RESP_ERR_NOT_COORDINATOR = 16,
  RD_KAFKA_RESP_ERR_TOPIC_EXCEPTION = 17,
  RD_KAFKA_RESP_ERR_RECORD_LIST_TOO_LARGE = 18,
  RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS = 19,
  RD_KAFKA_RESP_ERR_NOT_ENOUGH_REPLICAS_AFTER_APPEND = 20,
  RD_KAFKA_RESP_ERR_INVALID_REQUIRED_ACKS = 21,
  RD_KAFKA_RESP_ERR_ILLEGAL_GENERATION = 22,
  RD_KAFKA_RESP_ERR_INCONSISTENT_GROUP_PROTOCOL = 23,
  RD_KAFKA_RESP_ERR_INVALID_GROUP_ID = 24,
  RD_KAFKA_RESP_ERR_UNKNOWN_MEMBER_ID = 25,
  RD_KAFKA_RESP_ERR_INVALID_SESSION_TIMEOUT = 26,
  RD_KAFKA_RESP_ERR_REBALANCE_IN_PROGRESS = 27,
  RD_KAFKA_RESP_ERR_INVALID_COMMIT_OFFSET_SIZE = 28,
  RD_KAFKA_RESP_ERR_TOPIC_AUTHORIZATION_FAILED = 29,
  RD_KAFKA_RESP_ERR_GROUP_AUTHORIZATION_FAILED = 30,
  RD_KAFKA_RESP_ERR_CLUSTER_AUTHORIZATION_FAILED = 31,
  RD_KAFKA_RESP_ERR_INVALID_TIMESTAMP = 32,
  RD_KAFKA_RESP_ERR_UNSUPPORTED_SASL_MECHANISM = 33,
  RD_KAFKA_RESP_ERR_ILLEGAL_SASL_STATE = 34,
  RD_KAFKA_RESP_ERR_UNSUPPORTED_VERSION = 35,
  RD_KAFKA_RESP_ERR_TOPIC_ALREADY_EXISTS = 36,
  RD_KAFKA_RESP_ERR_INVALID_PARTITIONS = 37,
  RD_KAFKA_RESP_ERR_INVALID_REPLICATION_FACTOR = 38,
  RD_KAFKA_RESP_ERR_INVALID_REPLICA_ASSIGNMENT = 39,
  RD_KAFKA_RESP_ERR_INVALID_CONFIG = 40,
  RD_KAFKA_RESP_ERR_NOT_CONTROLLER = 41,
  RD_KAFKA_RESP_ERR_INVALID_REQUEST = 42,
  RD_KAFKA_RESP_ERR_UNSUPPORTED_FOR_MESSAGE_FORMAT = 43,
  RD_KAFKA_RESP_ERR_POLICY_VIOLATION = 44,
  RD_KAFKA_RESP_ERR_OUT_OF_ORDER_SEQUENCE_NUMBER = 45,
  RD_KAFKA_RESP_ERR_DUPLICATE_SEQUENCE_NUMBER = 46,
  RD_KAFKA_RESP_ERR_INVALID_PRODUCER_EPOCH = 47,
  RD_KAFKA_RESP_ERR_INVALID_TXN_STATE = 48,
  RD_KAFKA_RESP_ERR_INVALID_PRODUCER_ID_MAPPING = 49,
  RD_KAFKA_RESP_ERR_INVALID_TRANSACTION_TIMEOUT = 50,
  RD_KAFKA_RESP_ERR_CONCURRENT_TRANSACTIONS = 51,
  RD_KAFKA_RESP_ERR_TRANSACTION_COORDINATOR_FENCED = 52,
  RD_KAFKA_RESP_ERR_TRANSACTIONAL_ID_AUTHORIZATION_FAILED = 53,
  RD_KAFKA_RESP_ERR_SECURITY_DISABLED = 54,
  RD_KAFKA_RESP_ERR_OPERATION_NOT_ATTEMPTED = 55,
  RD_KAFKA_RESP_ERR_KAFKA_STORAGE_ERROR = 56,
  RD_KAFKA_RESP_ERR_LOG_DIR_NOT_FOUND = 57,
  RD_KAFKA_RESP_ERR_SASL_AUTHENTICATION_FAILED = 58,
  RD_KAFKA_RESP_ERR_UNKNOWN_PRODUCER_ID = 59,
  RD_KAFKA_RESP_ERR_REASSIGNMENT_IN_PROGRESS = 60,
  RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTH_DISABLED = 61,
  RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_NOT_FOUND = 62,
  RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_OWNER_MISMATCH = 63,
  RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_REQUEST_NOT_ALLOWED = 64,
  RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_AUTHORIZATION_FAILED = 65,
  RD_KAFKA_RESP_ERR_DELEGATION_TOKEN_EXPIRED = 66,
  RD_KAFKA_RESP_ERR_INVALID_PRINCIPAL_TYPE = 67,
  RD_KAFKA_RESP_ERR_NON_EMPTY_GROUP = 68,
  RD_KAFKA_RESP_ERR_GROUP_ID_NOT_FOUND = 69,
  RD_KAFKA_RESP_ERR_FETCH_SESSION_ID_NOT_FOUND = 70,
  RD_KAFKA_RESP_ERR_INVALID_FETCH_SESSION_EPOCH = 71,
  RD_KAFKA_RESP_ERR_LISTENER_NOT_FOUND = 72,
  RD_KAFKA_RESP_ERR_TOPIC_DELETION_DISABLED = 73,
  RD_KAFKA_RESP_ERR_FENCED_LEADER_EPOCH = 74,
  RD_KAFKA_RESP_ERR_UNKNOWN_LEADER_EPOCH = 75,
  RD_KAFKA_RESP_ERR_UNSUPPORTED_COMPRESSION_TYPE = 76,
  RD_KAFKA_RESP_ERR_STALE_BROKER_EPOCH = 77,
  RD_KAFKA_RESP_ERR_OFFSET_NOT_AVAILABLE = 78,
  RD_KAFKA_RESP_ERR_MEMBER_ID_REQUIRED = 79,
  RD_KAFKA_RESP_ERR_PREFERRED_LEADER_NOT_AVAILABLE = 80,
  RD_KAFKA_RESP_ERR_GROUP_MAX_SIZE_REACHED = 81,
  RD_KAFKA_RESP_ERR_FENCED_INSTANCE_ID = 82,
  RD_KAFKA_RESP_ERR_ELIGIBLE_LEADERS_NOT_AVAILABLE = 83,
  RD_KAFKA_RESP_ERR_ELECTION_NOT_NEEDED = 84,
  RD_KAFKA_RESP_ERR_NO_REASSIGNMENT_IN_PROGRESS = 85,
  RD_KAFKA_RESP_ERR_GROUP_SUBSCRIBED_TO_TOPIC = 86,
  RD_KAFKA_RESP_ERR_INVALID_RECORD = 87,
  RD_KAFKA_RESP_ERR_UNSTABLE_OFFSET_COMMIT = 88,
  RD_KAFKA_RESP_ERR_THROTTLING_QUOTA_EXCEEDED = 89,
  RD_KAFKA_RESP_ERR_PRODUCER_FENCED = 90,
  RD_KAFKA_RESP_ERR_RESOURCE_NOT_FOUND = 91,
  RD_KAFKA_RESP_ERR_DUPLICATE_RESOURCE = 92,
  RD_KAFKA_RESP_ERR_UNACCEPTABLE_CREDENTIAL = 93,
  RD_KAFKA_RESP_ERR_INCONSISTENT_VOTER_SET = 94,
  RD_KAFKA_RESP_ERR_INVALID_UPDATE_VERSION = 95,
  RD_KAFKA_RESP_ERR_FEATURE_UPDATE_FAILED = 96,
  RD_KAFKA_RESP_ERR_PRINCIPAL_DESERIALIZATION_FAILURE = 97,
  RD_KAFKA_RESP_ERR_END_ALL,
} rd_kafka_resp_err_t;
struct rd_kafka_err_desc {
  rd_kafka_resp_err_t code;
  char *name;
  char *desc;
};
void rd_kafka_get_err_descs(const struct rd_kafka_err_desc **errdescs, size_t *cntp);
const char *rd_kafka_err2str(rd_kafka_resp_err_t err);
const char *rd_kafka_err2name(rd_kafka_resp_err_t err);
rd_kafka_resp_err_t rd_kafka_last_error(void);
rd_kafka_resp_err_t rd_kafka_errno2err(int errnox);
int rd_kafka_errno(void);
rd_kafka_resp_err_t rd_kafka_fatal_error(rd_kafka_t *rk, char *errstr, size_t errstr_size);
rd_kafka_resp_err_t rd_kafka_test_fatal_error(rd_kafka_t *rk, rd_kafka_resp_err_t err, const char *reason);
rd_kafka_resp_err_t rd_kafka_error_code(const rd_kafka_error_t *error);
const char *rd_kafka_error_name(const rd_kafka_error_t *error);
const char *rd_kafka_error_string(const rd_kafka_error_t *error);
int rd_kafka_error_is_fatal(const rd_kafka_error_t *error);
int rd_kafka_error_is_retriable(const rd_kafka_error_t *error);
int rd_kafka_error_txn_requires_abort(const rd_kafka_error_t *error);
void rd_kafka_error_destroy(rd_kafka_error_t *error);
rd_kafka_error_t *rd_kafka_error_new(rd_kafka_resp_err_t code, const char *fmt, ...);
typedef struct rd_kafka_topic_partition_s {
  char *topic;
  int32_t partition;
  int64_t offset;
  void *metadata;
  size_t metadata_size;
  void *opaque;
  rd_kafka_resp_err_t err;
  void *_private;
} rd_kafka_topic_partition_t;
void rd_kafka_topic_partition_destroy(rd_kafka_topic_partition_t *rktpar);
typedef struct rd_kafka_topic_partition_list_s {
  int cnt;
  int size;
  rd_kafka_topic_partition_t *elems;
} rd_kafka_topic_partition_list_t;
rd_kafka_topic_partition_list_t *rd_kafka_topic_partition_list_new(int size);
void rd_kafka_topic_partition_list_destroy(rd_kafka_topic_partition_list_t *rkparlist);
rd_kafka_topic_partition_t *rd_kafka_topic_partition_list_add(rd_kafka_topic_partition_list_t *rktparlist, const char *topic, int32_t partition);
void rd_kafka_topic_partition_list_add_range(rd_kafka_topic_partition_list_t *rktparlist, const char *topic, int32_t start, int32_t stop);
int rd_kafka_topic_partition_list_del(rd_kafka_topic_partition_list_t *rktparlist, const char *topic, int32_t partition);
int rd_kafka_topic_partition_list_del_by_idx(rd_kafka_topic_partition_list_t *rktparlist, int idx);
rd_kafka_topic_partition_list_t *rd_kafka_topic_partition_list_copy(const rd_kafka_topic_partition_list_t *src);
rd_kafka_resp_err_t rd_kafka_topic_partition_list_set_offset(rd_kafka_topic_partition_list_t *rktparlist, const char *topic, int32_t partition, int64_t offset);
rd_kafka_topic_partition_t *rd_kafka_topic_partition_list_find(const rd_kafka_topic_partition_list_t *rktparlist, const char *topic, int32_t partition);
void rd_kafka_topic_partition_list_sort(rd_kafka_topic_partition_list_t *rktparlist, int (*cmp)(const void *a, const void *b, void *cmp_opaque), void *cmp_opaque);
typedef enum rd_kafka_vtype_t {
  RD_KAFKA_VTYPE_END,
  RD_KAFKA_VTYPE_TOPIC,
  RD_KAFKA_VTYPE_RKT,
  RD_KAFKA_VTYPE_PARTITION,
  RD_KAFKA_VTYPE_VALUE,
  RD_KAFKA_VTYPE_KEY,
  RD_KAFKA_VTYPE_OPAQUE,
  RD_KAFKA_VTYPE_MSGFLAGS,
  RD_KAFKA_VTYPE_TIMESTAMP,
  RD_KAFKA_VTYPE_HEADER,
  RD_KAFKA_VTYPE_HEADERS,
} rd_kafka_vtype_t;
typedef struct rd_kafka_vu_s {
  rd_kafka_vtype_t vtype;
  union {
    char *cstr;
    rd_kafka_topic_t *rkt;
    int i;
    int32_t i32;
    int64_t i64;
    struct {
      void *ptr;
      size_t size;
    } mem;
    struct {
      char *name;
      void *val;
      ssize_t size;
    } header;
    rd_kafka_headers_t *headers;
    void *ptr;
    char _pad[64];
  } u;
} rd_kafka_vu_t;
rd_kafka_headers_t *rd_kafka_headers_new(size_t initial_count);
void rd_kafka_headers_destroy(rd_kafka_headers_t *hdrs);
rd_kafka_headers_t *rd_kafka_headers_copy(const rd_kafka_headers_t *src);
rd_kafka_resp_err_t rd_kafka_header_add(rd_kafka_headers_t *hdrs, const char *name, ssize_t name_size, const void *value, ssize_t value_size);
rd_kafka_resp_err_t rd_kafka_header_remove(rd_kafka_headers_t *hdrs, const char *name);
rd_kafka_resp_err_t rd_kafka_header_get_last(const rd_kafka_headers_t *hdrs, const char *name, const void **valuep, size_t *sizep);
rd_kafka_resp_err_t rd_kafka_header_get(const rd_kafka_headers_t *hdrs, size_t idx, const char *name, const void **valuep, size_t *sizep);
rd_kafka_resp_err_t rd_kafka_header_get_all(const rd_kafka_headers_t *hdrs, size_t idx, const char **namep, const void **valuep, size_t *sizep);
typedef struct rd_kafka_message_s {
  rd_kafka_resp_err_t err;
  rd_kafka_topic_t *rkt;
  int32_t partition;
  void *payload;
  size_t len;
  void *key;
  size_t key_len;
  int64_t offset;
  void *_private;
} rd_kafka_message_t;
void rd_kafka_message_destroy(rd_kafka_message_t *rkmessage);
const char *rd_kafka_message_errstr(const rd_kafka_message_t *rkmessage);
int64_t rd_kafka_message_timestamp(const rd_kafka_message_t *rkmessage, rd_kafka_timestamp_type_t *tstype);
int64_t rd_kafka_message_latency(const rd_kafka_message_t *rkmessage);
int32_t rd_kafka_message_broker_id(const rd_kafka_message_t *rkmessage);
rd_kafka_resp_err_t rd_kafka_message_headers(const rd_kafka_message_t *rkmessage, rd_kafka_headers_t **hdrsp);
rd_kafka_resp_err_t rd_kafka_message_detach_headers(rd_kafka_message_t *rkmessage, rd_kafka_headers_t **hdrsp);
void rd_kafka_message_set_headers(rd_kafka_message_t *rkmessage, rd_kafka_headers_t *hdrs);
size_t rd_kafka_header_cnt(const rd_kafka_headers_t *hdrs);
typedef enum {
  RD_KAFKA_MSG_STATUS_NOT_PERSISTED = 0,
  RD_KAFKA_MSG_STATUS_POSSIBLY_PERSISTED = 1,
  RD_KAFKA_MSG_STATUS_PERSISTED = 2,
} rd_kafka_msg_status_t;
rd_kafka_msg_status_t rd_kafka_message_status(const rd_kafka_message_t *rkmessage);
typedef enum {
  RD_KAFKA_CONF_UNKNOWN = (- 2),
  RD_KAFKA_CONF_INVALID = (- 1),
  RD_KAFKA_CONF_OK = 0,
} rd_kafka_conf_res_t;
rd_kafka_conf_t *rd_kafka_conf_new(void);
void rd_kafka_conf_destroy(rd_kafka_conf_t *conf);
rd_kafka_conf_t *rd_kafka_conf_dup(const rd_kafka_conf_t *conf);
rd_kafka_conf_t *rd_kafka_conf_dup_filter(const rd_kafka_conf_t *conf, size_t filter_cnt, const char **filter);
const rd_kafka_conf_t *rd_kafka_conf(rd_kafka_t *rk);
rd_kafka_conf_res_t rd_kafka_conf_set(rd_kafka_conf_t *conf, const char *name, const char *value, char *errstr, size_t errstr_size);
void rd_kafka_conf_set_events(rd_kafka_conf_t *conf, int events);
void rd_kafka_conf_set_background_event_cb(rd_kafka_conf_t *conf, void (*event_cb)(rd_kafka_t *rk, rd_kafka_event_t *rkev, void *opaque));
void rd_kafka_conf_set_dr_cb(rd_kafka_conf_t *conf, void (*dr_cb)(rd_kafka_t *rk, void *payload, size_t len, rd_kafka_resp_err_t err, void *opaque, void *msg_opaque));
void rd_kafka_conf_set_dr_msg_cb(rd_kafka_conf_t *conf, void (*dr_msg_cb)(rd_kafka_t *rk, const rd_kafka_message_t *rkmessage, void *opaque));
void rd_kafka_conf_set_consume_cb(rd_kafka_conf_t *conf, void (*consume_cb)(rd_kafka_message_t *rkmessage, void *opaque));
void rd_kafka_conf_set_rebalance_cb(rd_kafka_conf_t *conf, void (*rebalance_cb)(rd_kafka_t *rk, rd_kafka_resp_err_t err, rd_kafka_topic_partition_list_t *partitions, void *opaque));
void rd_kafka_conf_set_offset_commit_cb(rd_kafka_conf_t *conf, void (*offset_commit_cb)(rd_kafka_t *rk, rd_kafka_resp_err_t err, rd_kafka_topic_partition_list_t *offsets, void *opaque));
void rd_kafka_conf_set_error_cb(rd_kafka_conf_t *conf, void (*error_cb)(rd_kafka_t *rk, int err, const char *reason, void *opaque));
void rd_kafka_conf_set_throttle_cb(rd_kafka_conf_t *conf, void (*throttle_cb)(rd_kafka_t *rk, const char *broker_name, int32_t broker_id, int throttle_time_ms, void *opaque));
void rd_kafka_conf_set_log_cb(rd_kafka_conf_t *conf, void (*log_cb)(const rd_kafka_t *rk, int level, const char *fac, const char *buf));
void rd_kafka_conf_set_stats_cb(rd_kafka_conf_t *conf, int (*stats_cb)(rd_kafka_t *rk, char *json, size_t json_len, void *opaque));
void rd_kafka_conf_set_oauthbearer_token_refresh_cb(rd_kafka_conf_t *conf, void (*oauthbearer_token_refresh_cb)(rd_kafka_t *rk, const char *oauthbearer_config, void *opaque));
void rd_kafka_conf_enable_sasl_queue(rd_kafka_conf_t *conf, int enable);
void rd_kafka_conf_set_socket_cb(rd_kafka_conf_t *conf, int (*socket_cb)(int domain, int type, int protocol, void *opaque));
void rd_kafka_conf_set_connect_cb(rd_kafka_conf_t *conf, int (*connect_cb)(int sockfd, const struct sockaddr *addr, int addrlen, const char *id, void *opaque));
void rd_kafka_conf_set_closesocket_cb(rd_kafka_conf_t *conf, int (*closesocket_cb)(int sockfd, void *opaque));
rd_kafka_conf_res_t rd_kafka_conf_set_ssl_cert_verify_cb(rd_kafka_conf_t *conf, int (*ssl_cert_verify_cb)(rd_kafka_t *rk, const char *broker_name, int32_t broker_id, int *x509_error, int depth, const char *buf, size_t size, char *errstr, size_t errstr_size, void *opaque));
typedef enum rd_kafka_cert_type_t {
  RD_KAFKA_CERT_PUBLIC_KEY,
  RD_KAFKA_CERT_PRIVATE_KEY,
  RD_KAFKA_CERT_CA,
  RD_KAFKA_CERT__CNT,
} rd_kafka_cert_type_t;
typedef enum rd_kafka_cert_enc_t {
  RD_KAFKA_CERT_ENC_PKCS12,
  RD_KAFKA_CERT_ENC_DER,
  RD_KAFKA_CERT_ENC_PEM,
  RD_KAFKA_CERT_ENC__CNT,
} rd_kafka_cert_enc_t;
rd_kafka_conf_res_t rd_kafka_conf_set_ssl_cert(rd_kafka_conf_t *conf, rd_kafka_cert_type_t cert_type, rd_kafka_cert_enc_t cert_enc, const void *buffer, size_t size, char *errstr, size_t errstr_size);
void rd_kafka_conf_set_engine_callback_data(rd_kafka_conf_t *conf, void *callback_data);
void rd_kafka_conf_set_opaque(rd_kafka_conf_t *conf, void *opaque);
void *rd_kafka_opaque(const rd_kafka_t *rk);
void rd_kafka_conf_set_default_topic_conf(rd_kafka_conf_t *conf, rd_kafka_topic_conf_t *tconf);
rd_kafka_topic_conf_t *rd_kafka_conf_get_default_topic_conf(rd_kafka_conf_t *conf);
rd_kafka_conf_res_t rd_kafka_conf_get(const rd_kafka_conf_t *conf, const char *name, char *dest, size_t *dest_size);
rd_kafka_conf_res_t rd_kafka_topic_conf_get(const rd_kafka_topic_conf_t *conf, const char *name, char *dest, size_t *dest_size);
const char **rd_kafka_conf_dump(rd_kafka_conf_t *conf, size_t *cntp);
const char **rd_kafka_topic_conf_dump(rd_kafka_topic_conf_t *conf, size_t *cntp);
void rd_kafka_conf_dump_free(const char **arr, size_t cnt);
void rd_kafka_conf_properties_show(FILE *fp);
rd_kafka_topic_conf_t *rd_kafka_topic_conf_new(void);
rd_kafka_topic_conf_t *rd_kafka_topic_conf_dup(const rd_kafka_topic_conf_t *conf);
rd_kafka_topic_conf_t *rd_kafka_default_topic_conf_dup(rd_kafka_t *rk);
void rd_kafka_topic_conf_destroy(rd_kafka_topic_conf_t *topic_conf);
rd_kafka_conf_res_t rd_kafka_topic_conf_set(rd_kafka_topic_conf_t *conf, const char *name, const char *value, char *errstr, size_t errstr_size);
void rd_kafka_topic_conf_set_opaque(rd_kafka_topic_conf_t *conf, void *rkt_opaque);
void rd_kafka_topic_conf_set_partitioner_cb(rd_kafka_topic_conf_t *topic_conf, int32_t (*partitioner)(const rd_kafka_topic_t *rkt, const void *keydata, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque));
void rd_kafka_topic_conf_set_msg_order_cmp(rd_kafka_topic_conf_t *topic_conf, int (*msg_order_cmp)(const rd_kafka_message_t *a, const rd_kafka_message_t *b));
int rd_kafka_topic_partition_available(const rd_kafka_topic_t *rkt, int32_t partition);
int32_t rd_kafka_msg_partitioner_random(const rd_kafka_topic_t *rkt, const void *key, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque);
int32_t rd_kafka_msg_partitioner_consistent(const rd_kafka_topic_t *rkt, const void *key, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque);
int32_t rd_kafka_msg_partitioner_consistent_random(const rd_kafka_topic_t *rkt, const void *key, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque);
int32_t rd_kafka_msg_partitioner_murmur2(const rd_kafka_topic_t *rkt, const void *key, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque);
int32_t rd_kafka_msg_partitioner_murmur2_random(const rd_kafka_topic_t *rkt, const void *key, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque);
int32_t rd_kafka_msg_partitioner_fnv1a(const rd_kafka_topic_t *rkt, const void *key, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque);
int32_t rd_kafka_msg_partitioner_fnv1a_random(const rd_kafka_topic_t *rkt, const void *key, size_t keylen, int32_t partition_cnt, void *rkt_opaque, void *msg_opaque);
rd_kafka_t *rd_kafka_new(rd_kafka_type_t type, rd_kafka_conf_t *conf, char *errstr, size_t errstr_size);
void rd_kafka_destroy(rd_kafka_t *rk);
void rd_kafka_destroy_flags(rd_kafka_t *rk, int flags);
const char *rd_kafka_name(const rd_kafka_t *rk);
rd_kafka_type_t rd_kafka_type(const rd_kafka_t *rk);
char *rd_kafka_memberid(const rd_kafka_t *rk);
char *rd_kafka_clusterid(rd_kafka_t *rk, int timeout_ms);
int32_t rd_kafka_controllerid(rd_kafka_t *rk, int timeout_ms);
rd_kafka_topic_t *rd_kafka_topic_new(rd_kafka_t *rk, const char *topic, rd_kafka_topic_conf_t *conf);
void rd_kafka_topic_destroy(rd_kafka_topic_t *rkt);
const char *rd_kafka_topic_name(const rd_kafka_topic_t *rkt);
void *rd_kafka_topic_opaque(const rd_kafka_topic_t *rkt);
int rd_kafka_poll(rd_kafka_t *rk, int timeout_ms);
void rd_kafka_yield(rd_kafka_t *rk);
rd_kafka_resp_err_t rd_kafka_pause_partitions(rd_kafka_t *rk, rd_kafka_topic_partition_list_t *partitions);
rd_kafka_resp_err_t rd_kafka_resume_partitions(rd_kafka_t *rk, rd_kafka_topic_partition_list_t *partitions);
rd_kafka_resp_err_t rd_kafka_query_watermark_offsets(rd_kafka_t *rk, const char *topic, int32_t partition, int64_t *low, int64_t *high, int timeout_ms);
rd_kafka_resp_err_t rd_kafka_get_watermark_offsets(rd_kafka_t *rk, const char *topic, int32_t partition, int64_t *low, int64_t *high);
rd_kafka_resp_err_t rd_kafka_offsets_for_times(rd_kafka_t *rk, rd_kafka_topic_partition_list_t *offsets, int timeout_ms);
void *rd_kafka_mem_calloc(rd_kafka_t *rk, size_t num, size_t size);
void *rd_kafka_mem_malloc(rd_kafka_t *rk, size_t size);
void rd_kafka_mem_free(rd_kafka_t *rk, void *ptr);
rd_kafka_queue_t *rd_kafka_queue_new(rd_kafka_t *rk);
void rd_kafka_queue_destroy(rd_kafka_queue_t *rkqu);
rd_kafka_queue_t *rd_kafka_queue_get_main(rd_kafka_t *rk);
rd_kafka_queue_t *rd_kafka_queue_get_sasl(rd_kafka_t *rk);
rd_kafka_error_t *rd_kafka_sasl_background_callbacks_enable(rd_kafka_t *rk);
rd_kafka_queue_t *rd_kafka_queue_get_consumer(rd_kafka_t *rk);
rd_kafka_queue_t *rd_kafka_queue_get_partition(rd_kafka_t *rk, const char *topic, int32_t partition);
rd_kafka_queue_t *rd_kafka_queue_get_background(rd_kafka_t *rk);
void rd_kafka_queue_forward(rd_kafka_queue_t *src, rd_kafka_queue_t *dst);
rd_kafka_resp_err_t rd_kafka_set_log_queue(rd_kafka_t *rk, rd_kafka_queue_t *rkqu);
size_t rd_kafka_queue_length(rd_kafka_queue_t *rkqu);
void rd_kafka_queue_io_event_enable(rd_kafka_queue_t *rkqu, int fd, const void *payload, size_t size);
void rd_kafka_queue_cb_event_enable(rd_kafka_queue_t *rkqu, void (*event_cb)(rd_kafka_t *rk, void *qev_opaque), void *qev_opaque);
void rd_kafka_queue_yield(rd_kafka_queue_t *rkqu);
int rd_kafka_consume_start(rd_kafka_topic_t *rkt, int32_t partition, int64_t offset);
int rd_kafka_consume_start_queue(rd_kafka_topic_t *rkt, int32_t partition, int64_t offset, rd_kafka_queue_t *rkqu);
int rd_kafka_consume_stop(rd_kafka_topic_t *rkt, int32_t partition);
rd_kafka_resp_err_t rd_kafka_seek(rd_kafka_topic_t *rkt, int32_t partition, int64_t offset, int timeout_ms);
rd_kafka_error_t *rd_kafka_seek_partitions(rd_kafka_t *rk, rd_kafka_topic_partition_list_t *partitions, int timeout_ms);
rd_kafka_message_t *rd_kafka_consume(rd_kafka_topic_t *rkt, int32_t partition, int timeout_ms);
ssize_t rd_kafka_consume_batch(rd_kafka_topic_t *rkt, int32_t partition, int timeout_ms, rd_kafka_message_t **rkmessages, size_t rkmessages_size);
int rd_kafka_consume_callback(rd_kafka_topic_t *rkt, int32_t partition, int timeout_ms, void (*consume_cb)(rd_kafka_message_t *rkmessage, void *commit_opaque), void *commit_opaque);
rd_kafka_message_t *rd_kafka_consume_queue(rd_kafka_queue_t *rkqu, int timeout_ms);
ssize_t rd_kafka_consume_batch_queue(rd_kafka_queue_t *rkqu, int timeout_ms, rd_kafka_message_t **rkmessages, size_t rkmessages_size);
int rd_kafka_consume_callback_queue(rd_kafka_queue_t *rkqu, int timeout_ms, void (*consume_cb)(rd_kafka_message_t *rkmessage, void *commit_opaque), void *commit_opaque);
rd_kafka_resp_err_t rd_kafka_offset_store(rd_kafka_topic_t *rkt, int32_t partition, int64_t offset);
rd_kafka_resp_err_t rd_kafka_offsets_store(rd_kafka_t *rk, rd_kafka_topic_partition_list_t *offsets);
rd_kafka_resp_err_t rd_kafka_subscribe(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *topics);
rd_kafka_resp_err_t rd_kafka_unsubscribe(rd_kafka_t *rk);
rd_kafka_resp_err_t rd_kafka_subscription(rd_kafka_t *rk, rd_kafka_topic_partition_list_t **topics);
rd_kafka_message_t *rd_kafka_consumer_poll(rd_kafka_t *rk, int timeout_ms);
rd_kafka_resp_err_t rd_kafka_consumer_close(rd_kafka_t *rk);
rd_kafka_error_t *rd_kafka_consumer_close_queue(rd_kafka_t *rk, rd_kafka_queue_t *rkqu);
int rd_kafka_consumer_closed(rd_kafka_t *rk);
rd_kafka_error_t *rd_kafka_incremental_assign(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *partitions);
rd_kafka_error_t *rd_kafka_incremental_unassign(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *partitions);
const char *rd_kafka_rebalance_protocol(rd_kafka_t *rk);
rd_kafka_resp_err_t rd_kafka_assign(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *partitions);
rd_kafka_resp_err_t rd_kafka_assignment(rd_kafka_t *rk, rd_kafka_topic_partition_list_t **partitions);
int rd_kafka_assignment_lost(rd_kafka_t *rk);
rd_kafka_resp_err_t rd_kafka_commit(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *offsets, int async);
rd_kafka_resp_err_t rd_kafka_commit_message(rd_kafka_t *rk, const rd_kafka_message_t *rkmessage, int async);
rd_kafka_resp_err_t rd_kafka_commit_queue(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *offsets, rd_kafka_queue_t *rkqu, void (*cb)(rd_kafka_t *rk, rd_kafka_resp_err_t err, rd_kafka_topic_partition_list_t *offsets, void *commit_opaque), void *commit_opaque);
rd_kafka_resp_err_t rd_kafka_committed(rd_kafka_t *rk, rd_kafka_topic_partition_list_t *partitions, int timeout_ms);
rd_kafka_resp_err_t rd_kafka_position(rd_kafka_t *rk, rd_kafka_topic_partition_list_t *partitions);
rd_kafka_consumer_group_metadata_t *rd_kafka_consumer_group_metadata(rd_kafka_t *rk);
rd_kafka_consumer_group_metadata_t *rd_kafka_consumer_group_metadata_new(const char *group_id);
rd_kafka_consumer_group_metadata_t *rd_kafka_consumer_group_metadata_new_with_genid(const char *group_id, int32_t generation_id, const char *member_id, const char *group_instance_id);
void rd_kafka_consumer_group_metadata_destroy(rd_kafka_consumer_group_metadata_t *);
rd_kafka_error_t *rd_kafka_consumer_group_metadata_write(const rd_kafka_consumer_group_metadata_t *cgmd, void **bufferp, size_t *sizep);
rd_kafka_error_t *rd_kafka_consumer_group_metadata_read(rd_kafka_consumer_group_metadata_t **cgmdp, const void *buffer, size_t size);
int rd_kafka_produce(rd_kafka_topic_t *rkt, int32_t partition, int msgflags, void *payload, size_t len, const void *key, size_t keylen, void *msg_opaque);
rd_kafka_resp_err_t rd_kafka_producev(rd_kafka_t *rk, ...);
rd_kafka_error_t *rd_kafka_produceva(rd_kafka_t *rk, const rd_kafka_vu_t *vus, size_t cnt);
int rd_kafka_produce_batch(rd_kafka_topic_t *rkt, int32_t partition, int msgflags, rd_kafka_message_t *rkmessages, int message_cnt);
rd_kafka_resp_err_t rd_kafka_flush(rd_kafka_t *rk, int timeout_ms);
rd_kafka_resp_err_t rd_kafka_purge(rd_kafka_t *rk, int purge_flags);
typedef struct rd_kafka_metadata_broker {
  int32_t id;
  char *host;
  int port;
} rd_kafka_metadata_broker_t;
typedef struct rd_kafka_metadata_partition {
  int32_t id;
  rd_kafka_resp_err_t err;
  int32_t leader;
  int replica_cnt;
  int32_t *replicas;
  int isr_cnt;
  int32_t *isrs;
} rd_kafka_metadata_partition_t;
typedef struct rd_kafka_metadata_topic {
  char *topic;
  int partition_cnt;
  struct rd_kafka_metadata_partition *partitions;
  rd_kafka_resp_err_t err;
} rd_kafka_metadata_topic_t;
typedef struct rd_kafka_metadata {
  int broker_cnt;
  struct rd_kafka_metadata_broker *brokers;
  int topic_cnt;
  struct rd_kafka_metadata_topic *topics;
  int32_t orig_broker_id;
  char *orig_broker_name;
} rd_kafka_metadata_t;
rd_kafka_resp_err_t rd_kafka_metadata(rd_kafka_t *rk, int all_topics, rd_kafka_topic_t *only_rkt, const struct rd_kafka_metadata **metadatap, int timeout_ms);
void rd_kafka_metadata_destroy(const struct rd_kafka_metadata *metadata);
struct rd_kafka_group_member_info {
  char *member_id;
  char *client_id;
  char *client_host;
  void *member_metadata;
  int member_metadata_size;
  void *member_assignment;
  int member_assignment_size;
};
struct rd_kafka_group_info {
  struct rd_kafka_metadata_broker broker;
  char *group;
  rd_kafka_resp_err_t err;
  char *state;
  char *protocol_type;
  char *protocol;
  struct rd_kafka_group_member_info *members;
  int member_cnt;
};
struct rd_kafka_group_list {
  struct rd_kafka_group_info *groups;
  int group_cnt;
};
rd_kafka_resp_err_t rd_kafka_list_groups(rd_kafka_t *rk, const char *group, const struct rd_kafka_group_list **grplistp, int timeout_ms);
void rd_kafka_group_list_destroy(const struct rd_kafka_group_list *grplist);
int rd_kafka_brokers_add(rd_kafka_t *rk, const char *brokerlist);
void rd_kafka_set_logger(rd_kafka_t *rk, void (*func)(const rd_kafka_t *rk, int level, const char *fac, const char *buf));
void rd_kafka_set_log_level(rd_kafka_t *rk, int level);
void rd_kafka_log_print(const rd_kafka_t *rk, int level, const char *fac, const char *buf);
void rd_kafka_log_syslog(const rd_kafka_t *rk, int level, const char *fac, const char *buf);
int rd_kafka_outq_len(rd_kafka_t *rk);
void rd_kafka_dump(FILE *fp, rd_kafka_t *rk);
int rd_kafka_thread_cnt(void);
typedef enum rd_kafka_thread_type_t {
  RD_KAFKA_THREAD_MAIN,
  RD_KAFKA_THREAD_BACKGROUND,
  RD_KAFKA_THREAD_BROKER,
} rd_kafka_thread_type_t;
int rd_kafka_wait_destroyed(int timeout_ms);
int rd_kafka_unittest(void);
rd_kafka_resp_err_t rd_kafka_poll_set_consumer(rd_kafka_t *rk);
typedef int rd_kafka_event_type_t;
rd_kafka_event_type_t rd_kafka_event_type(const rd_kafka_event_t *rkev);
const char *rd_kafka_event_name(const rd_kafka_event_t *rkev);
void rd_kafka_event_destroy(rd_kafka_event_t *rkev);
const rd_kafka_message_t *rd_kafka_event_message_next(rd_kafka_event_t *rkev);
size_t rd_kafka_event_message_array(rd_kafka_event_t *rkev, const rd_kafka_message_t **rkmessages, size_t size);
size_t rd_kafka_event_message_count(rd_kafka_event_t *rkev);
const char *rd_kafka_event_config_string(rd_kafka_event_t *rkev);
rd_kafka_resp_err_t rd_kafka_event_error(rd_kafka_event_t *rkev);
const char *rd_kafka_event_error_string(rd_kafka_event_t *rkev);
int rd_kafka_event_error_is_fatal(rd_kafka_event_t *rkev);
void *rd_kafka_event_opaque(rd_kafka_event_t *rkev);
int rd_kafka_event_log(rd_kafka_event_t *rkev, const char **fac, const char **str, int *level);
int rd_kafka_event_debug_contexts(rd_kafka_event_t *rkev, char *dst, size_t dstsize);
const char *rd_kafka_event_stats(rd_kafka_event_t *rkev);
rd_kafka_topic_partition_list_t *rd_kafka_event_topic_partition_list(rd_kafka_event_t *rkev);
rd_kafka_topic_partition_t *rd_kafka_event_topic_partition(rd_kafka_event_t *rkev);
typedef rd_kafka_event_t rd_kafka_CreateTopics_result_t;
typedef rd_kafka_event_t rd_kafka_DeleteTopics_result_t;
typedef rd_kafka_event_t rd_kafka_CreateAcls_result_t;
typedef rd_kafka_event_t rd_kafka_DescribeAcls_result_t;
typedef rd_kafka_event_t rd_kafka_DeleteAcls_result_t;
typedef rd_kafka_event_t rd_kafka_CreatePartitions_result_t;
typedef rd_kafka_event_t rd_kafka_AlterConfigs_result_t;
typedef rd_kafka_event_t rd_kafka_DescribeConfigs_result_t;
typedef rd_kafka_event_t rd_kafka_DeleteRecords_result_t;
typedef rd_kafka_event_t rd_kafka_DeleteGroups_result_t;
typedef rd_kafka_event_t rd_kafka_DeleteConsumerGroupOffsets_result_t;
const rd_kafka_CreateTopics_result_t *rd_kafka_event_CreateTopics_result(rd_kafka_event_t *rkev);
const rd_kafka_DeleteTopics_result_t *rd_kafka_event_DeleteTopics_result(rd_kafka_event_t *rkev);
const rd_kafka_CreatePartitions_result_t *rd_kafka_event_CreatePartitions_result(rd_kafka_event_t *rkev);
const rd_kafka_AlterConfigs_result_t *rd_kafka_event_AlterConfigs_result(rd_kafka_event_t *rkev);
const rd_kafka_DescribeConfigs_result_t *rd_kafka_event_DescribeConfigs_result(rd_kafka_event_t *rkev);
const rd_kafka_DeleteRecords_result_t *rd_kafka_event_DeleteRecords_result(rd_kafka_event_t *rkev);
const rd_kafka_DeleteGroups_result_t *rd_kafka_event_DeleteGroups_result(rd_kafka_event_t *rkev);
const rd_kafka_DeleteConsumerGroupOffsets_result_t *rd_kafka_event_DeleteConsumerGroupOffsets_result(rd_kafka_event_t *rkev);
const rd_kafka_CreateAcls_result_t *rd_kafka_event_CreateAcls_result(rd_kafka_event_t *rkev);
const rd_kafka_DescribeAcls_result_t *rd_kafka_event_DescribeAcls_result(rd_kafka_event_t *rkev);
const rd_kafka_DeleteAcls_result_t *rd_kafka_event_DeleteAcls_result(rd_kafka_event_t *rkev);
rd_kafka_event_t *rd_kafka_queue_poll(rd_kafka_queue_t *rkqu, int timeout_ms);
int rd_kafka_queue_poll_callback(rd_kafka_queue_t *rkqu, int timeout_ms);
typedef rd_kafka_resp_err_t (rd_kafka_plugin_f_conf_init_t)(rd_kafka_conf_t *conf, void **plug_opaquep, char *errstr, size_t errstr_size);
typedef rd_kafka_conf_res_t (rd_kafka_interceptor_f_on_conf_set_t)(rd_kafka_conf_t *conf, const char *name, const char *val, char *errstr, size_t errstr_size, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_conf_dup_t)(rd_kafka_conf_t *new_conf, const rd_kafka_conf_t *old_conf, size_t filter_cnt, const char **filter, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_conf_destroy_t)(void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_new_t)(rd_kafka_t *rk, const rd_kafka_conf_t *conf, void *ic_opaque, char *errstr, size_t errstr_size);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_destroy_t)(rd_kafka_t *rk, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_send_t)(rd_kafka_t *rk, rd_kafka_message_t *rkmessage, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_acknowledgement_t)(rd_kafka_t *rk, rd_kafka_message_t *rkmessage, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_consume_t)(rd_kafka_t *rk, rd_kafka_message_t *rkmessage, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_commit_t)(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *offsets, rd_kafka_resp_err_t err, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_request_sent_t)(rd_kafka_t *rk, int sockfd, const char *brokername, int32_t brokerid, int16_t ApiKey, int16_t ApiVersion, int32_t CorrId, size_t size, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_response_received_t)(rd_kafka_t *rk, int sockfd, const char *brokername, int32_t brokerid, int16_t ApiKey, int16_t ApiVersion, int32_t CorrId, size_t size, int64_t rtt, rd_kafka_resp_err_t err, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_thread_start_t)(rd_kafka_t *rk, rd_kafka_thread_type_t thread_type, const char *thread_name, void *ic_opaque);
typedef rd_kafka_resp_err_t (rd_kafka_interceptor_f_on_thread_exit_t)(rd_kafka_t *rk, rd_kafka_thread_type_t thread_type, const char *thread_name, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_conf_interceptor_add_on_conf_set(rd_kafka_conf_t *conf, const char *ic_name, rd_kafka_interceptor_f_on_conf_set_t *on_conf_set, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_conf_interceptor_add_on_conf_dup(rd_kafka_conf_t *conf, const char *ic_name, rd_kafka_interceptor_f_on_conf_dup_t *on_conf_dup, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_conf_interceptor_add_on_conf_destroy(rd_kafka_conf_t *conf, const char *ic_name, rd_kafka_interceptor_f_on_conf_destroy_t *on_conf_destroy, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_conf_interceptor_add_on_new(rd_kafka_conf_t *conf, const char *ic_name, rd_kafka_interceptor_f_on_new_t *on_new, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_destroy(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_destroy_t *on_destroy, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_send(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_send_t *on_send, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_acknowledgement(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_acknowledgement_t *on_acknowledgement, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_consume(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_consume_t *on_consume, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_commit(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_commit_t *on_commit, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_request_sent(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_request_sent_t *on_request_sent, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_response_received(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_response_received_t *on_response_received, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_thread_start(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_thread_start_t *on_thread_start, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_interceptor_add_on_thread_exit(rd_kafka_t *rk, const char *ic_name, rd_kafka_interceptor_f_on_thread_exit_t *on_thread_exit, void *ic_opaque);
rd_kafka_resp_err_t rd_kafka_topic_result_error(const rd_kafka_topic_result_t *topicres);
const char *rd_kafka_topic_result_error_string(const rd_kafka_topic_result_t *topicres);
const char *rd_kafka_topic_result_name(const rd_kafka_topic_result_t *topicres);
const rd_kafka_error_t *rd_kafka_group_result_error(const rd_kafka_group_result_t *groupres);
const char *rd_kafka_group_result_name(const rd_kafka_group_result_t *groupres);
const rd_kafka_topic_partition_list_t *rd_kafka_group_result_partitions(const rd_kafka_group_result_t *groupres);
typedef enum rd_kafka_admin_op_t {
  RD_KAFKA_ADMIN_OP_ANY = 0,
  RD_KAFKA_ADMIN_OP_CREATETOPICS,
  RD_KAFKA_ADMIN_OP_DELETETOPICS,
  RD_KAFKA_ADMIN_OP_CREATEPARTITIONS,
  RD_KAFKA_ADMIN_OP_ALTERCONFIGS,
  RD_KAFKA_ADMIN_OP_DESCRIBECONFIGS,
  RD_KAFKA_ADMIN_OP_DELETERECORDS,
  RD_KAFKA_ADMIN_OP_DELETEGROUPS,
  RD_KAFKA_ADMIN_OP_DELETECONSUMERGROUPOFFSETS,
  RD_KAFKA_ADMIN_OP_CREATEACLS,
  RD_KAFKA_ADMIN_OP_DESCRIBEACLS,
  RD_KAFKA_ADMIN_OP_DELETEACLS,
  RD_KAFKA_ADMIN_OP__CNT,
} rd_kafka_admin_op_t;
typedef struct rd_kafka_AdminOptions_s rd_kafka_AdminOptions_t;
rd_kafka_AdminOptions_t *rd_kafka_AdminOptions_new(rd_kafka_t *rk, rd_kafka_admin_op_t for_api);
void rd_kafka_AdminOptions_destroy(rd_kafka_AdminOptions_t *options);
rd_kafka_resp_err_t rd_kafka_AdminOptions_set_request_timeout(rd_kafka_AdminOptions_t *options, int timeout_ms, char *errstr, size_t errstr_size);
rd_kafka_resp_err_t rd_kafka_AdminOptions_set_operation_timeout(rd_kafka_AdminOptions_t *options, int timeout_ms, char *errstr, size_t errstr_size);
rd_kafka_resp_err_t rd_kafka_AdminOptions_set_validate_only(rd_kafka_AdminOptions_t *options, int true_or_false, char *errstr, size_t errstr_size);
rd_kafka_resp_err_t rd_kafka_AdminOptions_set_broker(rd_kafka_AdminOptions_t *options, int32_t broker_id, char *errstr, size_t errstr_size);
void rd_kafka_AdminOptions_set_opaque(rd_kafka_AdminOptions_t *options, void *ev_opaque);
typedef struct rd_kafka_NewTopic_s rd_kafka_NewTopic_t;
rd_kafka_NewTopic_t *rd_kafka_NewTopic_new(const char *topic, int num_partitions, int replication_factor, char *errstr, size_t errstr_size);
void rd_kafka_NewTopic_destroy(rd_kafka_NewTopic_t *new_topic);
void rd_kafka_NewTopic_destroy_array(rd_kafka_NewTopic_t **new_topics, size_t new_topic_cnt);
rd_kafka_resp_err_t rd_kafka_NewTopic_set_replica_assignment(rd_kafka_NewTopic_t *new_topic, int32_t partition, int32_t *broker_ids, size_t broker_id_cnt, char *errstr, size_t errstr_size);
rd_kafka_resp_err_t rd_kafka_NewTopic_set_config(rd_kafka_NewTopic_t *new_topic, const char *name, const char *value);
void rd_kafka_CreateTopics(rd_kafka_t *rk, rd_kafka_NewTopic_t **new_topics, size_t new_topic_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_topic_result_t **rd_kafka_CreateTopics_result_topics(const rd_kafka_CreateTopics_result_t *result, size_t *cntp);
typedef struct rd_kafka_DeleteTopic_s rd_kafka_DeleteTopic_t;
rd_kafka_DeleteTopic_t *rd_kafka_DeleteTopic_new(const char *topic);
void rd_kafka_DeleteTopic_destroy(rd_kafka_DeleteTopic_t *del_topic);
void rd_kafka_DeleteTopic_destroy_array(rd_kafka_DeleteTopic_t **del_topics, size_t del_topic_cnt);
void rd_kafka_DeleteTopics(rd_kafka_t *rk, rd_kafka_DeleteTopic_t **del_topics, size_t del_topic_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_topic_result_t **rd_kafka_DeleteTopics_result_topics(const rd_kafka_DeleteTopics_result_t *result, size_t *cntp);
typedef struct rd_kafka_NewPartitions_s rd_kafka_NewPartitions_t;
rd_kafka_NewPartitions_t *rd_kafka_NewPartitions_new(const char *topic, size_t new_total_cnt, char *errstr, size_t errstr_size);
void rd_kafka_NewPartitions_destroy(rd_kafka_NewPartitions_t *new_parts);
void rd_kafka_NewPartitions_destroy_array(rd_kafka_NewPartitions_t **new_parts, size_t new_parts_cnt);
rd_kafka_resp_err_t rd_kafka_NewPartitions_set_replica_assignment(rd_kafka_NewPartitions_t *new_parts, int32_t new_partition_idx, int32_t *broker_ids, size_t broker_id_cnt, char *errstr, size_t errstr_size);
void rd_kafka_CreatePartitions(rd_kafka_t *rk, rd_kafka_NewPartitions_t **new_parts, size_t new_parts_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_topic_result_t **rd_kafka_CreatePartitions_result_topics(const rd_kafka_CreatePartitions_result_t *result, size_t *cntp);
typedef enum rd_kafka_ConfigSource_t {
  RD_KAFKA_CONFIG_SOURCE_UNKNOWN_CONFIG = 0,
  RD_KAFKA_CONFIG_SOURCE_DYNAMIC_TOPIC_CONFIG = 1,
  RD_KAFKA_CONFIG_SOURCE_DYNAMIC_BROKER_CONFIG = 2,
  RD_KAFKA_CONFIG_SOURCE_DYNAMIC_DEFAULT_BROKER_CONFIG = 3,
  RD_KAFKA_CONFIG_SOURCE_STATIC_BROKER_CONFIG = 4,
  RD_KAFKA_CONFIG_SOURCE_DEFAULT_CONFIG = 5,
  RD_KAFKA_CONFIG_SOURCE__CNT,
} rd_kafka_ConfigSource_t;
const char *rd_kafka_ConfigSource_name(rd_kafka_ConfigSource_t confsource);
typedef struct rd_kafka_ConfigEntry_s rd_kafka_ConfigEntry_t;
const char *rd_kafka_ConfigEntry_name(const rd_kafka_ConfigEntry_t *entry);
const char *rd_kafka_ConfigEntry_value(const rd_kafka_ConfigEntry_t *entry);
rd_kafka_ConfigSource_t rd_kafka_ConfigEntry_source(const rd_kafka_ConfigEntry_t *entry);
int rd_kafka_ConfigEntry_is_read_only(const rd_kafka_ConfigEntry_t *entry);
int rd_kafka_ConfigEntry_is_default(const rd_kafka_ConfigEntry_t *entry);
int rd_kafka_ConfigEntry_is_sensitive(const rd_kafka_ConfigEntry_t *entry);
int rd_kafka_ConfigEntry_is_synonym(const rd_kafka_ConfigEntry_t *entry);
const rd_kafka_ConfigEntry_t **rd_kafka_ConfigEntry_synonyms(const rd_kafka_ConfigEntry_t *entry, size_t *cntp);
typedef enum rd_kafka_ResourceType_t {
  RD_KAFKA_RESOURCE_UNKNOWN = 0,
  RD_KAFKA_RESOURCE_ANY = 1,
  RD_KAFKA_RESOURCE_TOPIC = 2,
  RD_KAFKA_RESOURCE_GROUP = 3,
  RD_KAFKA_RESOURCE_BROKER = 4,
  RD_KAFKA_RESOURCE__CNT,
} rd_kafka_ResourceType_t;
typedef enum rd_kafka_ResourcePatternType_t {
  RD_KAFKA_RESOURCE_PATTERN_UNKNOWN = 0,
  RD_KAFKA_RESOURCE_PATTERN_ANY = 1,
  RD_KAFKA_RESOURCE_PATTERN_MATCH = 2,
  RD_KAFKA_RESOURCE_PATTERN_LITERAL = 3,
  RD_KAFKA_RESOURCE_PATTERN_PREFIXED = 4,
  RD_KAFKA_RESOURCE_PATTERN_TYPE__CNT,
} rd_kafka_ResourcePatternType_t;
const char *rd_kafka_ResourcePatternType_name(rd_kafka_ResourcePatternType_t resource_pattern_type);
const char *rd_kafka_ResourceType_name(rd_kafka_ResourceType_t restype);
typedef struct rd_kafka_ConfigResource_s rd_kafka_ConfigResource_t;
rd_kafka_ConfigResource_t *rd_kafka_ConfigResource_new(rd_kafka_ResourceType_t restype, const char *resname);
void rd_kafka_ConfigResource_destroy(rd_kafka_ConfigResource_t *config);
void rd_kafka_ConfigResource_destroy_array(rd_kafka_ConfigResource_t **config, size_t config_cnt);
rd_kafka_resp_err_t rd_kafka_ConfigResource_set_config(rd_kafka_ConfigResource_t *config, const char *name, const char *value);
const rd_kafka_ConfigEntry_t **rd_kafka_ConfigResource_configs(const rd_kafka_ConfigResource_t *config, size_t *cntp);
rd_kafka_ResourceType_t rd_kafka_ConfigResource_type(const rd_kafka_ConfigResource_t *config);
const char *rd_kafka_ConfigResource_name(const rd_kafka_ConfigResource_t *config);
rd_kafka_resp_err_t rd_kafka_ConfigResource_error(const rd_kafka_ConfigResource_t *config);
const char *rd_kafka_ConfigResource_error_string(const rd_kafka_ConfigResource_t *config);
void rd_kafka_AlterConfigs(rd_kafka_t *rk, rd_kafka_ConfigResource_t **configs, size_t config_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_ConfigResource_t **rd_kafka_AlterConfigs_result_resources(const rd_kafka_AlterConfigs_result_t *result, size_t *cntp);
void rd_kafka_DescribeConfigs(rd_kafka_t *rk, rd_kafka_ConfigResource_t **configs, size_t config_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_ConfigResource_t **rd_kafka_DescribeConfigs_result_resources(const rd_kafka_DescribeConfigs_result_t *result, size_t *cntp);
typedef struct rd_kafka_DeleteRecords_s rd_kafka_DeleteRecords_t;
rd_kafka_DeleteRecords_t *rd_kafka_DeleteRecords_new(const rd_kafka_topic_partition_list_t *before_offsets);
void rd_kafka_DeleteRecords_destroy(rd_kafka_DeleteRecords_t *del_records);
void rd_kafka_DeleteRecords_destroy_array(rd_kafka_DeleteRecords_t **del_records, size_t del_record_cnt);
void rd_kafka_DeleteRecords(rd_kafka_t *rk, rd_kafka_DeleteRecords_t **del_records, size_t del_record_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_topic_partition_list_t *rd_kafka_DeleteRecords_result_offsets(const rd_kafka_DeleteRecords_result_t *result);
typedef struct rd_kafka_DeleteGroup_s rd_kafka_DeleteGroup_t;
rd_kafka_DeleteGroup_t *rd_kafka_DeleteGroup_new(const char *group);
void rd_kafka_DeleteGroup_destroy(rd_kafka_DeleteGroup_t *del_group);
void rd_kafka_DeleteGroup_destroy_array(rd_kafka_DeleteGroup_t **del_groups, size_t del_group_cnt);
void rd_kafka_DeleteGroups(rd_kafka_t *rk, rd_kafka_DeleteGroup_t **del_groups, size_t del_group_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_group_result_t **rd_kafka_DeleteGroups_result_groups(const rd_kafka_DeleteGroups_result_t *result, size_t *cntp);
typedef struct rd_kafka_DeleteConsumerGroupOffsets_s rd_kafka_DeleteConsumerGroupOffsets_t;
rd_kafka_DeleteConsumerGroupOffsets_t *rd_kafka_DeleteConsumerGroupOffsets_new(const char *group, const rd_kafka_topic_partition_list_t *partitions);
void rd_kafka_DeleteConsumerGroupOffsets_destroy(rd_kafka_DeleteConsumerGroupOffsets_t *del_grpoffsets);
void rd_kafka_DeleteConsumerGroupOffsets_destroy_array(rd_kafka_DeleteConsumerGroupOffsets_t **del_grpoffsets, size_t del_grpoffset_cnt);
void rd_kafka_DeleteConsumerGroupOffsets(rd_kafka_t *rk, rd_kafka_DeleteConsumerGroupOffsets_t **del_grpoffsets, size_t del_grpoffsets_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_group_result_t **rd_kafka_DeleteConsumerGroupOffsets_result_groups(const rd_kafka_DeleteConsumerGroupOffsets_result_t *result, size_t *cntp);
typedef struct rd_kafka_AclBinding_s rd_kafka_AclBinding_t;
typedef rd_kafka_AclBinding_t rd_kafka_AclBindingFilter_t;
const rd_kafka_error_t *rd_kafka_acl_result_error(const rd_kafka_acl_result_t *aclres);
typedef enum rd_kafka_AclOperation_t {
  RD_KAFKA_ACL_OPERATION_UNKNOWN = 0,
  RD_KAFKA_ACL_OPERATION_ANY = 1,
  RD_KAFKA_ACL_OPERATION_ALL = 2,
  RD_KAFKA_ACL_OPERATION_READ = 3,
  RD_KAFKA_ACL_OPERATION_WRITE = 4,
  RD_KAFKA_ACL_OPERATION_CREATE = 5,
  RD_KAFKA_ACL_OPERATION_DELETE = 6,
  RD_KAFKA_ACL_OPERATION_ALTER = 7,
  RD_KAFKA_ACL_OPERATION_DESCRIBE = 8,
  RD_KAFKA_ACL_OPERATION_CLUSTER_ACTION = 9,
  RD_KAFKA_ACL_OPERATION_DESCRIBE_CONFIGS = 10,
  RD_KAFKA_ACL_OPERATION_ALTER_CONFIGS = 11,
  RD_KAFKA_ACL_OPERATION_IDEMPOTENT_WRITE = 12,
  RD_KAFKA_ACL_OPERATION__CNT,
} rd_kafka_AclOperation_t;
const char *rd_kafka_AclOperation_name(rd_kafka_AclOperation_t acl_operation);
typedef enum rd_kafka_AclPermissionType_t {
  RD_KAFKA_ACL_PERMISSION_TYPE_UNKNOWN = 0,
  RD_KAFKA_ACL_PERMISSION_TYPE_ANY = 1,
  RD_KAFKA_ACL_PERMISSION_TYPE_DENY = 2,
  RD_KAFKA_ACL_PERMISSION_TYPE_ALLOW = 3,
  RD_KAFKA_ACL_PERMISSION_TYPE__CNT,
} rd_kafka_AclPermissionType_t;
const char *rd_kafka_AclPermissionType_name(rd_kafka_AclPermissionType_t acl_permission_type);
rd_kafka_AclBinding_t *rd_kafka_AclBinding_new(rd_kafka_ResourceType_t restype, const char *name, rd_kafka_ResourcePatternType_t resource_pattern_type, const char *principal, const char *host, rd_kafka_AclOperation_t operation, rd_kafka_AclPermissionType_t permission_type, char *errstr, size_t errstr_size);
rd_kafka_AclBindingFilter_t *rd_kafka_AclBindingFilter_new(rd_kafka_ResourceType_t restype, const char *name, rd_kafka_ResourcePatternType_t resource_pattern_type, const char *principal, const char *host, rd_kafka_AclOperation_t operation, rd_kafka_AclPermissionType_t permission_type, char *errstr, size_t errstr_size);
rd_kafka_ResourceType_t rd_kafka_AclBinding_restype(const rd_kafka_AclBinding_t *acl);
const char *rd_kafka_AclBinding_name(const rd_kafka_AclBinding_t *acl);
const char *rd_kafka_AclBinding_principal(const rd_kafka_AclBinding_t *acl);
const char *rd_kafka_AclBinding_host(const rd_kafka_AclBinding_t *acl);
rd_kafka_AclOperation_t rd_kafka_AclBinding_operation(const rd_kafka_AclBinding_t *acl);
rd_kafka_AclPermissionType_t rd_kafka_AclBinding_permission_type(const rd_kafka_AclBinding_t *acl);
rd_kafka_ResourcePatternType_t rd_kafka_AclBinding_resource_pattern_type(const rd_kafka_AclBinding_t *acl);
const rd_kafka_error_t *rd_kafka_AclBinding_error(const rd_kafka_AclBinding_t *acl);
void rd_kafka_AclBinding_destroy(rd_kafka_AclBinding_t *acl_binding);
void rd_kafka_AclBinding_destroy_array(rd_kafka_AclBinding_t **acl_bindings, size_t acl_bindings_cnt);
const rd_kafka_acl_result_t **rd_kafka_CreateAcls_result_acls(const rd_kafka_CreateAcls_result_t *result, size_t *cntp);
void rd_kafka_CreateAcls(rd_kafka_t *rk, rd_kafka_AclBinding_t **new_acls, size_t new_acls_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
const rd_kafka_AclBinding_t **rd_kafka_DescribeAcls_result_acls(const rd_kafka_DescribeAcls_result_t *result, size_t *cntp);
void rd_kafka_DescribeAcls(rd_kafka_t *rk, rd_kafka_AclBindingFilter_t *acl_filter, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
typedef struct rd_kafka_DeleteAcls_result_response_s rd_kafka_DeleteAcls_result_response_t;
const rd_kafka_DeleteAcls_result_response_t **rd_kafka_DeleteAcls_result_responses(const rd_kafka_DeleteAcls_result_t *result, size_t *cntp);
const rd_kafka_error_t *rd_kafka_DeleteAcls_result_response_error(const rd_kafka_DeleteAcls_result_response_t *result_response);
const rd_kafka_AclBinding_t **rd_kafka_DeleteAcls_result_response_matching_acls(const rd_kafka_DeleteAcls_result_response_t *result_response, size_t *matching_acls_cntp);
void rd_kafka_DeleteAcls(rd_kafka_t *rk, rd_kafka_AclBindingFilter_t **del_acls, size_t del_acls_cnt, const rd_kafka_AdminOptions_t *options, rd_kafka_queue_t *rkqu);
rd_kafka_resp_err_t rd_kafka_oauthbearer_set_token(rd_kafka_t *rk, const char *token_value, int64_t md_lifetime_ms, const char *md_principal_name, const char **extensions, size_t extension_size, char *errstr, size_t errstr_size);
rd_kafka_resp_err_t rd_kafka_oauthbearer_set_token_failure(rd_kafka_t *rk, const char *errstr);
rd_kafka_error_t *rd_kafka_init_transactions(rd_kafka_t *rk, int timeout_ms);
rd_kafka_error_t *rd_kafka_begin_transaction(rd_kafka_t *rk);
rd_kafka_error_t *rd_kafka_send_offsets_to_transaction(rd_kafka_t *rk, const rd_kafka_topic_partition_list_t *offsets, const rd_kafka_consumer_group_metadata_t *cgmetadata, int timeout_ms);
rd_kafka_error_t *rd_kafka_commit_transaction(rd_kafka_t *rk, int timeout_ms);
rd_kafka_error_t *rd_kafka_abort_transaction(rd_kafka_t *rk, int timeout_ms);
typedef struct rd_kafka_mock_cluster_s rd_kafka_mock_cluster_t;
rd_kafka_mock_cluster_t *rd_kafka_mock_cluster_new(rd_kafka_t *rk, int broker_cnt);
void rd_kafka_mock_cluster_destroy(rd_kafka_mock_cluster_t *mcluster);
rd_kafka_t *rd_kafka_mock_cluster_handle(const rd_kafka_mock_cluster_t *mcluster);
rd_kafka_mock_cluster_t *rd_kafka_handle_mock_cluster(const rd_kafka_t *rk);
const char *rd_kafka_mock_cluster_bootstraps(const rd_kafka_mock_cluster_t *mcluster);
void rd_kafka_mock_clear_request_errors(rd_kafka_mock_cluster_t *mcluster, int16_t ApiKey);
void rd_kafka_mock_push_request_errors(rd_kafka_mock_cluster_t *mcluster, int16_t ApiKey, size_t cnt, ...);
void rd_kafka_mock_push_request_errors_array(rd_kafka_mock_cluster_t *mcluster, int16_t ApiKey, size_t cnt, const rd_kafka_resp_err_t *errors);
rd_kafka_resp_err_t rd_kafka_mock_broker_push_request_error_rtts(rd_kafka_mock_cluster_t *mcluster, int32_t broker_id, int16_t ApiKey, size_t cnt, ...);
void rd_kafka_mock_topic_set_error(rd_kafka_mock_cluster_t *mcluster, const char *topic, rd_kafka_resp_err_t err);
rd_kafka_resp_err_t rd_kafka_mock_topic_create(rd_kafka_mock_cluster_t *mcluster, const char *topic, int partition_cnt, int replication_factor);
rd_kafka_resp_err_t rd_kafka_mock_partition_set_leader(rd_kafka_mock_cluster_t *mcluster, const char *topic, int32_t partition, int32_t broker_id);
rd_kafka_resp_err_t rd_kafka_mock_partition_set_follower(rd_kafka_mock_cluster_t *mcluster, const char *topic, int32_t partition, int32_t broker_id);
rd_kafka_resp_err_t rd_kafka_mock_partition_set_follower_wmarks(rd_kafka_mock_cluster_t *mcluster, const char *topic, int32_t partition, int64_t lo, int64_t hi);
rd_kafka_resp_err_t rd_kafka_mock_broker_set_down(rd_kafka_mock_cluster_t *mcluster, int32_t broker_id);
rd_kafka_resp_err_t rd_kafka_mock_broker_set_up(rd_kafka_mock_cluster_t *mcluster, int32_t broker_id);
rd_kafka_resp_err_t rd_kafka_mock_broker_set_rtt(rd_kafka_mock_cluster_t *mcluster, int32_t broker_id, int rtt_ms);
rd_kafka_resp_err_t rd_kafka_mock_broker_set_rack(rd_kafka_mock_cluster_t *mcluster, int32_t broker_id, const char *rack);
rd_kafka_resp_err_t rd_kafka_mock_coordinator_set(rd_kafka_mock_cluster_t *mcluster, const char *key_type, const char *key, int32_t broker_id);
rd_kafka_resp_err_t rd_kafka_mock_set_apiversion(rd_kafka_mock_cluster_t *mcluster, int16_t ApiKey, int16_t MinVersion, int16_t MaxVersion);
';
