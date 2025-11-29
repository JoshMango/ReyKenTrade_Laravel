<div class="header-wrap">
    <h1 class="site-name">Reyken Traders</h1>
    <nav class="navbar">
        <a href="{{ route('faq') }}" class="navbar-item">FAQ</a>
        <a href="{{ route('products.index') }}" class="navbar-item">Products</a>
        <a href="{{ route('home') }}" class="navbar-item">Home</a>
        @auth
            <a href="{{ route('logout') }}" class="navbar-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="{{ route('orders.my') }}" class="navbar-item">My Orders</a>
        @else
            <a href="{{ route('login') }}" class="navbar-item">Account</a>
        @endauth
        <button href="#" id="shopping-cart">Cart</button>
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

