# TP6 - Authentication & Authorization RBAC Implementation

This project implements a complete Role-Based Access Control (RBAC) system for a Laravel application with both web authentication (Laravel Breeze) and API authentication (Laravel Passport).

## Project Structure

### Database

The RBAC system includes the following tables:

- **users**: User accounts
- **roles**: User roles (admin, manager, staff)
- **permissions**: Actions that can be performed
- **role_user**: Pivot table linking users to roles
- **permission_role**: Pivot table linking roles to permissions
- **products**: Products with categories
- **categories**: Product categories
- **oauth_clients**: Passport OAuth clients
- **oauth_access_tokens**: Passport access tokens
- **oauth_refresh_tokens**: Passport refresh tokens
- **oauth_personal_access_clients**: Passport personal access clients

### Models

1. **User** (`app/Models/User.php`)
   - Uses `HasApiTokens` trait for Passport support
   - Relationships: `roles()` (BelongsToMany)
   - Helper methods: `hasRole()`, `hasPermission()`

2. **Role** (`app/Models/Role.php`)
   - Relationships: `permissions()` (BelongsToMany), `users()` (BelongsToMany)

3. **Permission** (`app/Models/Permission.php`)
   - Relationships: `roles()` (BelongsToMany)

4. **Category** (`app/Models/Category.php`)
   - Relationships: `products()` (HasMany)

5. **Product** (`app/Models/Product.php`)
   - Relationships: `category()` (BelongsTo)

### Authorization

#### Gates (Role-level Authorization)

Defined in `app/Providers/AppServiceProvider.php`:

- Admin bypass: Admin users can perform any action
- Permission-based gates: `users.manage`, `products.create`, `products.update`, `products.delete`, `categories.create`, `categories.update`, `categories.delete`

Usage in controllers:
```php
abort_unless(auth()->user()->can('products.create'), 403);
```

#### Policies (Object-level Authorization)

1. **CategoryPolicy** (`app/Policies/CategoryPolicy.php`)
   - `view()`: Anyone can view
   - `create()`: Requires `categories.create` permission
   - `update()`: Requires `categories.update` permission
   - `delete()`: Requires `categories.delete` permission

2. **ProductPolicy** (`app/Policies/ProductPolicy.php`)
   - `view()`: Anyone can view
   - `create()`: Requires `products.create` permission
   - `update()`: Requires `products.update` permission
   - `delete()`: Requires `products.delete` permission

Usage in controllers:
```php
$this->authorize('update', $category);
```

## User Roles & Permissions

### Admin
- Full access to all resources
- Can manage users
- Can create, update, delete products and categories

### Manager
- Can create and update products
- Can create and update categories
- No user management

### Staff
- Can view products and categories
- No create, update, or delete permissions (controlled via Policy)

## Setup Instructions

### 1. Create Migration Files

The following migration files have been created:
- `database/migrations/2025_01_09_000001_create_roles_table.php`
- `database/migrations/2025_01_09_000002_create_permissions_table.php`
- `database/migrations/2025_01_09_000003_create_role_user_table.php`
- `database/migrations/2025_01_09_000004_create_permission_role_table.php`
- Passport OAuth migrations (2016_06_01_000001-000004)

### 2. Run Migrations

```bash
php artisan migrate
```

### 3. Run Seeders

The following seeders have been created:
- `RoleSeeder`: Creates admin, manager, staff roles
- `PermissionSeeder`: Creates all permissions and assigns them to roles
- `UserSeeder`: Creates sample users with appropriate roles

```bash
php artisan db:seed
```

This will create:
- **Admin User**: admin@example.com / password123
- **Manager User**: manager@example.com / password123
- **Staff User 1**: staff1@example.com / password123
- **Staff User 2**: staff2@example.com / password123

### 4. Configure Passport

The API guard is already configured in `config/auth.php`:

```php
'api' => [
    'driver' => 'passport',
    'provider' => 'users',
]
```

The User model includes the `HasApiTokens` trait for Passport support.

## API Endpoints

### Authentication

**POST /api/login**
```json
{
  "email": "admin@example.com",
  "password": "password123"
}
```

Response:
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com",
    "roles": [
      {
        "id": 1,
        "name": "admin",
        "description": "Administrator with full access"
      }
    ]
  }
}
```

**GET /api/me** (Protected)
Returns current user with roles

**POST /api/logout** (Protected)
Revokes the current token

### Categories & Products

All API endpoints are protected with `auth:api` middleware.

**Categories:**
- `GET /api/categories` - List all categories
- `POST /api/categories` - Create category (requires `categories.create`)
- `GET /api/categories/{id}` - Get category
- `PATCH /api/categories/{id}` - Update category (requires `categories.update`)
- `DELETE /api/categories/{id}` - Delete category (requires `categories.delete`)

**Products:**
- `GET /api/products` - List all products
- `POST /api/products` - Create product (requires `products.create`)
- `GET /api/products/{id}` - Get product
- `PATCH /api/products/{id}` - Update product (requires `products.update`)
- `DELETE /api/products/{id}` - Delete product (requires `products.delete`)

## Using Authorization in Controllers

### Check Role
```php
if (auth()->user()->hasRole('admin')) {
    // Admin-only logic
}
```

### Check Permission
```php
if (auth()->user()->hasPermission('products.create')) {
    // User has permission
}
```

### Use Gate (Role-level)
```php
abort_unless(auth()->user()->can('products.create'), 403);

// or

if (!Gate::allows('products.create')) {
    abort(403);
}
```

### Use Policy (Object-level)
```php
$this->authorize('update', $category);

// or

if (!auth()->user()->can('update', $category)) {
    abort(403);
}
```

## Important Files

- `app/Models/User.php` - User model with roles relationship
- `app/Models/Role.php` - Role model
- `app/Models/Permission.php` - Permission model
- `app/Providers/AppServiceProvider.php` - Gate definitions and policy registrations
- `app/Policies/CategoryPolicy.php` - Object-level authorization for categories
- `app/Policies/ProductPolicy.php` - Object-level authorization for products
- `config/auth.php` - Authentication configuration with Passport API guard
- `routes/api.php` - API routes with authentication
- `database/seeders/` - All seeder classes

## Testing

You can test the RBAC system by:

1. Login as different users (admin, manager, staff)
2. Try to access protected resources
3. Test API endpoints with Passport tokens
4. Verify permissions are enforced correctly

Example with cURL:
```bash
# Login
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password123"}'

# Use token to access protected endpoint
curl -X GET http://localhost/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Extending the System

To add new permissions:

1. Add to `PermissionSeeder`:
```php
Permission::create(['name' => 'new.permission']);
```

2. Assign to roles in `PermissionSeeder`:
```php
$adminRole->permissions()->attach(Permission::where('name', 'new.permission')->first());
```

3. Define gate in `AppServiceProvider`:
```php
Gate::define('new.permission', fn(User $user) => $user->hasPermission('new.permission'));
```

4. Use in controller:
```php
abort_unless(auth()->user()->can('new.permission'), 403);
```
