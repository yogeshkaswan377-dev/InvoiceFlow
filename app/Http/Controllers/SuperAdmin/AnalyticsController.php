<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        return view('super-admin.analytics', [
            'totalRevenue' => Invoice::sum('grand_total'),
            'monthlyRevenue' => Invoice::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(grand_total) as total'))
                ->whereYear('created_at', now()->year)
                ->groupBy('month')->orderBy('month')->get(),
            'companiesByPlan' => Company::select('subscription_plan', DB::raw('count(*) as count'))
                ->groupBy('subscription_plan')->get(),
        ]);
    }
}
