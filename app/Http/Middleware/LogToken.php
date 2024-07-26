<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogToken
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
        // Access the token from the cookie
        $token = $request->cookie('sanctum_token');

        // Log the token
        \Log::info('Sanctum Token: ' . $token);

        return $next($request);
    }
}
