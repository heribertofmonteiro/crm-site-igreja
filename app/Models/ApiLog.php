<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'endpoint',
        'route_name',
        'ip_address',
        'user_agent',
        'status_code',
        'request_data',
        'response_data',
        'error_message',
        'response_time_ms',
        'user_id',
        'api_token_id',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'response_time_ms' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function apiToken(): BelongsTo
    {
        return $this->belongsTo(ApiToken::class);
    }

    public function scopeByMethod($query, string $method)
    {
        return $query->where('method', $method);
    }

    public function scopeByEndpoint($query, string $endpoint)
    {
        return $query->where('endpoint', 'like', "%{$endpoint}%");
    }

    public function scopeByRouteName($query, string $routeName)
    {
        return $query->where('route_name', $routeName);
    }

    public function scopeByIpAddress($query, string $ipAddress)
    {
        return $query->where('ip_address', $ipAddress);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByApiToken($query, $tokenId)
    {
        return $query->where('api_token_id', $tokenId);
    }

    public function scopeByStatusCode($query, $statusCode)
    {
        return $query->where('status_code', $statusCode);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status_code', '>=', 200)
                   ->where('status_code', '<', 300);
    }

    public function scopeClientError($query)
    {
        return $query->where('status_code', '>=', 400)
                   ->where('status_code', '<', 500);
    }

    public function scopeServerError($query)
    {
        return $query->where('status_code', '>=', 500);
    }

    public function scopeSlow($query, $thresholdMs = 1000)
    {
        return $query->where('response_time_ms', '>', $thresholdMs);
    }

    public function scopeWithErrors($query)
    {
        return $query->whereNotNull('error_message');
    }

    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            'GET' => '<span class="badge badge-primary">GET</span>',
            'POST' => '<span class="badge badge-success">POST</span>',
            'PUT' => '<span class="badge badge-warning">PUT</span>',
            'PATCH' => '<span class="badge badge-info">PATCH</span>',
            'DELETE' => '<span class="badge badge-danger">DELETE</span>',
            'HEAD' => '<span class="badge badge-secondary">HEAD</span>',
            'OPTIONS' => '<span class="badge badge-secondary">OPTIONS</span>',
            default => '<span class="badge badge-secondary">' . $this->method . '</span>'
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        $code = (int) $this->status_code;
        
        if ($code >= 200 && $code < 300) {
            return '<span class="badge badge-success">' . $code . '</span>';
        }
        
        if ($code >= 300 && $code < 400) {
            return '<span class="badge badge-warning">' . $code . '</span>';
        }
        
        if ($code >= 400 && $code < 500) {
            return '<span class="badge badge-danger">' . $code . '</span>';
        }
        
        return '<span class="badge badge-secondary">' . $code . '</span>';
    }

    public function getFormattedResponseTimeAttribute(): string
    {
        if (!$this->response_time_ms) {
            return '--';
        }
        
        return $this->response_time_ms . 'ms';
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }

    public function isSuccessful(): bool
    {
        return $this->status_code >= 200 && $this->status_code < 300;
    }

    public function isClientError(): bool
    {
        return $this->status_code >= 400 && $this->status_code < 500;
    }

    public function isServerError(): bool
    {
        return $this->status_code >= 500;
    }

    public function isSlow(int $thresholdMs = 1000): bool
    {
        return $this->response_time_ms > $thresholdMs;
    }

    public function hasError(): bool
    {
        return !empty($this->error_message);
    }

    public function getRequestSizeAttribute(): int
    {
        return strlen(json_encode($this->request_data ?? []));
    }

    public function getResponseSizeAttribute(): int
    {
        return strlen(json_encode($this->response_data ?? []));
    }

    public function getFormattedRequestSizeAttribute(): string
    {
        $bytes = $this->request_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFormattedResponseSizeAttribute(): string
    {
        $bytes = $this->response_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getShortUserAgentAttribute(): string
    {
        if (!$this->user_agent) {
            return '--';
        }
        
        // Extract browser name from user agent
        if (preg_match('/(Chrome|Firefox|Safari|Edge|Opera|MSIE)/', $this->user_agent, $matches)) {
            return $matches[1];
        }
        
        return 'Unknown';
    }

    public static function logRequest(
        string $method,
        string $endpoint,
        int $statusCode,
        array $requestData = [],
        array $responseData = [],
        string $errorMessage = null,
        int $responseTimeMs = null,
        string $ipAddress = null,
        string $userAgent = null,
        $userId = null,
        $tokenId = null
    ): self {
        return self::create([
            'method' => $method,
            'endpoint' => $endpoint,
            'status_code' => $statusCode,
            'request_data' => $requestData,
            'response_data' => $responseData,
            'error_message' => $errorMessage,
            'response_time_ms' => $responseTimeMs,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'user_id' => $userId,
            'api_token_id' => $tokenId,
        ]);
    }

    public static function logSuccessfulRequest(
        string $method,
        string $endpoint,
        array $requestData = [],
        array $responseData = [],
        int $responseTimeMs = null,
        $userId = null,
        $tokenId = null
    ): self {
        return self::logRequest(
            $method,
            $endpoint,
            200,
            $requestData,
            $responseData,
            null,
            $responseTimeMs,
            null,
            null,
            $userId,
            $tokenId
        );
    }

    public static function logErrorRequest(
        string $method,
        string $endpoint,
        int $statusCode,
        string $errorMessage,
        array $requestData = [],
        array $responseData = [],
        int $responseTimeMs = null,
        $userId = null,
        $tokenId = null
    ): self {
        return self::logRequest(
            $method,
            $endpoint,
            $statusCode,
            $requestData,
            $responseData,
            $errorMessage,
            $responseTimeMs,
            null,
            null,
            $userId,
            $tokenId
        );
    }

    public static function getStats(array $filters = []): array
    {
        $query = self::query();

        if (isset($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (isset($filters['method'])) {
            $query->byMethod($filters['method']);
        }

        if (isset($filters['endpoint'])) {
            $query->byEndpoint($filters['endpoint']);
        }

        if (request()->has('status_code')) {
            $query->byStatusCode($filters['status_code']);
        }

        $total = $query->count();
        $successful = $query->successful()->count();
        $clientErrors = $query->clientError()->count();
        $serverErrors = $query->serverError()->count();
        $slow = $query->slow()->count();
        $withErrors = $query->withErrors()->count();

        return [
            'total' => $total,
            'successful' => $successful,
            'client_errors' => $clientErrors,
            'server_errors' => $serverErrors,
            'slow' => $slow,
            'with_errors' => $withErrors,
            'success_rate' => $total > 0 ? round(($successful / $total) * 100, 2) : 0,
            'error_rate' => $total > 0 ? round((($clientErrors + $serverErrors) / $total) * 100, 2) : 0,
            'slow_rate' => $total > 0 ? round(($slow / $total) * 100, 2) : 0,
        ];
    }

    public static function getTopEndpoints(int $limit = 10): array
    {
        return self::selectRaw('endpoint, COUNT(*) as count')
            ->groupBy('endpoint')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'endpoint' => $item->endpoint,
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    public static function getTopUsers(int $limit = 10): array
    {
        return self::selectRaw('user_id, COUNT(*) as count')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('count')
            ->limit($limit)
            ->with('user:id,name')
            ->get()
            ->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'user_name' => $item->user->name ?? 'Unknown',
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    public static function cleanupOldLogs(int $days = 30): int
    {
        return self::where('created_at', '<', now()->subDays($days))->delete();
    }

    public static function cleanupErrorLogs(): int
    {
        return self::withErrors()->delete();
    }

    public static function cleanupSlowLogs(int $thresholdMs = 5000): int
    {
        return self::slow($thresholdMs)->delete();
    }
}
