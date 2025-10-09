<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Setters;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class MessageTest extends TestCase
{
    protected Log $log;

    protected function setUp(): void
    {
        parent::setUp();

        $this->log = new Log();
        $this->log->message = str_pad('a', 250, 'a');
    }

    public function test(): void
    {
        $this->assertEquals(
            191,
            strlen($this->log->message),
        );

        $this->assertEquals(
            str_pad('a', 188, 'a') . '...',
            $this->log->message,
        );
    }
}
