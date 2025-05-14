<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;


protected $fillable = ['nom', 'description', 'prix', 'prix_unitaire', 'quantite', 'image', 'fournisseur_id', 'categorie_id'];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }

    public function inventaires()
    {
        return $this->hasMany(Inventaire::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'commandes')
            ->withPivot('quantite', 'prix_total', 'date_commande')
            ->withTimestamps();
    }
}
