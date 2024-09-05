<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Scopes;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;
use Carbon\Carbon;

class ByDateTest extends TestCase
{
    public function test(): void
    {
        $this->useDatabase();

        $today = Carbon::today();

        $expected = Log::factory()
            ->count(3)
            ->create([
                'logged_at' => $today,
            ]);

        $unexpected = Log::factory()
            ->count(3)
            ->create([
                'logged_at' => Carbon::tomorrow(),
            ]);

        $this->assertResultsMatch(
            Log::byDate($today)->get(),
            $expected,
            $unexpected,
        );
    }
}
