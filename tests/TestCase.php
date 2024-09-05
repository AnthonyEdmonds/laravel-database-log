<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests;

use AnthonyEdmonds\LaravelDatabaseLog\DatabaseLogServiceProvider;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\Traits\AssertsResults;
use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use AssertsResults;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    protected function getPackageProviders($app): array
    {
        return [
            DatabaseLogServiceProvider::class,
        ];
    }

    protected function useDatabase(): void
    {
        $this->app->useDatabasePath(__DIR__ . '/Database');
        $this->runLaravelMigrations();
    }
}
