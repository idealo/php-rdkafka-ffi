<?php

declare(strict_types=1);

use RdKafka\FFI\Api;

/**
 * @param int $err Error code
 *
 * @return string Returns the error as a string.
 */
function rd_kafka_err2str(int $err): string
{
    return Api::err2str($err);
}

/**
 * @param int $errnox A system errno
 *
 * @return int Returns a kafka error code as an integer.
 * @deprecated
 */
function rd_kafka_errno2err(int $errnox): int
{
    return Api::errno2err($errnox);
}

/**
 * @return int Returns the system errno as an integer.
 * @deprecated
 */
function rd_kafka_errno(): int
{
    return Api::errno();
}

/**
 * @return int Returns the special offset as an integer.
 */
function rd_kafka_offset_tail(int $cnt): int
{
    return RD_KAFKA_OFFSET_TAIL_BASE - $cnt;
}

/**
 * @return int Retrieve the current number of threads in use by librdkafka.
 */
function rd_kafka_thread_cnt(): int
{
    return Api::threadCount();
}

/**
 * @return string Returns librdkafka version.
 */
function rd_kafka_version(): string
{
    return Api::version();
}
