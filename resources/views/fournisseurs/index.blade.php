@extends('layouts.app1')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Gestion des Fournisseurs</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Fournisseurs</h4>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addFournisseurModal">Ajouter</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Adresse</th>
                                            <th>Ville</th>
                                            <th>Pays</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fournisseurs as $fournisseur)
                                            <tr>
                                                <td>{{ $fournisseur->nom }}</td>
                                                <td>{{ $fournisseur->email }}</td>
                                                <td>{{ $fournisseur->telephone }}</td>
                                                <td>{{ $fournisseur->adresse }}</td>
                                                <td>{{ $fournisseur->ville }}</td>
                                                <td>{{ $fournisseur->pays }}</td>
                                                <td>
                                                    @if ($fournisseur->status)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Désactivé</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Modifier -->
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editFournisseurModal{{ $fournisseur->id }}">
                                                        <i class="fas fa-edit"></i> <!-- Icône de modification -->
                                                    </button>

                                                    <!-- Activer/Désactiver -->
                                                    <form
                                                        action="{{ route('admin.fournisseurs.toggleStatus', $fournisseur->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-warning btn-sm">
                                                            <i
                                                                class="fas fa-toggle-{{ $fournisseur->status ? 'on' : 'off' }}"></i>
                                                            <!-- Icône d'activation/désactivation -->
                                                        </button>
                                                    </form>

                                                    <!-- Supprimer -->
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#deleteFournisseurModal{{ $fournisseur->id }}">
                                                        <i class="fas fa-trash-alt"></i> <!-- Icône de suppression -->
                                                    </button>
                                                </td>

                                            </tr>

                                            <!-- Modal Modifier -->
                                            <div class="modal fade" id="editFournisseurModal{{ $fournisseur->id }}"
                                                tabindex="-1" aria-labelledby="editFournisseurModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('admin.fournisseurs.update', $fournisseur->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editFournisseurModalLabel">
                                                                    Modifier le fournisseur</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nom" class="form-label">Nom</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nom" name="nom"
                                                                        value="{{ $fournisseur->nom }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Email</label>
                                                                    <input type="email" class="form-control"
                                                                        id="email" name="email"
                                                                        value="{{ $fournisseur->email }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="telephone"
                                                                        class="form-label">Téléphone</label>
                                                                    <input type="text" class="form-control"
                                                                        id="telephone" name="telephone"
                                                                        value="{{ $fournisseur->telephone }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="adresse" class="form-label">Adresse</label>
                                                                    <input type="text" class="form-control"
                                                                        id="adresse" name="adresse"
                                                                        value="{{ $fournisseur->adresse }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="ville" class="form-label">Ville</label>
                                                                    <input type="text" class="form-control"
                                                                        id="ville" name="ville"
                                                                        value="{{ $fournisseur->ville }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="pays" class="form-label">Pays</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pays" name="pays"
                                                                        value="{{ $fournisseur->pays }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-select" name="status"
                                                                        id="status">
                                                                        <option value="1"
                                                                            @if ($fournisseur->status) selected @endif>
                                                                            Active</option>
                                                                        <option value="0"
                                                                            @if (!$fournisseur->status) selected @endif>
                                                                            Désactivé</option>
                                                                    </select>
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

                                            <!-- Modal Supprimer -->
                                            <div class="modal fade" id="deleteFournisseurModal{{ $fournisseur->id }}"
                                                tabindex="-1" aria-labelledby="deleteFournisseurModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('admin.fournisseurs.destroy', $fournisseur->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteFournisseurModalLabel">
                                                                    Supprimer le fournisseur</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Êtes-vous sûr de vouloir supprimer ce fournisseur ?</p>
                                                                <p><strong>{{ $fournisseur->nom }}</strong></p>
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

    <!-- Modal Ajouter -->
    <div class="modal fade" id="addFournisseurModal" tabindex="-1" aria-labelledby="addFournisseurModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.fournisseurs.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFournisseurModalLabel">Ajouter un fournisseur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone">
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse">
                        </div>
                        <div class="mb-3">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" class="form-control" id="ville" name="ville">
                        </div>
                        <div class="mb-3">
                            <label for="pays" class="form-label">Pays</label>
                            <input type="text" class="form-control" id="pays" name="pays">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Désactivé</option>
                            </select>
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
