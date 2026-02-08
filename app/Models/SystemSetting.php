<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['key', 'value', 'type', 'description'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Cache duration in seconds (1 hour).
     */
    protected const CACHE_DURATION = 3600;

    /**
     * Get a system setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        // Try to get from cache first
        $cacheKey = "system_setting_{$key}";

        if (Cache::has($cacheKey)) {
            $cachedValue = Cache::get($cacheKey);

            // Handle special case for null cached value
            if ($cachedValue === '__NULL__') {
                return $default;
            }

            return $cachedValue;
        }

        // Get from database
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            // Cache the null value to avoid repeated DB queries
            Cache::put($cacheKey, '__NULL__', self::CACHE_DURATION);
            return $default;
        }

        // Cast value based on type
        $value = $setting->castValue($setting->value, $setting->type);

        // Cache the value
        Cache::put($cacheKey, $value ?? '__NULL__', self::CACHE_DURATION);

        return $value;
    }

    /**
     * Set a system setting value.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @param string|null $description
     * @return SystemSetting
     */
    public static function set(string $key, mixed $value, string $type = 'string', ?string $description = null): SystemSetting
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) || is_object($value) ? json_encode($value) : (string) $value,
                'type' => $type,
                'description' => $description,
            ]
        );

        // Clear cache
        Cache::forget("system_setting_{$key}");

        return $setting;
    }

    /**
     * Get all settings as an array.
     *
     * @return array
     */
    public static function allAsArray(): array
    {
        $settings = static::all();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->castValue($setting->value, $setting->type);
        }

        return $result;
    }

    /**
     * Cast value based on type.
     *
     * @param string|null $value
     * @param string $type
     * @return mixed
     */
    protected function castValue(?string $value, string $type): mixed
    {
        // Handle null values
        if ($value === null) {
            return match ($type) {
                'integer' => 0,
                'float', 'double' => 0.0,
                'boolean', 'bool' => false,
                'json', 'array', 'object' => null,
                'string' => '',
                default => null,
            };
        }

        return match ($type) {
            'integer' => (int) $value,
            'float', 'double' => (float) $value,
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json', 'array', 'object' => json_decode($value, $type === 'array' || $type === 'json'),
            'string' => $value,
            default => $value,
        };
    }

    /**
     * Clear all settings cache.
     *
     * @return void
     */
    public static function clearCache(): void
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("system_setting_{$setting->key}");
        }
    }
}
