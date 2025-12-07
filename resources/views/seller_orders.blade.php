@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/seller_orders.css') }}">

<div class="order-manager">
    <h2>Incoming Orders</h2>

    @if($orders->count())
        <div class="order-grid">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-summary">
                        <h3>Order [{{ $order['order_id'] }}]</h3>
                        <p><strong>Customer:</strong> {{ $order['fullname'] }}</p>
                        <p><strong>Date:</strong> {{ $order['order_date'] }}</p>
                        <p><strong>Status:</strong> {{ $order['order_status'] }}</p>
                        <p><strong>Total:</strong> ₱{{ number_format($order['total_amount'], 2) }}</p>
                        <button type="button" class="toggle-details">Show Details</button>
                    </div>

                    <div class="order-details">
                        <p><strong>Email:</strong> {{ $order['email'] }}</p>
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
                            <button type="submit" class="update-btn">Update Status</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="pagination-wrapper">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <p class="no-orders">No incoming orders.</p>
    @endif
</div>

@push('scripts')
<script>
    // Toggle order details
    document.querySelectorAll('.toggle-details').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.order-card');
            const details = card.querySelector('.order-details');
            details.classList.toggle('active');
            this.textContent = details.classList.contains('active') ? 'Hide Details' : 'Show Details';
        });
    });
</script>
@endpush
@endsection
