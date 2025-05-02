<?php

namespace AnthonyEdmonds\LaravelDatabaseLog;

use AnthonyEdmonds\LaravelDatabaseLog\Tests\Database\Factories\LogFactory;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @property string $channel
 * @property ?int $code
 * @property ?string $file
 * @property int $id
 * @property string $level
 * @property ?int $line
 * @property Carbon $logged_at
 * @property string $message
 * @property string $server
 * @property ?string $trace
 *
 * @method static Builder byCode(int $code)
 * @method static Builder byDate(Carbon|string $date)
 * @method static Builder byFile(string $file)
 * @method static Builder byServer(string $server)
 * @method static Builder byLevel(string $level)
 * @method static Builder byLine(int $line)
 * @method static Builder onChannel(string $channel)
 */
class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel',
        'code',
        'file',
        'level',
        'message',
        'server',
        'trace',
    ];

    protected $guarded = [
        'logged_at',
        'id',
    ];

    public $timestamps = false;

    // Setup
    public function __construct(array $attributes = [])
    {
        $this->table = config('database-log.table', 'logs');

        parent::__construct($attributes);
    }

    protected function casts(): array
    {
        return [
            'code' => 'int',
            'id' => 'int',
            'line' => 'int',
            'logged_at' => 'datetime',
        ];
    }

    protected static function newFactory(): LogFactory
    {
        return new LogFactory();
    }

    // Scopes
    public function scopeByCode(Builder $query, int $code): Builder
    {
        return $query->where('code', '=', $code);
    }

    public function scopeByDate(Builder $query, Carbon|string $date): Builder
    {
        return $query->where('logged_at', '=', $date);
    }

    public function scopeByFile(Builder $query, string $file): Builder
    {
        return $query->where('file', '=', $file);
    }

    public function scopeByLevel(Builder $query, string $level): Builder
    {
        return $query->where('level', '=', $level);
    }

    public function scopeByLine(Builder $query, int $line): Builder
    {
        return $query->where('line', '=', $line);
    }

    public function scopeByServer(Builder $query, string $server): Builder
    {
        return $query->where('server', '=', $server);
    }

    public function scopeOnChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', '=', $channel);
    }

    // Utilities
    public static function cleanup(int $daysOld): int
    {
        $expiryDate = Carbon::today()
            ->subDays($daysOld)
            ->toDateTimeString();

        return DB::table(config('database-log.table'))
            ->where('logged_at', '<', $expiryDate)
            ->delete();
    }

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

    protected function parseException(Throwable $exception): void
    {
        $this->code = $exception->getCode();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->trace = $exception->getTraceAsString();
    }
}
