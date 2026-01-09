<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's users.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $staffRole = Role::where('name', 'staff')->first();

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        if ($adminRole) {
            $admin->roles()->attach($adminRole);
        }

        // Create manager user
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password123'),
        ]);
        if ($managerRole) {
            $manager->roles()->attach($managerRole);
        }

        // Create first staff user
        $staff1 = User::create([
            'name' => 'Staff User 1',
            'email' => 'staff1@example.com',
            'password' => Hash::make('password123'),
        ]);
        if ($staffRole) {
            $staff1->roles()->attach($staffRole);
        }

        // Create second staff user
        $staff2 = User::create([
            'name' => 'Staff User 2',
            'email' => 'staff2@example.com',
            'password' => Hash::make('password123'),
        ]);
        if ($staffRole) {
            $staff2->roles()->attach($staffRole);
        }
    }
}
