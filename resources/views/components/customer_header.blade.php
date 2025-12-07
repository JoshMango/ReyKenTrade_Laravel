<style>
.navbar {
    display: flex;
    justify-content: space-between; /* Left links stay left, right links move right */
    align-items: center;
    gap: 15px;
}

/* Wrap left and right sections */
.nav-left, .nav-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logout-btn {
    font-weight: bold;
    color: #ff4d4f; /* Red for noticeable */
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px 12px;
    border-radius: 6px;
    transition: background 0.2s ease;
}

.logout-btn:hover {
    background-color: rgba(255, 77, 79, 0.1);
}

/* Sidebar content - vertical stacking */
.sidebar-content {
    flex: 1;
    padding: 20px;
    overflow-y: auto;   /* Vertical scroll if items overflow */
    max-height: 70vh;   /* limit height of sidebar */
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Cart item - vertical stacking, horizontal scroll if content overflows */
.cart-item {
    display: flex;
    flex-direction: row; /* keep image and details in a row */
    align-items: center;
    gap: 15px;
    padding: 10px;
    border-bottom: 1px solid #eee;
    overflow-x: auto;       /* horizontal scroll inside the item if needed */
    white-space: nowrap;    /* prevent wrapping inside item */
}

/* Image */
.cart-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
    flex-shrink: 0;  /* prevent shrinking */
}

/* Item details (name, quantity, price) */
.cart-item p,
.cart-item form {
    margin: 0;
    flex-shrink: 0;  /* keep full width for horizontal scroll */
}

/* Quantity input */
.cart-quantity-input {
    width: 60px;
}

/* Remove button */
.remove-cart-item-btn {
    margin-left: 10px;
    padding: 5px 10px;
    background: #ff4d4f;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s ease;
}

.remove-cart-item-btn:hover {
    background: #d9363e;
}

/* Scrollbar for horizontal overflow */
.cart-item::-webkit-scrollbar {
    height: 6px;
}

.cart-item::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.cart-item::-webkit-scrollbar-thumb {
    background: #5f40ea;
    border-radius: 3px;
}

.cart-item::-webkit-scrollbar-thumb:hover {
    background: #4934ab;
}
/* Checkout button */
.checkout-button {
    display: inline-block;
    width: 100%;
    text-align: center;
    padding: 12px 0;
    margin-top: 15px;
    background: linear-gradient(90deg, #563cec 0%, #a04dff 100%);
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.checkout-button:hover {
    background: linear-gradient(90deg, #4934ab 0%, #903ce9 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(108, 99, 255, 0.35);
}

</style>
<div class="header-wrap">
    <h1 class="site-name">Reyken Traders</h1>
    <nav class="navbar">
        <!-- Left links -->
        <div class="nav-left">
            <a href="{{ route('faq') }}" class="navbar-item">FAQ</a>
            <a href="{{ route('products.index') }}" class="navbar-item">Products</a>
            <a href="{{ route('home') }}" class="navbar-item">Home</a>
        </div>

        <!-- Right links -->
        <div class="nav-right">
            @auth
                <a href="{{ route('orders.my') }}" class="navbar-item">My Orders</a>
                <a href="{{ route('logout') }}" class="navbar-item logout-btn"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="navbar-item">Account</a>
            @endauth
            <button href="#" id="shopping-cart">Cart</button>
        </div>
    </nav>
</div>

<!-- CART -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="cart-sidebar" id="shoppingSidebar">
    <div class="cart-sidebar-header">
        <h3>Shopping Cart</h3>
        <button class="close-sidebar-btn">&times;</button>
    </div>
    <div class="sidebar-content">
        @auth
            @php
                $cartItems = \App\Models\Cart::where('user_id', auth()->id())->with('product')->get();
            @endphp
            @if($cartItems->count() > 0)
                @foreach($cartItems as $item)
                    <div class="cart-item" data-cart-id="{{ $item->cart_id }}">
                        <img src="{{ asset('storage/uploads/' . $item->product->productImage) }}" alt="{{ $item->product->productName }}">
                        <p>{{ $item->product->productName }}</p>
                        <form method="POST" action="{{ route('cart.update', $item->cart_id) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <label>Quantity: 
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" onchange="this.form.submit()" class="cart-quantity-input">
                            </label>
                        </form>
                        <p class="item-price">₱{{ number_format($item->product->productPrice * $item->quantity, 2) }}</p>
                        <form method="POST" action="{{ route('cart.destroy', $item->cart_id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-cart-item-btn">Remove</button>
                        </form>
                    </div>
                @endforeach
                <div class="cart-total">
                    <p id="cart-total-amount">Total: ₱{{ number_format($cartItems->sum(function($item) { return $item->product->productPrice * $item->quantity; }), 2) }}</p>
                </div>
                <a href="{{ route('checkout') }}" class="checkout-button">Checkout</a>
            @else
                <p>Your cart is empty!</p>
            @endif
        @else
            <p>You need to <a href="{{ route('login') }}">login first</a> to see your cart</p>
        @endauth
    </div>
</div>

<script>
    window.isUserLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    window.loggedInUserId = {{ auth()->check() ? auth()->id() : 'null' }};
</script>
<script src="{{ asset('scripts/cart.js') }}"></script>

