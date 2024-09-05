<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Scopes;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class OnChannelTest extends TestCase
{
    public function test(): void
    {
        $this->useDatabase();

        $expected = Log::factory()
            ->count(3)
            ->create([
                'channel' => 'panic',
            ]);

        $unexpected = Log::factory()
            ->count(3)
            ->create();

        $this->assertResultsMatch(
            Log::onChannel('panic')->get(),
            $expected,
            $unexpected,
        );
    }
}
