<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

class DownListenersTest extends BaseTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$downCounter = 33;
    }

    public function setUp(): void
    {
        parent::setUp();
        self::$downCounter++;
        $this->addDownListener(function () {
            self::$downCounter--;
        });
    }

    /** @dataProvider providerDownListener */
    public function testDownListener(int $c): void
    {
        $this->assertSame(34, self::$downCounter);
        self::$downCounter += $c;
        $l1 = $this->addDownListener(function () use ($c) {
            self::$downCounter -= $c;
        });
        $l2 = $this->addDownListener(function () use ($c) {
            self::$downCounter -= 5;
        });
        $this->assertNotSame($l1, $l2);
        $this->assertTrue($this->removeDownListener($l2));
        $this->assertFalse($this->removeDownListener($l2));
    }

    public static function providerDownListener(): array
    {
        return [
            [1],
            [3],
        ];
    }

    private static int $downCounter;
}
