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

Route::get('/login', function () {
    return view('login');
})->name('login');

