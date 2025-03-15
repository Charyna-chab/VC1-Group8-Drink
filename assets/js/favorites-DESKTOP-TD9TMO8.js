document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const favoriteItems = document.querySelectorAll('.favorite-item');
    const removeButtons = document.querySelectorAll('.favorite-remove');
    const orderButtons = document.querySelectorAll('.favorite-order-btn');

    // Initialize
    function init() {
        // Add animation to favorite items
        favoriteItems.forEach((item, index) => {
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Add event listeners
        removeButtons.forEach(btn => {
            btn.addEventListener('click', removeFavorite);
        });

        orderButtons.forEach(btn => {
            btn.addEventListener('click', orderItem);
        });
    }

    // Remove Favorite
    function removeFavorite() {
        const button = this;
        const itemId = button.dataset.id;
        const item = button.closest('.favorite-item');

        // Show confirmation dialog
        if (!confirm('Are you sure you want to remove this item from your favorites?')) {
            return;
        }

        // Send to server
        fetch(`/api/favorites/remove/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove element with animation
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';

                    setTimeout(() => {
                        item.remove();

                        // Check if there are no more favorites
                        if (document.querySelectorAll('.favorite-item').length === 0) {
                            // Show empty state
                            const content = document.querySelector('.content');
                            const favoritesGrid = document.querySelector('.favorites-grid');

                            favoritesGrid.remove();

                            const emptyState = document.createElement('div');
                            emptyState.className = 'favorites-empty';
                            emptyState.innerHTML = `
                <img src="/assets/images/empty-favorites.png" alt="No Favorites">
                <h3>No Favorites Yet</h3>
                <p>You haven't added any favorites yet. Browse our menu and add items to your favorites!</p>
                <a href="/menu" class="favorites-browse-btn">Browse Menu</a>
              `;

                            content.appendChild(emptyState);
                        }

                        // Show success message
                        showToast('success', 'Item removed from favorites');
                    }, 300);
                } else {
                    showToast('error', data.message || 'Failed to remove from favorites');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'An error occurred. Please try again.');
            });
    }

    // Order Item
    function orderItem() {
        const button = this;
        const itemId = button.dataset.id;
        const itemName = button.dataset.name;
        const itemPrice = button.dataset.price;
        const itemImage = button.dataset.image;

        // Redirect to order page with item details
        window.location.href = `/order/details/${itemId}`;
    }

    // Show Toast Notification
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `favorites-toast ${type}`;

        toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <div class="toast-content">
          <div class="toast-title">${type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Information'}</div>
          <div class="toast-message">${message}</div>
        </div>
      `;

        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector('.favorites-toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'favorites-toast-container';
            document.body.appendChild(toastContainer);
        }

        // Add toast to container
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