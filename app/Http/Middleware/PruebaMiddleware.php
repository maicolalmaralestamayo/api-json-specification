<?php

namespace App\Http\Middleware;

use Closure;

class PruebaMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
