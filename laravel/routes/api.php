<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CommentController;

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

    // Authors - protected
    Route::controller(AuthorController::class)->prefix('authors')->group(function () {
        Route::get('/', 'index');          // GET /api/authors
        Route::post('/', 'store');          // POST /api/authors
        Route::get('/{id}', 'show');        // GET /api/authors/{id}
        Route::get('/{id}/audiences', 'getAudiences'); // GET /api/authors/{id}/audiences
    });

    // Articles - protected
    Route::controller(ArticleController::class)->prefix('articles')->group(function () {
        Route::get('/', 'index');           // GET /api/articles
        Route::post('/', 'store');           // POST /api/articles
        Route::get('/{id}', 'show');         // GET /api/articles/{id}
        Route::patch('/{id}', 'update');     // PATCH /api/articles/{id}
        Route::delete('/{id}', 'destroy');   // DELETE /api/articles/{id}
        Route::get('/author/{authorId}', 'getByAuthor'); // GET /api/articles/author/{authorId}
    });

    // Audiences - protected
    Route::controller(AudienceController::class)->prefix('audiences')->group(function () {
        Route::get('/', 'index');          // GET /api/audiences
        Route::post('/', 'store');          // POST /api/audiences
        Route::get('/{id}', 'show');        // GET /api/audiences/{id}
    });

    // Subscriptions - protected
    Route::prefix('subscriptions')->group(function () {
        Route::post('/', [SubscriptionController::class, 'subscribe']);           // POST /api/subscriptions
        Route::delete('/', [SubscriptionController::class, 'unsubscribe']);       // DELETE /api/subscriptions
        Route::get('/article/{articleId}', [SubscriptionController::class, 'getSubscribers']); // GET /api/subscriptions/article/{id}
        Route::get('/audience/{audienceId}', [SubscriptionController::class, 'getSubscriptions']); // GET /api/subscriptions/audience/{id}
    });

    // Comments - protected
    Route::controller(CommentController::class)->prefix('comments')->group(function () {
        Route::get('/', 'index');           // GET /api/comments
        Route::post('/', 'store');           // POST /api/comments
        Route::get('/{id}', 'show');         // GET /api/comments/{id}
        Route::patch('/{id}', 'update');     // PATCH /api/comments/{id}
        Route::delete('/{id}', 'destroy');   // DELETE /api/comments/{id}
        Route::get('/user/{userId}', 'getByUser'); // GET /api/comments/user/{userId}
        Route::get('/{type}/{id}', 'getByCommentable'); // GET /api/comments/{type}/{id}
    });
});

