<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('auth/{provider}', [\App\Http\Controllers\SocialAuthController::class, 'redirect'])->name('social.login');
Route::get('auth/{provider}/callback', [\App\Http\Controllers\SocialAuthController::class, 'callback']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        // Route::get('/user', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('user');
        Route::resource('user', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'edit', 'show']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
