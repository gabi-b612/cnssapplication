<?php

use App\Models\Administrateur;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EntrepriseController;
use App\Http\Controllers\Admin\AdministrateurController;
use App\Http\Controllers\Admin\LiquidationController;
use App\Http\Controllers\Admin\ApfController;
use App\Http\Controllers\Admin\TravailleurController as AdminTravailleurController;
use App\Http\Controllers\Admin\DemandeController as AdminDemandeController;
use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Entreprise\EntrepriseAuthController;
use App\Http\Controllers\Entreprise\DashboardController as EntrepriseDashboardController;
use App\Http\Controllers\Entreprise\TravailleurController as EntrepriseTravailleurController;
use App\Http\Controllers\Entreprise\DemandeController as EntrepriseDemandeController;
use App\Http\Controllers\Apf\ApfAuthController;
use App\Http\Controllers\Apf\DashboardController as ApfDashboardController;
use App\Http\Controllers\Apf\DemandeController as ApfDemandeController;

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

    // Agents APF
    Route::resource('apfs', ApfController::class)->except(['show', 'create']);

    // Travailleurs
    Route::get('/travailleurs', [AdminTravailleurController::class, 'index'])->name('travailleurs.index');

    // Demandes validées
    Route::get('/demandes-validees', [AdminDemandeController::class, 'index'])->name('demandes-validees.index');

    // Configuration
    Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
    Route::put('/configuration', [ConfigurationController::class, 'update'])->name('configuration.update');

    // Liquidations
    Route::get('/liquidations/historique', [LiquidationController::class, 'historique'])->name('liquidations.historique');
    Route::resource('liquidations', LiquidationController::class)->except(['create', 'edit', 'update']);
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

        Route::resource('travailleurs', EntrepriseTravailleurController::class)->except(['show']);

        Route::get('/demandes', [EntrepriseDemandeController::class, 'index'])->name('demandes.index');
        Route::get('/demandes/create', [EntrepriseDemandeController::class, 'create'])->name('demandes.create');
        Route::post('/demandes', [EntrepriseDemandeController::class, 'store'])->name('demandes.store');
    });
});

// Routes APF (Agent des Prestations aux Familles)
Route::prefix('apf')->name('apf.')->group(function () {
    Route::middleware('guest:apf')->group(function () {
        Route::get('/login', [ApfAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ApfAuthController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth:apf')->group(function () {
        Route::get('/dashboard', [ApfDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [ApfAuthController::class, 'logout'])->name('logout');

        Route::get('/demandes-a-traiter', [ApfDemandeController::class, 'index'])->name('demandes.index');
        Route::post('/demandes/{demande}/valider', [ApfDemandeController::class, 'valider'])->name('demandes.valider');
    });
});

