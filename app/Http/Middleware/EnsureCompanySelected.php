<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCompanySelected
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user) {
            return $next($request);
        }
        
        // If user has no current company and has at least one company
        if (!$user->current_company_id && $user->company_id) {
            return redirect()->route('company.switch');
        }
        
        // If user has no company at all, redirect to create
        if (!$user->current_company_id && !$user->company_id) {
            return redirect()->route('company.create');
        }
        
        return $next($request);
    }
}