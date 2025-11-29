<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function landing()
    {
        if (!Auth::user()->isadmin) {
            return redirect()->route('home');
        }

        $products = Product::all();
        return view('seller_landingpage', compact('products'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $products = Product::where('productName', 'like', '%' . $request->search . '%')->get();

        return view('seller_landingpage', compact('products'));
    }
}
