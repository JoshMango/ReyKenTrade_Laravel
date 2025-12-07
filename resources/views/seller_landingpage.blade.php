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
            <div class="product-card" 
                data-id="{{ $product->product_id }}"
                data-brand="{{ $product->brand }}"
                data-size="{{ $product->size }}"
                data-type="{{ $product->type }}"
                data-load_index="{{ $product->load_index }}"
                data-speed_rating="{{ $product->speed_rating }}">
                <div class="product-summary">
                    <div class="product-thumb"><img src="{{ asset('storage/uploads/' . $product->productImage) }}" alt="{{ $product->productName }}"></div>
                    <div class="product-meta">
                        <h3>{{ $product->productName }}</h3>
                        <p class="price">₱{{ number_format($product->productPrice, 2) }}</p>
                        <div class="description-container">
                            <button type="button" class="toggle-desc">Show Description ▽</button>
                            <div class="desc-content">
                                <p>{{ $product->productDesc }}</p>
                            </div>
                        </div>
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
            </div>
        @endforeach
        </div>
        @if($products->hasPages())
            <div class="pagination-wrapper" style="text-align:center; margin-top: 20px;">
                {{ $products->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>
        @endif
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
<div id="edit-product-modal" style="display:none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h3>Edit Product</h3>
        <form id="edit-product-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="product_id" id="edit-product-id">
            
            <div class="form-row">
                <label>Product Name</label>
                <input type="text" name="productName" id="edit-productName" required>
            </div>
            <div class="form-row">
                <label>Brand</label>
                <input type="text" name="brand" id="edit-brand">
            </div>
            <div class="form-row">
                <label>Size</label>
                <input type="text" name="size" id="edit-size">
            </div>
            <div class="form-row">
                <label>Type</label>
                <select name="type" id="edit-type">
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
            <div class="form-row">
                <label>Load Index</label>
                <input type="number" name="load_index" id="edit-load_index">
            </div>
            <div class="form-row">
                <label>Speed Rating</label>
                <input type="text" name="speed_rating" id="edit-speed_rating">
            </div>
            <div class="form-row">
                <label>Price</label>
                <input type="number" name="productPrice" id="edit-productPrice" step="0.01" required>
            </div>
            <div class="form-row">
                <label>Description</label>
                <textarea name="productDescription" id="edit-productDescription" rows="4"></textarea>
            </div>
            <div class="form-row">
                <label>Image</label>
                <input type="file" name="productImage" accept="image/*">
            </div>

            <div class="modal-actions">
                <button type="submit" class="btn-apply">Update</button>
                <button type="button" class="btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script src="https://kit.fontawesome.com/499c47f1d4.js" crossorigin="anonymous"></script>
<script>
    // Show add product modal
    document.getElementById('add-listing-button').addEventListener('click', function() {
        document.getElementById('add-product-modal').style.display = 'block';
    });

        document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const productCard = this.closest('.product-card');
            const modal = document.getElementById('edit-product-modal');
            const form = document.getElementById('edit-product-form');

            // populate form values
            document.getElementById('edit-product-id').value = productCard.dataset.id;
            document.getElementById('edit-productName').value = productCard.querySelector('h3').textContent;
            document.getElementById('edit-productPrice').value = productCard.querySelector('.price').textContent.replace('₱','');
            document.getElementById('edit-productDescription').value = productCard.querySelector('.desc-content p').textContent;
            document.getElementById('edit-brand').value = productCard.dataset.brand || '';
            document.getElementById('edit-size').value = productCard.dataset.size || '';
            document.getElementById('edit-type').value = productCard.dataset.type || '';
            document.getElementById('edit-load_index').value = productCard.dataset.load_index || '';
            document.getElementById('edit-speed_rating').value = productCard.dataset.speed_rating || '';

            // update form action dynamically
            form.action = `/products/${productCard.dataset.id}`;

            modal.style.display = 'block';
        });
    });

    // Close Modal
    document.querySelectorAll('#edit-product-modal .btn-cancel, #edit-product-modal .modal-overlay').forEach(el => {
        el.addEventListener('click', function() {
            document.getElementById('edit-product-modal').style.display = 'none';
        });
    });

    document.querySelectorAll('.toggle-desc').forEach(btn => {
        btn.addEventListener('click', function() {
            const container = this.closest('.description-container');
            const content = container.querySelector('.desc-content');
            if (container.classList.contains('active')) {
                // hide
                content.style.maxHeight = '0';
                container.classList.remove('active');
                this.textContent = 'Show Description';
            } else {
                // show
                content.style.maxHeight = content.scrollHeight + 'px';
                container.classList.add('active');
                this.textContent = 'Hide Description';
            }
        });
    });
</script>
@endpush
@endsection

