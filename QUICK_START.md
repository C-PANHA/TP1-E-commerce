# Quick Start Guide - RBAC System

## Prerequisites

Make sure Docker and Docker Compose are running.

## Step 1: Navigate to Project Directory

```bash
cd "c:\Users\MSI A12U\OneDrive\ITC I4\Semester 1\INTERNET PROGRAMMINIG\For_testing\Laravel-Docker"
```

## Step 2: Start Docker Containers

```bash
docker-compose up -d
```

This will start:
- PHP-FPM container (with Laravel)
- Nginx container
- MySQL/MariaDB container

## Step 3: Access the App Container

```bash
docker-compose exec app bash
```

You're now inside the app container.

## Step 4: Install Dependencies (if needed)

```bash
cd /var/www/html/laravel
composer install
npm install
```

## Step 5: Run Migrations

This creates all database tables including RBAC tables:

```bash
php artisan migrate
```

## Step 6: Seed the Database

This creates test users and assigns roles/permissions:

```bash
php artisan db:seed
```

## Step 7: Build Frontend Assets

```bash
npm run build
```

Or for development with hot reload:
```bash
npm run dev
```

## Step 8: Access the Application

- **Web**: http://localhost
- **API**: http://localhost/api

## Test Users

All passwords are: `password123`

### Admin User
- Email: `admin@example.com`
- Password: `password123`
- Roles: admin
- Permissions: All

### Manager User
- Email: `manager@example.com`
- Password: `password123`
- Roles: manager
- Permissions: products.create, products.update, categories.create, categories.update

### Staff Users
- Email: `staff1@example.com` or `staff2@example.com`
- Password: `password123`
- Roles: staff
- Permissions: None (uses policies for object-level access)

## Testing the API

### 1. Login to Get Token

```bash
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email":"admin@example.com",
    "password":"password123"
  }'
```

Copy the `token` from the response.

### 2. Use Token to Access Protected Routes

```bash
curl -X GET http://localhost/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 3. Create a Product (Admin/Manager only)

```bash
curl -X POST http://localhost/api/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name":"Test Product",
    "category_id":1,
    "pricing":99.99,
    "description":"A test product"
  }'
```

## Common Commands

```bash
# View logs
docker-compose logs app

# Access container bash
docker-compose exec app bash

# Run migrations
docker-compose exec app php artisan migrate

# Run seeders
docker-compose exec app php artisan db:seed

# Clear cache
docker-compose exec app php artisan cache:clear

# Reset database (migrations + seeds)
docker-compose exec app php artisan migrate:fresh --seed
```

## Database Access

- **Host**: localhost:3306
- **Username**: root
- **Password**: root (default)
- **Database**: laravel

Use a MySQL client like MySQL Workbench or DBeaver to view tables.

## Troubleshooting

### "Connection refused" for API

Make sure Docker containers are running:
```bash
docker-compose ps
```

Should show:
- app (PHP container)
- web (Nginx container)
- db (MySQL container)

### Database errors

Reset the database:
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

### Permission denied errors

Make sure you're running commands inside the container:
```bash
docker-compose exec app [command]
```

### CORS errors in API calls

The API should accept requests from http://localhost. If you get CORS errors, check `config/cors.php`.

## Documentation

- **RBAC Details**: See `RBAC_DOCUMENTATION.md`
- **Implementation Summary**: See `IMPLEMENTATION_SUMMARY.md`
- **Laravel Docs**: https://laravel.com/docs
- **Passport Docs**: https://laravel.com/docs/passport

## Project Structure

```
laravel/
├── app/
│   ├── Models/
│   │   ├── User.php (with roles relationship)
│   │   ├── Role.php (new)
│   │   ├── Permission.php (new)
│   │   ├── Category.php
│   │   └── Product.php
│   ├── Policies/
│   │   ├── CategoryPolicy.php (new)
│   │   └── ProductPolicy.php (new)
│   ├── Http/
│   │   └── Controllers/
│   │       ├── CategoryController.php (updated)
│   │       └── ProductController.php (updated)
│   └── Providers/
│       └── AppServiceProvider.php (updated with gates)
├── database/
│   ├── migrations/
│   │   ├── 2025_01_09_000001-000004_*.php (RBAC tables)
│   │   ├── 2016_06_01_000001-000004_*.php (Passport tables)
│   │   └── Other migrations...
│   └── seeders/
│       ├── RoleSeeder.php (new)
│       ├── PermissionSeeder.php (new)
│       ├── UserSeeder.php (new)
│       └── DatabaseSeeder.php (updated)
├── routes/
│   ├── api.php (updated with Passport routes)
│   └── web.php
├── config/
│   └── auth.php (updated with Passport API guard)
└── ...other files...
```

## API Endpoints Summary

### Public
- `POST /api/login` - Login and get token

### Protected (require auth:api + permissions)

**Categories:**
- `GET /api/categories` - List all
- `POST /api/categories` - Create (requires categories.create)
- `GET /api/categories/{id}` - Get one
- `PATCH /api/categories/{id}` - Update (requires categories.update)
- `DELETE /api/categories/{id}` - Delete (requires categories.delete)

**Products:**
- `GET /api/products` - List all
- `POST /api/products` - Create (requires products.create)
- `GET /api/products/{id}` - Get one
- `PATCH /api/products/{id}` - Update (requires products.update)
- `DELETE /api/products/{id}` - Delete (requires products.delete)

**User:**
- `GET /api/me` - Get current user with roles
- `POST /api/logout` - Logout and revoke token

## Success Indicators

You'll know everything is working when:

1. ✅ Migrations run without errors
2. ✅ Seeders create test users and roles
3. ✅ Web login works
4. ✅ API login returns a token
5. ✅ Protected endpoints reject requests without token
6. ✅ Admin can perform all actions
7. ✅ Manager can only create/update products and categories
8. ✅ Staff cannot create/update/delete (403 Forbidden)
9. ✅ API responses include role information
