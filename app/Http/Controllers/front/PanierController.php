<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller
{

    public function afficher()
    {
        $panier = session()->get('panier', []);
        return view('front.panier', compact('panier'));
    }

    public function ajouter($id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            $panier[$id]['quantite']++;
        } else {
            $produit = Produit::findOrFail($id);
            $panier[$id] = [
                'nom' => $produit->nom,
                'prix' => $produit->prix_promo ?? $produit->prix_unitaire,
                'quantite' => 1,
                'image' => $produit->image,
            ];
        }

        session(['panier' => $panier]);

        return response()->json(['count' => count($panier)]);
    }

    public function compteur()
    {
        $panier = session('panier', []);
        return response()->json(['count' => count($panier)]);
    }

    public function update(Request $request, $id)
    {
        $panier = session()->get('panier', []);

        if (!isset($panier[$id])) {
            return response()->json(['error' => 'Produit non trouvé dans le panier.']);
        }

        if ($request->action === 'increment') {
            $panier[$id]['quantite'] += 1;
        } elseif ($request->action === 'decrement' && $panier[$id]['quantite'] > 1) {
            $panier[$id]['quantite'] -= 1;
        }

        session()->put('panier', $panier);

        // Renvoie le panier mis à jour sous forme JSON
        return response()->json(['panier' => $panier]);
    }

    public function supprimer($id)
    {
        $panier = session()->get('panier', []);
        unset($panier[$id]);
        session(['panier' => $panier]);

        // Renvoie la réponse JSON après suppression
        return response()->json(['panier' => $panier]);
    }
}
