<?php

use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\Auth\RegisterController;
use App\Http\Controllers\Customer\Auth\SocialAuthController;
use App\Http\Controllers\Customer\DashboardController;
use Illuminate\Support\Facades\Route;

// Customer Authentication Routes
Route::prefix('customer')->name('customer.')->group(function () {

    // Routes untuk guest (belum login) - gunakan customer.guest middleware
    Route::middleware('customer.guest')->group(function () {
        // Login Routes
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store'])->name('login.submit');

        // Register Routes
        Route::get('register', [RegisterController::class, 'create'])->name('register');
        Route::post('register', [RegisterController::class, 'store'])->name('register.submit');

        // Social Login Routes - PASTIKAN DI LUAR customer.auth middleware
        // Google Login
        Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
        Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

        // Untuk social media lainnya (future)
        Route::get('auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('auth.social');
        Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('auth.social.callback');
    });

    // Routes untuk authenticated customer - gunakan customer.auth middleware
    Route::middleware('customer.auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

        // Tambahkan routes untuk fitur undangan nanti di sini
        // Route::resource('invitations', \App\Http\Controllers\Customer\InvitationController::class);
    });
});

// Route default
Route::get('/', function () {
    return view('welcome');
});
