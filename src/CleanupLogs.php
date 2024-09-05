<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\DB;

class CleanupLogs extends Command implements PromptsForMissingInput
{
    protected $signature = 'database-log:cleanup {channel} {cutoff}';

    protected $description = 'Remove Logs from the database on a specific channel which are older than the cutoff in days';

    public function handle(): void
    {
        /** @var string $channel */
        $channel = $this->argument('channel');

        /** @var int $cutoff */
        $cutoff = $this->argument('cutoff');

        $this->info("Removing Logs from the $channel channel older than $cutoff days...");

        $expiryDate = Carbon::today()
            ->subDays($cutoff)
            ->toDateTimeString();

        $deleted = DB::table(config('database-log.table'))
            ->where('channel', '=', $channel)
            ->where('logged_at', '<', $expiryDate)
            ->delete();

        $this->info("Removed $deleted Logs!");
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'channel' => 'Which logging channel would you like to use?',
            'cutoff' => 'After how many days should Logs be deleted?',
        ];
    }
}
