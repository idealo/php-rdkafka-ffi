<?php
declare(strict_types=1);

use RdKafka\Api;

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
 */
function rd_kafka_errno2err(int $errnox): int
{
    throw new Exception('Not implemented.');
}

/**
 * @return int Returns the system errno as an integer.
 */
function rd_kafka_errno(): int
{
    throw new Exception('Not implemented.');
}

/**
 * @param int $cnt
 *
 * @return int Returns the special offset as an integer.
 */
function rd_kafka_offset_tail(int $cnt): int
{
    return RD_KAFKA_OFFSET_TAIL_BASE - $cnt;
}
