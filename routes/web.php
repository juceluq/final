<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
    Route::put('establishments/{establishment}', [EstablishmentController::class, 'update'])->name('establishments.update');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('post_review');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
});
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = User::findOrFail($request->route('id'));

    if ($user->hasVerifiedEmail()) {
        return redirect('/')->with('alert', [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'This user has been verified previously.'
        ]);
    }

    $user->markEmailAsVerified();
    event(new Verified($user));

    return redirect('/')->with('alert', [
        'type' => 'success',
        'title' => 'Sucess!',
        'message' => 'Your email has been verified!'
    ]);
})->name('verification.verify');

Route::get('/establishments/{establishment}', [EstablishmentController::class, 'show'])->name('establishments.show');
Route::post('/vote', [ReviewController::class, 'vote']);
Route::post('/search', [EstablishmentController::class, 'search'])->name('search');

Route::middleware(['auth', Auth::class])->group(function () {
    //! ruta para saber quien puede acceder a estas páginas
    Route::post('/reservar', [ReservaController::class, 'store'])->name('reserva.store');
    Route::delete('/reserva/{id}', [ReservaController::class, 'destroy'])->name('reserva.destroy');
    Route::delete('/establishments/{establishment}', [EstablishmentController::class, 'destroy'])->name('establishments.destroy');
    Route::get('establishments/{establishment}/edit', [EstablishmentController::class, 'edit'])->name('establishments.edit');
    Route::get('/mybusinesses', [EstablishmentController::class, 'mybusinesses'])->name('mybusinesses');
    Route::get('/myreserves', [ReservaController::class, 'index'])->name('myreserves');
});


//! Ruta para la página de inicio
Route::get('/', [EstablishmentController::class, 'index'])->name('index');

//! Ruta para la verificación de correo electrónico
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');
