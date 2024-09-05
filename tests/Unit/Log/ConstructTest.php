<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class ConstructTest extends TestCase
{
    public function test(): void
    {
        $log = new Log();

        $this->assertEquals('logs', $log->getTable());
    }
}
