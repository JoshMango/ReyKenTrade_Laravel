@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/checkout_page.css') }}">

<div class="checkout-content">
    <div class="checkout-text">
        <h1>Hey, {{ auth()->user()->username }}!</h1>
    </div>
    <hr>
    <div checkout-form>
        <form method="POST" action="{{ route('orders.store') }}" name="payment-form" class="payment-form">
            @csrf
            <h3>Choose your payment method</h3>
            <input type="radio" name="payment_method" id="GCash" value="GCash" required>
            <label class="method-label" for="GCash">GCash</label>
            <input type="radio" name="payment_method" id="PayPal" value="GPay" required>
            <label class="method-label" for="PayPal">GPay</label>
            <input type="radio" name="payment_method" id="CoD" value="Cash on Delivery" required>
            <label class="method-label" for="CoD">Cash on Delivery</label>
            <h4>Proceed to pay here 0919325984 for Gcash transactions</h4>
            <h4>Enter reference number(otherwise order will be rejected)
                <input type="text" name="reference" placeholder="For Gcash payment">
            </h4>
            <h3>Home Address</h3>
            <input type="text" placeholder="Address" class="customer-info" name="shipping_address" required>
            <input type="text" placeholder="Phone Number" class="customer-info" name="phonenumber" required>
            <h3 id="checkout-total-amount">Total: ₱{{ number_format($total, 2) }}</h3>
            <input type="submit" id="payment-submit" name="payment-submit" value="Proceed with Payment">
        </form>
    </div>
</div>
@endsection

