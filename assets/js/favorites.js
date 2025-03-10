document.addEventListener("DOMContentLoaded", () => {
    // Remove favorite functionality
    const removeButtons = document.querySelectorAll(".remove-favorite")
    removeButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.stopPropagation()

            const favoriteId = this.getAttribute("data-id")
            const favoriteCard = this.closest(".favorite-card")

            // Show confirmation dialog
            if (confirm("Are you sure you want to remove this item from your favorites?")) {
                // In a real app, you would send a request to the server
                // For demo purposes, we'll just remove the card with animation
                favoriteCard.style.opacity = "0"
                favoriteCard.style.transform = "scale(0.8)"

                setTimeout(() => {
                    favoriteCard.remove()

                    // Check if there are any favorites left
                    const remainingFavorites = document.querySelectorAll(".favorite-card")
                    if (remainingFavorites.length === 0) {
                        // Show empty state
                        const favoritesGrid = document.querySelector(".favorites-grid")
                        favoritesGrid.innerHTML = `
                <div class="empty-state">
                  <img src="/assets/images/empty-favorites.png" alt="No Favorites">
                  <h3>No Favorites Yet</h3>
                  <p>You haven't added any favorites yet. Browse our menu and add items to your favorites!</p>
                  <a href="/menu" class="btn-primary">Browse Menu</a>
                </div>
              `
                    }
                }, 300)

                // Show toast notification
                showToast(
                    "Removed from Favorites",
                    "Item has been removed from your favorites",
                    "/assets/images/logo/logo-small.png",
                )
            }
        })
    })

    // Order button functionality
    const orderButtons = document.querySelectorAll(".order-btn")
    orderButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.stopPropagation()

            // Get product data
            const productId = this.getAttribute("data-id")
            const productName = this.getAttribute("data-name")
            const productPrice = Number.parseFloat(this.getAttribute("data-price"))
            const productImage = this.getAttribute("data-image")

            // Use the openOrderPanel function from app.js
            if (typeof window.openOrderPanel === "function") {
                window.openOrderPanel(productId, productName, productPrice, productImage)
            } else {
                // Fallback if the function is not available
                alert(`Ordering ${productName} for $${productPrice}`)
            }
        })
    })

    // Make entire card clickable to open order panel
    const favoriteCards = document.querySelectorAll(".favorite-card")
    favoriteCards.forEach((card) => {
        card.addEventListener("click", function() {
            const orderButton = this.querySelector(".order-btn")
            if (orderButton) {
                orderButton.click()
            }
        })
    })

    // Function to show toast notification
    function showToast(title, message, image) {
        const toast = document.getElementById("toastNotification")
        const toastTitle = document.getElementById("toastTitle")
        const toastMessage = document.getElementById("toastMessage")
        const toastImage = document.getElementById("toastImage")

        if (toast && toastTitle && toastMessage && toastImage) {
            toastTitle.textContent = title
            toastMessage.textContent = message
            toastImage.src = image

            toast.classList.add("active")

            setTimeout(() => {
                toast.classList.remove("active")
            }, 3000)
        }
    }
})