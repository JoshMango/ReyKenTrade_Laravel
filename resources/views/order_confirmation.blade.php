@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/order_confirmation.css') }}">

<h1>Thanks for your order!</h1>
<h3>Your order ID is {{ $order->order_id }}</h3>
<p>Total Amount: ₱{{ number_format($order->total_amount, 2) }}</p>
<p>Status: {{ $order->order_status }}</p>
@endsection

