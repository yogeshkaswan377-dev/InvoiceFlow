<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OverdueReminderMail extends Mailable
{
    public function __construct(public Invoice $invoice) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'OVERDUE: Invoice #' . $this->invoice->invoice_number . ' - Payment Reminder',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.overdue-reminder',
            with: ['invoice' => $this->invoice]
        );
    }
}