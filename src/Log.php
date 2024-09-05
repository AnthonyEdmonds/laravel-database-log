<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * @property string $channel
 * @property ?int $code
 * @property ?string $file
 * @property Carbon $logged_at
 * @property int $id
 * @property string $level
 * @property ?int $line
 * @property string $message
 * @property ?string $trace
 */
class Log extends Model
{
    protected $fillable = [
        'channel',
        'level',
        'message',
    ];

    protected $guarded = [
        'logged_at',
        'id',
    ];

    public $timestamps = false;

    // Setup
    protected function casts(): array
    {
        return [
            'code' => 'int',
            'id' => 'int',
            'line' => 'int',
            'logged_at' => 'datetime',
        ];
    }

    // Scopes
    public function scopeOnChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', '=', $channel);
    }

    // Utilities
    public function interpretContext(array $context): void
    {
        if (
            array_key_exists('exception', $context) === true
            && is_a($context['exception'], Throwable::class) === true
        ) {
            $this->parseException($context['exception']);
        }
    }

    public function interpretExtra(array $extra): void
    {
        //
    }

    public function parseException(Throwable $exception): void
    {
        $this->code = $exception->getCode();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->trace =  $exception->getTraceAsString();
    }
}
