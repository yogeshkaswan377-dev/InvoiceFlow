<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\User;

class DashboardController extends Controller
{
    // SuperAdmin/DashboardController.php

    public function index()
    {
        return view('super-admin.dashboard', [
            'totalCompanies' => Company::count(),
            'newThisMonth' => Company::whereMonth('created_at', now()->month)->count(),
            'activeSubscriptions' => Company::where('is_active', true)->count(),
            'activePercentage' => Company::count() > 0 ? round((Company::where('is_active', true)->count() / Company::count()) * 100) : 0,
            'monthlyRevenue' => Invoice::whereMonth('created_at', now()->month)->sum('grand_total'),
            'revenueGrowth' => 18, // Calculate from last month
            'totalUsers' => User::count(),
            'newUsersToday' => User::whereDate('created_at', today())->count(),
            'recentCompanies' => Company::latest()->limit(5)->get(),
            'chartLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'chartData' => [450000, 520000, 480000, 610000, 720000, 820000],
            'growthData' => [8, 12, 15, 10, 18, 22],
            'recentActivities' => \App\Models\Company::latest()->limit(4)->get(),
        ]);
    }
}
