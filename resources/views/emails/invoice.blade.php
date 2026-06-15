<!DOCTYPE html>
<html>

<body>
    <h2>Invoice #{{ $invoice->invoice_number }}</h2>
    <p>Dear {{ $invoice->client->name }},</p>
    <p>Please find attached invoice #{{ $invoice->invoice_number }} for ₹{{ number_format($invoice->grand_total, 2) }}.</p>
    <p>Invoice Date: {{ $invoice->invoice_date->format('d M Y') }}</p>
    <p>Due Date: {{ $invoice->due_date->format('d M Y') }}</p>
    <p>Thank you for your business!</p>
    <p>{{ $invoice->company->name }}</p>
</body>

</html>