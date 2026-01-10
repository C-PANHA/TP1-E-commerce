# TP6 - Authentication & Authorization: Complete Implementation

## Overview

This project implements a complete **Role-Based Access Control (RBAC)** system for Laravel with both web and API authentication, as requested in the TP6 assignment.

## What's Included

### ✅ Part 0: Starter Setup
- Laravel Breeze installed and configured
- Web authentication (session-based) working
- Login/register pages functional

### ✅ Part 1: Database Design for RBAC
- `roles` table (admin, manager, staff)
- `permissions` table (users.manage, products.*, categories.*)
- `role_user` pivot table
- `permission_role` pivot table
- Eloquent models with relationships

### ✅ Part 2: Seed Data
- 3 roles created (admin, manager, staff)
- 7 permissions created
- 4 test users created with roles assigned
- All seeders are repeatable via `php artisan db:seed`

### ✅ Part 3: Authorization with Gates
- Admin bypass implemented (can do anything)
- Permission-based gates defined for each action
- Helper methods on User model (`hasRole()`, `hasPermission()`)
- Gates enforced in controllers

### ✅ Part 4: Policies (Object-Level Authorization)
- `CategoryPolicy` with view/create/update/delete rules
- `ProductPolicy` with view/create/update/delete rules
- Policies registered in AppServiceProvider
- Policies enforced in controllers

### ✅ Part 5: Passport for API Authentication
- Passport migrations created (OAuth clients, access tokens, refresh tokens, personal access clients)
- User model updated with `HasApiTokens` trait
- API guard configured in config/auth.php
- Login endpoint returns Bearer token
- Protected API routes with auth:api middleware
- All permission and policy checks enforced in API

## Quick Start

### 1. Start Docker
```bash
cd "c:\Users\MSI A12U\OneDrive\ITC I4\Semester 1\INTERNET PROGRAMMINIG\For_testing\Laravel-Docker"
docker-compose up -d
docker-compose exec app bash
```

### 2. Run Setup
```bash
cd /var/www/html/laravel
php artisan migrate
php artisan db:seed
npm install && npm run dev
```

### 3. Test Web Login
- Go to http://localhost
- Login with: admin@example.com / password123

### 4. Test API
```bash
# Get token
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password123"}'

# Use token
curl -X GET http://localhost/api/me \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Test Users

| Email | Password | Role | Permissions |
|-------|----------|------|-------------|
| admin@example.com | password123 | admin | All |
| manager@example.com | password123 | manager | products.*, categories.* (create/update) |
| staff1@example.com | password123 | staff | None (policy-based) |
| staff2@example.com | password123 | staff | None (policy-based) |

## Documentation Files

- **RBAC_DOCUMENTATION.md** - Complete RBAC system documentation
- **IMPLEMENTATION_SUMMARY.md** - Detailed implementation summary for each part
- **QUICK_START.md** - Quick setup and testing guide
- **VERIFICATION_CHECKLIST.md** - Comprehensive verification of all requirements

## Files Created/Modified

### Created
- `app/Models/Role.php`
- `app/Models/Permission.php`
- `app/Policies/CategoryPolicy.php`
- `app/Policies/ProductPolicy.php`
- `database/seeders/RoleSeeder.php`
- `database/seeders/PermissionSeeder.php`
- `database/seeders/UserSeeder.php`
- 4 RBAC migrations (roles, permissions, role_user, permission_role)
- 4 Passport OAuth migrations

### Modified
- `app/Models/User.php` - Added HasApiTokens, roles relationship, helper methods
- `app/Providers/AppServiceProvider.php` - Added gates and policy registrations
- `app/Http/Controllers/CategoryController.php` - Added authorization checks
- `app/Http/Controllers/ProductController.php` - Added authorization checks
- `routes/api.php` - Added Passport authentication and login endpoint
- `config/auth.php` - Added Passport API guard
- `database/seeders/DatabaseSeeder.php` - Call all RBAC seeders

## API Endpoints

### Public
- `POST /api/login` - Get Bearer token

### Protected (auth:api)
- `GET /api/me` - Current user with roles
- `POST /api/logout` - Revoke token

**Categories** (with permission/policy checks)
- `GET /api/categories` - List all
- `POST /api/categories` - Create [categories.create]
- `GET /api/categories/{id}` - View one
- `PATCH /api/categories/{id}` - Update [categories.update]
- `DELETE /api/categories/{id}` - Delete [categories.delete]

**Products** (with permission/policy checks)
- `GET /api/products` - List all
- `POST /api/products` - Create [products.create]
- `GET /api/products/{id}` - View one
- `PATCH /api/products/{id}` - Update [products.update]
- `DELETE /api/products/{id}` - Delete [products.delete]

## Authorization System

### Gates (Role/Permission Level)
```php
// Check in controller
abort_unless(auth()->user()->can('products.create'), 403);

