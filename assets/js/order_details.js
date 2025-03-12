// public/assets/js/order.js
document.addEventListener('DOMContentLoaded', function() {
    // Product search functionality
    const searchInput = document.getElementById('productSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const productName = card.querySelector('h3').textContent.toLowerCase();
                const productDesc = card.querySelector('p').textContent.toLowerCase();

                if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Category filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Filter products by category
                const category = this.getAttribute('data-category');
                const productCards = document.querySelectorAll('.product-card');

                productCards.forEach(card => {
                    if (category === 'all') {
                        card.style.display = 'block';
                    } else {
                        // In a real application, you would add data-category attributes to your product cards
                        // For now, we'll just show all products
                        card.style.display = 'block';
                    }
                });
            });
        });
    }

    // Favorite button functionality
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');

            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                // In a real application, you would send an AJAX request to add to favorites
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                // In a real application, you would send an AJAX request to remove from favorites
            }
        });
    });

    // Order details page functionality
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        // Quantity controls
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');
        const quantityInput = document.querySelector('input[name="quantity"]');

        minusBtn.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
                updateTotalPrice();
            }
        });

        plusBtn.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity < 10) {
                quantityInput.value = quantity + 1;
                updateTotalPrice();
            }
        });

        // Update total price when options change
        const sizeInputs = document.querySelectorAll('input[name="size"]');
        const toppingInputs = document.querySelectorAll('input[name="toppings[]"]');

        sizeInputs.forEach(input => {
            input.addEventListener('change', updateTotalPrice);
        });

        toppingInputs.forEach(input => {
            input.addEventListener('change', updateTotalPrice);
        });

        quantityInput.addEventListener('change', updateTotalPrice);

        // Calculate and update total price
        function updateTotalPrice() {
            const basePrice = parseFloat(document.querySelector('.product-price').textContent.replace('$', ''));
            const selectedSize = document.querySelector('input[name="size"]:checked');
            const sizePrice = selectedSize ? parseFloat(selectedSize.getAttribute('data-price')) : 0;

            let toppingsPrice = 0;
            const selectedToppings = document.querySelectorAll('input[name="toppings[]"]:checked');
            selectedToppings.forEach(topping => {
                toppingsPrice += parseFloat(topping.getAttribute('data-price'));
            });

            const quantity = parseInt(quantityInput.value);

            const totalPrice = (basePrice + sizePrice + toppingsPrice) * quantity;
            document.querySelector('.total-value').textContent = '$' + totalPrice.toFixed(2);
        }

        // Form submission
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // In a real application, you would send an AJAX request to add to cart
            // For now, we'll just show an alert
            alert('Item added to cart!');

            // Redirect to cart page or stay on the same page
            // window.location.href = '/cart';
        });
    }
});