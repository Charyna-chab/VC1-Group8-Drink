<<<<<<< HEAD
// favorites.js - Handles favorites functionality
document.addEventListener("DOMContentLoaded", () => {
    console.log("Favorites script loaded")

    // DOM Elements
    const favoriteButtons = document.querySelectorAll(".favorite-btn")
    const favoriteCards = document.querySelectorAll(".favorites-card")
    const favoriteRemoveButtons = document.querySelectorAll(".favorites-remove-btn")
    const favoriteOrderButtons = document.querySelectorAll(".favorites-order-btn")
    const emptyFavorites = document.querySelector(".favorites-empty")
    const favoritesGrid = document.querySelector(".favorites-grid")

    console.log("Favorites elements:", {
        favoriteButtons: favoriteButtons.length,
        favoriteCards: favoriteCards.length,
        favoriteRemoveButtons: favoriteRemoveButtons.length,
        favoriteOrderButtons: favoriteOrderButtons.length,
        emptyFavorites: !!emptyFavorites,
        favoritesGrid: !!favoritesGrid,
    })
=======
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
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4

    // Initialize favorites from localStorage
    let favorites = JSON.parse(localStorage.getItem("favorites")) || []

    // Add event listeners to favorite buttons on product cards
    favoriteButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault()
            e.stopPropagation()

            const productCard = this.closest(".product-card")
            const productId = productCard.querySelector(".order-btn").getAttribute("data-product-id")
            const productName = productCard.querySelector("h3").textContent
            const productImage = productCard.querySelector(".product-image img").src
            const productPrice = productCard.querySelector(".product-price").textContent
            const productDescription = productCard.querySelector(".product-desc").textContent

            const icon = this.querySelector("i")

            if (icon.classList.contains("far")) {
                // Add to favorites
                icon.classList.remove("far")
                icon.classList.add("fas")

                // Save to favorites
                addToFavorites(productId, productName, productImage, productPrice, productDescription)

                // Show notification
                showToast("Added to Favorites", `${productName} has been added to your favorites!`, "success")

<<<<<<< HEAD
                // Add notification
                if (window.addNotification) {
                    window.addNotification("Added to Favorites", `${productName} has been added to your favorites.`, "info")
                }
=======
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
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4

                // Add heart beat animation
                icon.style.animation = "heartBeat 0.5s ease-in-out"
                setTimeout(() => {
                    icon.style.animation = ""
                }, 500)
            } else {
                // Remove from favorites
                icon.classList.remove("fas")
                icon.classList.add("far")

                // Remove from favorites
                removeFromFavorites(productId)

                // Show notification
                showToast("Removed from Favorites", `${productName} has been removed from your favorites.`, "info")

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Removed from Favorites",
                        `${productName} has been removed from your favorites.`,
                        "info",
                    )
                }
            }
        })
    })

    // Add event listeners to remove buttons on favorite cards
    favoriteRemoveButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault()
            e.stopPropagation()

            const favoriteCard = this.closest(".favorites-card")
            const productId = favoriteCard.getAttribute("data-id")
            const productName = favoriteCard.querySelector(".favorites-title").textContent

            // Remove from favorites
            removeFromFavorites(productId)

            // Remove card with animation
            favoriteCard.classList.add("removing")
            setTimeout(() => {
                favoriteCard.remove()

                // Check if there are any favorites left
                if (document.querySelectorAll(".favorites-card").length === 0) {
                    showEmptyState()
                }
            }, 300)

            // Show notification
            showToast("Removed from Favorites", `${productName} has been removed from your favorites.`, "info")

            // Add notification
            if (window.addNotification) {
                window.addNotification("Removed from Favorites", `${productName} has been removed from your favorites.`, "info")
            }
        })
    })

    // Add event listeners to order buttons on favorite cards
    favoriteOrderButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault()
            e.stopPropagation()

            const productId = this.getAttribute("data-id")
            const productName = this.getAttribute("data-name")
            const productPrice = this.getAttribute("data-price")
            const productImage = this.getAttribute("data-image")

            // Redirect to order page with product ID
            window.location.href = `/order?product_id=${productId}`

            // Show notification
            showToast("Ordering", `Preparing to order ${productName}...`, "info")

            // Add notification
            if (window.addNotification) {
                window.addNotification("Ordering", `You're about to order ${productName}.`, "info")
            }
        })
    })

    // Add to favorites
    function addToFavorites(id, name, image, price, description) {
        // Remove price formatting
        price = price.replace("$", "").trim()

        // Check if already in favorites
        if (!favorites.some((item) => item.id === id)) {
            // Add to favorites
            favorites.push({
                id,
                name,
                image,
                price,
                description: description || "A delicious drink from Xing Fu Cha",
            })

            // Save to localStorage
            localStorage.setItem("favorites", JSON.stringify(favorites))

            // If we're on the favorites page, update the UI
            if (window.location.pathname === "/favorites") {
                updateFavoritesUI()
            }
        }
    }

    // Remove from favorites
    function removeFromFavorites(id) {
        // Filter out the removed item
        favorites = favorites.filter((item) => item.id !== id)

        // Save to localStorage
        localStorage.setItem("favorites", JSON.stringify(favorites))

        // Update favorite buttons on product cards
        updateFavoriteButtons()

        // If we're on the favorites page, update the UI
        if (window.location.pathname === "/favorites") {
            updateFavoritesUI()
        }
    }

    // Update favorite buttons on product cards
    function updateFavoriteButtons() {
        favoriteButtons.forEach((button) => {
            const productCard = button.closest(".product-card")
            const productId = productCard.querySelector(".order-btn").getAttribute("data-product-id")
            const icon = button.querySelector("i")

            if (favorites.some((item) => item.id === productId)) {
                icon.classList.remove("far")
                icon.classList.add("fas")
            } else {
                icon.classList.remove("fas")
                icon.classList.add("far")
            }
        })
    }

    // Update favorites UI
    function updateFavoritesUI() {
        if (!favoritesGrid) return

        // Clear favorites grid
        favoritesGrid.innerHTML = ""

        // Show empty state if no favorites
        if (favorites.length === 0) {
            showEmptyState()
            return
        }

        // Hide empty state
        if (emptyFavorites) {
            emptyFavorites.style.display = "none"
        }

        // Show favorites grid
        if (favoritesGrid) {
            favoritesGrid.style.display = "grid"
        }

        // Add favorite cards
        favorites.forEach((favorite) => {
            const favoriteCard = document.createElement("div")
            favoriteCard.className = "favorites-card"
            favoriteCard.setAttribute("data-id", favorite.id)

            favoriteCard.innerHTML = `
          <!-- Remove Button -->
          <button class="favorites-remove-btn" data-id="${favorite.id}">
            <i class="fas fa-times"></i>
            <span class="sr-only">Remove from favorites</span>
          </button>
  
          <!-- Product Image -->
          <div class="favorites-image">
            <img src="${favorite.image}" alt="${favorite.name}">
          </div>
  
          <!-- Product Info -->
          <div class="favorites-content">
            <h3 class="favorites-title">${favorite.name}</h3>
            <p class="favorites-description">${favorite.description}</p>
            
            <div class="favorites-footer">
              <div class="favorites-price">
                $${Number.parseFloat(favorite.price).toFixed(2)}
              </div>
              <button class="favorites-order-btn" 
                      data-id="${favorite.id}"
                      data-name="${favorite.name}"
                      data-price="${favorite.price}"
                      data-image="${favorite.image}">
                Order Now
              </button>
            </div>
          </div>
        `

            favoritesGrid.appendChild(favoriteCard)

            // Add event listener to remove button
            const removeButton = favoriteCard.querySelector(".favorites-remove-btn")
            removeButton.addEventListener("click", function(e) {
                e.preventDefault()
                e.stopPropagation()

                const productId = this.getAttribute("data-id")
                const productName = favoriteCard.querySelector(".favorites-title").textContent

                // Remove from favorites
                removeFromFavorites(productId)

                // Remove card with animation
                favoriteCard.classList.add("removing")
                setTimeout(() => {
                    favoriteCard.remove()

                    // Check if there are any favorites left
                    if (document.querySelectorAll(".favorites-card").length === 0) {
                        showEmptyState()
                    }
                }, 300)

<<<<<<< HEAD
                // Show notification
                showToast("Removed from Favorites", `${productName} has been removed from your favorites.`, "info")

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Removed from Favorites",
                        `${productName} has been removed from your favorites.`,
                        "info",
                    )
                }
            })
=======
                showToast('info', 'Removed from Favorites', 'Item removed from your favorites list');
            });
        });

        const orderButtons = grid.querySelectorAll('.favorites-order-btn');
        orderButtons.forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                const itemName = this.getAttribute('data-name');
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4

            // Add event listener to order button
            const orderButton = favoriteCard.querySelector(".favorites-order-btn")
            orderButton.addEventListener("click", function(e) {
                e.preventDefault()
                e.stopPropagation()

                const productId = this.getAttribute("data-id")
                const productName = this.getAttribute("data-name")

                // Redirect to order page with product ID
                window.location.href = `/order?product_id=${productId}`

                // Show notification
                showToast("Ordering", `Preparing to order ${productName}...`, "info")

                // Add notification
                if (window.addNotification) {
                    window.addNotification("Ordering", `You're about to order ${productName}.`, "info")
                }
            })
        })
    }

    // Show empty state
    function showEmptyState() {
        if (!emptyFavorites || !favoritesGrid) return

        // Show empty state
        emptyFavorites.style.display = "block"

        // Hide favorites grid
        favoritesGrid.style.display = "none"
    }

