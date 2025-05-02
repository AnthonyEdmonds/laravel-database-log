<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Log\Utilities;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;
use Carbon\Carbon;

class CleanupTest extends TestCase
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
        $this->assertEquals(1, Log::cleanup(30));

        $this->assertDatabaseHas($this->toKeep);
        $this->assertDatabaseMissing($this->toDelete);
    }
}
