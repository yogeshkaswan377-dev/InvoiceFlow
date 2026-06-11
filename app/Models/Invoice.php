<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'client_id',
        'created_by',
        'updated_by',
        'invoice_number',
        'invoice_type',
        'status',
        'reference_number',
        'irn',
        'invoice_date',
        'due_date',
        'paid_date',
        'cancelled_date',
        'gst_mode',
        'gst_rate',
        'place_of_supply',
        'place_of_supply_state_code',
        'reverse_charge',
        'subtotal',
        'discount_type',
        'discount_amount',
        'taxable_amount',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'total_gst_amount',
        'shipping_charges',
        'commission',
        'grand_total',
        'paid_amount',
        'balance_due',
        'notes',
        'terms_and_conditions',
        'payment_terms',
        'logistics_details',
        'estimated_delivery_date',
        'template_id',
        'show_hsn_sac',
        'show_digital_signature',
        'metadata',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'cancelled_date' => 'date',
        'estimated_delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'taxable_amount' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'igst_amount' => 'decimal:2',
        'total_gst_amount' => 'decimal:2',
        'shipping_charges' => 'decimal:2',
        'commission' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'reverse_charge' => 'boolean',
        'show_hsn_sac' => 'boolean',
        'show_digital_signature' => 'boolean',
        'logistics_details' => 'array',
        'metadata' => 'array',
    ];

    protected $dates = [
        'invoice_date',
        'due_date',
        'paid_date',
        'cancelled_date',
        'estimated_delivery_date',
    ];

    /**
     * Invoice belongs to a company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Invoice belongs to a client
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Invoice created by user
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Invoice updated by user
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Invoice has many items
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('sort_order');
    }

    /**
     * Invoice has many payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class);
    }

    /**
     * Invoice uses a template
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(InvoiceTemplate::class);
    }

    /**
     * Check if invoice is editable
     */
    public function isEditable(): bool
    {
        return in_array($this->status, ['draft']);
    }

    /**
     * Check if invoice is deletable
     */
    public function isDeletable(): bool
    {
        return in_array($this->status, ['draft']);
    }

    /**
     * Calculate balance due
     */
    public function calculateBalance(): float
    {
        return $this->grand_total - $this->paid_amount;
    }

    /**
     * Scope for GST invoices only
     */
    public function scopeGstInvoices($query)
    {
        return $query->where('invoice_type', 'gst_invoice');
    }

    /**
     * Scope for proforma invoices only
     */
    public function scopeProformaInvoices($query)
    {
        return $query->where('invoice_type', 'proforma');
    }

    /**
     * Scope for specific status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for overdue invoices
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->whereIn('status', ['sent', 'viewed', 'partially_paid'])
            ->where('balance_due', '>', 0);
    }
}
