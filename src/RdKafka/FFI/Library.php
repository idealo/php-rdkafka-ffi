<?php

declare(strict_types=1);

namespace RdKafka\FFI;

use FFI;
use FFI\CData;
use FFI\CType;
use FFI\Exception as FFIException;
use RuntimeException;

use function file_put_contents;
use function ini_get;
use function sprintf;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

/**
 * This class is for internal use. It provides access to the low level interface to librdkafka.
 * Best practice is to use high level interfaces like \RdKafka\Conf, \RdKafka\Producer, ...
 *
 * @see https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html
 */
class Library
{
    use Methods;

    public const VERSION_AUTODETECT = '';
    public const VERSION_LATEST = '2.0.2';
    public const PHP_LIBRARY_VERSION = '0.5.0';

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
     * @param string|CData|mixed $type
     */
    public static function new($type, bool $owned = true, bool $persistent = false): CData
    {
        return self::getFFI()->new($type, $owned, $persistent);
    }

    /**
     * @param mixed $type
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
        } catch (FFIException $exception) {
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

    /**
     * Whether method is supported by current binding version.
     */
    public static function hasMethod(string $name): bool
    {
        self::chooseVersion();

        return array_key_exists($name, RD_KAFKA_SUPPORTED_METHODS)
            && version_compare(self::$version, RD_KAFKA_SUPPORTED_METHODS[$name]['min'], '<') === false
            && version_compare(self::$version, RD_KAFKA_SUPPORTED_METHODS[$name]['max'], '>') === false;
    }

    /**
     * Method must be supported by current binding version otherwise an exception is thrown.
     * @throws RuntimeException
     */
    public static function requireMethod(string $name): void
    {
        if (self::hasMethod($name) === false) {
            throw new RuntimeException(
                sprintf(
                    'Method %s not supported by librdkafka version %s',
                    $name,
                    self::$version
                )
            );
        }
    }

    /**
     * Version must match the current binding otherwise an exception is thrown.
     * @throws RuntimeException
     */
    public static function requireVersion(string $operator, string $version): void
    {
        if (self::versionMatches($operator, $version) === false) {
            throw new RuntimeException(
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

    /**
     * Whether version matches the current binding version
     */
    public static function versionMatches(string $operator, string $version): bool
    {
        self::chooseVersion();

        $version = str_ireplace('pre', 'dev', $version);

        return version_compare(self::$version, $version, $operator);
    }

    /**
     * The version of librdkafka
     */
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
            self::$version = self::autoDetectVersion();
        }

        $constantsFile = __DIR__ . '/Versions/' . self::$version . '.php';
        if (file_exists($constantsFile) === false) {
            throw new RuntimeException(sprintf('Version %s not support', self::$version));
        }

        require_once($constantsFile);

        self::$cdef = RD_KAFKA_CDEF;
    }

    private static function autoDetectVersion(): string
    {
        $ffi = FFI::cdef('const char *rd_kafka_version_str(void);', self::getLibrary());
        $version = $ffi->rd_kafka_version_str();

        if (version_compare($version, self::VERSION_LATEST, '>') === true) {
            return self::VERSION_LATEST;
        }

        return $version;
    }

    /**
     * The version of the current binding with librdkafka
     */
    public static function getVersion(): string
    {
        return self::$version;
    }

    /**
     * The client version exposed to the brokers.
     *
     * The version has the format v{phpLibraryVersion}-v{bindingVersion}-librdkafka-v{librdkafkaVersion} - e.g. v0.1.0-dev-v1.5.2-librdkafka-v1.5.2)
     */
    public static function getClientVersion(): string
    {
        return sprintf(
            'v%s-v%s-librdkafka-v%s',
            self::PHP_LIBRARY_VERSION,
            self::getVersion(),
            self::getLibraryVersion()
        );
    }
}
