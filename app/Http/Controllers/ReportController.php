<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function outstanding()
    {
        $companyId = Auth::user()->current_company_id;
        $invoices = Invoice::where('company_id', $companyId)
            ->whereIn('status', ['sent', 'viewed', 'accepted', 'partially_paid', 'overdue'])
            ->where('balance_due', '>', 0)
            ->with('client')
            ->orderBy('due_date')
            ->get();

        return view('reports.outstanding', compact('invoices'));
    }

    public function exportCsv(Request $request)
    {
        $companyId = session('current_company_id') ?? auth()->user()->current_company_id;
        $from = $request->from ?? now()->startOfMonth()->format('Y-m-d');
        $to = $request->to ?? now()->format('Y-m-d');

        $invoices = Invoice::where('company_id', $companyId)
            ->whereBetween('invoice_date', [$from, $to])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="gstr1-report.csv"',
        ];

        $callback = function () use ($invoices) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Invoice #', 'Client', 'Date', 'Taxable Value', 'IGST', 'CGST', 'SGST', 'Total']);

            foreach ($invoices as $inv) {
                fputcsv($file, [
                    $inv->invoice_number,
                    $inv->client->name ?? 'N/A',
                    $inv->invoice_date->format('d/m/Y'),
                    $inv->taxable_amount,
                    $inv->igst_amount,
                    $inv->cgst_amount,
                    $inv->sgst_amount,
                    $inv->grand_total,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function gstr1(Request $request)
    {
        $companyId = session('current_company_id') ?? auth()->user()->current_company_id;

        $from = $request->from ?? now()->startOfMonth()->format('Y-m-d');
        $to = $request->to ?? now()->format('Y-m-d');

        $invoices = Invoice::where('company_id', $companyId)
            ->whereBetween('invoice_date', [$from, $to])
            ->whereIn('status', ['paid', 'sent', 'accepted'])
            ->get();

        $summary = [
            'total_invoices' => $invoices->count(),
            'taxable_value' => $invoices->sum('taxable_amount'),
            'total_gst' => $invoices->sum('total_gst_amount'),
            'hsn_count' => $invoices->pluck('items')->flatten()->pluck('hsn_code')->unique()->count(),
        ];

        // HSN Summary grouping
        $hsnSummary = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->where('invoices.company_id', $companyId)
            ->whereBetween('invoices.invoice_date', [$from, $to])
            ->select(
                'invoice_items.hsn_sac_code',  // 👈 hsn_code → hsn_sac_code
                DB::raw('SUM(invoice_items.quantity) as total_qty'),
                DB::raw('SUM(invoice_items.taxable_amount) as taxable_value'),
                DB::raw('SUM(invoice_items.igst_amount) as igst'),
                DB::raw('SUM(invoice_items.cgst_amount) as cgst'),
                DB::raw('SUM(invoice_items.sgst_amount) as sgst'),
                DB::raw('SUM(invoice_items.line_total_with_gst) as total')  // 👈 total_amount → line_total_with_gst
            )
            ->groupBy('invoice_items.hsn_sac_code')  // 👈 Yahan bhi change
            ->get();

        return view('reports.gstr1', compact('summary', 'hsnSummary', 'from', 'to'));
    }

    public function exportGstr1(Request $request)
    {
        $format = $request->format ?? 'excel';
        // Export logic using Laravel Excel or DomPDF

        if ($format === 'excel') {
            return Excel::download(new Gstr1Export($request->from, $request->to), 'gstr1-report.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = PDF::loadView('reports.gstr1-pdf', $data);
            return $pdf->download('gstr1-report.pdf');
        }
    }

    public function exportExcel(Request $request)
    {
        $companyId = Auth::user()->current_company_id;
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
