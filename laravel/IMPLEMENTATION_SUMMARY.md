# TP6 Implementation Summary

## Complete RBAC System for Laravel with Authentication & Authorization

### What Was Implemented

This project now has a complete Role-Based Access Control (RBAC) system with:

1. **Web Authentication** - Laravel Breeze (already configured)
2. **API Authentication** - Laravel Passport (OAuth 2.0 tokens)
3. **Role-Based Authorization** - Gates for role/permission-level checks
4. **Object-Level Authorization** - Policies for resource-level checks

---

## Part 0: Starter Setup ✅

**Status**: Already implemented (Laravel Breeze)

- Login and registration pages work
- Session-based authentication for web routes
- CSRF protection

---

## Part 1: Database Design ✅

**Created migrations:**

1. `2025_01_09_000001_create_roles_table.php`
   - Stores roles: admin, manager, staff

2. `2025_01_09_000002_create_permissions_table.php`
   - Stores permissions: users.manage, products.*, categories.*

3. `2025_01_09_000003_create_role_user_table.php`
   - Many-to-many relationship between users and roles

4. `2025_01_09_000004_create_permission_role_table.php`
   - Many-to-many relationship between roles and permissions

**Created models:**

- `app/Models/Role.php` - Role model with relationships
- `app/Models/Permission.php` - Permission model with relationships
- Updated `app/Models/User.php` - Added roles relationship and helper methods

**Relationships:**
- User → hasMany(Role) via role_user table
- Role → hasMany(Permission) via permission_role table
- Permission → hasMany(Role) via permission_role table

---

## Part 2: Seed Roles + Permissions + Users ✅

**Created seeders:**

1. `database/seeders/RoleSeeder.php`
   - Creates 3 roles: admin, manager, staff

2. `database/seeders/PermissionSeeder.php`
   - Creates 7 permissions
   - Assigns all to admin
   - Assigns product/category create/update to manager
   - Staff gets no direct permissions (uses policies)

3. `database/seeders/UserSeeder.php`
   - Creates 4 test users:
     - admin@example.com (password123) - admin role
     - manager@example.com (password123) - manager role
     - staff1@example.com (password123) - staff role
     - staff2@example.com (password123) - staff role

**Updated `DatabaseSeeder.php`** to call all seeders in order

---

## Part 3: Authorization with Gates ✅

**Implemented in `app/Providers/AppServiceProvider.php`:**

```php
// Admin bypass - admins can do anything
Gate::before(function ($user, $ability) {
    return $user->hasRole('admin') ? true : null;
});

// Permission-based gates
Gate::define('users.manage', fn($user) => $user->hasPermission('users.manage'));
Gate::define('products.create', fn($user) => $user->hasPermission('products.create'));
Gate::define('products.update', fn($user) => $user->hasPermission('products.update'));
Gate::define('products.delete', fn($user) => $user->hasPermission('products.delete'));
Gate::define('categories.create', fn($user) => $user->hasPermission('categories.create'));
Gate::define('categories.update', fn($user) => $user->hasPermission('categories.update'));
Gate::define('categories.delete', fn($user) => $user->hasPermission('categories.delete'));
```

**Added helper methods to User model:**

```php
public function hasRole(string $role): bool
public function hasPermission(string $permission): bool
```

**Usage in controllers:**
```php
abort_unless(auth()->user()->can('products.create'), 403);
```

---

## Part 4: Policies ✅

**Created `app/Policies/CategoryPolicy.php`:**
- `view()` - Anyone can view
- `create()` - Requires `categories.create` permission
- `update()` - Requires `categories.update` permission
- `delete()` - Requires `categories.delete` permission

**Created `app/Policies/ProductPolicy.php`:**
- `view()` - Anyone can view
- `create()` - Requires `products.create` permission
- `update()` - Requires `products.update` permission
- `delete()` - Requires `products.delete` permission

**Registered policies in AppServiceProvider:**
```php
Gate::policy(Category::class, CategoryPolicy::class);
Gate::policy(Product::class, ProductPolicy::class);
```

**Usage in controllers:**
```php
$this->authorize('update', $category);
```

---

## Part 5: Passport API Authentication ✅

