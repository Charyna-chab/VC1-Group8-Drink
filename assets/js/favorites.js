// assets/js/favorites.js
document.addEventListener('DOMContentLoaded', function() {
    // Load favorites from localStorage
    loadFavorites();

    // Remove from favorites functionality
    setupRemoveButtons();

    // Order button functionality
    setupOrderButtons();

    // Function to load favorites from localStorage
    function loadFavorites() {
        const favorites = getFavorites();
        const favoritesGrid = document.querySelector('.favorites-grid');
        const emptyState = document.querySelector('.favorites-empty');

        // If no favorites in localStorage, show empty state
        if (favorites.length === 0 && favoritesGrid) {
            favoritesGrid.style.display = 'none';
            if (emptyState) emptyState.style.display = 'block';
            return;
        }

        // If we have favorites but no grid (PHP didn't render any), create the grid
        if (favorites.length > 0 && !favoritesGrid) {
            createFavoritesGrid(favorites);
        }
    }

    // Function to create favorites grid dynamically
    function createFavoritesGrid(favorites) {
        const content = document.querySelector('.content');
        const emptyState = document.querySelector('.favorites-empty');

        if (emptyState) emptyState.style.display = 'none';

        const grid = document.createElement('div');
        grid.className = 'favorites-grid';

        favorites.forEach(item => {
            const card = document.createElement('div');
            card.className = 'favorites-card';
            card.setAttribute('data-id', item.id);

            card.innerHTML = `
                <button class="favorites-remove-btn" data-id="${item.id}">
                    <i class="fas fa-times"></i>
                    <span class="sr-only">Remove from favorites</span>
                </button>
                
                <div class="favorites-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                
                <div class="favorites-content">
                    <h3 class="favorites-title">${item.name}</h3>
                    <p class="favorites-description">${item.description || 'A delicious drink from Xing Fu Cha'}</p>
                    
                    <div class="favorites-footer">
                        <div class="favorites-price">
                            $${parseFloat(item.price).toFixed(2)}
                        </div>
                        <button class="favorites-order-btn" 
                                data-id="${item.id}"
                                data-name="${item.name}"
                                data-price="${item.price}"
                                data-image="${item.image}">
                            Order Now
                        </button>
                    </div>
                </div>
            `;

            grid.appendChild(card);
        });

        content.appendChild(grid);

        // Add event listeners to the new buttons
        setupRemoveButtons();
        setupOrderButtons();
    }

    // Setup remove buttons
    function setupRemoveButtons() {
        const removeButtons = document.querySelectorAll('.favorites-remove-btn');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                removeFavorite(itemId);

                // Remove the card with animation
                const card = this.closest('.favorites-card');
                card.style.animation = 'fadeOut 0.5s ease forwards';

                setTimeout(() => {
                    card.remove();

                    // Check if there are any favorites left
                    const remainingCards = document.querySelectorAll('.favorites-card');
                    if (remainingCards.length === 0) {
                        showEmptyState();
                    }
                }, 500);

                showToast('info', 'Removed from Favorites', 'Item removed from your favorites list');
            });
        });
    }

    // Setup order buttons
    function setupOrderButtons() {
        const orderButtons = document.querySelectorAll('.favorites-order-btn');
        orderButtons.forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                const itemName = this.getAttribute('data-name');

                showToast('success', 'Order Started', `Adding ${itemName} to your order`);

                // Redirect to order page with product ID
                setTimeout(() => {
                    window.location.href = `/order?product_id=${itemId}`;
                }, 1000);
            });
        });
    }

    // Function to show empty state
    function showEmptyState() {
        const content = document.querySelector('.content');
        const grid = document.querySelector('.favorites-grid');

        if (grid) grid.style.display = 'none';

        // Check if empty state already exists
        let emptyState = document.querySelector('.favorites-empty');

        if (!emptyState) {
            emptyState = document.createElement('div');
            emptyState.className = 'favorites-empty';

            emptyState.innerHTML = `
                <img src="/assets/images/empty-favorites.svg" alt="No Favorites">
                <h3>No Favorites Yet</h3>
                <p>You haven't added any favorites yet. Browse our menu and add items to your favorites!</p>
                <a href="/order" class="favorites-browse-btn">Browse Menu</a>
            `;

            content.appendChild(emptyState);
        } else {
            emptyState.style.display = 'block';
        }
    }

    // Function to remove favorite from localStorage
    function removeFavorite(id) {
        let favorites = getFavorites();
        favorites = favorites.filter(fav => fav.id !== id);
        localStorage.setItem('favorites', JSON.stringify(favorites));
    }

    // Function to get favorites from localStorage
    function getFavorites() {
        const favorites = localStorage.getItem('favorites');
        return favorites ? JSON.parse(favorites) : [];
    }

    // Toast notification
    function showToast(type, title, message) {
        const toastContainer = document.querySelector('.favorites-toast-container');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `favorites-toast ${type}`;

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info-circle'}"></i>
            </div>
            <div class="toast-content">
                <h4>${title}</h4>
                <p>${message}</p>
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

    // Add keyframes for animations if not already in the document
    if (!document.querySelector('style#favorites-animations')) {
        const style = document.createElement('style');
        style.id = 'favorites-animations';
        style.textContent = `
            @keyframes fadeOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(20px);
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            .favorites-card {
                position: relative;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .favorites-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }
            
            .favorites-remove-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                background-color: white;
                border: none;
                border-radius: 50%;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                z-index: 2;
                transition: transform 0.3s ease;
            }
            
            .favorites-remove-btn:hover {
                transform: rotate(90deg);
            }
            
            .favorites-image {
                height: 180px;
                overflow: hidden;
            }
            
            .favorites-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }
            
            .favorites-card:hover .favorites-image img {
                transform: scale(1.1);
            }
            
            .favorites-content {
                padding: 15px;
            }
            
            .favorites-title {
                margin: 0 0 10px;
                font-size: 18px;
                color: #333;
            }
            
            .favorites-description {
                margin: 0 0 15px;
                font-size: 14px;
                color: #666;
                line-height: 1.4;
                height: 40px;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }
            
            .favorites-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 10px;
            }
            
            .favorites-price {
                font-weight: bold;
                color: #ff5e62;
                font-size: 18px;
            }
            
            .favorites-order-btn {
                background-color: #ff5e62;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 8px 15px;
                cursor: pointer;
                font-weight: 600;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }
            
            .favorites-order-btn:hover {
                background-color: #ff4146;
                transform: scale(1.05);
            }
            
            .favorites-toast-container {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
            }
            
            .favorites-toast {
                display: flex;
                align-items: center;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                padding: 15px;
                margin-top: 10px;
                min-width: 300px;
                animation: slideIn 0.3s forwards;
            }
            
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            .favorites-toast.success {
                border-left: 4px solid #4caf50;
            }
            
            .favorites-toast.error {
                border-left: 4px solid #f44336;
            }
            
            .favorites-toast.info {
                border-left: 4px solid #2196f3;
            }
            
            .toast-icon {
                margin-right: 15px;
                font-size: 20px;
            }
            
            .favorites-toast.success .toast-icon {
                color: #4caf50;
            }
            
            .favorites-toast.error .toast-icon {
                color: #f44336;
            }
            
            .favorites-toast.info .toast-icon {
                color: #2196f3;
            }
            
            .toast-content {
                flex: 1;
            }
            
            .toast-content h4 {
                margin: 0 0 5px;
                font-size: 16px;
            }
            
            .toast-content p {
                margin: 0;
                font-size: 14px;
                color: #666;
            }
            
            .toast-close {
                background: none;
                border: none;
                cursor: pointer;
                color: #999;
                font-size: 16px;
            }
            
            .favorites-empty {
                text-align: center;
                padding: 50px 20px;
            }
            
            .favorites-empty img {
                width: 150px;
                margin-bottom: 20px;
                opacity: 0.7;
            }
            
            .favorites-empty h3 {
                margin: 0 0 10px;
                color: #333;
                font-size: 22px;
            }
            
            .favorites-empty p {
                margin: 0 0 20px;
                color: #666;
                font-size: 16px;
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }
            
            .favorites-browse-btn {
                display: inline-block;
                background-color: #ff5e62;
                color: white;
                text-decoration: none;
                padding: 12px 25px;
                border-radius: 5px;
                font-weight: 600;
                transition: background-color 0.3s ease, transform 0.3s ease;
            }
            
            .favorites-browse-btn:hover {
                background-color: #ff4146;
                transform: scale(1.05);
            }
        `;
        document.head.appendChild(style);
    }
});