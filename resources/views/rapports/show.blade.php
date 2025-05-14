@extends('layouts.app1')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Détails du Rapport</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Rapport pour {{ $rapport->produit->nom }}</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="produit">Produit</label>
                        <p>{{ $rapport->produit->nom }}</p>
                    </div>
                    <div class="form-group">
                        <label for="contenu">Contenu du rapport</label>
                        <p>{{ $rapport->contenu }}</p>
                    </div>
                    <div class="form-group">
                        <label for="date_rapport">Date du rapport</label>
                        <p>{{ $rapport->date_rapport }}</p>
                    </div>
                    <a href="{{ url('admin/rapports') }}" class="btn btn-secondary">Retour à la liste</a>
                </div>
            </div>
        </div>
    </div>
@endsection
