<?php
declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;

class ProducerTopic extends Topic
{
    /**
     * @param Producer $producer
     * @param string $name
     * @param TopicConf $conf
     * @throws Exception
     */
    public function __construct(Producer $producer, string $name, TopicConf $conf = null)
    {
        parent::__construct($producer, $name, $conf);
    }

    /**
     * @param int $partition
     * @param int $msgflags
     * @param string $payload
     * @param string $key
     * @param array $headers
     *
     * @return void
     * @throws Exception
     */
    public function produce(int $partition, int $msgflags, string $payload = null, string $key = null, array $headers = [])
    {
        if ($partition != RD_KAFKA_PARTITION_UA && ($partition < 0 || $partition > 0x7FFFFFFF)) {
            throw new InvalidArgumentException(sprintf("Out of range value '%d' for partition", $partition));
        }

        // todo why?
        if ($msgflags != 0) {
            throw new InvalidArgumentException(sprintf("Invalid value '%d' for msgflags", $msgflags));
        }

        $args = [
            RD_KAFKA_VTYPE_RKT,
            $this->topic,
            RD_KAFKA_VTYPE_PARTITION,
            $partition,
            RD_KAFKA_VTYPE_MSGFLAGS,
            $msgflags | RD_KAFKA_MSG_F_COPY,
            RD_KAFKA_VTYPE_VALUE,
            $payload,
            is_null($payload) ? null : strlen($payload),
            RD_KAFKA_VTYPE_KEY,
            $key,
            is_null($key) ? null : strlen($key),
        ];

        if (!empty($headers)) {
            foreach ($headers as $headerName => $headerValue) {
                $args[] = RD_KAFKA_VTYPE_HEADER;
                $args[] = $headerName;
                $args[] = $headerValue;
                $args[] = strlen($headerValue);
            }
        }

        $args[] = RD_KAFKA_VTYPE_END;

        $ret = self::$ffi->rd_kafka_producev(
            $this->kafka->getCData(),
            ...$args
        );

        if ($ret == -1) {
            $err = self::$ffi->rd_kafka_last_error();
            $errstr = self::err2str($err);
            throw new Exception($errstr);
        }
    }
}
