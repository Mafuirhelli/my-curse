<?php

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

Route::get('register', [
    UserController::class, 'create'
])->name('register');

Route::post('register',
    [UserController::class, 'store'
    ])->name('user.store');

Route::get('login',
    [UserController::class, 'login'
    ])->name('login');

Route::get('logout',
    [UserController::class, 'logout'
    ])->name('logout');


Route::get('verify-email', function () {
    return view('users.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:3,1'])->name('verification.send');


