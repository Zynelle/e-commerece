<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use HasFactory;
     protected $fillable = [
        'produit_id',
        'contenu',
        'date_rapport',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
