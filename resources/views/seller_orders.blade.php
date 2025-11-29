@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/seller_orders.css') }}">

<br>
<div class="order-manager">
    <h2>Incoming Orders</h2>
    @forelse($orders as $order)
        <div class="order-card">
            <h3>Order #{{ $order['order_id'] }}</h3>
            <p><strong>Customer:</strong> {{ $order['fullname'] }} ({{ $order['username'] }})</p>
            <p><strong>Email:</strong> {{ $order['email'] }}</p>
            <p><strong>Date:</strong> {{ $order['order_date'] }}</p>
            <p><strong>Status:</strong> {{ $order['order_status'] }}</p>
            <p><strong>Total:</strong> ₱{{ number_format($order['total_amount'], 2) }}</p>
            <p><strong>Shipping Address:</strong> {{ $order['shipping_address'] }}</p>
            <p><strong>Phone:</strong> {{ $order['customer_number'] }}</p>
            <p><strong>Payment Method:</strong> {{ $order['payment_mode'] }}</p>
            @if($order['reference_number'])
                <p><strong>Reference Number:</strong> {{ $order['reference_number'] }}</p>
            @endif
            <h4>Items:</h4>
            <ul>
                @foreach($order['items'] as $item)
                    <li>{{ $item['product_name'] }} - Quantity: {{ $item['quantity'] }} - ₱{{ number_format($item['total_price'], 2) }}</li>
                @endforeach
            </ul>
            <form method="POST" action="{{ route('orders.updateStatus', $order['order_id']) }}">
                @csrf
                @method('PUT')
                <select name="order_status">
                    <option value="Undelivered" {{ $order['order_status'] == 'Undelivered' ? 'selected' : '' }}>Undelivered</option>
                    <option value="Delivered" {{ $order['order_status'] == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Rejected" {{ $order['order_status'] == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit">Update Status</button>
            </form>
        </div>
    @empty
        <p>No incoming orders.</p>
    @endforelse
</div>
@endsection

