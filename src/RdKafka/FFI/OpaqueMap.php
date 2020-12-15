<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI\CData;

class OpaqueMap
{
    private static int $nextId = 0;
    /**
     * @var mixed[]
     */
    private static array $map = [];
    private static array $cMap = [];

    /**
     * @param mixed|null $opaque
     */
    public static function push($opaque): ?CData
    {
        if ($opaque === null) {
            return null;
        }

        self::$nextId++;
        if (self::$nextId === PHP_INT_MAX) {
            self::$nextId = 1;
        }

        self::$map[self::$nextId] = $opaque;

        $cOpaque = \FFI::new('int');
        $cOpaque->cdata = self::$nextId;
        self::$cMap[self::$nextId] = $cOpaque;

        return $cOpaque;
    }

    /**
     * @return mixed|null
     */
    public static function pull(?CData $cOpaque)
    {
        if ($cOpaque === null) {
            return null;
        }

        $cOpaque = \FFI::cast('int', $cOpaque);
        $id = $cOpaque->cdata;

        if (array_key_exists($id, self::$map) === false) {
            return null;
        }

        $opaque = self::$map[$id];

        unset(self::$map[$id]);
        unset(self::$cMap[$id]);

        return $opaque;
    }

    /**
     * @return mixed|null
     */
    public static function get(?CData $cOpaque)
    {
        if ($cOpaque === null) {
            return null;
        }

        $cOpaque = \FFI::cast('int', $cOpaque);
        $id = $cOpaque->cdata;

        if (array_key_exists($id, self::$map) === false) {
            return null;
        }

        return self::$map[$id];
    }
}
