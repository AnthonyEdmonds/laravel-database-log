# Laravel Database Log

Store your Laravel logs in the database

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
            ...
        ],
        ...
    ],
    ```
