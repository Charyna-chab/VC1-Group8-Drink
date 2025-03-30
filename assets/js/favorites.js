// favorites.js - Handles favorites functionality
document.addEventListener("DOMContentLoaded", () => {
    console.log("Favorites script loaded");

    // DOM Elements
    const favoriteButtons = document.querySelectorAll(".favorite-btn");
    const favoriteCards = document.querySelectorAll(".favorites-card");
    const favoriteRemoveButtons = document.querySelectorAll(".favorites-remove-btn");
    const favoriteOrderButtons = document.querySelectorAll(".favorites-order-btn");
    const emptyFavorites = document.querySelector(".favorites-empty");
    const favoritesGrid = document.querySelector(".favorites-grid");

    // Initialize favorites from localStorage
    let favorites = JSON.parse(localStorage.getItem("favorites")) || [];

    // Add event listeners to favorite buttons on product cards
    favoriteButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();

            const productCard = this.closest(".product-card");
            const productId = productCard.querySelector(".order-btn").getAttribute("data-product-id");
            const productName = productCard.querySelector("h3").textContent;
            const productImage = productCard.querySelector(".product-image img").src;
            const productPrice = productCard.querySelector(".product-price").textContent.replace("$", "").trim();
            const productDescription = productCard.querySelector(".product-desc").textContent;

            const icon = this.querySelector("i");

            if (icon.classList.contains("far")) {
                // Add to favorites
                icon.classList.remove("far");
                icon.classList.add("fas");

                // Save to favorites
                addToFavorites(productId, productName, productImage, productPrice, productDescription);

                // Show notification
                showToast("Added to Favorites", `${productName} has been added to your favorites!`, "success");

                // Add heart beat animation
                icon.style.animation = "heartBeat 0.5s ease-in-out";
                setTimeout(() => {
                    icon.style.animation = "";
                }, 500);
            } else {
                // Remove from favorites
                icon.classList.remove("fas");
                icon.classList.add("far");

                // Remove from favorites
                removeFromFavorites(productId);

                // Show notification
                showToast("Removed from Favorites", `${productName} has been removed from your favorites.`, "info");
            }
        });
    });

    // Add event listeners to remove buttons on favorite cards
    document.addEventListener('click', function(e) {
        if (e.target.closest('.favorites-remove-btn')) {
            const button = e.target.closest('.favorites-remove-btn');
            e.preventDefault();
            e.stopPropagation();

            const favoriteCard = button.closest(".favorites-card");
            const productId = favoriteCard.getAttribute("data-id");
            const productName = favoriteCard.querySelector(".favorites-title").textContent;

            // Remove from favorites
            removeFromFavorites(productId);

            // Remove card with animation
            favoriteCard.classList.add("removing");
            setTimeout(() => {
                favoriteCard.remove();

                // Check if there are any favorites left
                if (document.querySelectorAll(".favorites-card").length === 0) {
                    showEmptyState();
                }
            }, 300);

            // Show notification
            showToast("Removed from Favorites", `${productName} has been removed from your favorites.`, "info");
        }
    });

    // Add event listeners to order buttons on favorite cards
    document.addEventListener('click', function(e) {
        if (e.target.closest('.favorites-order-btn')) {
            const button = e.target.closest('.favorites-order-btn');
            e.preventDefault();
            e.stopPropagation();

            const productId = button.getAttribute("data-id");
            const productName = button.getAttribute("data-name");

            // Redirect to order page with product ID
            window.location.href = `/order?product_id=${productId}`;

            // Show notification
            showToast("Ordering", `Preparing to order ${productName}...`, "info");
        }
    });

    // Add to favorites
    function addToFavorites(id, name, image, price, description) {
        // Check if already in favorites
        if (!favorites.some((item) => item.id === id)) {
            // Add to favorites
            favorites.push({
                id,
                name,
                image,
                price,
                description: description || "A delicious drink from Xing Fu Cha",
            });

            // Save to localStorage
            localStorage.setItem("favorites", JSON.stringify(favorites));

            // If we're on the favorites page, update the UI
            if (window.location.pathname === "/favorites") {
                updateFavoritesUI();
            }

            // Send to server if user is logged in
            sendFavoritesToServer(id);
        }
    }

    // Send favorites to server
    function sendFavoritesToServer(productId) {
        // Check if user is logged in
        if (document.body.classList.contains("logged-in")) {
            fetch("/favorites/add", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        product_id: productId
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Favorite saved to server:", data);
                })
                .catch((error) => {
                    console.error("Error saving favorite to server:", error);
                });
        }
    }

    // Remove from favorites
    function removeFromFavorites(id) {
        // Filter out the removed item
        favorites = favorites.filter((item) => item.id !== id);

        // Save to localStorage
        localStorage.setItem("favorites", JSON.stringify(favorites));

        // Update favorite buttons on product cards
        updateFavoriteButtons();

        // If we're on the favorites page, update the UI
        if (window.location.pathname === "/favorites") {
            updateFavoritesUI();
        }

        // Send to server if user is logged in
        removeFavoriteFromServer(id);
    }

    // Remove favorite from server
    function removeFavoriteFromServer(productId) {
        // Check if user is logged in
        if (document.body.classList.contains("logged-in")) {
            fetch("/favorites/remove", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        product_id: productId
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Favorite removed from server:", data);
                })
                .catch((error) => {
                    console.error("Error removing favorite from server:", error);
                });
        }
    }

    // Update favorite buttons on product cards
    function updateFavoriteButtons() {
        favoriteButtons.forEach((button) => {
            const productCard = button.closest(".product-card");
            const productId = productCard.querySelector(".order-btn").getAttribute("data-product-id");
            const icon = button.querySelector("i");

            if (favorites.some((item) => item.id === productId)) {
                icon.classList.remove("far");
                icon.classList.add("fas");
            } else {
                icon.classList.remove("fas");
                icon.classList.add("far");
            }
        });
    }

    // Update favorites UI
    function updateFavoritesUI() {
        if (!favoritesGrid) return;

        // Clear favorites grid
        favoritesGrid.innerHTML = "";

        // Show empty state if no favorites
        if (favorites.length === 0) {
            showEmptyState();
            return;
        }

        // Hide empty state
        if (emptyFavorites) {
            emptyFavorites.style.display = "none";
        }

        // Show favorites grid
        if (favoritesGrid) {
            favoritesGrid.style.display = "grid";
        }

        // Add favorite cards
        favorites.forEach((favorite) => {
            const favoriteCard = document.createElement("div");
            favoriteCard.className = "favorites-card";
            favoriteCard.setAttribute("data-id", favorite.id);

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
          `;

            favoritesGrid.appendChild(favoriteCard);
        });
    }

    // Show empty state
    function showEmptyState() {
        if (!emptyFavorites || !favoritesGrid) return;

        // Show empty state
        emptyFavorites.style.display = "block";

        // Hide favorites grid
        favoritesGrid.style.display = "none";
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector(".favorites-toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.className = "favorites-toast-container";
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement("div");
        toast.className = "favorites-toast";

        let icon = "info-circle";
        if (type === "success") {
            icon = "check-circle";
            toast.classList.add("toast-success");
        } else if (type === "error") {
            icon = "exclamation-circle";
            toast.classList.add("toast-error");
        }

        toast.innerHTML = `
          <div class="toast-icon">
              <i class="fas fa-${icon}"></i>
          </div>
          <div class="toast-content">
              <h4>${title}</h4>
              <p>${message}</p>
          </div>
          <button class="favorites-toast-close">&times;</button>
      `;

        // Add to container
        toastContainer.appendChild(toast);

        // Add close button functionality
        const closeButton = toast.querySelector(".favorites-toast-close");
        closeButton.addEventListener("click", () => {
            toast.classList.add("toast-hiding");
            setTimeout(() => {
                toast.remove();
            }, 300);
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.classList.add("toast-hiding");
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }

    // Initialize
    updateFavoriteButtons();

    // If we're on the favorites page, update the UI
    if (window.location.pathname === "/favorites") {
        updateFavoritesUI();
    }

    // Load favorites from server if user is logged in
    if (document.body.classList.contains("logged-in")) {
        fetch("/favorites/getAll")
            .then((response) => response.json())
            .then((data) => {
                if (data.success && data.favorites.length > 0) {
                    // Merge server favorites with local favorites
                    const serverFavorites = data.favorites;

                    // Add any server favorites not in local storage
                    serverFavorites.forEach((serverFav) => {
                        if (!favorites.some((localFav) => localFav.id === serverFav.id)) {
                            favorites.push(serverFav);
                        }
                    });

                    // Save merged favorites to localStorage
                    localStorage.setItem("favorites", JSON.stringify(favorites));

                    // Update UI
                    updateFavoriteButtons();
                    if (window.location.pathname === "/favorites") {
                        updateFavoritesUI();
                    }
                }
            })
            .catch((error) => {
                console.error("Error loading favorites from server:", error);
            });
    }
});