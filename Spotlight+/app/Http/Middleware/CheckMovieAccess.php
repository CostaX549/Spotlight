<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMovieAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    $forbiddenMovies = [617932];
    $movieId = $request->route('filmeId');

    if (in_array($movieId, $forbiddenMovies)) {
        
        return response('Acesso não autorizado a este filme', 403);
    }
        return $next($request);
    }
}
