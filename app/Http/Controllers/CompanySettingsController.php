<?php
// app/Http/Controllers/CompanySettingsController.php

namespace App\Http\Controllers;

use App\DTOs\CompanySettingsData;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\Company\CompanySettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanySettingsController extends Controller
{
    public function __construct(
        protected CompanySettingsService $settingsService
    ) {}
    
    public function edit()
    {
        $company = $this->settingsService->getSettings(auth()->user()->company_id);
        $states = config('indian_states.states');
        
        return view('settings.index', compact('company', 'states'));
    }
    
    public function update(UpdateCompanyRequest $request)
    {
        $companyData = CompanySettingsData::fromRequest(
            $request->validated(),
            auth()->user()->company->bank_details ?? []
        );
        
        $company = $this->settingsService->updateSettings(auth()->user()->company_id, $companyData);
        
        return redirect()->route('settings.edit')
            ->with('success', 'Company settings updated successfully.');
    }
    
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048']
        ]);
        
        $company = $this->settingsService->updateLogo(
            auth()->user()->company_id,
            $request->file('logo')
        );
        
        return response()->json([
            'success' => true,
            'logo_url' => $company->logo_path ? Storage::url($company->logo_path) : null,
            'message' => 'Logo uploaded successfully.'
        ]);
    }
    
    public function updateSignature(Request $request)
    {
        $request->validate([
            'signature' => ['required', 'image', 'mimes:jpeg,png,jpg,svg', 'max:1024']
        ]);
        
        $company = $this->settingsService->updateSignature(
            auth()->user()->company_id,
            $request->file('signature')
        );
        
        return response()->json([
            'success' => true,
            'signature_url' => $company->signature_path ? Storage::url($company->signature_path) : null,
            'message' => 'Signature uploaded successfully.'
        ]);
    }
    
    public function removeLogo()
    {
        $company = $this->settingsService->removeLogo(auth()->user()->company_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Logo removed successfully.'
        ]);
    }
    
    public function removeSignature()
    {
        $company = $this->settingsService->removeSignature(auth()->user()->company_id);
        
        return response()->json([
            'success' => true,
            'message' => 'Signature removed successfully.'
        ]);
    }
}