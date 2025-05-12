<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'email', 'telephone'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commandes')
                    ->withPivot('quantite', 'prix_total', 'date_commande')
                    ->withTimestamps();
    }
}
