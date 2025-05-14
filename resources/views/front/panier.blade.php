@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Mon panier</h2>

    @if(count($panier) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panier as $id => $item)
                    <tr>
                        <td><img src="{{ Storage::url($item['image']) }}" width="50" /></td>
                        <td>{{ $item['nom'] }}</td>
                        <td>${{ $item['prix'] }}</td>
                        <td>
                            <!-- Formulaire pour décrémenter -->
                            <button type="button" class="btn btn-sm btn-outline-primary decrement" data-id="{{ $id }}">-</button>

                            <!-- Affichage de la quantité -->
                            <span class="mx-2" id="quantite-{{ $id }}">{{ $item['quantite'] }}</span>

                            <!-- Formulaire pour incrémenter -->
                            <button type="button" class="btn btn-sm btn-outline-primary increment" data-id="{{ $id }}">+</button>
                        </td>

                        <td>${{ $item['quantite'] * $item['prix'] }}</td>
                        <td>
                            <!-- Bouton pour supprimer l'élément -->
                            <button type="button" class="btn btn-sm btn-danger supprimer" data-id="{{ $id }}">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <h4>Total: ${{ collect($panier)->sum(fn($item) => $item['prix'] * $item['quantite']) }}</h4>
        </div>
    @else
        <p>Votre panier est vide.</p>
    @endif
</div>

<script>
    $(document).ready(function() {
        // Action pour incrémenter
        $('.increment').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '{{ url("panier/update/") }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: 'increment'
                },
                success: function(response) {
                    if (response.panier) {
                        $('#quantite-' + id).text(response.panier[id].quantite);
                        updateTotal(response.panier);
                    }
                }
            });
        });

        // Action pour décrémenter
        $('.decrement').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '{{ url("panier/update/") }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: 'decrement'
                },
                success: function(response) {
                    if (response.panier) {
                        $('#quantite-' + id).text(response.panier[id].quantite);
                        updateTotal(response.panier);
                    }
                }
            });
        });

        // Action pour supprimer un produit
        $('.supprimer').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '{{ url("panier/supprimer/") }}/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.panier) {
                        $('tr').find('button[data-id="' + id + '"]').closest('tr').remove();
                        updateTotal(response.panier);
                    }
                }
            });
        });

        // Met à jour le total du panier
        function updateTotal(panier) {
            var total = 0;
            $.each(panier, function(id, item) {
                total += item.prix * item.quantite;
            });
            $('h4').text('Total: $' + total);
        }
    });
</script>
@endsection
