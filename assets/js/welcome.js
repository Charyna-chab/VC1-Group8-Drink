// public/assets/js/welcome.js
document.addEventListener('DOMContentLoaded', function() {
    // Product search functionality
    const searchInput = document.getElementById('productSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');
            let foundProducts = false;

            productCards.forEach(card => {
                const productName = card.querySelector('h4').textContent.toLowerCase();
                const productDesc = card.querySelector('.description').textContent.toLowerCase();

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
    const categoryItems = document.querySelectorAll('.category-item');
    if (categoryItems.length > 0) {
        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                categoryItems.forEach(i => i.classList.remove('active'));

                // Add active class to clicked item
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
        },
        4: {
            id: 4,
            name: 'Brown Sugar Boba Milk',
            description: 'Fresh milk with brown sugar syrup and chewy boba pearls.',
            price: 5.75,
            image: '/assets/images/products/brown-sugar-boba.jpg'
        },
        5: {
            id: 5,
            name: 'Strawberry Fruit Tea',
            description: 'Refreshing tea with fresh strawberry puree and fruit bits.',
            price: 4.75,
            image: '/assets/images/products/strawberry-tea.jpg'
        },
        6: {
            id: 6,
            name: 'Mango Fruit Tea',
            description: 'Tropical mango flavor blended with our premium tea.',
            price: 4.75,
            image: '/assets/images/products/mango-tea.jpg'
        },
        9: {
            id: 9,
            name: 'Strawberry Smoothie',
            description: 'Creamy smoothie with fresh strawberries and milk.',
            price: 4.99,
            image: '/assets/images/products/strawberry-smoothie.jpg'
        },
        10: {
            id: 10,
            name: 'Mango Smoothie',
            description: 'Tropical mango smoothie with fresh mango puree and milk.',
            price: 5.50,
            image: '/assets/images/products/mango-smoothie.jpg'
        },
        11: {
            id: 11,
            name: 'Avocado Smoothie',
            description: 'Creamy avocado smoothie with fresh avocado and milk.',
            price: 6.00,
            image: '/assets/images/products/avocado-smoothie.jpg'
        },
        14: {
            id: 14,
            name: 'Caramel Macchiato',
            description: 'Espresso with steamed milk and caramel syrup.',
            price: 4.75,
            image: '/assets/images/products/caramel-macchiato.jpg'
        },
        17: {
            id: 17,
            name: 'Egg Waffles',
            description: 'Crispy on the outside, fluffy on the inside Hong Kong style egg waffles.',
            price: 4.00,
            image: '/assets/images/products/egg-waffles.jpg'
        },
        18: {
            id: 18,
            name: 'Popcorn Chicken',
            description: 'Crispy Taiwanese-style popcorn chicken with special seasoning.',
            price: 5.50,
            image: '/assets/images/products/popcorn-chicken.jpg'
        }
    };

    // Open modal when order button is clicked
    orderButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const product = products[productId];

            if (!product) {
                showToast('error', 'Error', 'Product not found');
                return;
            }

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
        const productId = document.getElementById('product_id').value;
        if (!basePrice && productId) {
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

    // Show Popular Drinks Section
    document.getElementById('showPopularDrinks').addEventListener('click', function() {
        const popularDrinksSection = document.getElementById('popularDrinksSection');
        const popularDishesContainer = document.getElementById('popularDishesContainer');
        const noPopularDrinksMessage = document.getElementById('noPopularDrinksMessage');

        // Fetch popular drinks data (this is a placeholder, replace with actual data fetching logic)
        const popularDrinks = [
            {
                id: 9,
                name: 'Strawberry Smoothie',
                image: '/assets/images/products/strawberry-smoothie.jpg',
                price: '$4.99',
                description: 'Top seller this week!'
            },
            // ...more popular drinks...
        ];

        // Clear existing popular drinks
        popularDishesContainer.innerHTML = '';

        if (popularDrinks.length > 0) {
            popularDrinks.forEach(drink => {
                const drinkCard = document.createElement('div');
                drinkCard.className = 'product-card';
                drinkCard.dataset.category = 'smoothie';
                drinkCard.innerHTML = `
                    <div class="product-image">
                        <img src="${drink.image}" alt="${drink.name}">
                        <button class="favorite-btn">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="product-info">
                        <h4>${drink.name}</h4>
                        <p class="description">${drink.description}</p>
                        <div class="product-price">${drink.price}</div>
                    </div>
                    <div class="product-actions">
                        <button class="btn-primary order-btn" data-product-id="${drink.id}">Add to Cart</button>
                    </div>
                `;
                popularDishesContainer.appendChild(drinkCard);
            });
            noPopularDrinksMessage.style.display = 'none';
        } else {
            noPopularDrinksMessage.style.display = 'block';
        }

        popularDrinksSection.style.display = 'block';
    });
});