<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

/**
 * @param int $err Error code
 *
 * @return string The error name as a string.
 */
function rd_kafka_err2name(int $err): string
{
    return Library::rd_kafka_err2name($err);
}

/**
 * @param int $err Error code
 *
 * @return string The error description a string.
 */
function rd_kafka_err2str(int $err): string
{
    return Library::rd_kafka_err2str($err);
}

/**
 * @param int $errnox A system errno
 *
 * @return int A kafka error code as an integer.
 * @deprecated
 */
function rd_kafka_errno2err(int $errnox): int
{
    return (int) Library::rd_kafka_errno2err($errnox);
}

/**
 * @return int The system errno as an integer.
 * @deprecated
 */
function rd_kafka_errno(): int
{
    return (int) Library::rd_kafka_errno();
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
    return (int) Library::rd_kafka_thread_cnt();
}

/**
 * @return string The librdkafka version.
 */
function rd_kafka_version(): string
{
    return Library::getLibraryVersion();
}
