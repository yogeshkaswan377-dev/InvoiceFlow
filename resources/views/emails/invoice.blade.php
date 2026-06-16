<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body style="font-family: Arial, sans-serif; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb;">

        <div style="text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 20px;">
            <h2 style="color: #2563eb; margin: 0;">{{ $invoice->invoice_type === 'gst_invoice' ? 'GST INVOICE' : 'PROFORMA INVOICE' }}</h2>
            <p style="font-size: 14px; color: #666;">{{ $invoice->invoice_number }}</p>
        </div>

        <p>Dear <strong>{{ $invoice->client->name }}</strong>,</p>

        <p>Please find attached your invoice details:</p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background: #f9fafb;"><strong>Invoice Number</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $invoice->invoice_number }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background: #f9fafb;"><strong>Invoice Date</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $invoice->invoice_date->format('d M Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background: #f9fafb;"><strong>Due Date</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $invoice->due_date->format('d M Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background: #f9fafb;"><strong>Grand Total</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd; font-size: 18px; font-weight: bold; color: #2563eb;">₹{{ number_format($invoice->grand_total, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd; background: #f9fafb;"><strong>Status</strong></td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ ucfirst($invoice->status) }}</td>
            </tr>
        </table>

        <p>The PDF invoice is attached to this email.</p>

        <p>Thank you for your business!</p>
        <p><strong>{{ $invoice->company->name }}</strong></p>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
        <p style="font-size: 11px; color: #999;">This email was sent from {{ $invoice->company->name }}. If you have any questions, please contact us at {{ $invoice->company->email ?? 'N/A' }}.</p>
    </div>
</body>

</html> 