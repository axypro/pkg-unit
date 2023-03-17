<?php

declare(strict_types=1);

namespace axy\pkg\unit;

use LogicException;

class TestsBootstrap
{
    public readonly string $rootDir;
    public readonly string $localDir;

    public function __construct(public readonly string $testDir)
    {
        $relativeRoot = "$testDir/..";
        $realRoot = realpath($relativeRoot);
        $this->rootDir = $realRoot ?: $relativeRoot;
        $this->localDir = "{$this->rootDir}/local";
    }

    public function getTmpDir(bool $create = true): ?TestTmpDir
    {
        if (($this->tmpDirInstance === null) && $create) {
            $this->tmpDirInstance = new TestTmpDir("{$this->localDir}/tmp");
        }
        return $this->tmpDirInstance;
    }

    public function setUp(): void
    {
        $this->tmpDirInstance?->setUp();
    }

    public function tearDown(): void
    {
        $this->tmpDirInstance?->tearDown();
    }

    public static function init(string $dir): void
    {
        if (self::$instance !== null) {
            throw new LogicException('Test bootstrap already initialized');
        }
        self::$instance = new self($dir);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            throw new LogicException('Required TestBootstrap::init(__DIR__) in bootstrap.php');
        }
        return self::$instance;
    }

    private ?TestTmpDir $tmpDirInstance = null;
    private static ?self $instance = null;
}
