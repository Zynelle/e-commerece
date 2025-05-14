<?php

use App\Http\Controllers\admin\CategorieController;
use App\Http\Controllers\admin\FournisseurController;
use App\Http\Controllers\admin\ProduitController;
use App\Http\Controllers\admin\RapportController;
use App\Http\Controllers\front\AcceuilController;
use App\Http\Controllers\front\PanierController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('categories', [CategorieController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategorieController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategorieController::class, 'store'])->name('categories.store');
        Route::get('categories/{id}/edit', [CategorieController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{id}', [CategorieController::class, 'update'])->name('categories.update');
        Route::patch('categories/{id}', [CategorieController::class, 'update'])->name('categories.update');
        Route::delete('categories/{id}', [CategorieController::class, 'destroy'])->name('categories.destroy');
        Route::patch('categories/{id}/status', [CategorieController::class, 'toggleStatus'])->name('categories.toggleStatus');

    });

    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('fournisseurs', [FournisseurController::class, 'index'])->name('fournisseurs.index');
    Route::get('fournisseurs/create', [FournisseurController::class, 'create'])->name('fournisseurs.create');
    Route::post('fournisseurs', [FournisseurController::class, 'store'])->name('fournisseurs.store');
    Route::get('fournisseurs/{fournisseur}', [FournisseurController::class, 'show'])->name('fournisseurs.show');
    Route::get('fournisseurs/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('fournisseurs.edit');
    Route::put('fournisseurs/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseurs.update');
    Route::delete('fournisseurs/{fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseurs.destroy');
    Route::patch('fournisseurs/{fournisseur}/status', [FournisseurController::class, 'toggleStatus'])->name('fournisseurs.toggleStatus');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('produits', [ProduitController::class, 'index'])->name('produits.index');
    Route::get('produits/create', [ProduitController::class, 'create'])->name('produits.create');
    Route::post('produits', [ProduitController::class, 'store'])->name('produits.store');
    Route::get('produits/{id}', [ProduitController::class, 'show'])->name('produits.show');
    Route::get('produits/{id}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
    Route::put('produits/{id}', [ProduitController::class, 'update'])->name('produits.update');
    Route::delete('produits/{id}', [ProduitController::class, 'destroy'])->name('produits.destroy');
    Route::post('produits/{id}/reduce-stock', [ProduitController::class, 'reduceStock'])->name('produits.reduceStock');
    Route::post('produits/{id}/add-stock', [ProduitController::class, 'addStock'])->name('produits.addStock');
});


Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('rapports/create', [RapportController::class, 'create'])->name('rapports.create');
    Route::post('rapports', [RapportController::class, 'store'])->name('rapports.store');
    Route::get('rapports/{id}', [RapportController::class, 'show'])->name('rapports.show');
    Route::get('rapports/{id}/edit', [RapportController::class, 'edit'])->name('rapports.edit');
    Route::put('rapports/{id}', [RapportController::class, 'update'])->name('rapports.update');
    Route::delete('rapports/{id}', [RapportController::class, 'destroy'])->name('rapports.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/', [AcceuilController::class, 'index'])->name('acceuil');
Route::post('/ajouter-au-panier/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::get('/compteur-panier', [PanierController::class, 'compteur'])->name('panier.compteur');
Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::get('/mon-panier', [PanierController::class, 'afficher'])->name('panier.afficher');
Route::post('/panier/update/{id}', [PanierController::class, 'update'])->name('panier.update');
Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
