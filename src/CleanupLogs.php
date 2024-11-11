<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\DB;

class CleanupLogs extends Command implements PromptsForMissingInput
{
    protected $signature = 'database-log:cleanup {cutoff}';

    protected $description = 'Remove Logs from the database which are older than the cutoff in days';

    public function handle(): void
    {
        /** @var int $cutoff */
        $cutoff = $this->argument('cutoff');

        $this->info("Removing Logs older than $cutoff days...");

        $expiryDate = Carbon::today()
            ->subDays($cutoff)
            ->toDateTimeString();

        $deleted = DB::table(config('database-log.table'))
            ->where('logged_at', '<', $expiryDate)
            ->delete();

        $this->info("Removed $deleted Logs!");
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'cutoff' => 'After how many days should Logs be deleted?',
        ];
    }
}
