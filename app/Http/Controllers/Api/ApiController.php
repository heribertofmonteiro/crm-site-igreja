<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\ApiLog;
use App\Models\ApiRateLimit;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * API authentication endpoint
     */
    public function authenticate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
            'abilities' => 'nullable|array',
            'abilities.*' => 'string|in:read,write,admin',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // Log failed authentication attempt
            $this->logApiRequest($request, 'authenticate', 401, 'Invalid credentials');
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Check rate limiting
        $rateLimitKey = 'auth:' . $request->ip();
        if (!ApiRateLimit::checkAndIncrement($rateLimitKey, $request->ip(), 5, 15)) {
            $this->logApiRequest($request, 'authenticate', 429, 'Rate limit exceeded');
            
            return response()->json([
                'success' => false,
                'message' => 'Too many authentication attempts. Please try again later.'
            ], 429);
        }

        // Create API token
        $token = ApiToken::create([
            'user_id' => $user->id,
            'name' => $request->input('name', 'API Token - ' . now()->format('Y-m-d H:i:s')),
            'token' => Hash::make($user->email . now() . random_bytes(32)),
            'abilities' => $request->input('abilities', ['read']),
            'expires_at' => $request->input('expires_at', now()->addDays(30)),
            'last_used_at' => now(),
        ]);

        $this->logApiRequest($request, 'authenticate', 200, 'Authentication successful');

        return response()->json([
            'success' => true,
            'message' => 'Authentication successful',
            'data' => [
                'token' => $token->token,
                'expires_at' => $token->expires_at,
                'abilities' => $token->abilities,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]
        ]);
    }

    /**
     * Get API token information
     */
    public function tokenInfo(Request $request): JsonResponse
    {
        $token = $this->getValidatedToken($request);
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        // Update last used timestamp
        $token->update(['last_used_at' => now()]);

        $this->logApiRequest($request, 'token_info', 200, 'Token info retrieved');

        return response()->json([
            'success' => true,
            'data' => [
                'token_id' => $token->id,
                'name' => $token->name,
                'abilities' => $token->abilities,
                'created_at' => $token->created_at,
                'expires_at' => $token->expires_at,
                'last_used_at' => $token->last_used_at,
                'usage_count' => $token->usage_count,
                'user' => [
                    'id' => $token->user->id,
                    'name' => $token->user->name,
                    'email' => $token->user->email,
                ]
            ]
        ]);
    }

    /**
     * Revoke API token
     */
    public function revokeToken(Request $request): JsonResponse
    {
        $token = $this->getValidatedToken($request);
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        $token->delete();

        $this->logApiRequest($request, 'revoke_token', 200, 'Token revoked');

        return response()->json([
            'success' => true,
            'message' => 'Token revoked successfully'
        ]);
    }

    /**
     * Get API usage statistics
     */
    public function usageStats(Request $request): JsonResponse
    {
        $token = $this->getValidatedToken($request);
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        // Check if user has admin abilities
        if (!in_array('admin', $token->abilities)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient permissions'
            ], 403);
        }

        $stats = [
            'total_tokens' => ApiToken::count(),
            'active_tokens' => ApiToken::where('expires_at', '>', now())->count(),
            'expired_tokens' => ApiToken::where('expires_at', '<=', now())->count(),
            'total_requests_today' => ApiLog::whereDate('created_at', today())->count(),
            'total_requests_this_month' => ApiLog::whereMonth('created_at', now()->month)
                                               ->whereYear('created_at', now()->year)
                                               ->count(),
            'rate_limits' => ApiRateLimit::getStats(),
            'top_endpoints' => ApiLog::selectRaw('endpoint, COUNT(*) as count')
                                ->whereDate('created_at', today())
                                ->groupBy('endpoint')
                                ->orderByDesc('count')
                                ->limit(10)
                                ->get(),
        ];

        $this->logApiRequest($request, 'usage_stats', 200, 'Usage stats retrieved');

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get API logs (admin only)
     */
    public function logs(Request $request): JsonResponse
    {
        $token = $this->getValidatedToken($request);
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        // Check if user has admin abilities
        if (!in_array('admin', $token->abilities)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient permissions'
            ], 403);
        }

        $logs = ApiLog::with('user')
                    ->orderByDesc('created_at')
                    ->paginate(50);

        $this->logApiRequest($request, 'logs', 200, 'Logs retrieved');

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }

    /**
     * Rate limiting information
     */
    public function rateLimitInfo(Request $request): JsonResponse
    {
        $token = $this->getValidatedToken($request);
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        $rateLimitKey = 'api:' . $request->ip();
        $rateLimit = ApiRateLimit::where('key', $rateLimitKey)
                               ->where('identifier', $request->ip())
                               ->first();

        $info = [
            'is_blocked' => ApiRateLimit::isBlocked($rateLimitKey, $request->ip()),
            'attempts' => $rateLimit ? $rateLimit->attempts : 0,
            'max_attempts' => $rateLimit ? $rateLimit->max_attempts : 60,
            'attempts_remaining' => $rateLimit ? $rateLimit->attempts_remaining : 60,
            'reset_at' => $rateLimit ? $rateLimit->formatted_reset_at : null,
            'time_until_reset' => $rateLimit ? $rateLimit->time_until_reset : null,
        ];

        $this->logApiRequest($request, 'rate_limit_info', 200, 'Rate limit info retrieved');

        return response()->json([
            'success' => true,
            'data' => $info
        ]);
    }

    /**
     * Validate and retrieve API token
     */
    private function getValidatedToken(Request $request): ?ApiToken
    {
        $tokenString = $request->bearerToken();
        
        if (!$tokenString) {
            return null;
        }

        $token = ApiToken::where('token', $tokenString)
                        ->where('expires_at', '>', now())
                        ->first();

        if ($token) {
            $token->increment('usage_count');
            $token->update(['last_used_at' => now()]);
        }

        return $token;
    }

    /**
     * Log API requests
     */
    private function logApiRequest(Request $request, string $endpoint, int $status, string $message = ''): void
    {
        ApiLog::create([
            'user_id' => $this->getValidatedToken($request)?->user_id,
            'endpoint' => $endpoint,
            'method' => $request->method(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => $request->except(['password', 'token']),
            'response_status' => $status,
            'response_message' => $message,
            'response_time' => microtime(true) - LARAVEL_START,
        ]);
    }
}
