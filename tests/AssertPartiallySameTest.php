<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

use PHPUnit\Framework\ExpectationFailedException;

class AssertPartiallySameTest extends BaseTestCase
{
    public function testAssertPartiallySame(): void
    {
        $this->assertPartiallySame([
            'a' => 1,
            'b' => 2,
        ], [
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ]);

        try {
            $this->assertPartiallySame([
                'a' => 2,
                'b' => 2,
            ], [
                'a' => 1,
                'b' => 2,
                'c' => 3,
            ]);
            $this->fail('assert fail not thrown');
        } catch (ExpectationFailedException) {
            $this->assertTrue(true, 'assert fail thrown');
        }
    }
}
