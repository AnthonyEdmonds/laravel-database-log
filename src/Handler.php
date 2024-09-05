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
                IlluminateLog::channel($this->fallback)
                    ->log($record->level, $record->message, $record->context);

                IlluminateLog::channel($this->fallback)
                    ->emergency('Laravel Database Log failed to write', ['exception' => $exception]);
            }
        }
    }
}
