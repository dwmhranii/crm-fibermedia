<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $table = 'leads';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'coverage_id',
        'package_id',
        'message',
        'source',
        'status',
        'handled_by',
        'handled_at',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
    ];

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_SPAM = 'spam';

    public static function statusOptions(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_CONTACTED => 'Contacted',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_SPAM => 'Spam',
        ];
    }

    public function coverage()
    {
        return $this->belongsTo(Coverage::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function markHandled(?int $userId = null): void
    {
        $this->handled_by = $userId;
        $this->handled_at = now();
    }
}
