<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 1970 00:00:00 GMT');
        return $next($request);
    }
}
