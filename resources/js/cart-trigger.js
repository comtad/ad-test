(function () {
    document.addEventListener('click', (e) => {
        if (e.target.closest('[data-cart-btn]')) {
            window.dispatchEvent(new CustomEvent('cart:add'));
        }
    });
})();
