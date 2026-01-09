<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's roles.
     */
    public function run(): void
    {
        // Create roles
        Role::create([
            'name' => 'admin',
            'description' => 'Administrator with full access',
        ]);

        Role::create([
            'name' => 'manager',
            'description' => 'Manager can create and update projects',
        ]);

        Role::create([
            'name' => 'staff',
            'description' => 'Staff can view and update assigned tasks',
        ]);
    }
}
