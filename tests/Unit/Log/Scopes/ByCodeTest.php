<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Scopes;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class ByCodeTest extends TestCase
{
    public function test(): void
    {
        $this->useDatabase();

        $expected = Log::factory()
            ->count(3)
            ->create([
                'code' => 0,
            ]);

        $unexpected = Log::factory()
            ->count(3)
            ->create([
                'code' => 1,
            ]);

        $this->assertResultsMatch(
            Log::byCode(0)->get(),
            $expected,
            $unexpected,
        );
    }
}
