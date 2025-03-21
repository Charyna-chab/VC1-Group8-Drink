// cart.js - Handles cart functionality
document.addEventListener("DOMContentLoaded", () => {
    // Initialize cart from localStorage
    window.cart = JSON.parse(localStorage.getItem("cart")) || []

    // DOM Elements
    const cartCountBadge = document.getElementById("cartCountBadge")
    const cartPanel = document.getElementById("cartPanel")
    const cartBtn = document.getElementById("cartBtn")
    const closeCartBtn = document.querySelector(".close-cart")
    const cartItemsList = document.getElementById("cartItemsList")
    const cartSubtotal = document.getElementById("cartSubtotal")
    const cartTotal = document.getElementById("cartTotal")
    const checkoutBtn = document.getElementById("checkoutBtn")
    const clearCartBtn = document.getElementById("clearCartBtn")
    const emptyCartMessage = document.getElementById("emptyCartMessage")
    const overlay = document.getElementById("overlay")

    console.log("Cart elements:", {
        cartCountBadge: !!cartCountBadge,
        cartPanel: !!cartPanel,
        cartBtn: !!cartBtn,
        closeCartBtn: !!closeCartBtn,
        cartItemsList: !!cartItemsList,
        cartSubtotal: !!cartSubtotal,
        cartTotal: !!cartTotal,
        checkoutBtn: !!checkoutBtn,
        clearCartBtn: !!clearCartBtn,
        emptyCartMessage: !!emptyCartMessage,
        overlay: !!overlay,
    })

    // Update cart count badge
    function updateCartCount() {
        if (!cartCountBadge) {
            console.error("Cart count badge element not found")
            return
        }

        const totalItems = window.cart.reduce((total, item) => total + item.quantity, 0)
        cartCountBadge.textContent = totalItems

        if (totalItems > 0) {
            cartCountBadge.style.display = "flex"
        } else {
            cartCountBadge.style.display = "none"
        }
    }

    // Calculate cart totals
    function calculateCartTotals() {
        const subtotal = window.cart.reduce((total, item) => total + item.totalPrice, 0)
        const tax = subtotal * 0.08 // 8% tax
        const total = subtotal + tax

        if (cartSubtotal) cartSubtotal.textContent = "$" + subtotal.toFixed(2)
        if (cartTotal) cartTotal.textContent = "$" + total.toFixed(2)

        return { subtotal, tax, total }
    }

    // Render cart items
    function renderCartItems() {
        if (!cartItemsList) {
            console.error("Cart items list element not found")
            return
        }

        if (window.cart.length === 0) {
            if (emptyCartMessage) emptyCartMessage.style.display = "block"
            cartItemsList.innerHTML = ""
            return
        }

        if (emptyCartMessage) emptyCartMessage.style.display = "none"

        cartItemsList.innerHTML = ""

        window.cart.forEach((item, index) => {
            const cartItem = document.createElement("div")
            cartItem.className = "cart-item"

            // Format toppings
            let toppingsText = "None"
            if (item.toppings && item.toppings.length > 0) {
                toppingsText = item.toppings.map((t) => t.name).join(", ")
            }

            cartItem.innerHTML = `
                  <div class="cart-item-image">
                      <img src="${item.image}" alt="${item.name}">
                  </div>
                  <div class="cart-item-details">
                      <h4>${item.name}</h4>
                      <p>Size: ${item.size.name}</p>
                      <p>Sugar: ${item.sugar.name}</p>
                      <p>Ice: ${item.ice.name}</p>
                      <p>Toppings: ${toppingsText}</p>
                      <div class="cart-item-price">$${item.basePrice.toFixed(2)} × ${item.quantity}</div>
                  </div>
                  <div class="cart-item-actions">
                      <div class="cart-quantity">
                          <button class="quantity-btn minus" data-index="${index}">-</button>
                          <span>${item.quantity}</span>
                          <button class="quantity-btn plus" data-index="${index}">+</button>
                      </div>
                      <div class="cart-item-total">$${item.totalPrice.toFixed(2)}</div>
                      <button class="remove-item" data-index="${index}">
                          <i class="fas fa-trash-alt"></i>
                      </button>
                  </div>
              `

            cartItemsList.appendChild(cartItem)
        })

        // Add event listeners to quantity buttons and remove buttons
        const minusButtons = document.querySelectorAll(".cart-quantity .minus")
        const plusButtons = document.querySelectorAll(".cart-quantity .plus")
        const removeButtons = document.querySelectorAll(".remove-item")

        minusButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const index = Number.parseInt(this.getAttribute("data-index"))
                decreaseQuantity(index)
            })
        })

        plusButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const index = Number.parseInt(this.getAttribute("data-index"))
                increaseQuantity(index)
            })
        })

        removeButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const index = Number.parseInt(this.getAttribute("data-index"))
                removeCartItem(index)
            })
        })
    }

    // Increase item quantity
    function increaseQuantity(index) {
        if (window.cart[index].quantity < 10) {
            window.cart[index].quantity++
                window.cart[index].totalPrice = window.cart[index].basePrice * window.cart[index].quantity

            // Save to localStorage
            localStorage.setItem("cart", JSON.stringify(window.cart))

            // Update UI
            updateCartCount()
            renderCartItems()
            calculateCartTotals()

            // Show notification
            showToast(
                "Quantity Updated",
                `${window.cart[index].name} quantity increased to ${window.cart[index].quantity}`,
                "info",
            )

            // Add notification
            if (window.addNotification) {
                window.addNotification(
                    "Quantity Updated",
                    `${window.cart[index].name} quantity increased to ${window.cart[index].quantity}`,
                    "cart",
                )
            }
        }
    }

    // Decrease item quantity
    function decreaseQuantity(index) {
        if (window.cart[index].quantity > 1) {
            window.cart[index].quantity--
                window.cart[index].totalPrice = window.cart[index].basePrice * window.cart[index].quantity

            // Save to localStorage
            localStorage.setItem("cart", JSON.stringify(window.cart))

            // Update UI
            updateCartCount()
            renderCartItems()
            calculateCartTotals()

            // Show notification
            showToast(
                "Quantity Updated",
                `${window.cart[index].name} quantity decreased to ${window.cart[index].quantity}`,
                "info",
            )

            // Add notification
            if (window.addNotification) {
                window.addNotification(
                    "Quantity Updated",
                    `${window.cart[index].name} quantity decreased to ${window.cart[index].quantity}`,
                    "cart",
                )
            }
        }
    }

    // Remove item from cart
    function removeCartItem(index) {
        const itemName = window.cart[index].name

        // Remove item
        window.cart.splice(index, 1)

        // Save to localStorage
        localStorage.setItem("cart", JSON.stringify(window.cart))

        // Update UI
        updateCartCount()
        renderCartItems()
        calculateCartTotals()

        // Show notification
        showToast("Item Removed", `${itemName} removed from your cart`, "info")

        // Add notification
        if (window.addNotification) {
            window.addNotification("Item Removed", `${itemName} has been removed from your cart`, "cart")
        }
    }

    // Clear cart
    function clearCart() {
        window.cart = []

        // Save to localStorage
        localStorage.setItem("cart", JSON.stringify(window.cart))

        // Update UI
        updateCartCount()
        renderCartItems()
        calculateCartTotals()

        // Show notification
        showToast("Cart Cleared", "All items have been removed from your cart", "info")

        // Add notification
        if (window.addNotification) {
            window.addNotification("Cart Cleared", "All items have been removed from your cart", "cart")
        }

        // Close cart panel
        if (cartPanel) cartPanel.classList.remove("active")
        if (overlay) overlay.classList.remove("active")
    }

    // Add item to cart
    window.addToCart = (item) => {
        console.log("Adding to cart:", item) // Debug log

        // Check if product already exists in cart
        const existingItemIndex = window.cart.findIndex(
            (cartItem) =>
            cartItem.productId === item.productId &&
            cartItem.size.value === item.size.value &&
            cartItem.sugar.value === item.sugar.value &&
            cartItem.ice.value === item.ice.value &&
            JSON.stringify(cartItem.toppings) === JSON.stringify(item.toppings),
        )

        if (existingItemIndex !== -1) {
            // Increase quantity
            window.cart[existingItemIndex].quantity += item.quantity
            window.cart[existingItemIndex].totalPrice =
                window.cart[existingItemIndex].basePrice * window.cart[existingItemIndex].quantity

            // Show notification
            showToast(
                "Quantity Updated",
                `${item.name} quantity increased to ${window.cart[existingItemIndex].quantity}`,
                "success",
            )

            // Add notification
            if (window.addNotification) {
                window.addNotification(
                    "Quantity Updated",
                    `${item.name} quantity increased to ${window.cart[existingItemIndex].quantity}`,
                    "cart",
                )
            }
        } else {
            // Add new item to cart
            window.cart.push(item)

            // Show notification
            showToast("Added to Cart", `${item.name} added to your cart`, "success")

            // Add notification
            if (window.addNotification) {
                window.addNotification("Added to Cart", `${item.name} has been added to your cart`, "cart")
            }
        }

        // Save to localStorage
        localStorage.setItem("cart", JSON.stringify(window.cart))

        // Update UI
        updateCartCount()
        renderCartItems()
        calculateCartTotals()

        return window.cart.length
    }

    // Open cart panel
    if (cartBtn) {
        cartBtn.addEventListener("click", (e) => {
            e.preventDefault()
            e.stopPropagation()

            if (cartPanel) {
                cartPanel.classList.add("active")
                if (overlay) overlay.classList.add("active")

                // Render cart items
                renderCartItems()
                calculateCartTotals()
            } else {
                console.error("Cart panel not found")
            }
        })
    } else {
        console.error("Cart button not found!") // Debug log
    }

    // Close cart panel
    if (closeCartBtn) {
        closeCartBtn.addEventListener("click", () => {
            if (cartPanel) {
                cartPanel.classList.remove("active")
                if (overlay) overlay.classList.remove("active")
            }
        })
    } else {
        console.error("Close cart button not found!") // Debug log
    }

    // Close cart when clicking on overlay
    if (overlay) {
        overlay.addEventListener("click", () => {
            if (cartPanel) {
                cartPanel.classList.remove("active")
                overlay.classList.remove("active")
            }
        })
    } else {
        console.error("Overlay not found!") // Debug log
    }

    // Clear cart button
    if (clearCartBtn) {
        clearCartBtn.addEventListener("click", clearCart)
    } else {
        console.error("Clear cart button not found!") // Debug log
    }

    // Checkout button
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", () => {
            if (window.cart.length === 0) {
                showToast("Empty Cart", "Your cart is empty. Add some items before checkout.", "error")
                return
            }

            // Show success message
            showToast("Checkout", "Proceeding to checkout...", "success")

            // Add notification
            if (window.addNotification) {
                window.addNotification(
                    "Order Placed",
                    "Your order has been placed successfully. Redirecting to booking page...",
                    "order",
                )
            }

            // Close cart panel
            if (cartPanel) cartPanel.classList.remove("active")
            if (overlay) overlay.classList.remove("active")

            // Redirect to booking page
            setTimeout(() => {
                window.location.href = "/booking"
            }, 1000)
        })
    } else {
        console.error("Checkout button not found!") // Debug log
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById("toastContainer")
        if (!toastContainer) {
            toastContainer = document.createElement("div")
            toastContainer.id = "toastContainer"
            toastContainer.className = "toast-container"
            document.body.appendChild(toastContainer)
        }

        const toast = document.createElement("div")
        toast.className = "toast"

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
              <button class="toast-close">&times;</button>
          `

        // Add to container
        toastContainer.appendChild(toast)

        // Add close button functionality
        const closeButton = toast.querySelector(".toast-close")
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

    // Initialize cart
    updateCartCount()
    renderCartItems()
    console.log("Cart initialized with", window.cart.length, "items") // Debug log
})