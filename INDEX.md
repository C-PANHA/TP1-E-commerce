# TP6 - Authentication & Authorization Implementation Index

## Quick Links

### Getting Started
1. **[TP6_README.md](./TP6_README.md)** - Overview and project summary
2. **[QUICK_START.md](./QUICK_START.md)** - Setup and testing guide
3. **[FILE_STRUCTURE.md](./FILE_STRUCTURE.md)** - Complete file listing

### Detailed Documentation
4. **[laravel/RBAC_DOCUMENTATION.md](./laravel/RBAC_DOCUMENTATION.md)** - Full RBAC documentation
5. **[laravel/IMPLEMENTATION_SUMMARY.md](./laravel/IMPLEMENTATION_SUMMARY.md)** - Implementation details for each part
6. **[laravel/VERIFICATION_CHECKLIST.md](./laravel/VERIFICATION_CHECKLIST.md)** - Verification checklist

---

## Implementation Summary

### Part 0: Starter Setup ✅
- Laravel Breeze authentication system
- Web session-based login/register
- CSRF protection
- Password hashing

**Files**: Already configured by Laravel Breeze

### Part 1: Database Design ✅
- Created Role and Permission models
- Created 4 pivot tables
- Defined relationships (User → Roles → Permissions)
- Proper foreign keys and cascading deletes

**Files Created**:
- `app/Models/Role.php`
- `app/Models/Permission.php`
- `database/migrations/2025_01_09_000001_create_roles_table.php`
- `database/migrations/2025_01_09_000002_create_permissions_table.php`
- `database/migrations/2025_01_09_000003_create_role_user_table.php`
- `database/migrations/2025_01_09_000004_create_permission_role_table.php`

**Files Modified**:
- `app/Models/User.php` - Added roles relationship and helper methods

### Part 2: Database Seeding ✅
- Created 3 roles: admin, manager, staff
- Created 7 permissions
- Created 4 test users with proper role assignments
- All seeders are repeatable

**Files Created**:
- `database/seeders/RoleSeeder.php`
- `database/seeders/PermissionSeeder.php`
- `database/seeders/UserSeeder.php`

**Files Modified**:
- `database/seeders/DatabaseSeeder.php` - Call all seeders in order

### Part 3: Authorization with Gates ✅
- Implemented Admin bypass (admin can do anything)
- Defined 7 permission-based gates
- Added helper methods to User model
- Enforced in controllers with abort_unless()

**Files Modified**:
- `app/Providers/AppServiceProvider.php` - Added gates
- `app/Models/User.php` - Added hasRole() and hasPermission()
- `app/Http/Controllers/CategoryController.php` - Added gate checks
- `app/Http/Controllers/ProductController.php` - Added gate checks

### Part 4: Policies (Object-Level) ✅
- Created CategoryPolicy for resource authorization
- Created ProductPolicy for resource authorization
- Registered policies in AppServiceProvider
- Enforced in controllers with authorize()

**Files Created**:
- `app/Policies/CategoryPolicy.php`
- `app/Policies/ProductPolicy.php`

**Files Modified**:
- `app/Providers/AppServiceProvider.php` - Added policy registration
- `app/Http/Controllers/CategoryController.php` - Added policy checks
- `app/Http/Controllers/ProductController.php` - Added policy checks

### Part 5: Passport for API Auth ✅
- Created Passport OAuth migrations (4 tables)
- Added HasApiTokens trait to User
- Configured API guard to use Passport
- Created login endpoint
- Created protected API routes
- Enforced gates and policies in API controllers

**Files Created**:
- `database/migrations/2016_06_01_000001_create_oauth_auth_codes_table.php`
- `database/migrations/2016_06_01_000002_create_oauth_access_tokens_table.php`
- `database/migrations/2016_06_01_000003_create_oauth_refresh_tokens_table.php`
- `database/migrations/2016_06_01_000004_create_oauth_personal_access_clients_table.php`

**Files Modified**:
- `app/Models/User.php` - Added HasApiTokens trait
- `config/auth.php` - Added Passport API guard
- `routes/api.php` - Added login endpoint and protected routes

---

## Key Files Reference

### Models
| File | Contains |
|------|----------|
| `app/Models/User.php` | User with roles, HasApiTokens, hasRole(), hasPermission() |
| `app/Models/Role.php` | Role with permissions and users relationships |
| `app/Models/Permission.php` | Permission with roles relationship |
| `app/Models/Category.php` | Category (existing) |
| `app/Models/Product.php` | Product (existing) |

### Authorization
| File | Purpose |
|------|---------|
| `app/Providers/AppServiceProvider.php` | Gates, policies, admin bypass |
| `app/Policies/CategoryPolicy.php` | Category object-level auth |
| `app/Policies/ProductPolicy.php` | Product object-level auth |

### API & Routes
| File | Purpose |
|------|---------|
| `routes/api.php` | API endpoints with Passport auth |
| `config/auth.php` | Authentication configuration |

### Controllers
| File | Purpose |
|------|---------|
| `app/Http/Controllers/CategoryController.php` | Category API with auth checks |
| `app/Http/Controllers/ProductController.php` | Product API with auth checks |

