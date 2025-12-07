<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

    // Search by product name
    if ($request->has('search') && $request->search) {
        $query->where('productName', 'like', '%' . $request->search . '%');
    }

    // Filter by brand
    if ($request->has('brand') && $request->brand) {
        $query->where('brand', $request->brand);
    }

    // Filter by type
    if ($request->has('type') && $request->type) {
        $query->where('type', $request->type);
    }

    // Filter by size
    if ($request->has('size') && $request->size) {
        $query->where('size', $request->size);
    }

    // Filter by price range
    if ($request->has('min_price') && $request->min_price) {
        $query->where('productPrice', '>=', $request->min_price);
    }
    if ($request->has('max_price') && $request->max_price) {
        $query->where('productPrice', '<=', $request->max_price);
    }

    // dropdown values
    $brands = Product::distinct()->pluck('brand')->filter()->sort()->values();
    $types = Product::distinct()->pluck('type')->filter()->sort()->values();
    $sizes = Product::distinct()->pluck('size')->filter()->sort()->values();

    // 🔥 ENABLE PAGINATION HERE
    $products = $query->paginate(12)->withQueryString();
    return view('product_listing', compact('products', 'brands', 'types', 'sizes'));
}

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product_info', compact('product'));
    }

    public function store(Request $request)
    {
        // only admins can add products
        if (!Auth::check() || !Auth::user()->isadmin) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'productName' => 'required|string',
            'brand' => 'nullable|string',
            'size' => 'nullable|string',
            'type' => 'nullable|string',
            'load_index' => 'nullable|integer',
            'speed_rating' => 'nullable|string',
            'productPrice' => 'required|numeric|min:0',
            'productDescription' => 'nullable|string',
            'productImage' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        $existingProduct = Product::whereRaw('LOWER(productName) = ?', [strtolower($request->productName)])->first();
        
        if ($existingProduct) {
            return back()->withErrors(['product' => 'Product already exists!'])->withInput();
        }

        // preserve original extension and generate a safe, unique filename
        $extension = $request->file('productImage')->getClientOriginalExtension();
        $imageName = Str::slug($request->productName) . '-' . time() . '.' . $extension;
        $request->file('productImage')->storeAs('public/uploads', $imageName);

        $product =             Product::create([
                'productName' => $request->productName,
                'brand' => $request->brand,
                'size' => $request->size,
                'type' => $request->type,
                'load_index' => $request->load_index,
                'speed_rating' => $request->speed_rating,
                'productPrice' => $request->productPrice,
                'productDesc' => $request->productDescription,
                'productImage' => $imageName,
                'bestseller' => false,
            ]);

        return back()->with('success', 'Product has been added successfully!');
    }

    public function update(Request $request, $id)
    {
        // only admins can update products
        if (!Auth::check() || !Auth::user()->isadmin) {
            abort(403, 'Unauthorized');
        }

        $product = Product::findOrFail($id);

        $request->validate([
            'productName' => 'required|string',
            'brand' => 'nullable|string',
            'size' => 'nullable|string',
            'type' => 'nullable|string',
            'load_index' => 'nullable|integer',
            'speed_rating' => 'nullable|string',
            'productPrice' => 'required|numeric|min:0',
            'productDescription' => 'nullable|string',
            'productImage' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        $product->productName = $request->productName;
        $product->brand = $request->brand;
        $product->size = $request->size;
        $product->type = $request->type;
        $product->load_index = $request->load_index;
        $product->speed_rating = $request->speed_rating;
        $product->productPrice = $request->productPrice;
        $product->productDesc = $request->productDescription;

        if ($request->hasFile('productImage')) {
            $extension = $request->file('productImage')->getClientOriginalExtension();
            $imageName = Str::slug($request->productName) . '-' . time() . '.' . $extension;
            $request->file('productImage')->storeAs('public/uploads', $imageName);
            $product->productImage = $imageName;
        }

        $product->save();

        return back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        // only admins can delete products
        if (!Auth::check() || !Auth::user()->isadmin) {
            abort(403, 'Unauthorized');
        }

        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product deleted successfully!');
    }

    public function markBestseller($id)
    {
        // only admins can toggle bestseller
        if (!Auth::check() || !Auth::user()->isadmin) {
            abort(403, 'Unauthorized');
        }

        $product = Product::findOrFail($id);
        $product->bestseller = !$product->bestseller;
        $product->save();

        return back()->with('success', 'Bestseller status updated!');
    }
}
