<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Scopes;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;

class ByLevelTest extends TestCase
{
    public function test(): void
    {
        $this->useDatabase();

        $expected = Log::factory()
            ->count(3)
            ->create([
                'level' => 'Hopeless',
            ]);

        $unexpected = Log::factory()
            ->count(3)
            ->create();

        $this->assertResultsMatch(
            Log::byLevel('Hopeless')->get(),
            $expected,
            $unexpected,
        );
    }
}
