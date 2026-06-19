<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInvite extends Model
{
    protected $fillable = ['company_id', 'invited_by', 'email', 'role', 'token', 'accepted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}
