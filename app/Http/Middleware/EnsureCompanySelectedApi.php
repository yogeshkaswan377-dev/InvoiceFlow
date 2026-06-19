<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanySelectedApi
{
    /**
     * Handle an incoming API request.
     * Stateless — uses X-Company-ID header or user's default company.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'type' => 'https://tools.ietf.org/html/rfc7235#section-3.1',
                'title' => 'Unauthenticated',
                'status' => 401,
                'detail' => 'Authentication required.',
            ], 401);
        }

        $companyId = null;

        // Priority 1: X-Company-ID header (stateless)
        $headerCompanyId = $request->header('X-Company-ID');
        if ($headerCompanyId) {
            // Verify user belongs to this company
            if ($user->company_id == $headerCompanyId || $user->current_company_id == $headerCompanyId) {
                $companyId = (int) $headerCompanyId;
            }
        }

        // Priority 2: User's current_company_id from database
        if (!$companyId && $user->current_company_id) {
            $companyId = $user->current_company_id;
        }

        // Priority 3: User's default company_id
        if (!$companyId && $user->company_id) {
            $companyId = $user->company_id;
        }

        if (!$companyId) {
            return response()->json([
                'type' => 'https://tools.ietf.org/html/rfc7231#section-6.5.4',
                'title' => 'Company Not Selected',
                'status' => 404,
                'detail' => 'Please select or create a company first. Use POST /api/v1/company to create one, or set X-Company-ID header.',
            ], 404);
        }

        // Store in session for backward compatibility with web Services
        // But don't fail if session isn't available (stateless API)
        try {
            session(['current_company_id' => $companyId]);
        } catch (\RuntimeException $e) {
            // Session not available in stateless API — that's fine
        }

        // Also merge into request for direct access
        $request->merge(['current_company_id' => $companyId]);

        return $next($request);
    }
}
