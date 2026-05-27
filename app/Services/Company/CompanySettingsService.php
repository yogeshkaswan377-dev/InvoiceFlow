<?php
// app/Services/Company/CompanySettingsService.php

namespace App\Services\Company;

use App\DTOs\CompanySettingsData;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CompanySettingsService
{
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {}
    
    public function getSettings(int $companyId)
    {
        return $this->companyRepository->getSettings($companyId);
    }
    
    public function updateSettings(int $companyId, CompanySettingsData $settingsData)
    {
        return DB::transaction(function () use ($companyId, $settingsData) {
            // Validate GST rates structure
            $this->validateGSTRates($settingsData->gst_rates);
            
            // Validate bank details structure
            $this->validateBankDetails($settingsData->bank_details);
            
            return $this->companyRepository->updateSettings($companyId, $settingsData->toArray());
        });
    }
    
    public function updateLogo(int $companyId, UploadedFile $file)
    {
        $this->validateImage($file, 2048); // Max 2MB
        
        return $this->companyRepository->updateLogo($companyId, $file);
    }
    
    public function updateSignature(int $companyId, UploadedFile $file)
    {
        $this->validateImage($file, 1024); // Max 1MB for signature
        
        return $this->companyRepository->updateSignature($companyId, $file);
    }
    
    public function removeLogo(int $companyId)
    {
        $company = $this->companyRepository->findById($companyId);
        
        if ($company && $company->logo_path) {
            \Storage::disk('public')->delete($company->logo_path);
            return $this->companyRepository->updateSettings($companyId, ['logo_path' => null]);
        }
        
        return $company;
    }
    
    public function removeSignature(int $companyId)
    {
        $company = $this->companyRepository->findById($companyId);
        
        if ($company && $company->signature_path) {
            \Storage::disk('public')->delete($company->signature_path);
            return $this->companyRepository->updateSettings($companyId, ['signature_path' => null]);
        }
        
        return $company;
    }
    
    public function updateBankDetails(int $companyId, array $bankDetails)
    {
        $this->validateBankDetails($bankDetails);
        
        return $this->companyRepository->updateBankDetails($companyId, $bankDetails);
    }
    
    public function updateGstRates(int $companyId, array $rates)
    {
        $this->validateGSTRates($rates);
        
        return $this->companyRepository->updateGstRates($companyId, $rates);
    }
    
    protected function validateImage(UploadedFile $file, int $maxSizeKB): void
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
        
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            throw ValidationException::withMessages([
                'file' => 'Only JPG, PNG, and SVG files are allowed.'
            ]);
        }
        
        if ($file->getSize() > $maxSizeKB * 1024) {
            throw ValidationException::withMessages([
                'file' => "File size must be less than {$maxSizeKB}KB."
            ]);
        }
    }
    
    protected function validateGSTRates(array $rates): void
    {
        foreach ($rates as $rate) {
            if (!isset($rate['rate']) || !is_numeric($rate['rate'])) {
                throw ValidationException::withMessages([
                    'gst_rates' => 'Invalid GST rate structure.'
                ]);
            }
            
            $expectedCgst = $rate['rate'] / 2;
            $expectedSgst = $rate['rate'] / 2;
            $expectedIgst = $rate['rate'];
            
            if ($rate['cgst'] != $expectedCgst || $rate['sgst'] != $expectedSgst || $rate['igst'] != $expectedIgst) {
                throw ValidationException::withMessages([
                    'gst_rates' => "Invalid tax distribution for rate {$rate['rate']}%. CGST/SGST should be half of the rate."
                ]);
            }
        }
    }
    
    protected function validateBankDetails(array $bankDetails): void
    {
        $requiredFields = ['bank_name', 'account_number', 'account_holder_name', 'ifsc_code'];
        
        foreach ($bankDetails as $account) {
            foreach ($requiredFields as $field) {
                if (empty($account[$field])) {
                    throw ValidationException::withMessages([
                        'bank_details' => "Bank details missing required field: {$field}"
                    ]);
                }
            }
            
            // Validate IFSC format
            if (!preg_match('/^[A-Z]{4}0[A-Z0-9]{6}$/', $account['ifsc_code'])) {
                throw ValidationException::withMessages([
                    'bank_details' => 'Invalid IFSC code format.'
                ]);
            }
        }
    }
}