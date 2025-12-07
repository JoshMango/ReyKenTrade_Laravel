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

        $products = Product::paginate(9); // 9 items per page (3 per row)
        return view('seller_landingpage', compact('products'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        // Use paginate here too
        $products = Product::where('productName', 'like', '%' . $request->search . '%')
                           ->paginate(9)
                           ->withQueryString(); // keeps the search term in the pagination links

        return view('seller_landingpage', compact('products'));
    }
}
