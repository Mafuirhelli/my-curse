<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





    Route::get('/dashboard', [AdminController::class, 'dashboard'
    ])->name('admin.dashboard')->middleware(AdminMiddleware::class)->middleware('auth');
Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
Route::get('/admin/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

Route::get('/admin/discounts', [AdminController::class, 'discounts'])->name('admin.discounts');
Route::get('/admin/discounts/create', [AdminController::class, 'createDiscount'])->name('admin.discounts.create');
Route::post('/admin/discounts', [AdminController::class, 'storeDiscount'])->name('admin.discounts.store');
Route::get('/admin/discounts/{discount}/edit', [AdminController::class, 'editDiscount'])->name('admin.discounts.edit');
Route::put('/admin/discounts/{discount}', [AdminController::class, 'updateDiscount'])->name('admin.discounts.update');
Route::delete('/admin/discounts/{discount}', [AdminController::class, 'deleteDiscount'])->name('admin.discounts.delete');

Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
Route::put('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');

Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::put('/admin/users/{user}/points', [AdminController::class, 'updateUserPoints'])->name('admin.users.points');


Route::middleware('guest')->group(function () {
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
    Route::get('forgot-password', function () {
        return view('users.forgot-password');
    })->name('password.request');
    Route::get('forgot-password', function () {
        return view('users.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', [UserController::class, 'forgotPasswordStore'])->name('password.email')->middleware('throttle:3,1');

    Route::get('reset-password/{token}', function (string $token) {
        return view('users.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('reset-password', [UserController::class, 'resetPasswordUpdate'])->name('password.update');
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
