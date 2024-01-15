<?php

declare(strict_types=1);

namespace axy\pkg\unit\tests;

class RequiresDockerTest extends BaseTestCase
{
    public function testRequiresDocker(): void
    {
        $this->requiresDocker();
        $this->assertTrue($this->isInDocker());
    }
}
