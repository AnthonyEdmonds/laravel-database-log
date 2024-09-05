<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Illuminate\Support\ServiceProvider;

class DatabaseLogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->publishes([
            __DIR__ . '/database-log.php' => config_path('database-log.php'),
        ]);

        $this->publishesMigrations([
            __DIR__ . '/0000_00_00_000000_create_logs_table.php' => database_path('migrations/0000_00_00_000000_create_logs_table.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/database-log.php', 'database-log');
    }

    public function boot(): void
    {
        $this->commands([
            CleanupLogs::class,
        ]);
    }
}
