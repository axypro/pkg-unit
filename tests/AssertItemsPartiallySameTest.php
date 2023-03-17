<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

class AssertItemsPartiallySameTest extends BaseTestCase
{
    public function testAssertItemsPartiallySame(): void
    {
        $expected = [
            ['a' => 1, 'c' => 3],
            ['a' => 4, 'b' => 5],
        ];
        $actual = (object)[
            ['a' => 1, 'b' => 2, 'c' => 3],
            ['a' => 4, 'b' => 5, 'c' => 6],
        ];
        $this->assertItemsPartiallySame($expected, $actual);
    }
}
