<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $companyId = Auth::user()->current_company_id;
        $invoices = Invoice::where('company_id', $companyId)
            ->when($request->type, fn($q) => $q->where('invoice_type', $request->type))
            ->when($request->date_from, fn($q) => $q->where('invoice_date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->where('invoice_date', '<=', $request->date_to))
            ->with('client')
            ->get();

        $filename = 'invoices-export-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename=' . $filename];

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

    public function gstr1(Request $request)
    {
        $companyId = Auth::user()->current_company_id;
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $invoices = Invoice::where('company_id', $companyId)
            ->where('invoice_type', 'gst_invoice')
            ->whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->with('client', 'items')
            ->get();

        $summary = [
            'b2b' => $invoices->where('client.client_type', 'business'),
            'b2c' => $invoices->where('client.client_type', 'individual'),
            'total_invoices' => $invoices->count(),
            'total_value' => $invoices->sum('grand_total'),
            'total_gst' => $invoices->sum('total_gst_amount'),
            'total_igst' => $invoices->sum('igst_amount'),
            'total_cgst' => $invoices->sum('cgst_amount'),
            'total_sgst' => $invoices->sum('sgst_amount'),
            'month' => $month,
            'year' => $year,
        ];

        return view('reports.gstr1', compact('summary', 'month', 'year'));
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
