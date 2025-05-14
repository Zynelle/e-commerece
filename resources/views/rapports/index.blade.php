@extends('layouts.app1')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Gestion des Rapports</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Rapports</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRapportModal">
                                Ajouter un rapport
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Contenu</th>
                                            <th>Date du rapport</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rapports as $rapport)
                                            <tr>
                                                <td>{{ $rapport->produit->nom }}</td>
                                                <td>{{ $rapport->contenu }}</td>
                                                <td>{{ $rapport->date_rapport }}</td>
                                                <td>
                                                    <!-- Voir -->
                                                    <a href="{{ route('admin.rapports.show', $rapport->id) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-eye"></i> Voir
                                                    </a>

                                                    <!-- Modifier -->
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editRapportModal{{ $rapport->id }}">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </button>

                                                    <!-- Supprimer -->
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#deleteRapportModal{{ $rapport->id }}">
                                                        <i class="fas fa-trash-alt"></i> Supprimer
                                                    </button>
                                                </td>

                                            </tr>

                                            <!-- Modal Modifier Rapport -->
                                            <div class="modal fade" id="editRapportModal{{ $rapport->id }}" tabindex="-1"
                                                aria-labelledby="editRapportModalLabel{{ $rapport->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.rapports.update', $rapport->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editRapportModalLabel{{ $rapport->id }}">Modifier
                                                                    le rapport pour {{ $rapport->produit->nom }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="produit_id">Produit</label>
                                                                    <select name="produit_id" class="form-control" required>
                                                                        <option value="">Sélectionner un produit
                                                                        </option>
                                                                        @foreach ($produits as $produit)
                                                                            <option value="{{ $produit->id }}"
                                                                                {{ $rapport->produit_id == $produit->id ? 'selected' : '' }}>
                                                                                {{ $produit->nom }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="contenu">Contenu du rapport</label>
                                                                    <textarea name="contenu" class="form-control" rows="4" required>{{ $rapport->contenu }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="date_rapport">Date du rapport</label>
                                                                    <input type="date" name="date_rapport"
                                                                        class="form-control"
                                                                        value="{{ $rapport->date_rapport }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Fermer</button>
                                                                <button type="submit" class="btn btn-primary">Mettre à
                                                                    jour</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Supprimer Rapport -->
                                            <div class="modal fade" id="deleteRapportModal{{ $rapport->id }}"
                                                tabindex="-1" aria-labelledby="deleteRapportModalLabel{{ $rapport->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.rapports.destroy', $rapport->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteRapportModalLabel{{ $rapport->id }}">
                                                                    Supprimer le rapport</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Êtes-vous sûr de vouloir supprimer ce rapport ? Cette
                                                                    action est irréversible.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Supprimer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajouter Rapport -->
    <div class="modal fade" id="addRapportModal" tabindex="-1" aria-labelledby="addRapportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.rapports.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRapportModalLabel">Ajouter un rapport</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="produit_id">Produit</label>
                            <select name="produit_id" class="form-control" required>
                                <option value="">Sélectionner un produit</option>
                                @foreach ($produits as $produit)
                                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contenu">Contenu du rapport</label>
                            <textarea name="contenu" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date_rapport">Date du rapport</label>
                            <input type="date" name="date_rapport" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
