<?php

use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\Auth\RegisterController;
use App\Http\Controllers\Customer\Auth\SocialAuthController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\InvitationController;
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

        // Social Login Routes
        Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
        Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    });

    // Routes untuk authenticated customer - gunakan customer.auth middleware
    Route::middleware('customer.auth')->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

        // Invitation Management Routes - PASTIKAN ROUTES INI ADA DI DALAM MIDDLEWARE AUTH
        Route::resource('invitations', InvitationController::class);

        // Additional invitation routes
        Route::get('invitations/{invitation}/preview', [InvitationController::class, 'preview'])
            ->name('invitations.preview');
        Route::post('invitations/{invitation}/publish', [InvitationController::class, 'publish'])
            ->name('invitations.publish');
        Route::post('invitations/{invitation}/unpublish', [InvitationController::class, 'unpublish'])
            ->name('invitations.unpublish');
    });
});

// Route default
Route::get('/', function () {
    return view('welcome');
});
