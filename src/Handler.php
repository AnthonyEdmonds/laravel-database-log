<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log as IlluminateLog;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Throwable;

class Handler extends AbstractProcessingHandler
{
    public ?string $fallback;

    public function __construct(int|string|Level $level = Level::Debug, bool $bubble = true, ?string $fallback = null)
    {
        parent::__construct($level, $bubble);

        $this->fallback = $fallback;
    }

    protected function write(LogRecord $record): void
    {
        $class = config('database-log.model', Log::class);

        /** @var Log $model */
        $model = new $class();
        $model->channel = $record->channel;
        $model->logged_at = Carbon::createFromImmutable($record->datetime);
        $model->level = $record->level->name;
        $model->message = $record->message;
        $model->interpretContext($record->context);
        $model->interpretExtra($record->extra);

        try {
            $model->save();
        } catch (Throwable $exception) {
            if ($this->fallback !== null) {
                $channel = IlluminateLog::channel($this->fallback);

                match ($record->level->name) {
                    'Alert' => $channel->alert($record->message, $record->context),
                    'Critical' => $channel->critical($record->message, $record->context),
                    'Debug' => $channel->debug($record->message, $record->context),
                    'Emergency' => $channel->emergency($record->message, $record->context),
                    'Info' => $channel->info($record->message, $record->context),
                    'Notice' => $channel->notice($record->message, $record->context),
                    'Warning' => $channel->warning($record->message, $record->context),
                    default => $channel->error($record->message, $record->context),
                };

                $channel->emergency('Laravel Database Log failed to write', ['exception' => $exception]);
            }
        }
    }
}
