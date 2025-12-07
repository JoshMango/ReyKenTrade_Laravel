@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/order_confirmation.css') }}">

<div class="order-confirmation">
    <h1>Thanks for your order!</h1>
    <h3>Your order ID is {{ $order->order_id }}</h3>
    <p class="total-amount">Total Amount: ₱{{ number_format($order->total_amount, 2) }}</p>
    <p class="status">Status: {{ $order->order_status }}</p>
    <a href="{{ route('home') }}" class="return-home-btn">Return Home</a>
</div>
@endsection
