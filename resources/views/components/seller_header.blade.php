<style>
    #logout-link {
        font-weight: bold;
        transition: background 0.2s ease;
        padding: 6px 12px;
        border-radius: 6px;
    }
    #logout-link:hover{
        color: #ff4d4f;
        background-color: rgba(255, 77, 79, 0.1);
    }
</style>
<div class="header-wrap">
    <h1 class="site-name">Reyken Traders</h1>
    <nav class="navbar">
        <a href="{{ route('seller.orders') }}" class="navbar-item">Orders</a>
        <a href="{{ route('products.index') }}" class="navbar-item">Products</a>
        <a href="{{ route('home') }}" class="navbar-item">Home</a>
        @auth
            <a href="{{ route('logout') }}" class="navbar-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" id="logout-link">Log Out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf   
            </form>
        @else
            <a href="{{ route('login') }}" class="navbar-item">Account</a>
        @endauth
        <a href="{{ route('seller.landing') }}"><button id="dashboard-button">Dashboard</button></a>
    </nav>
</div>
