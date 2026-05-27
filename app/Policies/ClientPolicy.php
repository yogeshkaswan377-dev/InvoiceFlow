<?php
// app/Policies/ClientPolicy.php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function view(User $user, Client $client): bool
    {
        return $user->company_id === $client->company_id;
    }
    
    public function create(User $user): bool
    {
        return in_array($user->role->name, ['owner', 'admin']);
    }
    
    public function update(User $user, Client $client): bool
    {
        return $user->company_id === $client->company_id && 
               in_array($user->role->name, ['owner', 'admin']);
    }
    
    public function delete(User $user, Client $client): bool
    {
        return $user->company_id === $client->company_id && 
               in_array($user->role->name, ['owner', 'admin']);
    }
}