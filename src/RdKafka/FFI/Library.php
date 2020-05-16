<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use FFI\CData;
use FFI\CType;
use FFI\Exception;
use InvalidArgumentException;
use RuntimeException;

use function file_put_contents;
use function ini_get;
use function sprintf;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

class Library
{
    use Methods;

    public const VERSION_AUTODETECT = '';
    public const VERSION_LATEST = '1.4.2';

    /**
     * @var FFI librdkafka binding - see https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
     */
    private static FFI $ffi;

    private static string $scope = 'RdKafka';
    private static ?string $library = null;
    private static ?string $cdef;
    private static string $version = self::VERSION_AUTODETECT;

    public static function init(
        string $version = self::VERSION_AUTODETECT,
        string $scope = 'RdKafka',
        ?string $library = null,
        ?string $cdef = null
    ): void {
        self::$version = $version;
        self::$scope = $scope;
        self::$library = $library;
        self::$cdef = $cdef;

        self::chooseVersion();
    }

    private function __construct()
    {
    }

    /**
     * @param $type
     */
    public static function new($type, bool $owned = true, bool $persistent = false): CData
    {
        return self::getFFI()->new($type, $owned, $persistent);
    }

    /**
     * @param $type
     */
    public static function cast($type, CData $ptr): CData
    {
        return self::getFFI()->cast($type, $ptr);
    }

    /**
     * @param string|CType $type
     */
    public static function type($type): CType
    {
        return self::getFFI()->type($type);
    }

    private static function ensureFFI(): void
    {
        if (isset(self::$ffi) === true) {
            return;
        }

        self::chooseVersion();

        try {
            self::$ffi = FFI::scope(self::$scope);
        } catch (Exception $exception) {
            if (ini_get('ffi.enable') === 'preload' && PHP_SAPI !== 'cli') {
                throw new RuntimeException(
                    sprintf(
                        'FFI_SCOPE "%s" not found (ffi.enable=preload requires you to call \RdKafka\Api::preload() in preload script)',
                        self::$scope
                    ),
                    $exception->getCode(),
                    $exception
                );
            }
            self::$ffi = FFI::cdef(self::$cdef, self::getLibrary());
        }
    }

    public static function getFFI(): FFI
    {
        self::ensureFFI();
        return self::$ffi;
    }

    public static function getLibrary(): string
    {
        if (self::$library !== null) {
            return self::$library;
        }

        switch (PHP_OS_FAMILY) {
            case 'Darwin':
                return 'librdkafka.dylib';
                break;
            case 'Windows':
                return 'librdkafka.dll';
                break;
            default:
                return 'librdkafka.so';
                break;
        }
    }

    public static function preload(
        string $version = self::VERSION_AUTODETECT,
        string $scope = 'RdKafka',
        ?string $library = null,
        ?string $cdef = null
    ): FFI {
        self::init($version, $scope, $library, $cdef);

        try {
            $file = tempnam(sys_get_temp_dir(), 'php-rdkafka-ffi');
            $scope = sprintf('#define FFI_SCOPE "%s"', self::$scope) . "\n";
            $library = sprintf('#define FFI_LIB "%s"', self::getLibrary()) . "\n";
            file_put_contents($file, $scope . $library . self::$cdef);
            $ffi = FFI::load($file);
        } finally {
            unlink($file);
        }

        return $ffi;
    }

    public static function hasMethod(string $name): bool
    {
        self::chooseVersion();

        return array_key_exists($name, RD_KAFKA_SUPPORTED_METHODS)
            && version_compare(self::$version, RD_KAFKA_SUPPORTED_METHODS[$name], '>=') === false;
    }

    public static function requireMethod(string $name): void
    {
        if (self::hasMethod($name) === false) {
            throw new \RdKafka\Exception(
                sprintf(
                    'Method %s not supported by librdkafka version %s',
                    $name,
                    self::$version
                )
            );
        }
    }

    public static function requireVersion(string $operator, string $version): void
    {
        if (version_compare(self::$version, $version, $operator) === false) {
            throw new \RdKafka\Exception(
                sprintf(
                    'Requires librdkafka %s %s. Binding version is %s, library version is %s.',
                    $operator,
                    $version,
                    self::$version,
                    self::getLibraryVersion()
                )
            );
        }
    }

    public static function getLibraryVersion(): string
    {
        return self::rd_kafka_version_str();
    }

    private static function chooseVersion(): void
    {
        if (isset(self::$cdef) === true) {
            return;
        }

        if (self::$version === self::VERSION_AUTODETECT) {
            $ffi = FFI::cdef('const char * rd_kafka_version_str(void);', self::getLibrary());
            self::$version = $ffi->rd_kafka_version_str();
        }

        $constantsFile = __DIR__ . '/Versions/' . self::$version . '.php';
        if (file_exists($constantsFile) === false) {
            throw new InvalidArgumentException(sprintf('Version %s not support', self::$version));
        }

        require_once($constantsFile);

        self::$cdef = RD_KAFKA_CDEF;
    }

    public static function getVersion(): string
    {
        return self::$version;
    }
}
