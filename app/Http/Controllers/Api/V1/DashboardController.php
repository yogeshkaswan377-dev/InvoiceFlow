<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $companyId = session('current_company_id');

        $totalInvoices = Invoice::where('company_id', $companyId)->count();
        $totalRevenue = Invoice::where('company_id', $companyId)
            ->where('status', 'paid')->sum('grand_total');
        $pendingAmount = Invoice::where('company_id', $companyId)
            ->whereIn('status', ['sent', 'viewed', 'accepted'])->sum('grand_total');
        $overdueCount = Invoice::where('company_id', $companyId)
            ->where('status', 'overdue')->count();
        $thisMonthRevenue = Invoice::where('company_id', $companyId)
            ->where('status', 'paid')
            ->whereMonth('invoice_date', now()->month)
            ->whereYear('invoice_date', now()->year)
            ->sum('grand_total');

        $recentInvoices = Invoice::where('company_id', $companyId)
            ->with('client:id,name')
            ->latest()
            ->limit(5)
            ->get();

        $monthlyRevenue = Invoice::where('company_id', $companyId)
            ->where('status', 'paid')
            ->whereYear('invoice_date', now()->year)
            ->select(DB::raw('MONTH(invoice_date) as month'), DB::raw('SUM(grand_total) as total'))
            ->groupBy('month')->orderBy('month')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => [
                    'total_invoices' => $totalInvoices,
                    'total_revenue' => round($totalRevenue, 2),
                    'pending_amount' => round($pendingAmount, 2),
                    'overdue_count' => $overdueCount,
                    'this_month_revenue' => round($thisMonthRevenue, 2),
                ],
                'recent_invoices' => InvoiceResource::collection($recentInvoices),
                'monthly_revenue' => $monthlyRevenue,
            ],
        ]);
    }
}