**Created Passport OAuth migrations:**
- `2016_06_01_000001_create_oauth_auth_codes_table.php` (oauth_clients)
- `2016_06_01_000002_create_oauth_access_tokens_table.php`
- `2016_06_01_000003_create_oauth_refresh_tokens_table.php`
- `2016_06_01_000004_create_oauth_personal_access_clients_table.php`

**Updated `app/Models/User.php`:**
- Added `use HasApiTokens;` trait

**Updated `config/auth.php`:**
```php
'api' => [
    'driver' => 'passport',
    'provider' => 'users',
]
```

**Updated `routes/api.php`:**
- `POST /api/login` - Returns Bearer token
- `GET /api/me` - Returns authenticated user with roles
- `POST /api/logout` - Revokes current token
- All product/category endpoints protected with `auth:api` middleware
- Gates and Policies enforced in API controllers

---

## Controller Updates ✅

**Updated `app/Http/Controllers/CategoryController.php`:**
- All methods use proper validation
- Authorization checks via `abort_unless()` and `authorize()`
- JSON responses with standardized format

**Updated `app/Http/Controllers/ProductController.php`:**
- All methods use proper validation
- Authorization checks via `abort_unless()` and `authorize()`
- JSON responses with standardized format

---

## Usage Examples

### Web Routes (Session-based)

```php
// Check role in blade template
@if(auth()->user()->hasRole('admin'))
  <p>Admin panel</p>
@endif

// Check permission
@can('products.create')
  <a href="/products/create">Create Product</a>
@endcan
```

### API Routes (Token-based)

**Login:**
```bash
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"manager@example.com","password":"password123"}'
```

Response:
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 2,
    "name": "Manager User",
    "email": "manager@example.com",
    "roles": [{"id": 2, "name": "manager"}]
  }
}
```

**Protected request:**
```bash
curl -X POST http://localhost/api/products \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..." \
  -H "Content-Type: application/json" \
  -d '{"name":"New Product","category_id":1,"pricing":29.99}'
```

**Get current user:**
```bash
curl -X GET http://localhost/api/me \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."
```

---

## Testing Checklist

- [ ] Run migrations: `php artisan migrate`
- [ ] Run seeders: `php artisan db:seed`
- [ ] Test web login with different users
- [ ] Test API login endpoint
- [ ] Test protected API endpoints with valid token
- [ ] Test authorization (try actions you don't have permission for)
- [ ] Verify admin bypass works
- [ ] Test policy enforcement on resources

---

## Key Files Created/Modified

### Created
- `app/Models/Role.php`
- `app/Models/Permission.php`
- `app/Policies/CategoryPolicy.php`
- `app/Policies/ProductPolicy.php`
- `database/seeders/RoleSeeder.php`
- `database/seeders/PermissionSeeder.php`
- `database/seeders/UserSeeder.php`
- `database/migrations/2025_01_09_000001-000004_*.php`
- `database/migrations/2016_06_01_000001-000004_*.php`
- `RBAC_DOCUMENTATION.md`

### Modified
- `app/Models/User.php` - Added roles, hasRole(), hasPermission(), HasApiTokens
- `app/Providers/AppServiceProvider.php` - Added gates and policy registrations
- `app/Http/Controllers/CategoryController.php` - Added authorization checks
- `app/Http/Controllers/ProductController.php` - Added authorization checks
- `routes/api.php` - Updated to use Passport auth and add login endpoint
- `config/auth.php` - Added Passport API guard

---

## Notes

1. **Passwords**: All test users use `password123`
2. **Admin Bypass**: Any admin user can perform any action regardless of permissions
3. **Token Expiration**: Configured by Passport (default 365 days)
4. **Scopes**: Currently using default scopes; can be customized
5. **CORS**: Configure in `config/cors.php` if needed for cross-origin requests

---

## Next Steps (Optional Enhancements)

1. Add user management endpoints
2. Create roles and permissions management UI
3. Add audit logging for authorization events
4. Implement custom scopes for API tokens
5. Add rate limiting to API endpoints
6. Implement API token refresh
7. Add WebSocket authentication if needed
8. Create tests for RBAC system
