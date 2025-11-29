// Cart sidebar styling and UI interactions only
document.addEventListener('DOMContentLoaded', function() {
    const shoppingCartIcon = document.getElementById("shopping-cart");
    const shoppingSidebar = document.getElementById('shoppingSidebar');
    const closeSidebarBtn = document.querySelector('.close-sidebar-btn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (shoppingCartIcon && shoppingSidebar && closeSidebarBtn && sidebarOverlay) {
        shoppingCartIcon.addEventListener('click', function(event) {
            event.preventDefault();
            shoppingSidebar.classList.add('open');
            sidebarOverlay.classList.add('open');
        });

        closeSidebarBtn.addEventListener('click', function() {
            shoppingSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('open');
        });

        sidebarOverlay.addEventListener('click', function() {
            shoppingSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('open');
        });
    }
});
