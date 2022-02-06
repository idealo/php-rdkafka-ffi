# Use preloading

Preloading helps to reduce the overhead of parsing C declarations and frequently used php files per request.

!!! Note

    Requires activated [opcache](https://www.php.net/manual/de/opcache.installation.php).

### Example preload.php

```php
<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$files = new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            dirname(__DIR__) . '/src'
        )
    ),
    '/^.+\/[A-Z][^\/]+?\.php$/'
);

foreach ($files as $file) {
    if (! $file->isFile()) {
        continue;
    }
    require_once($file->getPathName());
}

Library::preload();
```

### Configure php.ini

```ini
# force preload mode
ffi.enable = preload
# enable opcache extension
zend_extension = opcache
# enable opcache
opcache.enable = true
# enable opcache on cli
opcache.enable_cli = true
# change to correct user
opcache.preload_user = wwwdata
# absolute path to preload.php
opcache.preload = /path/to/preload.php
```

## See also

- [opcache.preload](https://www.php.net/manual/de/opcache.preloading.php)
- [FFI preloading example](https://www.php.net/manual/de/ffi.examples-complete.php)