<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proforma #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; padding: 30px; }
        .header { text-align: center; border-bottom: 2px solid #6366f1; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { color: #6366f1; margin: 0; }
        .company-info { display: flex; justify-content: space-between; margin: 20px 0; }
        .company-info div { width: 48%; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th { background: #6366f1; color: white; padding: 8px; }
        td { border: 1px solid #ddd; padding: 8px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-table { width: 300px; margin-left: auto; }
        .total-table td { border: none; padding: 5px 10px; }
        .total-table tr:last-child { border-top: 2px solid #6366f1; font-weight: bold; font-size: 14px; }
        .footer { margin-top: 30px; text-align: right; }
        .signature-box { display: inline-block; text-align: center; margin-top: 40px; }
        .signature-img { max-width: 150px; max-height: 60px; }
        .signature-line { border-top: 1px solid #000; width: 150px; margin: 10px 0; }
        .logo { max-width: 150px; max-height: 60px; }
    </style>
</head>
<body>
    <div class="header">
        @if($invoice->company->logo_path)
            <img src="{{ public_path($invoice->company->logo_path) }}" class="logo">
        @endif
        <h2>PROFORMA INVOICE</h2>
        <p>{{ $invoice->invoice_number }}</p>
    </div>

    <div class="company-info">
        <div>
            <strong>{{ $invoice->company->name }}</strong><br>
            {{ $invoice->company->address_line_1 }}<br>
            {{ $invoice->company->city }}, {{ $invoice->company->state }} - {{ $invoice->company->pincode }}<br>
            GSTIN: {{ $invoice->company->gstin }}
        </div>
        <div>
            <strong>To:</strong><br>
            {{ $invoice->client->name }}<br>
            @if($invoice->client->address_line_1)
                {{ $invoice->client->address_line_1 }}<br>
                {{ $invoice->client->city }}, {{ $invoice->client->state }}<br>
            @endif
            GSTIN: {{ $invoice->client->gstin }}
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; margin: 15px 0;">
        <div>Date: <strong>{{ $invoice->invoice_date->format('d M Y') }}</strong></div>
        <div>Due: <strong>{{ $invoice->due_date->format('d M Y') }}</strong></div>
    </div>

    <table>
        <tr><th>#</th><th>Item</th><th>Qty</th><th>Rate</th><th>Amount</th></tr>
        @foreach($invoice->items as $i => $item)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{{ $item->name }}</td>
            <td class="text-center">{{ $item->quantity }}</td>
            <td class="text-right">₹{{ number_format($item->unit_price, 2) }}</td>
            <td class="text-right">₹{{ number_format($item->line_total, 2) }}</td>
        </tr>
        @endforeach
    </table>

    <table class="total-table">
        <tr><td>Subtotal</td><td class="text-right">₹{{ number_format($invoice->subtotal, 2) }}</td></tr>
        @if($invoice->discount_amount > 0)
        <tr><td>Discount</td><td class="text-right">- ₹{{ number_format($invoice->discount_amount, 2) }}</td></tr>
        @endif
        <tr><td>GST</td><td class="text-right">₹{{ number_format($invoice->total_gst_amount, 2) }}</td></tr>
        <tr><td>Grand Total</td><td class="text-right">₹{{ number_format($invoice->grand_total, 2) }}</td></tr>
    </table>

    <div class="footer">
        <div class="signature-box">
            @if($invoice->company->signature_path)
                <img src="{{ public_path($invoice->company->signature_path) }}" class="signature-img">
            @endif
            <div class="signature-line"></div>
            <p>Authorized Signature</p>
        </div>
    </div>
</body>
</html>