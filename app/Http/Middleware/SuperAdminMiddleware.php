<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('super_admin')) {
            // Agar /dashboard pe gaya toh super-admin dashboard pe redirect karo
            if ($request->is('dashboard')) {
                return redirect()->route('super-admin.dashboard');
            }
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
