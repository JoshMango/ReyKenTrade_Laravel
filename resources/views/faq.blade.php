@extends('layouts.app')

@section('content')
<style>
    .faq-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
    }

    .faq-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
        color: #333;
    }

    .faq-subtext {
        text-align: center;
        margin-bottom: 30px;
        color: #666;
    }

    .faq-item {
        background: white;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 15px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: 0.3s ease;
    }

    .faq-item:hover {
        background: #754fdd;
        color: white;
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .faq-item:hover .faq-question {
        color: white;
    }

    .faq-question {
        font-size: 18px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #333;
    }

    .faq-toggle-icon {
        transition: transform 0.3s ease;
    }

    .faq-answer {
        margin-top: 10px;
        color: #555;
        display: none;
        line-height: 1.6;
    }
    .faq-answer:hover {
        color: white;
    }
    .faq-question:hover {
        color: white;
    }

    .faq-item.active .faq-answer {
        display: block;
        color: white;
    }

    .faq-item.active .faq-toggle-icon {
        transform: rotate(180deg);
    }
</style>

<div class="faq-container">

    <h1 class="faq-title">Frequently Asked Questions</h1>
    <p class="faq-subtext">Find answers to the most common questions about ordering, payments, and product management.</p>

    <!-- FAQ 1 -->
    <div class="faq-item">
        <div class="faq-question">
            How do I place an order?
            <span class="faq-toggle-icon">⌄</span>
        </div>
        <div class="faq-answer">
            To place an order, simply add items to your cart and proceed to checkout.  
            Enter your shipping address, contact number, and preferred payment method.  
            Once completed, your order will be processed immediately.
        </div>
    </div>

    <!-- FAQ 2 -->
    <div class="faq-item">
        <div class="faq-question">
            What payment methods are accepted?
            <span class="faq-toggle-icon">⌄</span>
        </div>
        <div class="faq-answer">
            We accept a variety of payment methods including Cash on Delivery (COD),  
            GCash, bank transfer, and other available digital wallets.  
            Additional payment options may be added in the future.
        </div>
    </div>

    <!-- FAQ 3 -->
    <div class="faq-item">
        <div class="faq-question">
            How long does delivery take?
            <span class="faq-toggle-icon">⌄</span>
        </div>
        <div class="faq-answer">
            Delivery usually takes 2–5 days depending on your location  
            and the availability of the courier.  
            You will be notified once your order is out for delivery.
        </div>
    </div>

    <!-- FAQ 4 -->
    <div class="faq-item">
        <div class="faq-question">
            Can I cancel or edit my order?
            <span class="faq-toggle-icon">⌄</span>
        </div>
        <div class="faq-answer">
            If your order is still marked as <b>Undelivered</b>, you may contact support  
            to request a cancellation or modification. Once delivered, orders  
            can no longer be changed.
        </div>
    </div>

    <!-- FAQ 5 -->
    <div class="faq-item">
        <div class="faq-question">
            I am a seller — how do I add or edit products?
            <span class="faq-toggle-icon">⌄</span>
        </div>
        <div class="faq-answer">
            Go to your Seller Dashboard and open the Products page.  
            From there, you can add new items, edit existing products,  
            change prices, upload new images, and manage availability.
        </div>
    </div>

    <!-- FAQ 6 -->
    <div class="faq-item">
        <div class="faq-question">
            Why can’t I see pagination in some pages?
            <span class="faq-toggle-icon">⌄</span>
        </div>
        <div class="faq-answer">
            Pagination only appears when there are more items than the page limit.  
            If the list is short, the pagination bar is automatically hidden.
        </div>
    </div>

</div>

<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>

@endsection
