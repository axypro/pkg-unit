<?php

declare(strict_types=1);

namespace axy\pkg\unit;

use DirectoryIterator;

class DirCleaner
{
    public static function clear(string $dir, bool $rmRoot = false): void
    {
        if (!file_exists($dir)) {
            return;
        }
        $iterator = new DirectoryIterator($dir);
        foreach ($iterator as $file) {
            if ($file->isDot()) {
                continue;
            }
            if ($file->isFile()) {
                unlink($file->getRealPath());
            }
            if ($file->isDir()) {
                self::clear($file->getRealPath(), true);
            }
        }
        if ($rmRoot) {
            rmdir($dir);
        }
    }
}
