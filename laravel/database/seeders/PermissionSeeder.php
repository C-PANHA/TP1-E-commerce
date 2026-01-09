<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's permissions.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            ['name' => 'users.manage', 'description' => 'Manage users'],
            
            // Products
            ['name' => 'products.create', 'description' => 'Create products'],
            ['name' => 'products.update', 'description' => 'Update products'],
            ['name' => 'products.delete', 'description' => 'Delete products'],
            
            // Categories
            ['name' => 'categories.create', 'description' => 'Create categories'],
            ['name' => 'categories.update', 'description' => 'Update categories'],
            ['name' => 'categories.delete', 'description' => 'Delete categories'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign permissions to roles
        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $staffRole = Role::where('name', 'staff')->first();

        // Admin gets all permissions
        if ($adminRole) {
            $adminRole->permissions()->sync(Permission::pluck('id'));
        }

        // Manager gets products and categories create/update
        if ($managerRole) {
            $managerPermissions = Permission::whereIn('name', [
                'products.create',
                'products.update',
                'categories.create',
                'categories.update',
            ])->pluck('id');
            $managerRole->permissions()->sync($managerPermissions);
        }

        // Staff gets nothing by default (they have object-level permissions via Policy)
        if ($staffRole) {
            $staffRole->permissions()->sync([]);
        }
    }
}
