<?php

use App\Models\Administrateur;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\AdministrateurController;
use App\Http\Controllers\Admin\LiquidationController;
use App\Http\Controllers\Entreprise\EntrepriseAuthController;
use App\Http\Controllers\Entreprise\DashboardController as EntrepriseDashboardController;
use App\Http\Controllers\Entreprise\TravailleurController;
use App\Http\Controllers\Entreprise\DemandeController;

Route::get('/', function () {
    return redirect()->route('login');
});

//Route::get('/test-create-admin', function () {
//    $admin = Administrateur::create([
//        'nom' => 'Dupont',
//        'prenom' => 'Jean',
//        'email' => 'admin@gmail.com',
//        'password' => Hash::make('admin@123'),
//    ]);
//
//    return response()->json([
//        'message' => 'Administrateur créé avec succès !',
//        'data' => $admin
//    ]);
//});

// Routes d'Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
});

// Routes Entreprise (Employeur)
Route::prefix('entreprise')->name('entreprise.')->group(function () {
    Route::middleware('guest:entreprise')->group(function () {
        Route::get('/login', [EntrepriseAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [EntrepriseAuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth:entreprise')->group(function () {
        Route::get('/dashboard', [EntrepriseDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [EntrepriseAuthController::class, 'logout'])->name('logout');

        Route::resource('travailleurs', TravailleurController::class)->except(['show']);

        Route::get('/demandes', [DemandeController::class, 'index'])->name('demandes.index');
        Route::get('/demandes/create', [DemandeController::class, 'create'])->name('demandes.create');
        Route::post('/demandes', [DemandeController::class, 'store'])->name('demandes.store');
    });
});

