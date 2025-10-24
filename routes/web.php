<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('profile', [UserController::class, 'profile'])->name('profile');

Route::get('/interior', function () {
    return view('interior');
})->name('interior');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('profile',
        [UserController::class, 'profile'
        ])->name('profile');
    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.avatar.update');
});

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




