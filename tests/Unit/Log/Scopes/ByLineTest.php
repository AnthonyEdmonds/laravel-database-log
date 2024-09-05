<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Scopes;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class ByLineTest extends TestCase
{
    public function test(): void
    {
        $this->useDatabase();

        $expected = Log::factory()
            ->count(3)
            ->create([
                'line' => 0,
            ]);

        $unexpected = Log::factory()
            ->count(3)
            ->create([
                'line' => 1,
            ]);

        $this->assertResultsMatch(
            Log::byLine(0)->get(),
            $expected,
            $unexpected,
        );
    }
}
