<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Carbon\Carbon;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Throwable;

/**
 * array $context = []
 * array $extra = []
*/
class Handler extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        $class = config('database-log.model', Log::class);

        /** @var Log $model */
        $model = new $class();
        $model->channel = $record->channel;
        $model->logged_at = Carbon::createFromImmutable($record->datetime);
        $model->level = $record->level->name;
        $model->message = $record->message;

        try {
            $model->save();
        } catch (Throwable $exception) {
            // TODO Fallback log
        }

        dd(
            $record->context,
            $record->extra,
        );
    }
}
