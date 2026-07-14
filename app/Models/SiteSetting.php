<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'key', 'value', 'group', 'is_active',
    ];

    public static function cacheKey(): string
    {
        return 'site_settings.all';
    }

    public static function clearCache(): void
    {
        Cache::forget(static::cacheKey());
    }

    public static function allKeyValue(): array
    {
        return Cache::rememberForever(static::cacheKey(), function () {
            return static::query()
                ->where('is_active', 1)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function getValue(string $key, $default = null)
    {
        $all = static::allKeyValue();
        return $all[$key] ?? $default;
    }

    public static function setValue(string $key, $value, ?string $group = null): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'is_active' => 1,
            ]
        );

        static::clearCache();
    }
}
