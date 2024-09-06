<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Scopes;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class ByServerTest extends TestCase
{
    public function test(): void
    {
        $this->useDatabase();

        $expected = Log::factory()
            ->count(3)
            ->create([
                'server' => 'potato',
            ]);

        $unexpected = Log::factory()
            ->count(3)
            ->create();

        $this->assertResultsMatch(
            Log::byServer('potato')->get(),
            $expected,
            $unexpected,
        );
    }
}
