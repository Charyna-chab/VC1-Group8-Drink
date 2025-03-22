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
            e.stopPropagation(); // Prevent card click event
            const icon = this.querySelector('i');
            const productCard = this.closest('.product-card');
            const productId = productCard.querySelector('.order-btn').getAttribute('data-product-id');
            const productName = productCard.querySelector('h4').textContent;
            const productImage = productCard.querySelector('.product-image img').src;
            const productPrice = productCard.querySelector('.product-price').textContent.replace('$', '');
            const productDesc = productCard.querySelector('.description').textContent;

            if (icon.classList.contains('far')) {
                // Add to favorites
                icon.classList.remove('far');
                icon.classList.add('fas');

                // Save to localStorage
                saveFavorite(productId, productName, productImage, productPrice, productDesc);

                showToast('success', 'Added to Favorites', 'Item added to your favorites list');

                // Redirect to favorites page after a short delay
                setTimeout(() => {
                    window.location.href = '/favorites';
                }, 1000);
            } else {
                // Remove from favorites
                icon.classList.remove('fas');
                icon.classList.add('far');

                // Remove from localStorage
                removeFavorite(productId);

                showToast('info', 'Removed from Favorites', 'Item removed from your favorites list');
            }
        });
    });

    // Product card click for details
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't show details if clicking on favorite button or order button
            if (e.target.closest('.favorite-btn') || e.target.closest('.order-btn')) {
                return;
            }

            const productId = this.querySelector('.order-btn').getAttribute('data-product-id');
            const productName = this.querySelector('h4').textContent;
            const productImage = this.querySelector('.product-image img').src;
            const productPrice = this.querySelector('.product-price').textContent;
            const productDesc = this.querySelector('.description').textContent;

            showProductDetails(productId, productName, productImage, productPrice, productDesc);
        });
    });

    // Create product detail modal if it doesn't exist
    if (!document.getElementById('productDetailModal')) {
        const modal = document.createElement('div');
        modal.id = 'productDetailModal';
        modal.className = 'product-modal';
        modal.innerHTML = `
            <div class="product-modal-content">
                <div class="product-modal-header">
                    <h3>Product Details</h3>
                    <button class="product-modal-close">&times;</button>
                </div>
                <div class="product-modal-body">
                    <div class="product-modal-image">
                        <img src="/placeholder.svg" alt="Product Image">
                    </div>
                    <div class="product-modal-details">
                        <h2 class="product-modal-title"></h2>
                        <p class="product-modal-description"></p>
                        <div class="product-modal-price"></div>
                        <div class="product-modal-actions">
                            <button class="btn-favorite"><i class="far fa-heart"></i> Add to Favorites</button>
                            <button class="btn-primary modal-order-btn">Order Now</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);

        // Close modal when clicking on close button or outside
        const closeBtn = modal.querySelector('.product-modal-close');
        closeBtn.addEventListener('click', function() {
            closeProductModal();
        });

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeProductModal();
            }
        });

        // Favorite button in modal
        const favoriteBtn = modal.querySelector('.btn-favorite');
        favoriteBtn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const icon = this.querySelector('i');
            const productName = modal.querySelector('.product-modal-title').textContent;
            const productImage = modal.querySelector('.product-modal-image img').src;
            const productPrice = modal.querySelector('.product-modal-price').textContent.replace('$', '');
            const productDesc = modal.querySelector('.product-modal-description').textContent;

            if (icon.classList.contains('far')) {
                // Add to favorites
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.innerHTML = `<i class="fas fa-heart"></i> Added to Favorites`;

                // Save to localStorage
                saveFavorite(productId, productName, productImage, productPrice, productDesc);

                showToast('success', 'Added to Favorites', 'Item added to your favorites list');
            } else {
                // Remove from favorites
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.innerHTML = `<i class="far fa-heart"></i> Add to Favorites`;

                // Remove from localStorage
                removeFavorite(productId);

                showToast('info', 'Removed from Favorites', 'Item removed from your favorites list');
            }
        });

        // Order button in modal
        const orderBtn = modal.querySelector('.modal-order-btn');
        orderBtn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            closeProductModal();

            // Find and click the order button on the product card
            const orderBtnOnCard = document.querySelector(`.order-btn[data-product-id="${productId}"]`);
            if (orderBtnOnCard) {
                orderBtnOnCard.click();
            }
        });
    }

    // Function to show product details modal
    function showProductDetails(id, name, image, price, description) {
        const modal = document.getElementById('productDetailModal');

        // Set product details in modal
        modal.querySelector('.product-modal-title').textContent = name;
        modal.querySelector('.product-modal-description').textContent = description;
        modal.querySelector('.product-modal-price').textContent = price;
        modal.querySelector('.product-modal-image img').src = image;

        // Set product ID for the buttons
        modal.querySelector('.btn-favorite').setAttribute('data-product-id', id);
        modal.querySelector('.modal-order-btn').setAttribute('data-product-id', id);

        // Check if product is in favorites
        const favorites = getFavorites();
        const isFavorite = favorites.some(fav => fav.id === id);
        const favoriteBtn = modal.querySelector('.btn-favorite');
        const favoriteIcon = favoriteBtn.querySelector('i');

        if (isFavorite) {
            favoriteIcon.classList.remove('far');
            favoriteIcon.classList.add('fas');
            favoriteBtn.innerHTML = `<i class="fas fa-heart"></i> Added to Favorites`;
        } else {
            favoriteIcon.classList.remove('fas');
            favoriteIcon.classList.add('far');
            favoriteBtn.innerHTML = `<i class="far fa-heart"></i> Add to Favorites`;
        }

        // Show modal
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Function to close product details modal
    function closeProductModal() {
        const modal = document.getElementById('productDetailModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Function to save favorite to localStorage
    function saveFavorite(id, name, image, price, description) {
        let favorites = getFavorites();

        // Check if product is already in favorites
        if (!favorites.some(fav => fav.id === id)) {
            favorites.push({
                id: id,
                name: name,
                image: image,
                price: price,
                description: description
            });

            localStorage.setItem('favorites', JSON.stringify(favorites));
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
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

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

    // Initialize favorites from localStorage
    function initializeFavorites() {
        const favorites = getFavorites();
        const favoriteButtons = document.querySelectorAll('.favorite-btn');

        favoriteButtons.forEach(button => {
            const productCard = button.closest('.product-card');
            const productId = productCard.querySelector('.order-btn').getAttribute('data-product-id');

            if (favorites.some(fav => fav.id === productId)) {
                const icon = button.querySelector('i');
                icon.classList.remove('far');
                icon.classList.add('fas');
            }
        });
    }

    // Call initialize function
    initializeFavorites();
});

// Improved search function that sorts matching products to the top
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[placeholder="Search..."]');
    const tableBody = document.querySelector('tbody');
    
    // Store the original order of rows
    const originalRows = Array.from(tableBody.querySelectorAll('tr'));
    
    searchInput.addEventListener('keyup', function() {
      const searchTerm = this.value.toLowerCase().trim();
      
      if (searchTerm === '') {
        // If search is empty, restore original order
        restoreOriginalOrder();
        return;
      }
      
      // Create an array to hold rows and their match scores
      const rowsWithScores = [];
      
      originalRows.forEach(row => {
        const id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
        const productName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const productDetail = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        const price = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
        
        // Calculate match score (higher is better match)
        let score = 0;
        
        // Exact matches get highest score
        if (id === searchTerm) score += 100;
        if (productName === searchTerm) score += 100;
        if (productDetail === searchTerm) score += 100;
        if (price === searchTerm) score += 100;
        
        // Partial matches get lower scores
        if (id.includes(searchTerm)) score += 50;
        if (productName.includes(searchTerm)) score += 50;
        if (productDetail.includes(searchTerm)) score += 30;
        if (price.includes(searchTerm)) score += 40;
        
        // Add row to array with its score
        rowsWithScores.push({ row, score });
      });
      
      // Sort rows by score (highest first)
      rowsWithScores.sort((a, b) => b.score - a.score);
      
      // Clear the table
      tableBody.innerHTML = '';
      
      // Add rows back in sorted order, hiding non-matching rows
      rowsWithScores.forEach(item => {
        if (item.score > 0) {
          // Highlight the matching row
          item.row.style.display = '';
          item.row.style.backgroundColor = '#f0f8ff'; // Light blue highlight
          
          // After a short delay, remove the highlight
          setTimeout(() => {
            item.row.style.backgroundColor = '';
          }, 2000);
          
          tableBody.appendChild(item.row);
        } else {
          // Hide non-matching rows
          item.row.style.display = 'none';
          tableBody.appendChild(item.row);
        }
      });
    });
    
    // Function to restore original order
    function restoreOriginalOrder() {
      tableBody.innerHTML = '';
      originalRows.forEach(row => {
        row.style.display = '';
        row.style.backgroundColor = '';
        tableBody.appendChild(row);
      });
    }
    
    // Add event listener for the search button
    const searchButton = document.querySelector('.input-group-append button');
    searchButton.addEventListener('click', function() {
      // Trigger the keyup event on the search input
      const event = new Event('keyup');
      searchInput.dispatchEvent(event);
    });
  });
