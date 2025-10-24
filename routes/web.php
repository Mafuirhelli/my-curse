<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::get('/interior', function () {
    return view('interior');
})->name('interior');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('register', [\App\Http\Controllers\UserController::class, 'create'])->name('register');
Route::post('register', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::get('login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');


