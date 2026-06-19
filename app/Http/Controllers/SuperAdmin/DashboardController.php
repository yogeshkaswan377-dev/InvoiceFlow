<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('super-admin.dashboard', [
            'totalCompanies' => Company::count(),
            'activeCompanies' => Company::where('is_active', 1)->count(),
            'suspendedCompanies' => Company::where('is_active', 0)->count(),
            'totalUsers' => User::count(),
            'totalInvoices' => Invoice::count(),
            'totalRevenue' => Invoice::sum('grand_total'),
            'recentCompanies' => Company::latest()->limit(5)->get(),
        ]);
    }
}
