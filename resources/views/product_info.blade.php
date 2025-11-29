@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product_info.css') }}">
<style>
    .product-details-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }
    .product-specs-table {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
    }
    .spec-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #dee2e6;
    }
    .spec-row:last-child {
        border-bottom: none;
    }
    .spec-label {
        font-weight: 600;
        color: #333;
    }
    .spec-value {
        color: #666;
    }
    @media (max-width: 768px) {
        .product-details-container {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $otherProducts = \App\Models\Product::where('product_id', '!=', $product->product_id)->limit(4)->get();
@endphp

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div class="product-details-container">
        <div class="product-image">
            <img src="{{ asset('storage/uploads/' . $product->productImage) }}" alt="{{ $product->productName }}" style="width: 100%; max-height: 500px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        </div>
        <div class="product-info">
            <h2 class="product-name" style="color: #333; margin-bottom: 15px;">{{ $product->productName }}</h2>
            <p class="product-price" id="product-price" data-base-price="{{ $product->productPrice }}" style="font-size: 2em; font-weight: bold; color: #007bff; margin-bottom: 20px;">
                Price: ₱{{ number_format($product->productPrice, 2) }}
            </p>
            
            <!-- Product Specifications -->
            <div class="product-specs-table">
                <h3 style="margin-bottom: 15px; color: #333;">Specifications</h3>
                @if($product->brand)
                    <div class="spec-row">
                        <span class="spec-label">Brand:</span>
                        <span class="spec-value">{{ $product->brand }}</span>
                    </div>
                @endif
                @if($product->size)
                    <div class="spec-row">
                        <span class="spec-label">Size:</span>
                        <span class="spec-value">{{ $product->size }}</span>
                    </div>
                @endif
                @if($product->type)
                    <div class="spec-row">
                        <span class="spec-label">Type:</span>
                        <span class="spec-value">{{ $product->type }}</span>
                    </div>
                @endif
                @if($product->load_index)
                    <div class="spec-row">
                        <span class="spec-label">Load Index:</span>
                        <span class="spec-value">{{ $product->load_index }}</span>
                    </div>
                @endif
                @if($product->speed_rating)
                    <div class="spec-row">
                        <span class="spec-label">Speed Rating:</span>
                        <span class="spec-value">{{ $product->speed_rating }}</span>
                    </div>
                @endif
            </div>
            
            @auth
                @if(!auth()->user()->isadmin)
                    <form method="POST" action="{{ route('cart.store') }}" class="quantity-selection" style="margin: 20px 0;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <label for="quantity" style="display: block; margin-bottom: 10px; font-weight: 600;">Quantity:</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="number" id="quantity" name="quantity" class="quantity-input" value="1" min="1" onchange="updatePrice()" style="padding: 10px; width: 80px; border: 1px solid #ddd; border-radius: 4px;">
                            <button type="submit" class="add-to-cart-button" style="padding: 12px 30px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 1em;">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                @endif
                
                @if(auth()->user()->isadmin)
                    <form method="POST" action="{{ route('products.bestseller', $product->product_id) }}" style="display: inline; margin: 10px 0;">
                        @csrf
                        <button type="submit" class="bestseller-button {{ $product->bestseller ? 'marked' : '' }}" style="padding: 10px 20px; background: {{ $product->bestseller ? '#ffc107' : '#6c757d' }}; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            {{ $product->bestseller ? '✓ Marked as Bestseller' : 'Mark as Bestseller' }}
                        </button>
                    </form>
                @endif
            @else
                <p style="margin: 20px 0; color: #666;">Please <a href="{{ route('login') }}" style="color: #007bff;">login</a> to add items to cart.</p>
            @endauth
        </div>
    </div>
    
    <div class="product-description" style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 40px;">
        <h3 style="color: #333; margin-bottom: 15px;">Product Description</h3>
        <p style="color: #666; line-height: 1.6;">{{ $product->productDesc ?? 'No description available.' }}</p>
    </div>

    <div class="similar-products-section" style="margin-top: 40px;">
        <h2 style="color: #333; margin-bottom: 25px;">Other Products</h2>
        <div class="similar-products-grid" id="otherProductsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            @forelse($otherProducts as $otherProduct)
                <div class="similar-product-item" style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <a href="{{ route('products.show', $otherProduct->product_id) }}" style="text-decoration: none; color: inherit;">
                        <div class="similar-product-image" style="height: 150px; margin-bottom: 10px;">
                            <img src="{{ asset('storage/uploads/' . $otherProduct->productImage) }}" alt="{{ $otherProduct->productName }}" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <h4 class="similar-product-name" style="color: #333; margin-bottom: 5px; font-size: 0.95em;">{{ $otherProduct->productName }}</h4>
                        <p class="similar-product-price" style="color: #007bff; font-weight: 600;">₱{{ number_format($otherProduct->productPrice, 2) }}</p>
                    </a>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: #666;">No other products available.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updatePrice() {
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const basePrice = parseFloat(document.getElementById('product-price').dataset.basePrice);
        const newPrice = basePrice * quantity;
        document.getElementById('product-price').textContent = 'Price: ₱' + newPrice.toFixed(2);
    }
</script>
@endpush
@endsection
