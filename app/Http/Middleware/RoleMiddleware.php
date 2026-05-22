<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            // Redirect to the appropriate dashboard based on the user's actual role
            return match ($userRole) {
                'admin' => redirect()->route('admin.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                default => redirect()->route('home'),
            };
        }

        return $next($request);
    }
}
