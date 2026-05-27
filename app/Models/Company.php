<?php
// app/Models/Company.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_name',
        'gstin',
        'logo_path',
        'signature_path',
        'bank_details',
        'gst_mode_default',
        'gst_rates',
        'gst_settings',
        'invoice_preferences',
        'invoice_prefix',
        'quote_prefix',
        'default_payment_terms',
        'state_code',
        'state_name',
        'address_line_1',
        'address_line_2',
        'city',
        'pincode',
        'phone',
        'website',
        'pan',
        'cin'
    ];

    protected $casts = [
        'bank_details' => 'array',
        'gst_rates' => 'array',
        'gst_settings' => 'array',
        'invoice_preferences' => 'array',
        'gst_mode_default' => 'string',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function getDefaultGstRatesAttribute(): array
    {
        return $this->gst_rates ?? config('gst_rates.default_rates');
    }

    public function getFormattedGstinAttribute(): string
    {
        return formatGSTIN($this->gstin);
    }
}
