<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $produits = Produit::paginate('4');
        return view('front.shop', compact('produits'));
    }
}
