<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);

        // Admin bypass - admin can do anything
        Gate::before(function (User $user, string $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        // Define gates for permissions
        Gate::define('users.manage', fn(User $user) => $user->hasPermission('users.manage'));
        Gate::define('products.create', fn(User $user) => $user->hasPermission('products.create'));
        Gate::define('products.update', fn(User $user) => $user->hasPermission('products.update'));
        Gate::define('products.delete', fn(User $user) => $user->hasPermission('products.delete'));
        Gate::define('categories.create', fn(User $user) => $user->hasPermission('categories.create'));
        Gate::define('categories.update', fn(User $user) => $user->hasPermission('categories.update'));
        Gate::define('categories.delete', fn(User $user) => $user->hasPermission('categories.delete'));
    }
}
