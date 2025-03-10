document.addEventListener('DOMContentLoaded', function() {
    // Add favorite functionality for product cards
    const favoriteButtons = document.querySelectorAll('.favorite-btn');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Check if user is logged in
            if (!isLoggedIn()) {
                showLoginPrompt();
                return;
            }

            const productId = this.getAttribute('data-product-id');
            const isFavorite = this.classList.contains('active');

            if (isFavorite) {
                removeFavorite(productId, this);
            } else {
                addFavorite(productId, this);
            }
        });
    });

    function isLoggedIn() {
        // Check if user is logged in (you can modify this based on your authentication system)
        return document.body.classList.contains('user-logged-in');
    }

    function showLoginPrompt() {
        const notification = document.createElement('div');
        notification.className = 'notification info';
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-info-circle"></i>
                <span>Please login to add items to your favorites</span>
            </div>
            <div class="notification-actions">
                <a href="/login" class="btn btn-sm btn-primary">Login</a>
                <button class="btn btn-sm btn-outline dismiss-btn">Dismiss</button>
            </div>
        `;

        document.body.appendChild(notification);

        // Add event listener to dismiss button
        notification.querySelector('.dismiss-btn').addEventListener('click', function() {
            notification.classList.add('fade-out');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        });

        // Auto dismiss after 8 seconds
        setTimeout(() => {
            if (document.body.contains(notification)) {
                notification.classList.add('fade-out');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }
        }, 8000);
    }

    function addFavorite(productId, button) {
        fetch('/favorites/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    productId: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.add('active');
                    button.setAttribute('title', 'Remove from favorites');
                    button.querySelector('i').classList.remove('far');
                    button.querySelector('i').classList.add('fas');

                    showNotification('Added to favorites!', 'success');
                    updateFavoritesCount(data.favoritesCount);
                } else {
                    showNotification(data.message || 'Failed to add to favorites', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred', 'error');
            });
    }

    function removeFavorite(productId, button) {
        fetch('/favorites/remove-by-product', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    productId: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.classList.remove('active');
                    button.setAttribute('title', 'Add to favorites');
                    button.querySelector('i').classList.remove('fas');
                    button.querySelector('i').classList.add('far');

                    showNotification('Removed from favorites', 'success');
                    updateFavoritesCount(data.favoritesCount);
                } else {
                    showNotification(data.message || 'Failed to remove from favorites', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred', 'error');
            });
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    function updateFavoritesCount(count) {
        const favoritesCountBadge = document.querySelector('.sidebar-nav li a[href="/dashboard/favorites"] .badge');

        if (count > 0) {
            if (favoritesCountBadge) {
                favoritesCountBadge.textContent = count;
                favoritesCountBadge.classList.add('pulse');
                setTimeout(() => {
                    favoritesCountBadge.classList.remove('pulse');
                }, 500);
            } else {
                const favoritesLink = document.querySelector('.sidebar-nav li a[href="/dashboard/favorites"]');
                if (favoritesLink) {
                    const badge = document.createElement('span');
                    badge.className = 'badge pulse';
                    badge.textContent = count;
                    favoritesLink.appendChild(badge);

                    setTimeout(() => {
                        badge.classList.remove('pulse');
                    }, 500);
                }
            }
        } else if (favoritesCountBadge) {
            favoritesCountBadge.remove();
        }
    }
});