<!DOCTYPE html>
<html>

<body style="font-family: Arial, sans-serif; padding: 20px;">
    <div style="max-width: 600px; margin: auto; border: 1px solid #6366f1; border-radius: 8px; padding: 20px;">
        <div style="text-align:center; border-bottom: 2px solid #6366f1; padding-bottom:15px;">
            <h2 style="color:#6366f1;">PROFORMA INVOICE</h2>
            <p>{{ $invoice->invoice_number }}</p>
        </div>
        <p>Dear <strong>{{ $invoice->client->name }}</strong>,</p>
        <p>Please find attached proforma invoice for your reference.</p>
        <table style="width:100%; margin:20px 0;">
            <tr>
                <td style="padding:8px; background:#f9fafb;"><strong>Amount</strong></td>
                <td style="font-size:18px;font-weight:bold;">₹{{ number_format($invoice->grand_total, 2) }}</td>
            </tr>
            <tr>
                <td style="padding:8px; background:#f9fafb;"><strong>Valid Until</strong></td>
                <td>{{ $invoice->due_date->format('d M Y') }}</td>
            </tr>
        </table>
        <p>This is a proforma invoice and not a tax invoice.</p>
        <p>{{ $invoice->company->name }}</p>
    </div>
</body>

</html>