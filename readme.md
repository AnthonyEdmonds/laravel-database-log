# Laravel Database Log

Store your Laravel logs in the database!

## Installation

1. Add the library using Composer:
    ```
    composer require anthonyedmonds\laravel-database-log
    ```
2. The service provider will be automatically registered.
    If required, you can manually register the service provider by adding it to your `bootstrap/providers.php`:
    ```
    return [
        ...
        AnthonyEdmonds\GovukLaravel\Providers\GovukServiceProvider::class,
        ...
    ],
    ```
3. Publish the database migration and config files using Artisan:
    ```
    php artisan vendor:publish anthonyedmonds\databaselogserviceprovider
    ```
4. Add a log channel to 'config/logging.php' based on the following:
    ```
    'channels' => [
        ...
        'database' => [
            'driver' => 'monolog',
            'handler' => AnthonyEdmonds\LaravalDatabaseLog\Handler::class,
            'with' => [
                'fallback' => 'stack',
            ],
        ],
        ...
    ],
    ```
    The fallback parameter is optional, and can point to a log to use in case the database cannot be reached.
5. Optionally, add the `database-log:cleanup` command to your scheduler:
    ```
    
    ```

## Usage

Whenever Laravel creates a log, whether manually or when exceptions are thrown, a new Log will be created in the database.

You are free to use those Logs in whatever fashion you see fit; no UI or other restrictions are provided by this library.

## Roadmap

1. Check that it works with stack
2. Clenaup command
3. Check works with level restriction
4. Unit tests
5. Scopes
6. Database indexes

## Issues and feedback

You are welcome to raise issues on Github to provide bug reports, issues, and feedback.
