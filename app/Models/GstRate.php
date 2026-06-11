<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GstRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'hsn_code',
        'description',
        'cgst_rate',
        'sgst_rate',
        'igst_rate',
        'effective_from',
        'effective_to',
        'is_active',
    ];

    protected $casts = [
        'cgst_rate' => 'decimal:2',
        'sgst_rate' => 'decimal:2',
        'igst_rate' => 'decimal:2',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active rates only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific HSN code
     */
    public function scopeByHsnCode($query, $hsnCode)
    {
        return $query->where('hsn_code', $hsnCode);
    }

    /**
     * Get current effective rate for a date
     */
    public function scopeEffectiveOn($query, $date = null)
    {
        $date = $date ?? now()->format('Y-m-d');

        return $query->where('effective_from', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('effective_to')
                    ->orWhere('effective_to', '>=', $date);
            })
            ->where('is_active', true);
    }

    /**
     * Get total GST rate (CGST + SGST or IGST)
     */
    public function getTotalRateAttribute(): float
    {
        return $this->cgst_rate + $this->sgst_rate + $this->igst_rate;
    }

    /**
     * Check if rate is currently effective
     */
    public function isCurrentlyEffective(): bool
    {
        $today = now()->format('Y-m-d');

        return $this->is_active
            && $this->effective_from <= $today
            && ($this->effective_to === null || $this->effective_to >= $today);
    }
}
