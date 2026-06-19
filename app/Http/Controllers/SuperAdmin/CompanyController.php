<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::withCount('users')->paginate(20);
        return view('super-admin.companies.index', compact('companies'));
    }

    public function show(Company $company)
    {
        $company->loadCount(['users', 'invoices', 'clients']);
        $company->loadSum('invoices', 'grand_total');
        return view('super-admin.companies.show', compact('company'));
    }

    public function approve(Company $company)
    {
        $company->update(['is_active' => 1]);
        return back()->with('success', 'Company approved!');
    }

    public function suspend(Company $company)
    {
        $company->update(['is_active' => 0]);
        return back()->with('success', 'Company suspended!');
    }

    public function users(Company $company)
    {
        $users = $company->users()->paginate(20);
        return view('super-admin.companies.users', compact('company', 'users'));
    }

    public function invoices(Company $company)
    {
        $invoices = $company->invoices()->with('client')->latest()->paginate(20);
        return view('super-admin.companies.invoices', compact('company', 'invoices'));
    }
}
