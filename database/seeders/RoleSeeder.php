<?php
// database/seeders/RoleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            'view settings',
            'edit settings',
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles with guard_name
        $ownerRole = Role::create(['name' => 'owner', 'guard_name' => 'web']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $staffRole = Role::create(['name' => 'staff', 'guard_name' => 'web']);

        // Assign permissions
        $ownerRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo([
            'view clients', 'create clients', 'edit clients', 'delete clients',
            'view settings', 'edit settings',
            'view invoices', 'create invoices', 'edit invoices', 'delete invoices'
        ]);
        $staffRole->givePermissionTo([
            'view clients', 'view invoices'
        ]);
    }
}