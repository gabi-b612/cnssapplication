<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\AdministrateurController;
use App\Http\Controllers\Admin\LiquidationController;

Route::get('/', function () {
    return view('welcome');
});

// Routes Admin (protégées par auth:administrateur)
Route::middleware(['auth:administrateur'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Entreprises
    Route::resource('entreprises', EntrepriseController::class);
    
    // Administrateurs
    Route::resource('administrateurs', AdministrateurController::class);
    
    // Liquidations
    Route::resource('liquidations', LiquidationController::class);
    
    // Logout
    Route::post('/logout', function () {
        auth('administrateur')->logout();
        return redirect('/');
    })->name('logout');
});

