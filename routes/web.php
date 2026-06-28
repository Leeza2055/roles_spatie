<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:super_admin|admin|viewer'])->group(function () {
    Route::inertia('viewer', 'Viewer')->name('viewer');
});

Route::middleware(['auth', 'verified', 'role:super_admin|admin'])->group(function () {
    Route::inertia('admin', 'Admin')->name('admin');
});

Route::middleware(['auth', 'verified', 'role:super_admin'])->group(function () {
    Route::inertia('super_admin', 'SuperAdmin')->name('super_admin');
    Route::resource('/users', UserController::class)->except('show');
});

require __DIR__.'/settings.php';
