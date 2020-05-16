<?php

declare(strict_types=1);

namespace FFI\Generator\Types;

/*

typedef (type) symbol
    typedef (signed long int) int64_t;

type function_name(type|symbol var_name, type|symbol function_or_var_name(type|symbol var_name, ))
    rd_kafka_headers_t * rd_kafka_fatal_error(rd_kafka_t *rk, int(*cmp)(const void *a, const void *b, void *opaque));

type (keyword:enum|struct|union, etc) name type layout symbol
    typedef struct rd_kafka_topic_partition_list_s {
      int cnt;
      int size;
      rd_kafka_topic_partition_t *elems;
    } rd_kafka_topic_partition_list_t;

 */

abstract class Type
{
    protected bool $const = false;
    protected string $symbolName;

    abstract public function getCName(): string;

    abstract public function getCType(string $ptr = ''): string;

    abstract public function getPhpTypes(): string;

    abstract public function getPhpDocTypes(): string;

    public function withConst(bool $flag)
    {
        $cloned = clone $this;
        $cloned->const = $flag;
        return $cloned;
    }

    public function isConst(): bool
    {
        return $this->const;
    }

    // todo definition name > not type
    public function withSymbolName(string $name)
    {
        $cloned = clone $this;
        $cloned->symbolName = $name;
        return $cloned;
    }

    public function getSymbolName(): string
    {
        return $this->symbolName ?? ''; //$this->getCName();
    }

    public function getName(): string
    {
        return $this->getSymbolName() ?: $this->getCName();
    }
}