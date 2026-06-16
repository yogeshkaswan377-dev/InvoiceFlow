<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <div style="max-width: 600px; margin: auto; border: 1px solid #ef4444; border-radius: 8px; padding: 20px;">
        <div style="background: #fef2f2; padding: 15px; border-radius: 8px; text-align: center;">
            <h2 style="color: #dc2626; margin: 0;">⚠ PAYMENT OVERDUE</h2>
        </div>
        <p>Dear <strong>{{ $invoice->client->name }}</strong>,</p>
        <p>This is a reminder that invoice <strong>#{{ $invoice->invoice_number }}</strong> is now <strong style="color: #dc2626;">OVERDUE</strong>.</p>
        <table style="width:100%; margin:20px 0;">
            <tr><td style="padding:8px; background:#f9fafb;"><strong>Invoice</strong></td><td>{{ $invoice->invoice_number }}</td></tr>
            <tr><td style="padding:8px; background:#f9fafb;"><strong>Due Date</strong></td><td style="color:#dc2626;">{{ $invoice->due_date->format('d M Y') }}</td></tr>
            <tr><td style="padding:8px; background:#f9fafb;"><strong>Amount</strong></td><td style="font-size:18px;font-weight:bold;">₹{{ number_format($invoice->balance_due, 2) }}</td></tr>
            <tr><td style="padding:8px; background:#f9fafb;"><strong>Days Overdue</strong></td><td style="color:#dc2626;">{{ $invoice->due_date->diffInDays(now()) }} days</td></tr>
        </table>
        <p>Please make payment at your earliest convenience.</p>
        <p>{{ $invoice->company->name }}</p>
    </div>
</body>
</html>