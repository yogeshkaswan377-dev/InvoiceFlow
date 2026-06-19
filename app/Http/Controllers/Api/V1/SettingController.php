<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Get company settings.
     */
    public function index(): JsonResponse
    {
        $company = Company::findOrFail(session('current_company_id'));

        return response()->json([
            'success' => true,
            'data' => new CompanyResource($company),
        ]);
    }

    /**
     * Update company settings.
     */
    public function update(Request $request): JsonResponse
    {
        $company = Company::findOrFail(session('current_company_id'));

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'gstin' => [
                'nullable',
                'string',
                'size:15',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            ],
            'state_code' => 'sometimes|string|size:2',
            'state_name' => 'sometimes|string|max:100',
            'address_line_1' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:100',
            'pincode' => 'sometimes|string|max:10',
            'country' => 'sometimes|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'bank_details' => 'nullable|array',
            'invoice_prefix' => 'nullable|string|max:20',
            'quote_prefix' => 'nullable|string|max:20',
            'default_payment_terms' => 'nullable|string|max:100',
            'default_gst_mode' => 'nullable|in:exclusive,inclusive',
            'default_gst_rate' => 'nullable|numeric|min:0|max:100',
            'terms_conditions' => 'nullable|string|max:5000',
        ]);

        $company->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
            'data' => new CompanyResource($company->fresh()),
        ]);
    }

    /**
     * Upload company logo.
     */
    public function uploadLogo(Request $request): JsonResponse
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $company = Company::findOrFail(session('current_company_id'));

        if ($company->logo_path) {
            Storage::disk('public')->delete($company->logo_path);
        }

        $path = $request->file('logo')->store('logos', 'public');
        $company->update(['logo_path' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Logo uploaded successfully.',
            'data' => ['logo_url' => Storage::url($path)],
        ]);
    }

    /**
     * Upload signature.
     */
    public function uploadSignature(Request $request): JsonResponse
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        $company = Company::findOrFail(session('current_company_id'));

        if ($company->signature_path) {
            Storage::disk('public')->delete($company->signature_path);
        }

        $path = $request->file('signature')->store('signatures', 'public');
        $company->update(['signature_path' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Signature uploaded successfully.',
            'data' => ['signature_url' => Storage::url($path)],
        ]);
    }

    /**
     * Remove media (logo/signature).
     */
    public function removeMedia(Request $request): JsonResponse
    {
        $request->validate(['type' => 'required|in:logo,signature']);

        $company = Company::findOrFail(session('current_company_id'));
        $field = $request->type === 'logo' ? 'logo_path' : 'signature_path';

        if ($company->$field) {
            Storage::disk('public')->delete($company->$field);
            $company->update([$field => null]);
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst($request->type) . ' removed successfully.',
        ]);
    }
}
