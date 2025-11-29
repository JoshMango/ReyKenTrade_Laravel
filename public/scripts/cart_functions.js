// Cart styling functions only - no backend logic
function cartTotalCalculation() {
    let total_checkout;
    const cartTotalElement = document.getElementById('cart-total-amount'); 
    let cartTotalPrice = 0;
    const itemPrices = document.querySelectorAll(".item-price");
    itemPrices.forEach(itemPrice => {
        const priceText = itemPrice.textContent.replace('₱', '').replace(',', '');
        const priceValue = parseFloat(priceText);
        if (!isNaN(priceValue)) {
            cartTotalPrice += priceValue;
        }
    });
    if (cartTotalElement) {
        cartTotalElement.textContent = `Total: ₱${cartTotalPrice.toFixed(2)}`;
        // Check if on checkout page
        if (document.querySelector('.checkout-content')) {
            total_checkout = document.getElementById('checkout-total-amount');
            if (total_checkout) {
                total_checkout.textContent = `Total: ₱${cartTotalPrice.toFixed(2)}`;
            }
        } 
    } 
}

// Calculate total on page load
document.addEventListener('DOMContentLoaded', function() {
    cartTotalCalculation();
});