<<<<<<< HEAD
    // Show toast notification
    function showToast(title, message, type = "info") {
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector(".favorites-toast-container")
        if (!toastContainer) {
            toastContainer = document.createElement("div")
            toastContainer.className = "favorites-toast-container"
            document.body.appendChild(toastContainer)
=======
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
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4
        }

        const toast = document.createElement("div")
        toast.className = "favorites-toast"

        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
            toast.style.borderLeftColor = "#4caf50"
        } else if (type === "error") {
            icon = "exclamation-circle"
            toast.style.borderLeftColor = "#f44336"
        }

        toast.innerHTML = `
        <div>
          <i class="fas fa-${icon}" style="color: ${type === "success" ? "#4caf50" : type === "error" ? "#f44336" : "#ff5e62"}; font-size: 20px; margin-right: 10px;"></i>
        </div>
        <div style="flex: 1;">
          <h4>${title}</h4>
          <p>${message}</p>
        </div>
        <button class="favorites-toast-close">&times;</button>
      `

        // Add to container
        toastContainer.appendChild(toast)

        // Add close button functionality
        const closeButton = toast.querySelector(".favorites-toast-close")
        closeButton.addEventListener("click", () => {
            toast.remove()
        })

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.opacity = "0"
            setTimeout(() => {
                toast.remove()
            }, 300)
        }, 5000)
    }

