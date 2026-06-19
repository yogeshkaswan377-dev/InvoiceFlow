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

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    protected static function booted()
    {
        static::creating(function ($client) {
            if (is_null($client->place_of_supply) && $client->company_id && $client->state_code) {
                $company = Company::find($client->company_id);
                if ($company && $company->state_code) {
                    $client->place_of_supply = ($client->state_code === $company->state_code)
                        ? 'intra_state'
                        : 'inter_state';
                }
            }
        });
    }
}
