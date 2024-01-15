<?php

declare(strict_types=1);

namespace axy\pkg\unit;

use PHPUnit\Framework\TestCase;

abstract class BaseAxyTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        TestsBootstrap::getInstance()->setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        TestsBootstrap::getInstance()->tearDown();
    }

    final public static function assertPartiallySame(
        array|object $expected,
        mixed $actual,
        string $message = '',
        bool $strict = true,
        bool $allowNull = false,
    ): void {
        if (is_object($actual)) {
            $actual = (array)$actual;
        } elseif (!is_array($actual)) {
            self::assertIsArray($actual, $message);
            return;
        }
        if (is_object($expected)) {
            $expected = (array)$expected;
        }
        $actual = ArrHelper::prepareActualForPartiallyComparison($expected, $actual, $strict, $allowNull);
        self::assertSame($expected, $actual, $message);
    }

    final public static function assertItemsPartiallySame(
        array|object $expected,
        mixed $actual,
        string $message = '',
        bool $strict = true,
        bool $allowNull = false,
    ): void {
        if (is_object($actual)) {
            $actual = (array)$actual;
        } elseif (!is_array($actual)) {
            self::assertIsArray($actual, $message);
            return;
        }
        if (is_object($expected)) {
            $expected = (array)$expected;
        }
        $actual = ArrHelper::prepareActualForItemsPartiallyComparison($expected, $actual, $strict, $allowNull);
        self::assertSame($expected, $actual, $message);
    }

    protected function tmpDir(): TestTmpDir
    {
        return TestsBootstrap::getInstance()->getTmpDir();
    }

    protected function isInDocker(): bool
    {
        if ($this->isItInDocker === null) {
            $this->isItInDocker = (getenv('AXY_PKG_ENVIRONMENT', true) === 'docker');
        }
        return $this->isItInDocker;
    }

    protected function requiresDocker(?string $message = null): void
    {
        if (!$this->isInDocker()) {
            $this->markTestSkipped($message ?? 'This test must be run in docker');
        }
    }

    private ?bool $isItInDocker = null;
}
