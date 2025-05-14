<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class AcceuilController extends Controller
{
    public function index(){
        $categories = Categorie::all();
        $produits = Produit::all();
        return view('front.acceuil',compact('categories','produits'));
    }
}
