<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\CleanupLogsJob;

use AnthonyEdmonds\LaravelDatabaseLog\CleanupLogsJob;
use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;
use Carbon\Carbon;

class HandleTest extends TestCase
{
    protected CleanupLogsJob $job;

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

        $this->job = new CleanupLogsJob(30);
        $this->job->handle();
    }

    public function test(): void
    {
        $this->assertDatabaseHas($this->toKeep);
        $this->assertDatabaseMissing($this->toDelete);
    }
}
