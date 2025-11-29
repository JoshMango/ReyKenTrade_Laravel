@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">
<style>
    .home-wrap {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    .intro-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 40px;
        border-radius: 12px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .intro-text h1 {
        font-size: 3em;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    .intro-text h3 {
        font-size: 1.5em;
        margin-bottom: 30px;
        opacity: 0.9;
    }
    .browse-button {
        padding: 15px 40px;
        background: white;
        color: #667eea;
        border: none;
        border-radius: 8px;
        font-size: 1.2em;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    .browse-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    .recommendations {
        margin-top: 40px;
    }
    .bestsellers-wrap h1 {
        color: #333;
        margin-bottom: 30px;
        font-size: 2.5em;
        text-align: center;
    }
    #bestsellers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }
    .bestseller-item {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    .bestseller-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .bestseller-item img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 15px;
    }
    .bestseller-item h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.2em;
    }
    .bestseller-item p {
        color: #007bff;
        font-size: 1.5em;
        font-weight: bold;
        margin-top: 10px;
    }
</style>

<div class="home-wrap">
    <div class="intro-header">
        <div class="intro-content">
            <div class="intro-text">
                <h1 class="header-text">Browse our finest selection of tires</h1>
                <h3 class="header-description">Premium quality tires for every vehicle and driving style</h3>
                <a href="{{ route('products.index') }}">
                    <button class="browse-button">Browse Collection</button>
                </a>
            </div>
        </div>
    </div>
    
    <div class="recommendations">
        <div class="bestsellers-wrap">
            <h1>Bestsellers</h1>
            <div id="bestsellers-grid">
                @forelse($bestsellers as $product)
                    <div class="bestseller-item" onclick="window.location.href='{{ route('products.show', $product->product_id) }}'">
                        <img src="{{ asset('storage/uploads/' . $product->productImage) }}" alt="{{ $product->productName }}">
                        <h3>{{ $product->productName }}</h3>
                        @if($product->brand)
                            <p style="font-size: 0.9em; color: #666; margin: 5px 0;">{{ $product->brand }}</p>
                        @endif
                        <p>₱{{ number_format($product->productPrice, 2) }}</p>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                        <p>No bestsellers found yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
