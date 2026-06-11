<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'type',
        'prefix',
        'year',
        'last_sequence',
    ];

    protected $casts = [
        'last_sequence' => 'integer',
    ];

    /**
     * Sequence belongs to company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