### Database
| File | Purpose |
|------|---------|
| `database/migrations/2025_01_09_*.php` | RBAC tables (4 files) |
| `database/migrations/2016_06_01_*.php` | Passport OAuth tables (4 files) |
| `database/seeders/RoleSeeder.php` | Create roles |
| `database/seeders/PermissionSeeder.php` | Create permissions |
| `database/seeders/UserSeeder.php` | Create test users |
| `database/seeders/DatabaseSeeder.php` | Call all seeders |

---

## Test Users (After Migration & Seeding)

```
Admin User:
  Email: admin@example.com
  Password: password123
  Roles: admin
  Permissions: ALL

Manager User:
  Email: manager@example.com
  Password: password123
  Roles: manager
  Permissions: products.create, products.update, categories.create, categories.update

Staff User 1:
  Email: staff1@example.com
  Password: password123
  Roles: staff
  Permissions: NONE (uses policies)

Staff User 2:
  Email: staff2@example.com
  Password: password123
  Roles: staff
  Permissions: NONE (uses policies)
```

---

## Setup Steps

1. **Start Docker**:
   ```bash
   cd Laravel-Docker
   docker-compose up -d
   docker-compose exec app bash
   ```

2. **Navigate to Laravel**:
   ```bash
   cd /var/www/html/laravel
   ```

3. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

4. **Seed Database**:
   ```bash
   php artisan db:seed
   ```

5. **Build Frontend** (optional):
   ```bash
   npm install && npm run dev
   ```

6. **Access Application**:
   - Web: http://localhost (login with test users)
   - API: http://localhost/api/login (get token)

---

## API Examples

### Login (Get Token)
```bash
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password123"}'
```

Response:
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com",
    "roles": [{"id": 1, "name": "admin"}]
  }
}
```

### Get Current User
```bash
curl -X GET http://localhost/api/me \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."
```

### Create Product (Manager/Admin only)
```bash
curl -X POST http://localhost/api/products \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..." \
  -H "Content-Type: application/json" \
  -d '{
    "name":"New Product",
    "category_id":1,
    "pricing":99.99,
    "description":"A test product"
  }'
```

### Try Action Without Permission (Should get 403)
```bash
# Login as staff user, try to create product
curl -X POST http://localhost/api/products \
  -H "Authorization: Bearer STAFF_TOKEN..." \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","category_id":1,"pricing":99.99}'

# Response: 403 Forbidden
```

---

## Authorization Methods

### In Controllers
```php
// Check role
if (auth()->user()->hasRole('admin')) { ... }

// Check permission (Gate)
abort_unless(auth()->user()->can('products.create'), 403);

// Check resource (Policy)
$this->authorize('update', $product);
```

### In Blade Templates
```blade
@if(auth()->user()->hasRole('admin'))
  <p>Admin panel</p>
@endif

@can('products.create')
  <a href="/products/create">Create</a>
@endcan

@can('update', $product)
  <a href="/products/{{ $product->id }}/edit">Edit</a>
@endcan
```

### In Routes (Middleware)
```php
Route::middleware('auth:api')->group(function () {
  // All routes here require valid API token
});

Route::middleware('auth:api', 'can:products.create')->group(function () {
  // Routes here require permission
});
```

---

## Verification Checklist

- [x] Part 0: Starter setup working
- [x] Part 1: RBAC database tables created
- [x] Part 2: Roles, permissions, users seeded
- [x] Part 3: Gates implemented and enforced
- [x] Part 4: Policies created and registered
- [x] Part 5: Passport OAuth configured
- [x] API endpoints protected and tested
- [x] Controllers enforce authorization
- [x] Documentation complete

See `laravel/VERIFICATION_CHECKLIST.md` for full verification details.

---

## Documentation Files

| Document | Purpose |
|----------|---------|
| `TP6_README.md` | Project overview |
| `QUICK_START.md` | Quick setup guide |
| `FILE_STRUCTURE.md` | Complete file listing |
| `laravel/RBAC_DOCUMENTATION.md` | Full RBAC documentation |
| `laravel/IMPLEMENTATION_SUMMARY.md` | Implementation summary |
| `laravel/VERIFICATION_CHECKLIST.md` | Verification checklist |
| `INDEX.md` | This file |

---

## Important Notes

1. **Admin Bypass**: Any user with admin role can bypass all permission checks
2. **Token Expiration**: Configured by Passport (default 365 days)
3. **Password Reset**: Use `php artisan tinker` if needed to reset test user passwords
4. **Database Reset**: `php artisan migrate:fresh --seed` to reset everything
5. **CORS**: API is configured to accept localhost requests

---

## Troubleshooting

### Docker container won't start
```bash
docker-compose down
docker-compose up -d
```

### Database errors
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

### Can't access API
- Make sure containers are running: `docker-compose ps`
- Make sure migrations ran: `php artisan migrate --list`

### Permissions not working
- Clear config cache: `php artisan config:clear`
- Clear auth cache: `php artisan cache:clear`

---

## Support Files

All files are properly documented with:
- PHPDoc comments
- Method signatures with types
- Relationship definitions
- Gate definitions
- Policy rules
- Validation rules

See individual files for more details.

---

**Status**: ✅ COMPLETE AND READY FOR TESTING

All 5 parts of TP6 have been implemented successfully!
