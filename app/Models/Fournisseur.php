<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'email', 'telephone', 'adresse', 'ville', 'pays', 'status'];

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
