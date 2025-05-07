<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CleanupLogsJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public function __construct(public int $daysOld)
    {
        //
    }

    public function handle(): void
    {
        Log::cleanup($this->daysOld);
    }
}
