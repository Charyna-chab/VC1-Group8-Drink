// assets/js/order.js
document.addEventListener('DOMContentLoaded', function() {
            // Product search functionality
            const searchInput = document.getElementById('productSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const productCards = document.querySelectorAll('.product-card');
                    let foundProducts = false;

                    productCards.forEach(card => {
                        const productName = card.querySelector('h3').textContent.toLowerCase();
                        const productDesc = card.querySelector('p').textContent.toLowerCase();

                        if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                            card.style.display = 'block';
                            foundProducts = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Show/hide no products message
                    const noProductMessage = document.getElementById('no-product-message');
                    if (noProductMessage) {
                        noProductMessage.style.display = foundProducts ? 'none' : 'block';
                    }
                });
            }

            // Category filter functionality
            const categoryButtons = document.querySelectorAll('.category-btn');
            if (categoryButtons.length > 0) {
                categoryButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        categoryButtons.forEach(btn => btn.classList.remove('active'));

                        // Add active class to clicked button
                        this.classList.add('active');

                        // Filter products by category
                        const category = this.getAttribute('data-category');
                        const productCards = document.querySelectorAll('.product-card');
                        let foundProducts = false;

                        productCards.forEach(card => {
                            if (category === 'all') {
                                card.style.display = 'block';
                                foundProducts = true;
                            } else {
                                const cardCategory = card.getAttribute('data-category');
                                if (cardCategory === category) {
                                    card.style.display = 'block';
                                    foundProducts = true;
                                } else {
                                    card.style.display = 'none';
                                }
                            }
                        });

                        // Show/hide no products message
                        const noProductMessage = document.getElementById('no-product-message');
                        if (noProductMessage) {
                            noProductMessage.style.display = foundProducts ? 'none' : 'block';
                        }
                    });
                });
            }

            // Favorite button functionality
            const favoriteButtons = document.querySelectorAll('.favorite-btn');
            favoriteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const icon = this.querySelector('i');
                    const productId = this.getAttribute('data-product-id');

                    // Toggle favorite status
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        showToast('success', 'Added to Favorites', 'Item added to your favorites list');

                        // Send AJAX request to add to favorites
                        fetch('/favorites/add', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ product_id: productId })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) {
                                    // Revert UI if request failed
                                    icon.classList.remove('fas');
                                    icon.classList.add('far');
                                    showToast('error', 'Error', data.message || 'Failed to add to favorites');
                                }
                            })
                            .catch(error => {
                                // Revert UI if request failed
                                icon.classList.remove('fas');
                                icon.classList.add('far');
                                showToast('error', 'Error', 'Failed to add to favorites');
                            });
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        showToast('info', 'Removed from Favorites', 'Item removed from your favorites list');

                        // Send AJAX request to remove from favorites
                        fetch('/favorites/remove', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ product_id: productId })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) {
                                    // Revert UI if request failed
                                    icon.classList.remove('far');
                                    icon.classList.add('fas');
                                    showToast('error', 'Error', data.message || 'Failed to remove from favorites');
                                }
                            })
                            .catch(error => {
                                // Revert UI if request failed
                                icon.classList.remove('far');
                                icon.classList.add('fas');
                                showToast('error', 'Error', 'Failed to remove from favorites');
                            });
                    }
                });
            });

            // Order modal functionality
            const orderButtons = document.querySelectorAll('.order-btn');
            const orderModal = document.getElementById('orderModal');
            const closeModalBtn = document.querySelector('.close-modal');
            const cancelOrderBtn = document.getElementById('cancelOrder');

            // Open modal when order button is clicked
            orderButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productCard = this.closest('.product-card');

                    if (!productCard) {
                        showToast('error', 'Error', 'Product not found');
                        return;
                    }

                    // Get product details from the card
                    const productName = productCard.querySelector('h3').textContent;
                    const productDesc = productCard.querySelector('p').textContent;
                    const productPrice = productCard.querySelector('.product-price').textContent.replace('$', '');
                    const productImage = productCard.querySelector('img').src;

                    // Populate modal with product details
                    document.getElementById('product_id').value = productId;
                    document.querySelector('.modal-product-image').src = productImage;
                    document.querySelector('.modal-product-name').textContent = productName;
                    document.querySelector('.modal-product-description').textContent = productDesc;
                    document.querySelector('.modal-product-price').textContent = '$' + productPrice;

                    // Reset form
                    document.getElementById('customizeForm').reset();

                    // Set default values
                    document.querySelector('input[name="size"][value="medium"]').checked = true;
                    document.querySelector('input[name="sugar"][value="50"]').checked = true;
                    document.querySelector('input[name="ice"][value="100"]').checked = true;
                    document.querySelector('input[name="quantity"]').value = 1;

                    // Calculate initial total price
                    updateTotalPrice(parseFloat(productPrice));

                    // Show modal
                    orderModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Close modal
            function closeModal() {
                orderModal.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', closeModal);
            }

            if (cancelOrderBtn) {
                cancelOrderBtn.addEventListener('click', closeModal);
            }

            // Close modal when clicking outside
            orderModal.addEventListener('click', function(e) {
                if (e.target === orderModal) {
                    closeModal();
                }
            });

            // Quantity controls
            const minusBtn = document.querySelector('.minus-btn');
            const plusBtn = document.querySelector('.plus-btn');
            const quantityInput = document.querySelector('input[name="quantity"]');

            if (minusBtn && plusBtn && quantityInput) {
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

                // Ensure quantity is within valid range when manually changed
                quantityInput.addEventListener('change', function() {
                        let quantity = parseInt(this.value);
                        if
                        function() {
                            let quantity = parseInt(this.value);
                            if (isNaN(quantity) || quantity < 1) {
                                this.value = 1;
                                quantity = 1;
                            } else if (quantity > 10) {
                                this.value = 10;
                                quantity = 10;
                            }
                            updateTotalPrice();
                        });
                }

                // Update total price when options change
                const sizeInputs = document.querySelectorAll('input[name="size"]');
                const toppingInputs = document.querySelectorAll('input[name="toppings[]"]');

                if (sizeInputs.length > 0) {
                    sizeInputs.forEach(input => {
                        input.addEventListener('change', updateTotalPrice);
                    });
                }

                if (toppingInputs.length > 0) {
                    toppingInputs.forEach(input => {
                        input.addEventListener('change', updateTotalPrice);
                    });
                }

                // Calculate and update total price
                function updateTotalPrice(basePrice) {
                    if (!basePrice) {
                        const productPriceElement = document.querySelector('.modal-product-price');
                        if (productPriceElement) {
                            basePrice = parseFloat(productPriceElement.textContent.replace('$', ''));
                        } else {
                            basePrice = 0;
                        }
                    }

                    let sizePrice = 0;
                    const selectedSize = document.querySelector('input[name="size"]:checked');
                    if (selectedSize) {
                        sizePrice = parseFloat(selectedSize.getAttribute('data-price') || 0);
                    }

                    let toppingsPrice = 0;
                    const selectedToppings = document.querySelectorAll('input[name="toppings[]"]:checked');
                    selectedToppings.forEach(topping => {
                        toppingsPrice += parseFloat(topping.getAttribute('data-price') || 0);
                    });

                    const quantity = parseInt(quantityInput.value || 1);

                    const totalPrice = (basePrice + sizePrice + toppingsPrice) * quantity;
                    const priceValueElement = document.querySelector('.price-value');
                    if (priceValueElement) {
                        priceValueElement.textContent = '$' + totalPrice.toFixed(2);
                    }
                }

                // Form submission
                const customizeForm = document.getElementById('customizeForm');
                if (customizeForm) {
                    customizeForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        // Get form data
                        const formData = new FormData(this);
                        const productId = formData.get('product_id');
                        const productName = document.querySelector('.modal-product-name').textContent;
                        const size = formData.get('size');
                        const sugar = formData.get('sugar') + '%';
                        const ice = formData.get('ice') + '%';
                        const toppings = formData.getAll('toppings[]');
                        const quantity = formData.get('quantity');
                        const instructions = formData.get('instructions');
                        const totalPrice = document.querySelector('.price-value').textContent;

                        // Create order data object
                        const orderData = {
                            product_id: productId,
                            product_name: productName,
                            size: size,
                            sugar: sugar,
                            ice: ice,
                            toppings: toppings,
                            quantity: quantity,
                            instructions: instructions,
                            total_price: totalPrice.replace('$', '')
                        };

                        // Send AJAX request to add to cart
                        fetch('/cart/add', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(orderData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Close modal
                                    closeModal();

                                    // Show success toast
                                    showToast('success', 'Order Added', `${quantity}x ${productName} added to your cart`);

                                    // Update cart count if available
                                    const cartBadge = document.querySelector('.cart-badge');
                                    if (cartBadge) {
                                        const currentCount = parseInt(cartBadge.textContent || '0');
                                        cartBadge.textContent = currentCount + 1;
                                        cartBadge.classList.add('active');
                                    }

                                    // Redirect to booking page after a short delay
                                    setTimeout(() => {
                                        window.location.href = '/booking';
                                    }, 1500);
                                } else {
                                    showToast('error', 'Error', data.message || 'Failed to add to cart');
                                }
                            })
                            .catch(error => {
                                showToast('error', 'Error', 'Failed to add to cart');
                                console.error('Error:', error);

                                // For demo purposes, simulate success if the API endpoint doesn't exist
                                closeModal();
                                showToast('success', 'Order Added', `${quantity}x ${productName} added to your cart`);
                                setTimeout(() => {
                                    window.location.href = '/booking';
                                }, 1500);
                            });
                    });
                }

                // Toast notification
                function showToast(type, title, message) {
                    const toastContainer = document.getElementById('toastContainer');
                    if (!toastContainer) return;

                    const toast = document.createElement('div');
                    toast.className = `toast ${type}`;

                    let icon = '';
                    if (type === 'success') {
                        icon = 'check';
                    } else if (type === 'error') {
                        icon = 'times';
                    } else {
                        icon = 'info';
                    }

                    toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${icon}"></i>
            </div>
            <div class="toast-content">
                <h4 class="toast-title">${title}</h4>
                <p class="toast-message">${message}</p>
            </div>
            <button class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;

                    toastContainer.appendChild(toast);

                    // Auto remove toast after 5 seconds
                    setTimeout(() => {
                        toast.style.animation = 'slideOut 0.3s forwards';
                        setTimeout(() => {
                            toast.remove();
                        }, 300);
                    }, 5000);

                    // Close toast on click
                    const closeBtn = toast.querySelector('.toast-close');
                    closeBtn.addEventListener('click', function() {
                        toast.style.animation = 'slideOut 0.3s forwards';
                        setTimeout(() => {
                            toast.remove();
                        }, 300);
                    });
                }
            });