@extends('layouts.app1')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Gestion des Produits</h3>
        </div>

        <!-- Formulaire de filtrage des produits -->
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('admin.produits.index') }}" method="GET" class="row g-2">
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="nom" placeholder="Nom du produit" value="{{ request('nom') }}">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="categorie_id">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="fournisseur_id">
                            <option value="">Tous les fournisseurs</option>
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id') == $fournisseur->id ? 'selected' : '' }}>
                                    {{ $fournisseur->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="prix_min" placeholder="Prix min" value="{{ request('prix_min') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="prix_max" placeholder="Prix max" value="{{ request('prix_max') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des produits -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Liste des Produits</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutProduitModal">
                    Ajouter un Produit
                </button>
            </div>
            <div class="card-body">
                @if($produits->count())
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Image</th>
                                    <th>Fournisseur</th>
                                    <th>Catégorie</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produits as $produit)
                                <tr>
                                    <td>{{ $produit->nom }}</td>
                                    <td>{{ Str::limit($produit->description, 50) }}</td>
                                    <td>{{ number_format($produit->prix, 2) }} €</td>
                                    <td>{{ $produit->quantite }}</td>
                                    <td>
                                        @if($produit->image)
                                            <img src="{{ Storage::url($produit->image) }}" alt="image" width="50" height="50" style="object-fit: cover;">
                                        @else
                                            <span class="text-muted">Aucune</span>
                                        @endif
                                    </td>
                                    <td>{{ $produit->fournisseur->nom }}</td>
                                    <td>{{ $produit->categorie->nom }}</td>
                                    <td>
                                        <a href="{{ route('admin.produits.edit', $produit->id) }}" class="btn btn-sm btn-info">Modifier</a>
                                        <form action="{{ route('admin.produits.destroy', $produit->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                @else
                    <p class="text-center text-muted">Aucun produit trouvé.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal d'ajout de produit -->
    <div class="modal fade" id="ajoutProduitModal" tabindex="-1" aria-labelledby="ajoutProduitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.produits.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="ajoutProduitModalLabel">Ajouter un Produit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom du produit</label>
                                <input type="text" name="nom" id="nom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="prix_unitaire" class="form-label">Prix unitaire (€)</label>
                                <input type="number" step="0.01" name="prix_unitaire" id="prix_unitaire" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="prix" class="form-label">Prix total (€)</label>
                                <input type="number" step="0.01" name="prix" id="prix" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="quantite" class="form-label">Quantité</label>
                                <input type="number" name="quantite" id="quantite" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="fournisseur_id" class="form-label">Fournisseur</label>
                                <select name="fournisseur_id" id="fournisseur_id" class="form-select" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="categorie_id" class="form-label">Catégorie</label>
                                <select name="categorie_id" id="categorie_id" class="form-select" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
