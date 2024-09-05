<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Utilities;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;
use ErrorException;

class InterpretContextTest extends TestCase
{
    public function testHandlesExceptions(): void
    {
        $exception = new ErrorException(
            code: 123,
            filename: 'My file',
            line: 321,
        );

        $log = new Log();
        $log->interpretContext([
            'exception' => $exception,
        ]);

        $this->assertEquals(123, $log->code);
        $this->assertEquals('My file', $log->file);
        $this->assertEquals(321, $log->line);
        $this->assertNotEmpty($log->trace);
    }
}
