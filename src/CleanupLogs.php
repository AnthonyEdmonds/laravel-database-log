<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class CleanupLogs extends Command implements PromptsForMissingInput
{
    protected $signature = 'database-log:cleanup {cutoff}';

    protected $description = 'Remove Logs from the database which are older than the cutoff in days';

    public function handle(): void
    {
        /** @var int $cutoff */
        $cutoff = $this->argument('cutoff');

        $this->info("Removing Logs older than $cutoff days...");
        $deleted = Log::cleanup($cutoff);
        $this->info("Removed $deleted Logs!");
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'cutoff' => 'After how many days should Logs be deleted?',
        ];
    }
}
