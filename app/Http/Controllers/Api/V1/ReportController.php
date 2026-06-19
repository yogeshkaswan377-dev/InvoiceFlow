<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function outstanding(Request $request): JsonResponse
    {
        $companyId = session('current_company_id');

        $invoices = Invoice::where('company_id', $companyId)
            ->whereIn('status', ['sent', 'viewed', 'accepted', 'partially_paid', 'overdue'])
            ->where('balance_due', '>', 0)
            ->with('client')
            ->orderBy('due_date')
            ->paginate($request->per_page ?? 50);

        return response()->json([
            'success' => true,
            'data' => InvoiceResource::collection($invoices->items()),
            'meta' => [
                'current_page' => $invoices->currentPage(),
                'last_page' => $invoices->lastPage(),
                'per_page' => $invoices->perPage(),
                'total' => $invoices->total(),
            ],
        ]);
    }

    /**
     * GSTR1 summary report.
     */
    public function gstr1(Request $request): JsonResponse
    {
        $companyId = session('current_company_id');
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $invoices = Invoice::where('company_id', $companyId)
            ->where('invoice_type', 'gst_invoice')
            ->whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->with('client', 'items')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'b2b_count' => $invoices->where('client.client_type', 'business')->count(),
                'b2c_count' => $invoices->where('client.client_type', 'individual')->count(),
                'total_invoices' => $invoices->count(),
                'total_value' => round($invoices->sum('grand_total'), 2),
                'total_gst' => round($invoices->sum('total_gst_amount'), 2),
                'total_igst' => round($invoices->sum('igst_amount'), 2),
                'total_cgst' => round($invoices->sum('cgst_amount'), 2),
                'total_sgst' => round($invoices->sum('sgst_amount'), 2),
                'month' => (int) $month,
                'year' => (int) $year,
            ],
        ]);
    }

    /**
     * Export CSV.
     */
    public function exportCsv(Request $request)
    {
        $companyId = session('current_company_id');

        $invoices = Invoice::where('company_id', $companyId)
            ->when($request->type, fn($q) => $q->where('invoice_type', $request->type))
            ->when($request->date_from, fn($q) => $q->where('invoice_date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->where('invoice_date', '<=', $request->date_to))
            ->with('client')
            ->get();

        $filename = 'invoices-export-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        $callback = function () use ($invoices) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Invoice #', 'Type', 'Client', 'Date', 'Due Date', 'Subtotal', 'GST', 'Total', 'Balance', 'Status']);
            foreach ($invoices as $invoice) {
                fputcsv($file, [
                    $invoice->invoice_number,
                    $invoice->invoice_type,
                    $invoice->client->name ?? '',
                    $invoice->invoice_date->format('Y-m-d'),
                    $invoice->due_date->format('Y-m-d'),
                    $invoice->subtotal,
                    $invoice->total_gst_amount,
                    $invoice->grand_total,
                    $invoice->balance_due,
                    $invoice->status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Excel.
     */
    public function exportExcel(Request $request)
    {
        $companyId = session('current_company_id');

        $invoices = Invoice::where('company_id', $companyId)
            ->when($request->type, fn($q) => $q->where('invoice_type', $request->type))
            ->with('client')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Invoice #');
        $sheet->setCellValue('B1', 'Type');
        $sheet->setCellValue('C1', 'Client');
        $sheet->setCellValue('D1', 'Date');
        $sheet->setCellValue('E1', 'Subtotal');
        $sheet->setCellValue('F1', 'GST');
        $sheet->setCellValue('G1', 'Total');
        $sheet->setCellValue('H1', 'Status');

        $row = 2;
        foreach ($invoices as $invoice) {
            $sheet->setCellValue('A' . $row, $invoice->invoice_number);
            $sheet->setCellValue('B' . $row, $invoice->invoice_type);
            $sheet->setCellValue('C' . $row, $invoice->client->name ?? '');
            $sheet->setCellValue('D' . $row, $invoice->invoice_date->format('Y-m-d'));
            $sheet->setCellValue('E' . $row, $invoice->subtotal);
            $sheet->setCellValue('F' . $row, $invoice->total_gst_amount);
            $sheet->setCellValue('G' . $row, $invoice->grand_total);
            $sheet->setCellValue('H' . $row, $invoice->status);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'invoices-' . now()->format('Y-m-d') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }
}
