@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/customer_orders.css') }}">

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
            <div class="order-items-grid">
                @foreach($order['items'] as $index => $item)
                    <div class="order-item-card {{ $index >= 4 ? 'hidden-item' : '' }}">
                        <img src="{{ asset('storage/uploads/' . $item['product_image']) }}" alt="{{ $item['product_name'] }}">
                        <p>{{ $item['product_name'] }}</p>
                        <p>Quantity: {{ $item['quantity'] }}</p>
                        <p>₱{{ number_format($item['total_price'], 2) }}</p>
                    </div>
                @endforeach
            </div>

            @if(count($order['items']) > 4)
                <button class="show-more-btn" onclick="toggleItems(this)">Show More</button>
            @endif
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse

    @if($orders->hasPages())
        <div class="pagination-wrapper">
            {{ $orders->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>

<script>
function toggleItems(button) {
    // Get the closest order-card container
    const orderCard = button.closest('.order-card');
    // Find all items that are hidden
    const hiddenItems = orderCard.querySelectorAll('.hidden-item');
    
    hiddenItems.forEach(item => {
        if (item.style.display === 'none' || !item.style.display) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });

    // Toggle button text
    button.textContent = button.textContent === 'Show More' ? 'Show Less' : 'Show More';
}
</script>

@endsection
