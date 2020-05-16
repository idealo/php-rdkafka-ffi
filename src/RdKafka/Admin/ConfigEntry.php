<?php

declare(strict_types=1);

namespace RdKafka\Admin;

use FFI;
use FFI\CData;
use RdKafka\FFI\Library;

class ConfigEntry
{
    public string $name;
    public ?string $value;
    public int $source;
    public bool $isReadOnly;
    public bool $isDefault;
    public bool $isSensitive;
    public bool $isSynonym;

    /**
     * @var ConfigEntry[]
     */
    public array $synonyms;

    public function __construct(CData $entry)
    {
        $this->name = Library::rd_kafka_ConfigEntry_name($entry);
        $this->value = Library::rd_kafka_ConfigEntry_value($entry);
        $this->source = (int) Library::rd_kafka_ConfigEntry_source($entry);
        $this->isReadOnly = (bool) Library::rd_kafka_ConfigEntry_is_read_only($entry);
        $this->isDefault = (bool) Library::rd_kafka_ConfigEntry_is_default($entry);
        $this->isSensitive = (bool) Library::rd_kafka_ConfigEntry_is_sensitive($entry);
        $this->isSynonym = (bool) Library::rd_kafka_ConfigEntry_is_synonym($entry);

        $size = Library::new('size_t');
        $synonymsPtr = Library::rd_kafka_ConfigEntry_synonyms($entry, FFI::addr($size));
        $synonyms = [];
        for ($i = 0; $i < (int) $size->cdata; $i++) {
            $synonyms[] = new self($synonymsPtr[$i]);
        }
        $this->synonyms = $synonyms;
    }
}
