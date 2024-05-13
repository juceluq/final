<?php

use App\Http\Controllers\EstablishmentController;
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
Route::get('/establishments/create', [EstablishmentController::class, 'create'])->name('establishments.create')->middleware('auth');
Route::post('/establishments', [EstablishmentController::class, 'store'])->name('establishments.store')->middleware('auth');
Route::delete('/establishments/{establishment}', [EstablishmentController::class, 'destroy'])->middleware('auth')->name('establishments.destroy');
Route::get('/establishments/{establishment}', [EstablishmentController::class, 'show'])->name('establishments.show');
Route::middleware(['auth'])->group(function () {
    Route::get('establishments/{establishment}/edit', [EstablishmentController::class, 'edit'])->name('establishments.edit');
    Route::put('establishments/{establishment}', [EstablishmentController::class, 'update'])->name('establishments.update');
});
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/', [EstablishmentController::class, 'index'])->name('index');
