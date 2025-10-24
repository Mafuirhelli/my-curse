<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/menu', function () {
    $products = \App\Models\Product::where('is_active', true)->get();
    return view('menu', compact('products'));
})->name('menu');

Route::get('profile', [UserController::class, 'profile'])->name('profile');

Route::get('/interior', function () {
    return view('interior');
})->name('interior');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Маршруты администратора
    Route::get('/dashboard', [AdminController::class, 'dashboard'
    ])->name('admin.dashboard')->middleware(AdminMiddleware::class)->middleware('auth');
    // Управление продуктами
    Route::get('/products', [AdminController::class, 'products'
    ])->name('admin.products')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::get('/products/create', [AdminController::class, 'createProduct'
    ])->name('admin.products.create')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::post('/products', [AdminController::class, 'storeProduct'
    ])->name('admin.products.store')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'
    ])->name('admin.products.edit')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'
    ])->name('admin.products.update')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'
    ])->name('admin.products.delete')->middleware(AdminMiddleware::class)->middleware('auth');
    // Управление скидками
    Route::get('/discounts', [AdminController::class, 'discounts'
    ])->name('admin.discounts')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::post('/discounts', [AdminController::class, 'storeDiscount'
    ])->name('admin.discounts.store')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::delete('/discounts/{discount}', [AdminController::class, 'deleteDiscount'
    ])->name('admin.discounts.delete')->middleware(AdminMiddleware::class)->middleware('auth');
    // Управление заказами
    Route::get('/orders',
        [AdminController::class, 'orders'
        ])->name('admin.orders')->middleware(AdminMiddleware::class)->middleware('auth');
    Route::put('/orders/{order}/status',
        [AdminController::class, 'updateOrderStatus'
        ])->name('admin.orders.status')->middleware(AdminMiddleware::class)->middleware('auth');


Route::middleware('guest')->group(function () {
    Route::get('register',
        [UserController::class, 'create'
        ])->name('register');

    Route::post('register',
        [UserController::class, 'store'
        ])->name('users.store');

    Route::get('login',
        [UserController::class, 'login'
        ])->name('login');
    Route::post('login',
        [UserController::class, 'loginAuth'
        ])->name('login.auth');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('profile',
        [UserController::class, 'profile'
        ])->name('profile');
    Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{product}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{product}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::put('/cart/update/{product}', [OrderController::class, 'updateCart'])->name('cart.update');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/order-history', [OrderController::class, 'orderHistory'])->name('order.history');

    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.avatar.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', function () {
        return view('users.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('profile');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:3,1')->name('verification.send');

    Route::get('logout',
        [UserController::class, 'logout'
        ])->name('logout');
});
