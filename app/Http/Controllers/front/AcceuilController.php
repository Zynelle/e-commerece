<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class AcceuilController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        $produits = Produit::all();
        return view('front.acceuil', compact('categories', 'produits'));
    }

    // Nouvelle méthode pour afficher le détail d'un produit
    public function show($id)
    {
        $produit = Produit::findOrFail($id); // Trouver le produit par son ID
        return view('front.detail_produit', compact('produit')); // Retourner la vue de détail avec le produit
    }
}
