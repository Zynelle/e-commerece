<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    /**
     * Afficher la liste paginée des produits avec filtres.
     */
    public function index(Request $request)
    {
        $query = Produit::query();

        // Filtrer par nom
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        // Filtrer par catégorie
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        // Filtrer par fournisseur
        if ($request->filled('fournisseur_id')) {
            $query->where('fournisseur_id', $request->fournisseur_id);
        }

        // Filtrer par prix (min et/ou max)
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }

        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        // Exécuter la requête pour obtenir les produits
        $produits = $query->get();

        // Récupérer les catégories et les fournisseurs pour les filtres
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();

        return view('produits.index', compact('produits', 'categories', 'fournisseurs'));
    }


    /**
     * Afficher le formulaire de création d'un produit.
     */
    public function create()
    {
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();
        return view('produits.create', compact('categories', 'fournisseurs'));
    }

    /**
     * Enregistrer un produit dans la base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_unitaire' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'prix_total' => 'nullable|numeric|min:0',
            'fournisseur_id' => 'required',
            'categorie_id' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produits', 'public');
            $validated['image'] = $imagePath;
        }

        Produit::create($validated);

        return redirect()->route('admin.produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    /**
     * Afficher les détails d'un produit.
     */
    public function show(string $id)
    {
        $produit = Produit::findOrFail($id);
        return view('admin.produits.show', compact('produit'));
    }

    /**
     * Afficher le formulaire pour éditer un produit.
     */
    public function edit(string $id)
    {
        $produit = Produit::findOrFail($id);
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();
        return view('produits.edit', compact('produit', 'categories', 'fournisseurs'));
    }

    /**
     * Mettre à jour les informations d'un produit.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit = Produit::findOrFail($id);

        // Mise à jour du produit
        $produit->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'prix' => $validated['prix'],
            'prix_unitaire' => $validated['prix_unitaire'],
            'quantite' => $validated['quantite'],
            'image' => $request->file('image') ? $request->file('image')->store('images') : $produit->image,
            'fournisseur_id' => $validated['fournisseur_id'],
            'categorie_id' => $validated['categorie_id'],
        ]);

        return redirect('admin/produits')->with('success', 'Produit mis à jour avec succès');
    }

    /**
     * Supprimer un produit.
     */
    public function destroy(string $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();
        return redirect()->route('admin.produits.index')->with('success', 'Produit supprimé avec succès');
    }

    /**
     * Fonction pour réduire la quantité du produit lors d'une vente.
     */
    public function reduceStock(Request $request, string $id)
    {
        $validated = $request->validate([
            'quantite_vendue' => 'required|integer|min:1',
        ]);

        $produit = Produit::findOrFail($id);

        if ($produit->quantite >= $validated['quantite_vendue']) {
            $produit->quantite -= $validated['quantite_vendue'];
            $produit->save();

            return response()->json([
                'message' => 'Quantité réduite avec succès.',
                'quantite_restante' => $produit->quantite,
            ], 200);
        }

        return response()->json([
            'error' => 'Quantité insuffisante en stock.',
        ], 400);
    }

    /**
     * Fonction pour ajouter un stock à un produit.
     */
    public function addStock(Request $request, string $id)
    {
        $validated = $request->validate([
            'quantite_ajoutee' => 'required|integer|min:1',
        ]);

        $produit = Produit::findOrFail($id);
        $produit->quantite += $validated['quantite_ajoutee'];
        $produit->save();

        return response()->json([
            'message' => 'Stock ajouté avec succès.',
            'quantite_restante' => $produit->quantite,
        ], 200);
    }
}
