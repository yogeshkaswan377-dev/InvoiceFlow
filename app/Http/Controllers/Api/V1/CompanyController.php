<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Create a new company.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'gstin' => [
                'nullable',
                'string',
                'size:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            ],
            'state_code' => 'required|string|size:2',
            'state_name' => 'required|string|max:100',
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $company = Company::create($validated);
        session(['current_company_id' => $company->id]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->company_id = $company->id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Company created successfully.',
            'data' => new CompanyResource($company),
        ], 201);
    }

    /**
     * Get current company.
     */
    public function current(): JsonResponse
    {
        $company = Company::findOrFail(session('current_company_id'));

        return response()->json([
            'success' => true,
            'data' => new CompanyResource($company),
        ]);
    }

    /**
     * List user's companies for switching.
     */
    public function switchCompany(): JsonResponse
    {
        $user = Auth::user();
        $companies = Company::where('user_id', $user->id)
            ->orWhere('id', $user->company_id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => CompanyResource::collection($companies),
            'current_company_id' => session('current_company_id'),
        ]);
    }

    /**
     * Set current company.
     */
    public function setCurrent(Company $company): JsonResponse
    {
        session(['current_company_id' => $company->id]);

        return response()->json([
            'success' => true,
            'message' => "Switched to company: {$company->name}",
            'data' => new CompanyResource($company),
        ]);
    }
}
