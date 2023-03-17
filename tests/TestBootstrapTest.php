<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

use axy\pkg\unit\TestsBootstrap;
use LogicException;

class TestBootstrapTest extends BaseTestCase
{
    public function testInstance(): void
    {
        $bootstrap = new TestsBootstrap(__DIR__ . '/fake');
        $this->assertSame(__DIR__ . '/fake', $bootstrap->testDir);
        $root = $bootstrap->rootDir;
        $this->assertSame(__DIR__, $root);
        $this->assertNull($bootstrap->getTmpDir(false));
        $tmpDir = $bootstrap->getTmpDir();
        $this->assertSame(__DIR__ . '/local/tmp', $tmpDir?->dir);
        $this->assertSame($tmpDir, $bootstrap->getTmpDir());
    }

    public function testStatic(): void
    {
        $bootstrap = TestsBootstrap::getInstance();
        $this->assertSame(dirname(__DIR__) . '/local/tmp', $bootstrap->getTmpDir()->dir);
        $this->expectException(LogicException::class);
        TestsBootstrap::init(__DIR__);
    }
}
