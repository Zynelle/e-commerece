<!-- resources/views/front/produit-detail.blade.php -->

@extends('front.layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>{{ $produit->nom }}</h2>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ Storage::url($produit->image) }}" class="img-fluid" alt="{{ $produit->nom }}">
            </div>
            <div class="col-md-6">
                <h4>Prix : ${{ $produit->prix_promo ?? $produit->prix_unitaire }}</h4>
                <p>{{ $produit->description }}</p>
                <a href="{{ route('panier.ajouter', ['id' => $produit->id]) }}" class="btn btn-primary">Ajouter au Panier</a>
            </div>
        </div>
    </div>
@endsection
