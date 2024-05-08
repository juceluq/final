<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth as FacadesAuth;

FacadesAuth::routes();
FacadesAuth::routes(['verify' => true]);

// Guest routes
Route::get('/login', [SessionController::class, 'index'])->middleware("guest")->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware("guest");

// Authenticated routes
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form')->middleware("guest");
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    return view('index');
});
