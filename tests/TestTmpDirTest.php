<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

use axy\pkg\unit\{
    DirCleaner,
    TestTmpDir,
};
use PHPUnit\Framework\ExpectationFailedException;

class TestTmpDirTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $dir = $this->tmpDir()->dir . '/test';
        $this->tmp = new TestTmpDir($dir);
        DirCleaner::clear($dir, true);
    }

    public function testRootDir(): void
    {
        $this->assertSame($this->tmp->dir, $this->tmpDir()->dir . '/test');
        $this->assertFileDoesNotExist($this->tmp->dir);
    }

    public function testMake(): void
    {
        $dir = $this->tmp->dir;
        $this->assertFileDoesNotExist($dir);
        $this->tmp->makeDir();
        $this->assertFileExists($dir);
        $this->tmp->makeDir();
        $this->assertFileExists($dir);
        $this->tmp->makeDir('a/b/c');
        $this->assertFileExists("$dir/a/b/c");
    }

    public function testGetPath(): void
    {
        $dir = $this->tmp->dir;
        $this->assertFileDoesNotExist("$dir/a/c");
        $path = $this->tmp->getPath('a/c/file.txt');
        $this->assertSame("$dir/a/c/file.txt", $path);
        $this->assertFileDoesNotExist("$dir/a/c");
        $this->assertSame($path, $this->tmp->getPath('a/c/file.txt', make: true));
        $this->assertFileExists("$dir/a/c");
        file_put_contents($path, 'xxx');
        $this->assertSame($path, $this->tmp->getPath('a/c/file.txt'));
        $this->assertFileExists($path);
        $this->assertSame($path, $this->tmp->getPath('a/c/file.txt', clear: true));
        $this->assertFileDoesNotExist($path);
        $this->assertFileExists("$dir/a/c");
        file_put_contents($path, 'xxx');
        $this->assertSame("$dir/a", $this->tmp->getPath('a', clear: true));
        $this->assertFileDoesNotExist("$dir/a");
        file_put_contents("$dir/a.txt", 'xxx');
        $this->assertSame($dir, $this->tmp->getPath(clear: true));
        $this->assertFileExists($dir);
        $this->assertFileDoesNotExist("$dir/a.txt");
    }

    public function testCheckExists(): void
    {
        $dir = $this->tmp->dir;
        mkdir("$dir/sub", recursive: true);
        touch("$dir/sub/a.txt");
        $this->assertTrue($this->tmp->doesExist('sub'));
        $this->assertTrue($this->tmp->doesExist('/sub/a.txt'));
        $this->assertFalse($this->tmp->doesExist('sub/sub'));
        $this->assertFalse($this->tmp->doesExist('sub/b.txt'));
        $this->tmp->assertFileExists('sub');
        $this->tmp->assertFileExists('sub/a.txt');
        $this->tmp->assertFileDoesNotExist('sub/sub');
        $this->tmp->assertFileDoesNotExist('sub/b.txt');
        try {
            $this->tmp->assertFileExists('sub/b.txt');
            $this->fail('Is not thrown');
        } catch (ExpectationFailedException) {
            $this->assertTrue(true, 'Thrown');
        }
        try {
            $this->tmp->assertFileDoesNotExist('sub/a.txt');
            $this->fail('Is not thrown');
        } catch (ExpectationFailedException) {
            $this->assertTrue(true, 'Thrown');
        }
    }

    public function testPut(): void
    {
        $dir = $this->tmp->dir;
        $this->tmp->put('a/b.txt', 'content');
        $fn = "$dir/a/b.txt";
        $this->assertFileExists($fn);
        $this->assertSame('content', trim(file_get_contents($fn)));
    }

    public function testGet(): void
    {
        $dir = $this->tmp->dir;
        mkdir("$dir/a", recursive: true);
        $fn = "$dir/a/b.txt";
        file_put_contents($fn, 'test');
        $this->assertSame('test', trim($this->tmp->get('a/b.txt')));
        $this->assertNull($this->tmp->get('a/c.txt'));
    }

    public function testOpen(): void
    {
        $fp = $this->tmp->open('a/b/c.txt', 'wt');
        $this->assertIsResource($fp);
        fwrite($fp, 'xxx');
        fclose($fp);
        $fn = "{$this->tmp->dir}/a/b/c.txt";
        $this->assertFileExists($fn);
        $this->assertSame('xxx', trim($this->tmp->get('a/b/c.txt')));
    }

    public function testClear(): void
    {
        $dir = $this->tmp->dir;
        $this->tmp->put('/a/b/c.txt', 'test');
        $this->tmp->put('/d/e/f.txt', 'test');
        $this->tmp->put('/g/h/i.txt', 'test');
        $this->assertFileExists("$dir/a/b/c.txt");
        $this->tmp->clear('a');
        $this->assertFileExists("$dir/a");
        $this->assertFileDoesNotExist("$dir/a/b");
        $this->assertFileExists("$dir/d/e/f.txt");
        $this->assertFileExists("$dir/g/h/i.txt");
        $this->tmp->clear();
        $this->assertFileDoesNotExist("$dir/a");
        $this->assertFileDoesNotExist("$dir/d");
        $this->assertFileDoesNotExist("$dir/g");
        $this->assertFileExists($dir);
    }

    public function testNeedCleaning(): void
    {
        $dir = $this->tmp->dir;
        $this->tmp->put('/a/b/c.txt', 'test');
        $this->tmp->put('/d/e/f.txt', 'test');
        $this->tmp->needCleaning();
        $this->assertFileExists("$dir/a/b/c.txt");
        $this->assertFileExists("$dir/d/e/f.txt");
        $this->tmp->setUp();
        $this->assertFileDoesNotExist("$dir/a");
        $this->assertFileDoesNotExist("$dir/d/");
    }

    private TestTmpDir $tmp;
}
