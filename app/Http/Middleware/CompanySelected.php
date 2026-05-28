<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanySelected
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('current_company_id')) {
            return redirect()->route('company.switch');
        }

        return $next($request);
    }
}