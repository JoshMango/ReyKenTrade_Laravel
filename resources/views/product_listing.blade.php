@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product_listing.css') }}">
<style>
/* Pagination container */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 25px;
}

/* Pagination UL (tailwind template) */
.pagination-wrapper nav > div > span,
.pagination-wrapper nav > div > a {
    margin: 0 3px;
}

/* Pagination buttons (links + spans) */
.pagination-wrapper a,
.pagination-wrapper span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;

    padding: 0 12px;
    border-radius: 10px;

    background: #ede9ff;   /* light purple */
    color: #5f40ea;        /* primary purple */
    font-weight: 600;
    font-size: 14px;
    border: none;

    transition: 0.25s ease;
    cursor: pointer;
}

/* Hover */
.pagination-wrapper a:hover {
    background: #d9d2ff; /* deeper soft purple */
    color: #3f00b3;      /* slightly darker purple */
    transform: translateY(-2px);
}

/* Active page */
.pagination-wrapper .bg-indigo-500,
.pagination-wrapper .bg-indigo-500:hover {
    background: #5f40ea !important;
    color: #fff !important;
    box-shadow: 0 3px 8px rgba(95, 64, 234, 0.4);
}

/* Disabled buttons */
.pagination-wrapper .cursor-default {
    background: #f1f1f1 !important;
    color: #6d6d6d !important;
    cursor: not-allowed;
    box-shadow: none;
    transform: none;
}

/* Arrow icons */
.pagination-wrapper svg {
    width: 18px;
    height: 18px;
}

.pagination-wrapper svg path,
.pagination-wrapper svg polyline {
    stroke: #5f40ea;
}

/* Disabled arrow icon */
.pagination-wrapper .cursor-default svg path,
.pagination-wrapper .cursor-default svg polyline {
    stroke: #bbbbbb;
}

/* Mobile responsive sizing */
@media (max-width: 480px) {
    .pagination-wrapper a,
    .pagination-wrapper span {
        min-width: 32px;
        height: 32px;
        font-size: 12px;
        padding: 0 8px;
    }
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
    @if($products->hasPages())
            <div class="pagination-wrapper" style="text-align:center; margin-top: 20px;">
                {{ $products->links('vendor.pagination.tailwind') }}
            </div>
    @endif
</div>
@endsection
