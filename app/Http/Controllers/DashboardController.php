<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->current_company_id;

        // Stats
        $totalInvoices = Invoice::where('company_id', $companyId)->count();
        $totalClients = Client::where('company_id', $companyId)->count();
        $totalRevenue = Invoice::where('company_id', $companyId)
            ->where('status', 'paid')
            ->sum('grand_total');
        $pendingAmount = Invoice::where('company_id', $companyId)
            ->whereIn('status', ['sent', 'viewed', 'accepted', 'partially_paid', 'overdue'])
            ->sum('balance_due');
        $overdueCount = Invoice::where('company_id', $companyId)
            ->where('status', 'overdue')
            ->count();

        // Recent Invoices
        $recentInvoices = Invoice::where('company_id', $companyId)
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        // Monthly Revenue (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Invoice::where('company_id', $companyId)
                ->whereYear('invoice_date', $month->year)
                ->whereMonth('invoice_date', $month->month)
                ->sum('grand_total');
            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => (float) $revenue,
            ];
        }

        // Invoice by Status
        $statusCounts = [
            'draft' => Invoice::where('company_id', $companyId)->where('status', 'draft')->count(),
            'sent' => Invoice::where('company_id', $companyId)->where('status', 'sent')->count(),
            'paid' => Invoice::where('company_id', $companyId)->where('status', 'paid')->count(),
            'overdue' => Invoice::where('company_id', $companyId)->where('status', 'overdue')->count(),
        ];

        // Invoice by Type
        $typeCounts = [
            'proforma' => Invoice::where('company_id', $companyId)->where('invoice_type', 'proforma')->count(),
            'gst_invoice' => Invoice::where('company_id', $companyId)->where('invoice_type', 'gst_invoice')->count(),
        ];

        return view('dashboard', compact(
            'totalInvoices',
            'totalClients',
            'totalRevenue',
            'pendingAmount',
            'overdueCount',
            'recentInvoices',
            'monthlyRevenue',
            'statusCounts',
            'typeCounts'
        ));
    }
}
