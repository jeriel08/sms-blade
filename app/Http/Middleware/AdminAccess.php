<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Check if user has principal or head-teacher role
        if (!$user->hasAnyRole(['principal', 'head-teacher'])) {
            abort(403, 'Access denied. Only Principal and Head Teacher can access this page.');
        }

        return $next($request);
    }
}
