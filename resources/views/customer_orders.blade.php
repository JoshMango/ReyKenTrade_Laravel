@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/customer_orders.css') }}">

<br>
<div class="order-view">
    <h2>My Orders</h2>
    @forelse($orders as $order)
        <div class="order-card">
            <h3>Order #{{ $order['order_id'] }}</h3>
            <p><strong>Date:</strong> {{ $order['order_date'] }}</p>
            <p><strong>Status:</strong> {{ $order['order_status'] }}</p>
            <p><strong>Total:</strong> ₱{{ number_format($order['total_amount'], 2) }}</p>
            <p><strong>Shipping Address:</strong> {{ $order['shipping_address'] }}</p>
            <p><strong>Payment Method:</strong> {{ $order['payment_mode'] }}</p>
            <h4>Items:</h4>
            <ul>
                @foreach($order['items'] as $item)
                    <li>{{ $item['product_name'] }} - Quantity: {{ $item['quantity'] }} - ₱{{ number_format($item['total_price'], 2) }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
</div>
@endsection

