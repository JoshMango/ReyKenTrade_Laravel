// Seller landing page styling only - all backend logic handled by PHP
// Modal toggle for adding products
document.addEventListener('DOMContentLoaded', function() {
    const addListingButton = document.getElementById('add-listing-button');
    const addProductModal = document.getElementById('add-product-modal');
    
    if (addListingButton && addProductModal) {
        addListingButton.addEventListener('click', function() {
            addProductModal.style.display = 'block';
        });
    }
});
