@extends('layouts.app1')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Modifier un Produit</h3>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')  <!-- Utilisation de la méthode PUT pour la mise à jour -->

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du Produit</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $produit->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $produit->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prix_unitaire" class="form-label">Prix Unitaire</label>
                        <input type="number" step="0.01" class="form-control @error('prix_unitaire') is-invalid @enderror" id="prix_unitaire" name="prix_unitaire" value="{{ old('prix_unitaire', $produit->prix_unitaire) }}" required>
                        @error('prix_unitaire')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" class="form-control @error('quantite') is-invalid @enderror" id="quantite" name="quantite" value="{{ old('quantite', $produit->quantite) }}" required>
                        @error('quantite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prix_total" class="form-label">Prix Total</label>
                        <input type="number" step="0.01" class="form-control @error('prix_total') is-invalid @enderror" id="prix_total" name="prix_total" value="{{ old('prix_total', $produit->prix_unitaire * $produit->quantite) }}" readonly>
                        @error('prix_total')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fournisseur_id" class="form-label">Fournisseur</label>
                        <select class="form-select @error('fournisseur_id') is-invalid @enderror" id="fournisseur_id" name="fournisseur_id" required>
                            <option value="">-- Choisir un fournisseur --</option>
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id', $produit->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>{{ $fournisseur->nom }}</option>
                            @endforeach
                        </select>
                        @error('fournisseur_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="categorie_id" class="form-label">Catégorie</label>
                        <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                            <option value="">-- Choisir une catégorie --</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image du Produit</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                        @if ($produit->image)
                            <img src="{{ Storage::url($produit->image) }}" alt="image produit" width="50" height="50" class="mt-2">
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('admin.produits.index') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
