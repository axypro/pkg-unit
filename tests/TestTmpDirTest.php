<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

use axy\pkg\unit\{
    DirCleaner,
    TestTmpDir,
};

class TestTmpDirTest extends BaseTestCase
{
    public function testTmpDir(): void
    {
        $dir = $this->tmpDir()->dir . '/test';
        if (file_exists($dir)) {
            unlink($dir);
        }
        DirCleaner::clear($dir, true);
        $this->assertFileDoesNotExist($dir);
        $tmp = new TestTmpDir($dir);
        $tmp->makeDir('/a/b');
        $this->assertFileExists("$dir/a/b");

        $path = $tmp->getPath('/a/c/f.txt', false);
        $this->assertSame("$dir/a/c/f.txt", $path);
        $this->assertFileDoesNotExist("$dir/a/c");
        $path = $tmp->getPath('/a/c/f.txt', true);
        $this->assertSame("$dir/a/c/f.txt", $path);
        $this->assertFileExists("$dir/a/c");

        $tmp->assertFileDoesNotExist("$dir/a/d/f.txt");
        $this->assertFalse($tmp->doesExist("$dir/a/d/f.txt"));
        $tmp->put("$dir/a/d/f.txt", 'content');
        $this->assertTrue($tmp->doesExist("$dir/a/d/f.txt"));
        $tmp->assertFileExists("$dir/a/d/f.txt");
        $this->assertSame('content', trim($tmp->get("$dir/a/d/f.txt")));
        $this->assertNull($tmp->get("$dir/a/d/f2.txt"));

        $fp = $tmp->open("$dir/a/d/f.txt", "rt");
        $this->assertSame('content', trim(fgets($fp)));
        fclose($fp);

        $tmp->needCleaning();
        $this->assertFileExists("$dir/a");
        $tmp->setUp();
        $this->assertFileDoesNotExist("$dir/a");
        $this->assertFileExists($dir);
    }
}
