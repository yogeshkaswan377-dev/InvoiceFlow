<?php
// app/Repositories/CompanyRepository.php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected Company $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }


    public function create(array $data): Company
    {
        return DB::transaction(function () use ($data) {
            return $this->model->create($data);
        });
    }

    public function updateSettings(int $companyId, array $data): Company
    {
        return DB::transaction(function () use ($companyId, $data) {
            $company = $this->model->findOrFail($companyId);
            $company->update($data);
            return $company->fresh();
        });
    }

    public function updateLogo(int $companyId, UploadedFile $file): Company
    {
        return DB::transaction(function () use ($companyId, $file) {
            $company = $this->model->findOrFail($companyId);

            // Delete old logo if exists
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }

            $path = $file->store('logos', 'public');
            $company->update(['logo_path' => $path]);

            return $company->fresh();
        });
    }

    public function updateSignature(int $companyId, UploadedFile $file): Company
    {
        return DB::transaction(function () use ($companyId, $file) {
            $company = $this->model->findOrFail($companyId);

            // Delete old signature if exists
            if ($company->signature_path) {
                Storage::disk('public')->delete($company->signature_path);
            }

            $path = $file->store('signatures', 'public');
            $company->update(['signature_path' => $path]);

            return $company->fresh();
        });
    }

    public function updateBankDetails(int $companyId, array $bankDetails): Company
    {
        return DB::transaction(function () use ($companyId, $bankDetails) {
            $company = $this->model->findOrFail($companyId);
            $company->update(['bank_details' => $bankDetails]);
            return $company->fresh();
        });
    }

    public function updateGstRates(int $companyId, array $rates): Company
    {
        return DB::transaction(function () use ($companyId, $rates) {
            $company = $this->model->findOrFail($companyId);
            $company->update(['gst_rates' => $rates]);
            return $company->fresh();
        });
    }

    public function getSettings(int $companyId): Company
    {
        return $this->model->findOrFail($companyId);
    }

    public function findById(int $id): ?Company
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
