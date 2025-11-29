<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bestsellers = Product::where('bestseller', true)
            ->orderBy('product_id', 'desc')
            ->limit(3)
            ->get();

        return view('home', compact('bestsellers'));
    }
}
