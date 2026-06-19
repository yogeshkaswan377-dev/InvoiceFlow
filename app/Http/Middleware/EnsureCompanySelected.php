<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanySelected
{
    public function handle(Request $request, Closure $next): Response
    {

        // Super Admin bypass
        if (auth()->check() && auth()->user()->hasRole('super_admin')) {
            return $next($request);
        }
        if (
            !session()->has('current_company_id') &&
            auth()->check() &&
            auth()->user()->company_id
        ) {
            session([
                'current_company_id' => auth()->user()->company_id
            ]);
        }

        if (!session()->has('current_company_id')) {
            return redirect()->route('company.create');
        }

        return $next($request);
    }
}
