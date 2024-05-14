<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth as FacadesAuth;

//! Habilitar las rutas de autenticación predeterminadas de Laravel con verificación de correo electrónico
FacadesAuth::routes(['verify' => true]);

//! Rutas para usuarios no autenticados
Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'index'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
});

//! Rutas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
    Route::get('/establishments/create', [EstablishmentController::class, 'create'])->name('establishments.create');
    Route::post('/establishments', [EstablishmentController::class, 'store'])->name('establishments.store');
    Route::delete('/establishments/{establishment}', [EstablishmentController::class, 'destroy'])->name('establishments.destroy');
    Route::get('/establishments/{establishment}', [EstablishmentController::class, 'show'])->name('establishments.show');
    Route::get('establishments/{establishment}/edit', [EstablishmentController::class, 'edit'])->name('establishments.edit');
    Route::put('establishments/{establishment}', [EstablishmentController::class, 'update'])->name('establishments.update');
});


Route::middleware(['auth', Auth::class])->group(function () {
    //! ruta para saber quien puede acceder a estas páginas
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reserva.store');
    Route::get('/myreserves', [ReservaController::class, 'index'])->name('myreserves');
    Route::delete('/reserva/{id}', [ReservaController::class, 'destroy'])->name('reserva.destroy');
    Route::get('/mybusinesses', [EstablishmentController::class, 'mybusinesses'])->name('mybusinesses');
});


//! Ruta para la página de inicio
Route::get('/', [EstablishmentController::class, 'index'])->name('index');

//! Ruta para la verificación de correo electrónico
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');