// Check in blade
@can('products.create')
  <a href="/products/create">Create</a>
@endcan
```

### Policies (Object Level)
```php
// Check in controller
$this->authorize('update', $category);

// Check in blade
@can('update', $category)
  <a href="/categories/{{ $category->id }}/edit">Edit</a>
@endcan
```

### Helper Methods
```php
// Check role
if (auth()->user()->hasRole('admin')) { ... }

// Check permission
if (auth()->user()->hasPermission('products.create')) { ... }
```

## Security Features

- ✅ Password hashing with bcrypt
- ✅ CSRF protection on web routes
- ✅ API token authentication with Passport
- ✅ Permission-based authorization
- ✅ Resource-level authorization with Policies
- ✅ Admin bypass for full access
- ✅ Token revocation on logout
- ✅ Input validation on all endpoints
- ✅ 403 Forbidden responses for unauthorized access

## Database Schema

```
users
├─ id
├─ name
├─ email
├─ password
├─ timestamps

roles
├─ id
├─ name (admin, manager, staff)
├─ description
├─ timestamps

permissions
├─ id
├─ name (users.manage, products.*, categories.*)
├─ description
├─ timestamps

role_user (pivot)
├─ id
├─ user_id → users.id
├─ role_id → roles.id
├─ unique(user_id, role_id)

permission_role (pivot)
├─ id
├─ permission_id → permissions.id
├─ role_id → roles.id
├─ unique(permission_id, role_id)

oauth_clients, oauth_access_tokens, oauth_refresh_tokens, oauth_personal_access_clients
(Passport OAuth tables)
```

## Features Implemented

1. **User Authentication**
   - Web: Session-based with Laravel Breeze
   - API: Token-based with Laravel Passport

2. **Role Management**
   - Admin, Manager, Staff roles
   - Flexible role assignment

3. **Permission Management**
   - 7 permissions covering user, product, and category management
   - Permissions assigned to roles
   - Users inherit permissions through roles

4. **Authorization**
   - Gate-based (role/permission level)
   - Policy-based (object level)
   - Admin bypass for unrestricted access

5. **API**
   - Login endpoint returns Bearer token
   - All endpoints protected with auth:api middleware
   - Permission and policy enforcement in API controllers
   - Proper JSON responses with standardized format

6. **Data Seeding**
   - Repeatable seeders for easy testing
   - Test users with different roles
   - Sample permissions and role assignments

## Verification

All requirements from TP6 have been implemented and can be verified:

1. ✅ Migrations create required tables
2. ✅ Models define relationships correctly
3. ✅ Seeders create test data
4. ✅ Gates check permissions
5. ✅ Policies enforce object-level rules
6. ✅ Passport provides API authentication
7. ✅ Controllers enforce authorization
8. ✅ API routes are protected
9. ✅ Documentation is comprehensive

## Ready for

- ✅ Database migrations and seeding
- ✅ Web authentication testing
- ✅ API token authentication testing
- ✅ Authorization and permission testing
- ✅ Production deployment (with proper .env)

---

**Status: COMPLETE AND READY FOR TESTING** ✅

See the documentation files for detailed information on setup, usage, and testing.
