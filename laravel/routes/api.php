<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Public login endpoint for API
Route::post('/login', function (Request $request) {
    $request->validate(['email' => 'required|email', 'password' => 'required']);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = $request->user();
    $token = $user->createToken('mobile')->accessToken;

    return response()->json([
        'token' => $token,
        'user' => $user->load('roles'),
    ]);
});

// Protected routes with Passport auth
Route::middleware('auth:api')->group(function () {
    // Get current user with roles
    Route::get('/me', fn(Request $r) => $r->user()->load('roles'));

    // Logout - revoke token
    Route::post('/logout', function (Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully']);
    });

    // Categories - protected
    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/', 'getCategories');             // GET /api/categories
        Route::post('/', 'createCategory');           // POST /api/categories
        Route::get('/{categoryId}', 'getCategory');   // GET /api/categories/{categoryId}
        Route::patch('/{categoryId}', 'updateCategory'); // PATCH /api/categories/{categoryId}
        Route::delete('/{categoryId}', 'deleteCategory'); // DELETE /api/categories/{categoryId}
    });

    // Products - protected
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::patch('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

