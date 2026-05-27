<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];

    public function users(): BelongsToMany
{
    return $this->belongsToMany(User::class)->withPivot('company_id');
}
}