@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/seller_landingpage.css') }}">

<div class="product-manager">
    <h2 style="font-weight:lighter;">Welcome Seller!</h2>
    <form method="POST" action="{{ route('seller.search') }}" class="search-item-bar">
        @csrf
        <input type="search" name="search" placeholder="Enter product name to edit..." class="search-item" required>
        <button type="submit" class="search-submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button type="button" class="add-listing" id="add-listing-button"><i class="fas fa-plus"></i></button>
    </form>
</div>

<div id="product-information-card">
    @if(isset($products) && $products->count() > 0)
        <div class="seller-grid">
        @foreach($products as $product)
            <div class="product-card">
                <div class="product-summary">
                    <div class="product-thumb"><img src="{{ asset('storage/uploads/' . $product->productImage) }}" alt="{{ $product->productName }}"></div>
                    <div class="product-meta">
                        <h3>{{ $product->productName }}</h3>
                        <p class="price">₱{{ number_format($product->productPrice, 2) }}</p>
                        <p class="short-desc">{{ \Illuminate\Support\Str::limit($product->productDesc, 100) }}</p>
                    </div>
                </div>
                <div class="product-actions">
                    <button type="button" class="btn-edit" data-target="edit-panel-{{ $product->product_id }}">Edit</button>
                    <form method="POST" action="{{ route('products.destroy', $product->product_id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </div>

                <div id="edit-panel-{{ $product->product_id }}" class="edit-panel" style="display:none;">
                    <form method="POST" action="{{ route('products.update', $product->product_id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <label>Product Name</label>
                            <input type="text" name="productName" value="{{ $product->productName }}" required>
                        </div>
                        <div class="form-row">
                            <label>Brand</label>
                            <input type="text" name="brand" value="{{ $product->brand }}">
                        </div>
                        <div class="form-row">
                            <label>Size</label>
                            <input type="text" name="size" value="{{ $product->size }}">
                        </div>
                        <div class="form-row">
                            <label>Type</label>
                            <select name="type">
                                <option value="">Select Type</option>
                                <option value="All-Season" {{ $product->type == 'All-Season' ? 'selected' : '' }}>All-Season</option>
                                <option value="All-Terrain" {{ $product->type == 'All-Terrain' ? 'selected' : '' }}>All-Terrain</option>
                                <option value="Performance" {{ $product->type == 'Performance' ? 'selected' : '' }}>Performance</option>
                                <option value="Touring" {{ $product->type == 'Touring' ? 'selected' : '' }}>Touring</option>
                                <option value="Mud Terrain" {{ $product->type == 'Mud Terrain' ? 'selected' : '' }}>Mud Terrain</option>
                                <option value="Comfort" {{ $product->type == 'Comfort' ? 'selected' : '' }}>Comfort</option>
                                <option value="Eco" {{ $product->type == 'Eco' ? 'selected' : '' }}>Eco</option>
                                <option value="OEM" {{ $product->type == 'OEM' ? 'selected' : '' }}>OEM</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <label>Load Index</label>
                            <input type="number" name="load_index" value="{{ $product->load_index }}">
                        </div>
                        <div class="form-row">
                            <label>Speed Rating</label>
                            <input type="text" name="speed_rating" value="{{ $product->speed_rating }}">
                        </div>
                        <div class="form-row">
                            <label>Price</label>
                            <input type="number" name="productPrice" value="{{ $product->productPrice }}" step="0.01" required>
                        </div>
                        <div class="form-row">
                            <label>Description</label>
                            <textarea name="productDescription" rows="3">{{ $product->productDesc }}</textarea>
                        </div>
                        <div class="form-row">
                            <label>Image (optional)</label>
                            <input type="file" name="productImage" accept="image/*">
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-apply">Update</button>
                            <button type="button" class="btn-cancel" data-target="edit-panel-{{ $product->product_id }}">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        </div>
    @endif
</div>

<!-- Add Product Modal -->
<div id="add-product-modal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border: 2px solid #000; border-radius: 8px; z-index: 1000; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
    <h3 style="margin-bottom: 20px; color: #333;">Add New Product</h3>
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Product Name:</label>
            <input type="text" name="productName" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Brand:</label>
            <input type="text" name="brand" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Size (e.g., 205/55R16):</label>
            <input type="text" name="size" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Type:</label>
            <select name="type" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">Select Type</option>
                <option value="All-Season">All-Season</option>
                <option value="All-Terrain">All-Terrain</option>
                <option value="Performance">Performance</option>
                <option value="Touring">Touring</option>
                <option value="Mud Terrain">Mud Terrain</option>
                <option value="Comfort">Comfort</option>
                <option value="Eco">Eco</option>
                <option value="OEM">OEM</option>
            </select>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Load Index:</label>
            <input type="number" name="load_index" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Speed Rating:</label>
            <input type="text" name="speed_rating" placeholder="e.g., H, V, W" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Price:</label>
            <input type="number" name="productPrice" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Description:</label>
            <textarea name="productDescription" rows="4" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Image:</label>
            <input type="file" name="productImage" accept="image/*" required style="width: 100%; padding: 8px;">
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="flex: 1; padding: 12px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Add Product</button>
            <button type="button" onclick="document.getElementById('add-product-modal').style.display='none'" style="flex: 1; padding: 12px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Cancel</button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://kit.fontawesome.com/499c47f1d4.js" crossorigin="anonymous"></script>
<script>
    // Show add product modal
    document.getElementById('add-listing-button').addEventListener('click', function() {
        document.getElementById('add-product-modal').style.display = 'block';
    });

    // Toggle edit panels per product
    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var panel = document.getElementById(targetId);
            if (!panel) return;
            if (panel.style.display === 'none' || panel.style.display === '') {
                panel.style.display = 'block';
                this.textContent = 'Close';
                this.classList.add('active');
            } else {
                panel.style.display = 'none';
                this.textContent = 'Edit';
                this.classList.remove('active');
            }
        });
    });

    // Cancel buttons inside edit panels
    document.querySelectorAll('.btn-cancel').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var panel = document.getElementById(targetId);
            if (!panel) return;
            panel.style.display = 'none';
            // reset corresponding edit button text
            var editBtn = document.querySelector('.btn-edit[data-target="' + targetId + '"]');
            if (editBtn) { editBtn.textContent = 'Edit'; editBtn.classList.remove('active'); }
        });
    });
</script>
@endpush
@endsection

