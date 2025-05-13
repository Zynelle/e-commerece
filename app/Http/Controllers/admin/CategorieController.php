<?php

namespace App\Http\Controllers\admin;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create', ['categorie' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|unique:categories,nom',
            'description' => 'nullable|string',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Categorie::create($data);
        return redirect('admin/categories')->with('success', 'Catégorie créée.');
    }

    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('categories.show', compact('categorie'));
    }

    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $data = $request->validate([
            'nom' => 'required|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable|string',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Optionnel : Supprimer l'ancienne image
            if ($categorie->image) {
                Storage::disk('public')->delete($categorie->image);
            }

            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $categorie->update($data);
        return redirect('admin/categories')->with('success', 'Catégorie mise à jour.');
    }

    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        if ($categorie->image) {
            Storage::disk('public')->delete($categorie->image);
        }

        $categorie->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }


    public function toggleStatus($id)
{
    $categorie = Categorie::findOrFail($id);

    // Basculer le statut de la catégorie (activer/désactiver)
    $categorie->status = !$categorie->status;
    $categorie->save();

    // Retourner à la vue avec un message de succès
    return back()->with('success', 'Statut de la catégorie mis à jour.');
}

}
