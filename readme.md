# Laravel Database Log

Store your Laravel logs in the database!

## Installation

1. Add the library using Composer:
    ```
    composer require anthonyedmonds/laravel-database-log
    ```
2. The service provider will be automatically registered.
    If required, you can manually register the service provider by adding it to your `bootstrap/providers.php`:
    ```
    return [
        ...
        AnthonyEdmonds\LaravelDatabaseLog\DatabaseLogServiceProvider::class,
        ...
    ];
    ```
3. Publish the database migration and config files using Artisan:
    ```
    php artisan vendor:publish --provider="AnthonyEdmonds\LaravelDatabaseLog\DatabaseLogServiceProvider"
    ```
4. Add a log channel to 'config/logging.php' based on the following:
    ```
    'channels' => [
        ...
        'database' => [
            'driver' => 'monolog',
            'handler' => AnthonyEdmonds\LaravelDatabaseLog\Handler::class,
            'with' => [
                'fallback' => 'daily',
            ],
            'level' => env('LOG_LEVEL', 'debug'),
        ],
        ...
    ],
    ```
    * The `fallback` parameter is optional, and can point to a log to use in case the database cannot be reached.
    * The `level` parameter can be excluded if desired.

## Configuration

The configuration found at `config/database-log.php` allows you to customise the following:

| Field | Default                               | Purpose                                                             |
|-------|---------------------------------------|---------------------------------------------------------------------|
| model | AnthonyEdmonds\LaravelDatabaseLog\Log | The class name of the model to use for storing logs in the database |
| table | logs                                  | The name of the table used to store database logs                   |

## Cleaning up old logs

### Job

A Laravel Job is provided to cleanup old logs.

Add the job to your schedule, providing the number of days after which logs should be deleted.

```php
$schedule
    ->job(new CleanupLogsJob())
    ->daily();
```

### Command

The `database-log:cleanup` command is also provided to remove old logs from the database as required.

You can provide the number of days after which logs should be deleted as part of the command.

```bash
php artisan database-log:cleanup 14
```

You can also schedule the command to run automatically by adding it to your scheduler:

```
$schedule
   ->command('database-log:cleanup 90')
   ->daily();
```

## Usage

Whenever Laravel creates a log, whether manually or when exceptions are thrown, a new Log will be created in the database.

You are free to use those Logs in whatever fashion you see fit; no UI or other restrictions are provided by this library.

## Issues and feedback

You are welcome to raise issues on Github to provide bug reports, issues, and feedback.
