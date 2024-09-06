<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Database\Factories;

use AnthonyEdmonds\LaravelDatabaseLog\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'channel' => $this->faker->word(),
            'code' => $this->faker->randomNumber(3),
            'file' => $this->faker->filePath(),
            'level' => $this->faker->randomElement([
                'Alert',
                'Critical',
                'Debug',
                'Emergency',
                'Info',
                'Notice',
                'Warning',
            ]),
            'logged_at' => $this->faker->datetime(),
            'message' =>  $this->faker->sentence(),
            'server' => $this->faker->word(),
            'trace' => $this->faker->paragraph(),
        ];
    }
}
