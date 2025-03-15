document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const orderButtons = document.querySelectorAll('.order-btn');
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    const categoryButtons = document.querySelectorAll('.category-btn');
    const searchInput = document.getElementById('productSearch');
    const orderModal = document.getElementById('orderModal');
    const closeModalBtn = document.querySelector('.close-modal');
    const cancelOrderBtn = document.getElementById('cancelOrder');
    const customizeForm = document.getElementById('customizeForm');
    const productCards = document.querySelectorAll('.product-card');
    const quantityInput = document.getElementById('quantity');
    const minusBtn = document.querySelector('.minus-btn');
    const plusBtn = document.querySelector('.plus-btn');
    const priceValue = document.querySelector('.price-value');

    // Variables
    let basePrice = 0;
    let currentProductId = null;

    // Initialize
    function init() {
        // Add event listeners
        orderButtons.forEach(btn => {
            btn.addEventListener('click', openOrderModal);
        });

        favoriteButtons.forEach(btn => {
            btn.addEventListener('click', toggleFavorite);
        });

        categoryButtons.forEach(btn => {
            btn.addEventListener('click', filterProducts);
        });

        if (searchInput) {
            searchInput.addEventListener('input', searchProducts);
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeModal);
        }

        if (cancelOrderBtn) {
            cancelOrderBtn.addEventListener('click', closeModal);
        }

        if (customizeForm) {
            customizeForm.addEventListener('submit', submitOrder);

            // Add event listeners for price calculation
            const sizeInputs = customizeForm.querySelectorAll('input[name="size"]');
            const toppingInputs = customizeForm.querySelectorAll('input[name="toppings[]"]');

            sizeInputs.forEach(input => {
                input.addEventListener('change', calculateTotal);
            });

            toppingInputs.forEach(input => {
                input.addEventListener('change', calculateTotal);
            });
        }

        if (minusBtn) {
            minusBtn.addEventListener('click', decreaseQuantity);
        }

        if (plusBtn) {
            plusBtn.addEventListener('click', increaseQuantity);
        }

        if (quantityInput) {
            quantityInput.addEventListener('change', calculateTotal);
        }

        // Add animation to product cards
        productCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    // Open Order Modal
    function openOrderModal(e) {
        e.preventDefault();

        const productId = this.dataset.productId || this.closest('.product-card').dataset.id;
        currentProductId = productId;

        // Get product details via AJAX
        fetch(`/api/products/${productId}`)
            .then(response => response.json())
            .then(product => {
                // Set product details in modal
                document.getElementById('product_id').value = product.id;
                document.querySelector('.modal-product-name').textContent = product.name;
                document.querySelector('.modal-product-description').textContent = product.description;
                document.querySelector('.modal-product-price').textContent = `$${product.price.toFixed(2)}`;
                document.querySelector('.modal-product-image').src = product.image;

                // Set base price
                basePrice = product.price;

                // Calculate initial total
                calculateTotal();

                // Show modal
                orderModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
                showToast('error', 'Failed to load product details. Please try again.');
            });
    }

    // Close Modal
    function closeModal() {
        orderModal.classList.remove('active');
        document.body.style.overflow = '';

        // Reset form
        if (customizeForm) {
            customizeForm.reset();
        }
    }

    // Calculate Total Price
    function calculateTotal() {
        if (!basePrice) return;

        let total = basePrice;

        // Add size price
        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (selectedSize) {
            total += parseFloat(selectedSize.dataset.price || 0);
        }

        // Add toppings price
        const selectedToppings = document.querySelectorAll('input[name="toppings[]"]:checked');
        selectedToppings.forEach(topping => {
            total += parseFloat(topping.dataset.price || 0);
        });

        // Multiply by quantity
        const quantity = parseInt(quantityInput.value) || 1;
        total *= quantity;

        // Update price display
        priceValue.textContent = `$${total.toFixed(2)}`;
    }

    // Decrease Quantity
    function decreaseQuantity() {
        const currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            calculateTotal();
        }
    }

    // Increase Quantity
    function increaseQuantity() {
        const currentValue = parseInt(quantityInput.value) || 1;
        if (currentValue < 10) {
            quantityInput.value = currentValue + 1;
            calculateTotal();
        }
    }

    // Submit Order
    function submitOrder(e) {
        e.preventDefault();

        const formData = new FormData(customizeForm);
        const orderData = {
            product_id: formData.get('product_id'),
            size: formData.get('size'),
            sugar: formData.get('sugar'),
            ice: formData.get('ice'),
            toppings: Array.from(formData.getAll('toppings[]')),
            instructions: formData.get('instructions'),
            quantity: formData.get('quantity')
        };

        // Send order data to server
        fetch('/api/orders/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    showToast('success', 'Item added to cart successfully!');
                } else {
                    showToast('error', data.message || 'Failed to add item to cart.');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                showToast('error', 'An error occurred. Please try again.');
            });
    }

    // Toggle Favorite
    function toggleFavorite(e) {
        e.preventDefault();
        e.stopPropagation();

        const button = this;
        const productId = button.dataset.id || button.closest('.product-card').dataset.id;
        const icon = button.querySelector('i');

        // Check if already favorited
        const isFavorite = icon.classList.contains('fas');

        // Send request to server
        fetch(`/api/favorites/${isFavorite ? 'remove' : 'add'}/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle icon
                    if (isFavorite) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        showToast('success', 'Removed from favorites');
                    } else {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        showToast('success', 'Added to favorites');

                        // Ask if user wants to go to favorites page
                        if (confirm('Item added to favorites! Would you like to view your favorites?')) {
                            window.location.href = '/favorites';
                        }
                    }
                } else {
                    showToast('error', data.message || 'Failed to update favorites.');
                }
            })
            .catch(error => {
                console.error('Error updating favorites:', error);
                showToast('error', 'An error occurred. Please try again.');
            });
    }

    // Filter Products by Category
    function filterProducts() {
        const category = this.dataset.category;

        // Update active button
        categoryButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        this.classList.add('active');

        // Filter products
        productCards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Search Products
    function searchProducts() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        productCards.forEach(card => {
            const productName = card.querySelector('h3').textContent.toLowerCase();
            const productDescription = card.querySelector('p').textContent.toLowerCase();

            if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Show Toast Notification
    function showToast(type, message) {
        const toastContainer = document.getElementById('toastContainer');

        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <div class="toast-content">
          <div class="toast-title">${type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Information'}</div>
          <div class="toast-message">${message}</div>
        </div>
      `;

        toastContainer.appendChild(toast);

        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Initialize
    init();
});