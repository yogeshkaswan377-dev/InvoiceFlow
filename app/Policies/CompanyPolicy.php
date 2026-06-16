<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function view(User $user, Company $company): bool
    {
        return $user->current_company_id === $company->id;
    }

    public function update(User $user, Company $company): bool
    {
        return $user->current_company_id === $company->id
            && $user->hasRole('owner');
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->current_company_id === $company->id
            && $user->hasRole('owner');
    }
}
