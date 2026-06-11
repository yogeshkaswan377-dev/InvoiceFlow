<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'company_id',
        'received_by',
        'amount',
        'payment_date',
        'payment_method',
        'reference_number',
        'transaction_id',
        'cheque_number',
        'cheque_date',
        'bank_name',
        'gateway_response',
        'status',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'cheque_date' => 'date',
        'gateway_response' => 'array',
    ];

    /**
     * Payment belongs to invoice
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Payment received by user
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Payment belongs to company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
