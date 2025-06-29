<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated and has one of the specified roles
        // If not, abort with a 403 Forbidden response
        // You can customize the logic here based on your application's requirements
        // For example, you might want to redirect to a login page or show an error message
        
            if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
                abort(403); // Forbidden
            }

            return $next($request);
        
    }
}
