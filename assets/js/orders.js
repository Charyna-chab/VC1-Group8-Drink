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
                showToast('success', 'Added to Favorites', 'Item added to your favorites list');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                showToast('info', 'Removed from Favorites', 'Item removed from your favorites list');
            }
        });
    });

    // Order modal functionality
    const orderButtons = document.querySelectorAll('.order-btn');
    const orderModal = document.getElementById('orderModal');
    const closeModalBtn = document.querySelector('.close-modal');
    const cancelOrderBtn = document.getElementById('cancelOrder');

    // Sample product data (in a real app, this would come from the server)
    const products = {
        1: {
            id: 1,
            name: 'Classic Milk Tea',
            description: 'Our signature milk tea with premium black tea and creamy milk.',
            price: 4.50,
            image: '/assets/images/products/classic-milk-tea.jpg'
        },
        2: {
            id: 2,
            name: 'Taro Milk Tea',
            description: 'Creamy taro flavor blended with our premium milk tea.',
            price: 5.00,
            image: '/assets/images/products/taro-milk-tea.jpg'
        },
        3: {
            id: 3,
            name: 'Matcha Latte',
            description: 'Premium Japanese matcha powder with fresh milk.',
            price: 5.50,
            image: '/assets/images/products/matcha-latte.jpg'
        }
    };

    // Open modal when order button is clicked
    orderButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const product = products[productId];

            // Populate modal with product details
            document.getElementById('product_id').value = product.id;
            document.querySelector('.modal-product-image').src = product.image;
            document.querySelector('.modal-product-name').textContent = product.name;
            document.querySelector('.modal-product-description').textContent = product.description;
            document.querySelector('.modal-product-price').textContent = '$' + product.price.toFixed(2);

            // Calculate initial total price
            updateTotalPrice(product.price);

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

    if (quantityInput) {
        quantityInput.addEventListener('change', updateTotalPrice);
    }

    // Calculate and update total price
    function updateTotalPrice(basePrice) {
        if (!basePrice) {
            const productId = document.getElementById('product_id').value;
            basePrice = products[productId].price;
        }

        let sizePrice = 0;
        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (selectedSize) {
            sizePrice = parseFloat(selectedSize.getAttribute('data-price'));
        }

        let toppingsPrice = 0;
        const selectedToppings = document.querySelectorAll('input[name="toppings[]"]:checked');
        selectedToppings.forEach(topping => {
            toppingsPrice += parseFloat(topping.getAttribute('data-price'));
        });

        const quantity = parseInt(quantityInput.value);

        const totalPrice = (basePrice + sizePrice + toppingsPrice) * quantity;
        document.querySelector('.price-value').textContent = '$' + totalPrice.toFixed(2);
    }

    // Form submission
    const customizeForm = document.getElementById('customizeForm');
    if (customizeForm) {
        customizeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const productId = formData.get('product_id');
            const product = products[productId];
            const size = formData.get('size');
            const sugar = formData.get('sugar') + '%';
            const ice = formData.get('ice') + '%';
            const toppings = formData.getAll('toppings[]');
            const quantity = formData.get('quantity');

            // Close modal
            closeModal();

            // Show success toast
            showToast('success', 'Order Added', `${quantity}x ${product.name} added to your cart`);

            // Update booking badge
            const bookingBadge = document.querySelector('.booking-badge');
            if (bookingBadge) {
                const currentCount = parseInt(bookingBadge.textContent);
                bookingBadge.textContent = currentCount + 1;
                bookingBadge.style.display = 'inline-flex';
            }

            // Update notification badge
            const notificationBadge = document.getElementById('notification-badge');
            if (notificationBadge) {
                const currentCount = parseInt(notificationBadge.textContent);
                notificationBadge.textContent = currentCount + 1;
                notificationBadge.style.display = 'inline-flex';
            }

            // Redirect to booking page after a short delay
            setTimeout(() => {
                window.location.href = '/booking';
            }, 1500);
        });
    }

    // Toast notification
    function showToast(type, title, message) {
        const toastContainer = document.getElementById('toastContainer');

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        let icon = '';
        if (type === 'success') {
            icon = 'check';
        } else if (type === 'error') {
            icon = 'x';
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

    // Booking page functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    if (filterTabs.length > 0) {
        filterTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                filterTabs.forEach(t => t.classList.remove('active'));

                // Add active class to clicked tab
                this.classList.add('active');

                // Filter bookings by status
                const status = this.getAttribute('data-status');
                const bookingCards = document.querySelectorAll('.booking-card');

                bookingCards.forEach(card => {
                    if (status === 'all') {
                        card.style.display = 'block';
                    } else {
                        const cardStatus = card.getAttribute('data-status');
                        card.style.display = cardStatus === status ? 'block' : 'none';
                    }
                });
            });
        });
    }

    // Cancel booking functionality
    const cancelButtons = document.querySelectorAll('.cancel-booking-btn');
    if (cancelButtons.length > 0) {
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.getAttribute('data-id');

                // In a real application, you would send an AJAX request to cancel the booking
                // For now, we'll just show a confirmation dialog and a toast
                if (confirm('Are you sure you want to cancel this order?')) {
                    showToast('info', 'Order Cancelled', 'Your order has been cancelled successfully');

                    // Update the booking card status
                    const bookingCard = this.closest('.booking-card');
                    if (bookingCard) {
                        bookingCard.setAttribute('data-status', 'cancelled');
                        const statusElement = bookingCard.querySelector('.booking-status');
                        if (statusElement) {
                            statusElement.textContent = 'Cancelled';
                            statusElement.className = 'booking-status cancelled';
                        }

                        // Remove cancel button
                        this.remove();
                    }
                }
            });
        });
    }

    // Notification button functionality
    const notificationBtn = document.getElementById('notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            // In a real application, you would show a dropdown with notifications
            // For now, we'll just reset the badge count
            const badge = this.querySelector('#notification-badge');
            badge.textContent = '0';
            badge.style.display = 'none';

            showToast('info', 'Notifications Cleared', 'All notifications have been marked as read');
        });
    }
});

function showCategory(category) {
    // Hide all categories
    var contents = document.querySelectorAll('.category-content');
    contents.forEach(function(content) {
        content.style.display = 'none';
    });

    // Show the clicked category
    var categoryContent = document.getElementById(category);
    if (categoryContent) {
        categoryContent.style.display = 'block';
    }
}