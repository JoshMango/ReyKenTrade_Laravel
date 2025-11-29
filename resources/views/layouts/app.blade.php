<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reyken Traders</title>
    
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shopping_cart.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="header-file">
        @if(auth()->check() && auth()->user()->isadmin)
            @include('components.seller_header')
        @else
            @include('components.customer_header')
        @endif
    </div>
    
    @if(session('success'))
        <div style="background: #4CAF50; color: white; padding: 10px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div style="background: #f44336; color: white; padding: 10px; text-align: center;">
            <ul style="list-style: none; margin: 0; padding: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @yield('content')
    
    @stack('scripts')
</body>
</html>

