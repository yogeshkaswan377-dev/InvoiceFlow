<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['owner', 'admin', 'staff']);
    }

    public function view(User $user, Client $client): bool
    {
        return $user->company_id === $client->company_id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['owner', 'admin']);
    }

    public function update(User $user, Client $client): bool
    {
        return $user->company_id === $client->company_id
            && $user->hasAnyRole(['owner', 'admin']);
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->company_id === $client->company_id
            && $user->hasAnyRole(['owner', 'admin']);
    }
}