<<<<<<< HEAD
    // Add CSS for favorites
    const style = document.createElement("style")
    style.textContent = `
      /* Favorites Page Styles */
      .favorites-header {
        margin-bottom: 30px;
      }
      
      .favorites-header h2 {
        font-size: 24px;
        margin: 0 0 10px;
        color: #333;
      }
      
      .favorites-header p {
        font-size: 16px;
        color: #666;
        margin: 0;
      }
      
      .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
      }
      
      .favorites-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.3s ease;
        position: relative;
      }
      
      .favorites-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
      }
      
      .favorites-card.removing {
        opacity: 0;
        transform: scale(0.8);
      }
      
      .favorites-remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background-color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 2;
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
      }
      
      .favorites-card:hover .favorites-remove-btn {
        opacity: 1;
      }
      
      .favorites-remove-btn:hover {
        transform: scale(1.1);
      }
      
      .favorites-image {
        height: 180px;
        overflow: hidden;
      }
      
      .favorites-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
      }
      
      .favorites-card:hover .favorites-image img {
        transform: scale(1.05);
      }
      
      .favorites-content {
        padding: 15px;
      }
      
      .favorites-title {
        font-size: 18px;
        margin: 0 0 10px;
        color: #333;
      }
      
      .favorites-description {
        font-size: 14px;
        color: #666;
        margin: 0 0 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 40px;
      }
      
      .favorites-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      
      .favorites-price {
        font-size: 18px;
        font-weight: 700;
        color: #ff5e62;
      }
      
      .favorites-order-btn {
        padding: 8px 15px;
        background-color: #ff5e62;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
      }
      
      .favorites-order-btn:hover {
        background-color: #ff4146;
        transform: translateY(-2px);
      }
      
      /* Empty State */
      .favorites-empty {
        text-align: center;
        padding: 40px 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      }
      
      .favorites-empty img {
        width: 120px;
        height: auto;
        margin-bottom: 20px;
        opacity: 0.7;
      }
      
      .favorites-empty h3 {
        font-size: 20px;
        margin: 0 0 10px;
        color: #333;
      }
      
      .favorites-empty p {
        font-size: 16px;
        color: #666;
        margin: 0 0 20px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
      }
      
      .favorites-browse-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #ff5e62;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        text-decoration: none;
      }
      
      .favorites-browse-btn:hover {
        background-color: #ff4146;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 94, 98, 0.3);
      }
      
      /* Toast Notifications */
      .favorites-toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 350px;
      }
      
      .favorites-toast {
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 15px;
        display: flex;
        align-items: flex-start;
        border-left: 4px solid #ff5e62;
        animation: slideIn 0.3s ease forwards;
        opacity: 1;
        transition: opacity 0.3s ease;
      }
      
      @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
      }
      
      .favorites-toast h4 {
        margin: 0 0 5px;
        font-size: 16px;
        color: #333;
      }
      
      .favorites-toast p {
        margin: 0;
        font-size: 14px;
        color: #666;
      }
      
      .favorites-toast-close {
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: #999;
        margin-left: 10px;
      }
      
      /* Heart Animation */
      @keyframes heartBeat {
        0% { transform: scale(1); }
        25% { transform: scale(1.3); }
        50% { transform: scale(1); }
        75% { transform: scale(1.3); }
        100% { transform: scale(1); }
      }
      
      /* Screen Reader Only */
      .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
      }
      
      /* Responsive Styles */
      @media (max-width: 768px) {
        .favorites-grid {
          grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
      }
      
      @media (max-width: 576px) {
        .favorites-grid {
          grid-template-columns: 1fr;
        }
      }
    `
    document.head.appendChild(style)

    // Initialize
    updateFavoriteButtons()

    // If we're on the favorites page, update the UI
    if (window.location.pathname === "/favorites") {
        updateFavoritesUI()
=======
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
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4
    }
})