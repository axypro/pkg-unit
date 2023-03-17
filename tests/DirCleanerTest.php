<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

use axy\pkg\unit\DirCleaner;

class DirCleanerTest extends BaseTestCase
{
    /** @dataProvider providerClear */
    public function testClear(bool $rmRoot): void
    {
        $dir = $this->tmpDir()->dir . '/clear-test';
        mkdir("$dir/a/b", recursive: true);
        file_put_contents("$dir/a/b/f.txt", 'content');
        file_put_contents("$dir/a/b/.h", 'hidden');
        DirCleaner::clear($dir, $rmRoot);
        $this->assertFileDoesNotExist("$dir/a");
        if ($rmRoot) {
            $this->assertFileDoesNotExist($dir);
        } else {
            $this->assertFileExists($dir);
        }
    }

    public static function providerClear(): array
    {
        return [
            [true],
            [false],
        ];
    }
}
