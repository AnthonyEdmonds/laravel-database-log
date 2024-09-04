<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Illuminate\Support\ServiceProvider;

class DatabaseLogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->publishes([
            __DIR__.'/database-log.php' => config_path('database-log.php'),
        ]);

        $this->mergeConfigFrom(__DIR__.'/database-log.php', 'database-log');
    }

    public function boot(): void
    {
        //
    }
}
