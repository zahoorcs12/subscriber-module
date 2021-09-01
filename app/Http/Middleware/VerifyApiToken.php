<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiToken
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
        $authApiToken = config('auth.api.token');
        $bearerToken =  $request->bearerToken();
        if ($request->apiToken != $authApiToken && $bearerToken != $authApiToken) {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
        return $next($request);
    }
}
