<?php

use App\Http\Controllers\Supplier\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:supplier'])
    ->prefix('supplier')
    ->name('supplier.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });