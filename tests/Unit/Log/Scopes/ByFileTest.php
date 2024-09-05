<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Scopes;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class ByFileTest extends TestCase
{
    public function test(): void
    {
        $this->useDatabase();

        $expected = Log::factory()
            ->count(3)
            ->create([
                'file' => 'abc',
            ]);

        $unexpected = Log::factory()
            ->count(3)
            ->create();

        $this->assertResultsMatch(
            Log::byFile('abc')->get(),
            $expected,
            $unexpected,
        );
    }
}
