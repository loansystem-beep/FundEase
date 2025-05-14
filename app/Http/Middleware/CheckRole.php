<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user is authenticated and has the required role
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // Redirect if the user does not have the required role
            return redirect()->route('dashboard')->with('error', 'You do not have the required permissions.');
        }

        // Allow the request to proceed if the role is valid
        return $next($request);
    }
}
