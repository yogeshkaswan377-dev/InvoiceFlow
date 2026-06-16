<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>GST Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h2 {
            color: #2563eb;
            margin: 0;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .company-info {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .company-info div {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th {
            background: #2563eb;
            color: white;
            padding: 8px;
        }

        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-table {
            width: 350px;
            margin-left: auto;
        }

        .total-table td {
            border: none;
            padding: 5px 10px;
        }

        .total-table tr:last-child {
            border-top: 2px solid #2563eb;
            font-weight: bold;
            font-size: 14px;
        }

        .gst-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: bold;
        }

        .igst-badge {
            background: #f3e8ff;
            color: #7c3aed;
        }

        .cgst-badge {
            background: #dbeafe;
            color: #2563eb;
        }

        .mode-badge {
            background: #f0fdf4;
            color: #16a34a;
            padding: 4px 12px;
            border-radius: 12px;
        }

        .rcm-badge {
            background: #fef3c7;
            color: #d97706;
            padding: 4px 12px;
            border-radius: 12px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 40px;
        }

        .signature-img {
            max-width: 150px;
            max-height: 60px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 150px;
            margin: 10px 0;
        }

        .qr-code {
            text-align: right;
            margin-top: 20px;
        }

        .qr-code img {
            width: 100px;
            height: 100px;
        }

        .logo {
            max-width: 150px;
            max-height: 60px;
        }
    </style>
</head>

<body>
    <div class="header">
        @if($invoice->company->logo_path)
        <img src="{{ public_path($invoice->company->logo_path) }}" class="logo" style="max-width:150px;">
        @endif
        <h2>TAX INVOICE</h2>
        <p>{{ $invoice->invoice_number }}</p>
        <p>
            <span class="mode-badge">{{ ucfirst($invoice->gst_mode) }} Mode</span>
            @if($invoice->reverse_charge)
            <span class="rcm-badge">RCM Applicable</span>
            @endif
        </p>
    </div>

    <div class="company-info">
        <div>
            <strong>{{ $invoice->company->name }}</strong><br>
            {{ $invoice->company->address_line_1 }}<br>
            {{ $invoice->company->city }}, {{ $invoice->company->state }} - {{ $invoice->company->pincode }}<br>
            GSTIN: {{ $invoice->company->gstin }}<br>
            @if($invoice->company->phone) Phone: {{ $invoice->company->phone }}<br> @endif
            @if($invoice->company->email) Email: {{ $invoice->company->email }} @endif
        </div>
        <div>
            <strong>Bill To:</strong><br>
            {{ $invoice->client->name }}<br>
            @if($invoice->client->address_line_1)
            {{ $invoice->client->address_line_1 }}<br>
            {{ $invoice->client->city }}, {{ $invoice->client->state }} - {{ $invoice->client->pincode }}<br>
            @endif
            GSTIN: {{ $invoice->client->gstin }}<br>
            Place of Supply: {{ $invoice->place_of_supply_state_code }}
            (<span class="{{ $invoice->igst_amount > 0 ? 'igst-badge' : 'cgst-badge' }}">
                {{ $invoice->igst_amount > 0 ? 'Inter-State' : 'Intra-State' }}
            </span>)
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; margin: 15px 0;">
        <div>Invoice Date: <strong>{{ $invoice->invoice_date->format('d M Y') }}</strong></div>
        <div>Due Date: <strong>{{ $invoice->due_date->format('d M Y') }}</strong></div>
        <div>Tax Type:
            <span class="{{ $invoice->igst_amount > 0 ? 'igst-badge' : 'cgst-badge' }}">
                {{ $invoice->igst_amount > 0 ? 'IGST' : 'CGST + SGST' }}
            </span>
        </div>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>Item</th>
            <th>HSN/SAC</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>GST%</th>
            <th>Taxable</th>
            <th>Amount</th>
        </tr>
        @foreach($invoice->items as $i => $item)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{{ $item->name }}</td>
            <td class="text-center">{{ $item->hsn_sac_code ?? '-' }}</td>
            <td class="text-center">{{ $item->quantity }}</td>
            <td class="text-right">₹{{ number_format($item->unit_price, 2) }}</td>
            <td class="text-center">{{ $item->gst_rate }}%</td>
            <td class="text-right">₹{{ number_format($item->taxable_amount, 2) }}</td>
            <td class="text-right">₹{{ number_format($item->line_total, 2) }}</td>
        </tr>
        @endforeach
    </table>

    <table class="total-table">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">₹{{ number_format($invoice->subtotal, 2) }}</td>
        </tr>
        @if($invoice->discount_amount > 0)
        <tr>
            <td>Discount</td>
            <td class="text-right">- ₹{{ number_format($invoice->discount_amount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td>Taxable Amount</td>
            <td class="text-right">₹{{ number_format($invoice->taxable_amount, 2) }}</td>
        </tr>

        @if($invoice->gst_mode === 'inclusive')
        <tr>
            <td colspan="2" style="color: #16a34a; padding: 5px;">
                <em>Inclusive: Base ₹{{ number_format($invoice->taxable_amount - $invoice->total_gst_amount, 2) }} + GST ₹{{ number_format($invoice->total_gst_amount, 2) }} = Total ₹{{ number_format($invoice->taxable_amount, 2) }}</em>
            </td>
        </tr>
        @endif

        @if($invoice->igst_amount > 0)
        <tr>
            <td>IGST ({{ $invoice->gst_rate }}%)</td>
            <td class="text-right">₹{{ number_format($invoice->igst_amount, 2) }}</td>
        </tr>
        @else
        <tr>
            <td>CGST ({{ $invoice->gst_rate/2 }}%)</td>
            <td class="text-right">₹{{ number_format($invoice->cgst_amount, 2) }}</td>
        </tr>
        <tr>
            <td>SGST ({{ $invoice->gst_rate/2 }}%)</td>
            <td class="text-right">₹{{ number_format($invoice->sgst_amount, 2) }}</td>
        </tr>
        @endif

        @if($invoice->shipping_charges > 0)
        <tr>
            <td>Shipping</td>
            <td class="text-right">₹{{ number_format($invoice->shipping_charges, 2) }}</td>
        </tr>
        @endif
        @if($invoice->commission > 0)
        <tr>
            <td>Commission</td>
            <td class="text-right">₹{{ number_format($invoice->commission, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td>Grand Total</td>
            <td class="text-right">₹{{ number_format($invoice->grand_total, 2) }}</td>
        </tr>
    </table>

    @if($invoice->reverse_charge)
    <div style="background: #fef3c7; padding: 10px; border-radius: 5px; margin: 15px 0;">
        ⚠️ <strong>Reverse Charge Mechanism:</strong> Tax liability lies with the recipient of goods/services.
    </div>
    @endif

    @if($invoice->terms_and_conditions)
    <div style="margin: 15px 0; font-size: 10px; color: #666;">
        <strong>Terms & Conditions:</strong><br>{{ $invoice->terms_and_conditions }}
    </div>
    @endif

    @if($invoice->company->bank_details)
    @php
    $bank = is_array($invoice->company->bank_details)
    ? $invoice->company->bank_details
    : json_decode($invoice->company->bank_details, true);
    @endphp
    @if(!empty($bank['upi_id']))
    <div class="qr-code" style="text-align: right; margin-top: 20px;">
        <p style="font-size: 10px;">Scan to Pay via UPI</p>
        <img src="data:image/png;base64,{{ base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate('upi://pay?pa=' . $bank['upi_id'] . '&pn=' . urlencode($invoice->company->name) . '&am=' . $invoice->grand_total . '&tn=' . $invoice->invoice_number)) }}">
        <p style="font-size: 10px;">{{ $bank['upi_id'] ?? '' }}</p>
    </div>
    @endif
    @endif

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