<?php

use App\Http\Controllers\SessionController;
use App\Http\Middleware\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', [SessionController::class, 'index'])->middleware("guest");

Route::get('/', function () {
    return view('index');
});

Route::get('/register', function () {
    return view('register');
})->middleware("guest");


Route::post('/login', [SessionController::class, 'store'])->middleware("guest");
Route::post('/logout', [SessionController::class, 'destroy'])->middleware(Auth::class);
