<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle($request, Closure $next)
{
    // Skip auth check for public admin routes
   if (!Auth::check() || Auth::user()->role != 1) {
        abort(403, 'Unauthorized access. Admin privileges required.');
    }

    return $next($request);
}
}
