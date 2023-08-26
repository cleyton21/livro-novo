<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']
)->middleware(['auth', 'verified', 'checkUserStatus'])->name('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

Route::resource('user', UserController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'delete', 'destroy'])
    ->middleware(['auth', 'verified']);

Route::get('/user/autorizar/{id}', [UserController::class, 'autorizar']);
Route::get('/user/mudarperfil/{id}', [UserController::class, 'mudarPerfil']);
Route::post('/user/updatepassword/{id}', [UserController::class, 'atualizarSenha'])
        ->middleware(['auth', 'verified']);

Route::resource('livro', LivroController::class)
    ->only(['index', 'store', 'create', 'edit', 'update'])
    ->middleware(['auth', 'verified']);

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
