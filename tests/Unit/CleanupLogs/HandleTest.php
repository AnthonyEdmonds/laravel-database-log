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
            'channel' => 'database',
            'logged_at' => Carbon::today()->subDays(31),
        ]);

        $this->toKeep = Log::factory()->create([
            'channel' => 'database',
            'logged_at' => Carbon::today()->subDays(30),
        ]);
    }

    public function test(): void
    {
        $this->artisan('database-log:cleanup')
            ->expectsQuestion('Which logging channel would you like to use?', 'database')
            ->expectsQuestion('After how many days should Logs be deleted?', 30)
            ->expectsOutput('Removing Logs from the database channel older than 30 days...')
            ->expectsOutput('Removed 1 Logs!');

        $this->assertDatabaseHas($this->toKeep);
        $this->assertDatabaseMissing($this->toDelete);
    }
}
