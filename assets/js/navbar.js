// assets/js/navbar.js
document.addEventListener("DOMContentLoaded", () => {
    // Add cart icon to navbar if it doesn't exist
    const navbar = document.querySelector(".navbar-nav")
    if (navbar) {
        // Check if cart icon already exists
        let cartIcon = navbar.querySelector(".cart-icon")

        if (!cartIcon) {
            // Create cart icon
            const cartItem = document.createElement("li")
            cartItem.className = "nav-item"

            cartItem.innerHTML = `
                  <a href="#" class="nav-link cart-icon">
                      <i class="fas fa-shopping-cart"></i>
                      <span class="cart-badge" id="cartBadge">0</span>
                  </a>
              `

            navbar.appendChild(cartItem)

            // Update cart badge
            updateCartBadge()

            // Add event listener to cart icon
            cartIcon = cartItem.querySelector(".cart-icon")
            cartIcon.addEventListener("click", (e) => {
                e.preventDefault()

                // Toggle cart panel
                const cartPanel = document.getElementById("cartPanel")
                const cartOverlay = document.getElementById("cartOverlay")

                if (cartPanel && cartOverlay) {
                    cartPanel.classList.toggle("active")
                    cartOverlay.classList.toggle("active")

                    if (cartPanel.classList.contains("active")) {
                        cartPanel.style.animation = "slideInRight 0.3s forwards"
                    } else {
                        cartPanel.style.animation = "slideOutRight 0.3s forwards"
                    }
                }
            })
        }
    }

    // Update cart badge
    function updateCartBadge() {
        const cartBadge = document.getElementById("cartBadge")
        if (cartBadge) {
            const cart = JSON.parse(localStorage.getItem("cart")) || []
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0)

            cartBadge.textContent = totalItems
            cartBadge.style.display = totalItems > 0 ? "block" : "none"
        }
    }

    // Listen for storage events to update cart badge
    window.addEventListener("storage", (e) => {
        if (e.key === "cart") {
            updateCartBadge()
        }
    })
})