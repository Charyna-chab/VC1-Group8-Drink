document.addEventListener('DOMContentLoaded', function() {
    // Load favorites from localStorage
    loadFavorites();

    // Remove from favorites functionality
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

    // Order button functionality
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
                    <p class="favorites-description">${item.description}</p>
                    
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
        const removeButtons = grid.querySelectorAll('.favorites-remove-btn');
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

        const orderButtons = grid.querySelectorAll('.favorites-order-btn');
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
                <a href="/menu" class="favorites-browse-btn">Browse Menu</a>
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

    // Add keyframes for fadeOut animation if not already in the document
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
        `;
        document.head.appendChild(style);
    }
});