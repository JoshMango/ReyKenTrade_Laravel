@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product_listing.css') }}">
<style>
    .filters-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
    }
    .filter-group label {
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
    .filter-group select,
    .filter-group input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    .filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    .btn-filter {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
    }
    .btn-filter:hover {
        background: #0056b3;
    }
    .btn-clear {
        background: #6c757d;
    }
    .btn-clear:hover {
        background: #545b62;
    }
    .product-item {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .product-image {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        background: #fafafa;
        border-radius: 6px;
        padding: 8px;
    }
    .product-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        display: block;
    }
    .product-item h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.2em;
    }
    .product-specs {
        font-size: 0.9em;
        color: #666;
        margin-bottom: 10px;
    }
    .product-price {
        font-size: 1.5em;
        font-weight: bold;
        color: #007bff;
        margin-top: 10px;
    }
    .results-count {
        margin-bottom: 20px;
        color: #666;
        font-size: 1.1em;
    }
</style>

<div class="container" style="max-width: 1400px; margin: 0 auto; padding: 20px;">
    <h1 style="margin-bottom: 30px; color: #333;">Our Tire Collection</h1>
    
    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" action="{{ route('products.index') }}" id="filter-form">
            <div class="filters-row">
                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" name="search" id="search" placeholder="Product name..." value="{{ request('search') }}">
                </div>
                
                <div class="filter-group">
                    <label for="brand">Brand</label>
                    <select name="brand" id="brand">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="type">Type</label>
                    <select name="type" id="type">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="size">Size</label>
                    <select name="size" id="size">
                        <option value="">All Sizes</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size }}" {{ request('size') == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="min_price">Min Price (₱)</label>
                    <input type="number" name="min_price" id="min_price" placeholder="0" value="{{ request('min_price') }}" min="0">
                </div>
                
                <div class="filter-group">
                    <label for="max_price">Max Price (₱)</label>
                    <input type="number" name="max_price" id="max_price" placeholder="10000" value="{{ request('max_price') }}" min="0">
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn-filter">Apply Filters</button>
                <a href="{{ route('products.index') }}" class="btn-filter btn-clear" style="text-decoration: none; display: inline-block;">Clear Filters</a>
            </div>
        </form>
    </div>

    <div class="results-count">
        Found {{ $products->count() }} product(s)
    </div>

    <div class="product-grid" id="productGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
        @forelse($products as $product)
            <div class="product-item">
                <a href="{{ route('products.show', $product->product_id) }}" style="display: block; text-decoration: none; color: inherit;">
                    <div class="product-image">
                        <img src="{{ asset('storage/uploads/' . $product->productImage) }}" alt="{{ $product->productName }}" onerror="this.onerror=null;this.src='{{ asset('storage/uploads/Tire Example.png') }}'">
                    </div>
                    <h3>{{ $product->productName }}</h3>
                    <div class="product-specs">
                        @if($product->brand)
                            <strong>Brand:</strong> {{ $product->brand }}<br>
                        @endif
                        @if($product->size)
                            <strong>Size:</strong> {{ $product->size }}<br>
                        @endif
                        @if($product->type)
                            <strong>Type:</strong> {{ $product->type }}<br>
                        @endif
                        @if($product->speed_rating)
                            <strong>Speed Rating:</strong> {{ $product->speed_rating }}
                        @endif
                    </div>
                    <p class="product-price">₱{{ number_format($product->productPrice, 2) }}</p>
                </a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                <p style="font-size: 1.2em;">No products found matching your criteria.</p>
                <a href="{{ route('products.index') }}" style="color: #007bff; text-decoration: underline;">Clear filters and view all products</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
