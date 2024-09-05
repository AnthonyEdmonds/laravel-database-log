<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $channel
 * @property Carbon $logged_at
 * @property int $id
 * @property string $level
 * @property string $message
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
            'id' => 'int',
            'logged_at' => 'datetime',
        ];
    }

    // Scopes
    public function scopeOnChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', '=', $channel);
    }
}
