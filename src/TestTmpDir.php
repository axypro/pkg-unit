<?php

declare(strict_types=1);

namespace axy\pkg\unit;

use PHPUnit\Framework\TestCase;

class TestTmpDir
{
    public function __construct(public readonly string $dir)
    {
    }

    public function setUp(): void
    {
        if ($this->dirNeedCleaning) {
            $this->dirNeedCleaning = false;
            $this->clear();
        }
    }

    public function tearDown(): void
    {
    }

    public function clear(?string $path = null): void
    {
        DirCleaner::clear($this->createPath($path), false);
    }

    public function needCleaning(): void
    {
        $this->dirNeedCleaning = true;
    }

    public function makeDir(?string $path = null): void
    {
        $dir = $this->createPath($path);
        if (!file_exists($dir)) {
            mkdir($dir, recursive: true);
        }
    }

    public function getPath(?string $path = null, bool $make = false): string
    {
        $path = $this->createPath($path);
        if ($make) {
            $dir = dirname($path);
            if (!file_exists($dir)) {
                mkdir($dir, recursive: true);
            }
        }
        return $path;
    }

    public function doesExist(?string $path = null): bool
    {
        return file_exists($this->createPath($path));
    }

    public function put(string $path, string $content): void
    {
        $path = $this->getPath($path, make: true);
        file_put_contents($path, $content);
    }

    public function get(string $path): ?string
    {
        $path = $this->getPath($path, make: false);
        $content = @file_get_contents($path);
        if (!is_string($content)) {
            $content = null;
        }
        return $content;
    }

    public function open(string $path, string $mode): mixed
    {
        $path = $this->getPath($path, make: true);
        $fp = fopen($path, $mode);
        if ($fp === false) {
            return null;
        }
        return $fp;
    }

    public function assertFileExists(string $path, string $message = ''): void
    {
        TestCase::assertFileExists($this->createPath($path), $message);
    }

    public function assertFileDoesNotExist(string $path, string $message = ''): void
    {
        TestCase::assertFileDoesNotExist($this->createPath($path), $message);
    }

    private function createPath(?string $path): string
    {
        if ($path === null) {
            return $this->dir;
        }
        $path = ltrim($path, '/');
        if ($path === '') {
            return $this->dir;
        }
        return "{$this->dir}/$path";
    }

    private bool $dirNeedCleaning = false;
}
