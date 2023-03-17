<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

use axy\pkg\unit\ArrHelper;

class ArrHelperTest extends BaseTestCase
{
    public function testPrepareActualForPartiallyComparison(): void
    {
        $actual = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'bool' => true,
        ];
        $expected = [
            'd' => 4,
            'c' => '3',
            'a' => 1,
            'bool' => 1,
        ];
        $actualProcessed = [
            'c' => 3,
            'a' => 1,
            'bool' => true,
        ];
        $this->assertSame($actualProcessed, ArrHelper::prepareActualForPartiallyComparison($expected, $actual));
        $this->assertSame([
            'c' => '3',
            'a' => 1,
            'bool' => 1,
        ], ArrHelper::prepareActualForPartiallyComparison($expected, $actual, strict: false));
        $this->assertSame([
            'd' => null,
            'c' => '3',
            'a' => 1,
            'bool' => 1,
        ], ArrHelper::prepareActualForPartiallyComparison($expected, $actual, strict: false, allowNull: true));
    }

    public function testPrepareActualForItemsPartiallyComparison(): void
    {
        $expected = [
            'a' => [
                'b' => 1,
                'c' => 2,
            ],
            'b' => 1,
            'c' => 3,
        ];
        $actual = [
            'a' => [
                'b' => 3,
                'd' => 4,
            ],
            'b' => ['a' => 1],
            'd' => 4,
        ];
        $actualProcessed = [
            'a' => [
                'b' => 3,
            ],
            'b' => ['a' => 1],
            'd' => 4,
        ];
        $this->assertSame($actualProcessed, ArrHelper::prepareActualForItemsPartiallyComparison($expected, $actual));
    }
}
