# Preloading

## Using your preferred framework

### Import needed classes

```
use RdKafka\FFI\Library;
```

### Load files

```
$files = new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            dirname(__DIR__) . '/src' // You can change this directory according to where you want the files to be preloaded
        )
    ),
    '/^.+\/[A-Z][^\/]+?\.php$/'
);
```

### Iterate on files

```
foreach ($files as $file) {
    if ($file->isFile() === false) {
        continue;
    }
    require_once($file->getPathName());
}
```

### Preload files

```
Library::preload();
```