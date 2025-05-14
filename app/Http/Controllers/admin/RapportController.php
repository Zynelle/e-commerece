<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Rapport;
use App\Models\Produit;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rapports = Rapport::all();
        $produits = Produit::all();  // Récupérer tous les produits pour la sélection
        // Récupérer tous les rapports
        return view('rapports.index', compact('rapports','produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produits = Produit::all();  // Récupérer tous les produits pour la sélection
        return view('admin.rapports.create', compact('produits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'contenu' => 'required',
            'date_rapport' => 'nullable|date',
        ]);

        Rapport::create([
            'produit_id' => $request->produit_id,
            'contenu' => $request->contenu,
            'date_rapport' => $request->date_rapport ?: now(),
        ]);

        return redirect()->route('admin.rapports.index')->with('success', 'Rapport ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        return view('rapports.show', compact('rapport'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        $produits = Produit::all();
        return view('admin.rapports.edit', compact('rapport', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'contenu' => 'required',
            'date_rapport' => 'nullable|date',
        ]);

        $rapport = Rapport::findOrFail($id);
        $rapport->update([
            'produit_id' => $request->produit_id,
            'contenu' => $request->contenu,
            'date_rapport' => $request->date_rapport ?: now(),
        ]);

        return redirect()->route('admin.rapports.index')->with('success', 'Rapport mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rapport = Rapport::findOrFail($id);
        $rapport->delete();

        return redirect()->route('admin.rapports.index')->with('success', 'Rapport supprimé avec succès');
    }
}
