<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMultipleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->check() || Auth::guard('lawyer')->check()) {
            return $next($request); // Proceed to next request if any guard is authenticated
        }

        // If both guards fail, redirect back to the previous page
        return redirect()->back()->with('error', 'You are not authorized to access this page.');
    }
}
