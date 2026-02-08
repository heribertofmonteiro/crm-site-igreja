<?php

namespace App\Http\Middleware;

use App\Models\ApiToken;
use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenString = $request->bearerToken();
        
        if (!$tokenString) {
            return response()->json([
                'success' => false,
                'message' => 'API token required'
            ], 401);
        }

        $token = ApiToken::where('token', $tokenString)
                        ->where('expires_at', '>', now())
                        ->first();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        // Update token usage
        $token->increment('usage_count');
        $token->update(['last_used_at' => now()]);

        // Add token to request for later use
        $request->merge(['api_token' => $token]);

        return $next($request);
    }
}
