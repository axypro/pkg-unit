# Temporary directory object

Sometimes you need to test writing to the file system.
It is suggested to use the `{package}/local/tmp` directory for writing.

* `local` is ignored in git
* `local` is writable in the docker version (root of package is mounted as readonly)
* `local/tmp` is mounted in docker as tmpfs:
    * it is faster
    * extra junk is not stored on the host
    * the next time you run the tests, this directory will be guaranteed to be empty
* In the docker a directory outside the package root can be used.
  `{package}/local/tmp` used because the tests can be run on the host

## The object

Inside test methods the method `->tmpDir()` is available.
It returns the object for work with the temp directory.

```php
public function testLogWriter(): void
{
    $fn = $this->tmpDir()->getPath('log.txt');
    $logger = new LoggerForTest($fn);
    $logger->log('message');
    $this->tmpDir()->assertFileExists($fn);
    $content = $this->tmpDir()->get('log.txt');
    $this->assertStringContainsString('message', $content);
}
```

### Methods

`$path` argument takes a relative path inside the temp directory.
Leading slashes are ignoring.
`/a/b/file.txt` correspond to `{package}/local/tmp/a/b/file.txt`.
NULL (if is available) correspond to the temp directory root.

* `makeDir([$path])` - makes (recursively) a directory inside the tmp
* `getPath([$path, bool $make = false, bool $clear = false]): string` - returns a path inside the tmp
    * `$make` - if is specified the parent directory of `$path` will be made
    * `$clear` - if the target file (or directory) exists it will be deleted
* `doesExist([$path]): bool` - checks if a path (file or directory) is existing
* `put(string $path, string $content)` - saves a content to a file
    * if the file directory is not existed it will be made
* `get(string $path): ?string` - returns the file content (NULL if the file is not found)
* `open(string $path, string $mode): ?resource` - open a file handler

Assets (for testing):

* `assertFileExists($path [, $message])`
* `assertFileDoesNotExist($path [, $message])`

Clear directory.
The directory is not automatically cleared and when the new test started it can be not empty.

* `clear([$path])` - clears all temp directory or subdirectory
* `needCleaning()` - marks the directory to be cleaned up after the current test
