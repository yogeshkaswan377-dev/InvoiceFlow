<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\DTOs\CompanyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    protected CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $user = Auth::user();

        $companyData = CompanyData::fromRequest($request);

        $company = DB::transaction(function () use ($companyData, $user) {
            // Create company
            $company = $this->companyRepository->create($companyData->toArray());

            // Update user with company_id
            $user->company_id = $company->id;
            $user->save();

            // Assign role using Spatie Permission - MUST specify guard_name
            $user->assignRole('owner'); // This works because guard_name defaults to 'web' in config

            return $company;
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Company created successfully.');
    }

    public function switchCompany()
    {
        $user = Auth::user();
        $companies = $user->company()->get();

        return view('company.switch', compact('companies'));
    }

    public function setCurrentCompany(Request $request, $companyId)
    {
        $user = Auth::user();
        $company = $this->companyRepository->findOrFail($companyId);

        // Verify user belongs to this company
        if ($user->company_id != $company->id && !$user->hasRole('owner', $company->id)) {
            abort(403);
        }

        $user->current_company_id = $company->id;
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Company created successfully! Please complete your profile.');
    }

    public function settings()
    {
        $company = Auth::user()->currentCompany;
        return view('company.settings', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, $companyId)
    {
        $companyData = CompanyData::fromArray($request->validated());
        $company = $this->companyRepository->update($companyId, $companyData->toArray());

        return redirect()->route('company.settings')->with('success', 'Company updated successfully!');
    }
}
