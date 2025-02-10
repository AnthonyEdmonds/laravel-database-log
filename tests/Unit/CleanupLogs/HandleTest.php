<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\CleanupLogs;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;
use Carbon\Carbon;

class HandleTest extends TestCase
{
    protected Log $toDelete;

    protected Log $toKeep;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        config()->set('database-log.table', 'logs');

        $this->toDelete = Log::factory()->create([
            'logged_at' => Carbon::today()->subDays(31),
        ]);

        $this->toKeep = Log::factory()->create([
            'logged_at' => Carbon::today()->subDays(30),
        ]);
    }

    public function test(): void
    {
        $this->artisan('database-log:cleanup')
            ->expectsQuestion('After how many days should Logs be deleted?', 30)
            ->expectsOutput('Removing Logs older than 30 days...')
            ->expectsOutput('Removed 1 Logs!');

        $this->assertDatabaseHas('logs', $this->toKeep->toArray());
        $this->assertDatabaseMissing('logs', $this->toDelete->toArray());
    }
}
