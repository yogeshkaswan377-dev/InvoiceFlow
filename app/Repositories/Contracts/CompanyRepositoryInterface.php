<?php
// app/Repositories/Contracts/CompanyRepositoryInterface.php

namespace App\Repositories\Contracts;

use App\Models\Company;
use Illuminate\Http\UploadedFile;

interface CompanyRepositoryInterface
{
    public function create(array $data): Company;  // ADD THIS LINE
    public function updateSettings(int $companyId, array $data): Company;
    public function updateLogo(int $companyId, UploadedFile $file): Company;
    public function updateSignature(int $companyId, UploadedFile $file): Company;
    public function updateBankDetails(int $companyId, array $bankDetails): Company;
    public function updateGstRates(int $companyId, array $rates): Company;
    public function getSettings(int $companyId): Company;
    public function findById(int $id): ?Company;
}