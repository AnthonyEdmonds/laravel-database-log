<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Utilities;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class InterpretExtraTest extends TestCase
{
    public function testHandlesExceptions(): void
    {
        $log = new Log();
        $log->interpretExtra([]);

        // Not sure what extra is used for, stubbed for future
        $this->expectNotToPerformAssertions();
    }
}
