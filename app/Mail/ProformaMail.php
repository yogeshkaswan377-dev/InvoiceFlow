<?php

namespace App\Mail;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class ProformaMail extends Mailable
{
    public function __construct(public Invoice $invoice) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Proforma Invoice #' . $this->invoice->invoice_number . ' from ' . $this->invoice->company->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.proforma',
            with: ['invoice' => $this->invoice]
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('proformas.pdf', ['invoice' => $this->invoice]);
        return [
            Attachment::fromData(fn() => $pdf->output(), $this->invoice->invoice_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}