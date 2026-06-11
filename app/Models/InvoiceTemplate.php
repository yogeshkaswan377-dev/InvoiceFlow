<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'is_default',
        'color_scheme',
        'font_family',
        'show_logo',
        'show_signature',
        'show_upi_qr',
        'header_text',
        'footer_text',
        'terms_and_conditions',
        'layout_config',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'show_logo' => 'boolean',
        'show_signature' => 'boolean',
        'show_upi_qr' => 'boolean',
        'layout_config' => 'array',
    ];

    /**
     * Template belongs to company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
