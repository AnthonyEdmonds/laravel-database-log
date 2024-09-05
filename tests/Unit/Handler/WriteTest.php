<?php

namespace AnthonyEdmonds\LaravelDatabaseLog\Tests\Unit\Handler;

use AnthonyEdmonds\LaravelDatabaseLog\Handler;
use AnthonyEdmonds\LaravelDatabaseLog\Tests\TestCase;
use Carbon\CarbonImmutable;
use ErrorException;
use Illuminate\Log\LogManager;
use Illuminate\Support\Facades\Log;
use Mockery\Mock;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\Attributes\DataProvider;

class WriteTest extends TestCase
{
    protected array $context = [];

    protected Handler $handler;

    protected CarbonImmutable $now;

    protected LogRecord $record;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->now = CarbonImmutable::now();
        $this->handler = new Handler(fallback: 'my_fallback');
    }

    public function testSavesLog(): void
    {
        $this->context = [
            'exception' => new ErrorException(
                code: 0,
                line: 12,
            ),
        ];

        $this->makeRecord(Level::Error);

        $this->handler->handle($this->record);

        $this->assertDatabaseHas('logs', [
            'channel' => 'database',
            'code' => 0,
            'level' => 'Error',
            'line' => 12,
            'logged_at' => $this->now->toDateTimeString(),
            'message' => 'My message',
        ]);
    }

    #[DataProvider('levels')]
    public function testFallback(Level $level, string $method): void
    {
        config()->set('logging.default', 'my_fallback');
        config()->set('database-log.table', 'mortis');

        $this->makeRecord($level);

        /** @var LogManager|Mock $mock */
        $mock = Log::partialMock();
        $mock->setApplication(app());

        $mock->expects('channel')->with('my_fallback')->andReturnSelf();

        $mock->expects($method)
            ->with('My message', [])
            ->andReturnNull();

        $mock->expects('emergency')
            ->withSomeOfArgs('Laravel Database Log failed to write')
            ->andReturnNull();

        $this->handler->handle($this->record);
    }

    public static function levels(): array
    {
        return [
            ['level' => Level::Alert, 'method' => 'alert'],
            ['level' => Level::Critical, 'method' => 'critical'],
            ['level' => Level::Debug, 'method' => 'debug'],
            ['level' => Level::Emergency, 'method' => 'emergency'],
            ['level' => Level::Error, 'method' => 'error'],
            ['level' => Level::Info, 'method' => 'info'],
            ['level' => Level::Notice, 'method' => 'notice'],
            ['level' => Level::Warning, 'method' => 'warning'],
        ];
    }

    protected function makeRecord(Level $level): void
    {
        $this->record = new LogRecord(
            $this->now,
            'database',
            $level,
            'My message',
            $this->context,
        );
    }
}
