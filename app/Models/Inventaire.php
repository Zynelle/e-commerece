<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;
     protected $fillable = [
        'produit_id',
        'stock_initial',
        'stock_actuel',
        'date_inventaire',
        'remarques',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
