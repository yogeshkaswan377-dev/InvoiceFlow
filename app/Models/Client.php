<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'client_type',
        'name',
        'company_name',
        'email',
        'phone',
        'gstin',
        'state_code',
        'state_name',
        'address_line_1',
        'city',
        'pincode',
        'country',
        'place_of_supply',
        'credit_limit',
        'is_active',
        'state',
        'status'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_limit' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}