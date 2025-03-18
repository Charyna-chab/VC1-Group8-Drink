// assets/js/cart.js
document.addEventListener("DOMContentLoaded", () => {
    // Initialize cart from localStorage
    const cart = JSON.parse(localStorage.getItem("cart")) || []

    // DOM Elements
    const cartIcon = document.querySelector(".cart-icon")
    const cartBadge = document.getElementById("cartBadge")

    // Create cart panel if it doesn't exist
    let cartPanel = document.getElementById("cartPanel")
    if (!cartPanel) {
        cartPanel = document.createElement("div")
        cartPanel.id = "cartPanel"
        cartPanel.className = "cart-panel"

        cartPanel.innerHTML = `
              <div class="cart-panel-content">
                  <div class="cart-header">
                      <h3>Your Cart</h3>
                      <button class="close-cart-btn">&times;</button>
                  </div>
                  <div class="cart-items">
                      <!-- Cart items will be loaded here -->
                  </div>
                  <div class="cart-empty">
                      <img src="/assets/images/empty-cart.svg" alt="Empty Cart">
                      <h4>Your cart is empty</h4>
                      <p>Add some delicious drinks to your cart!</p>
                      <a href="/order" class="btn-primary">Browse Menu</a>
                  </div>
                  <div class="cart-footer">
                      <div class="cart-subtotal">
                          <span>Subtotal:</span>
                          <span class="subtotal-amount">$0.00</span>
                      </div>
                      <div class="cart-tax">
                          <span>Tax (8%):</span>
                          <span class="tax-amount">$0.00</span>
                      </div>
                      <div class="cart-total">
                          <span>Total:</span>
                          <span class="total-amount">$0.00</span>
                      </div>
                      <button class="checkout-btn">Proceed to Checkout</button>
                      <button class="continue-shopping-btn">Continue Shopping</button>
                  </div>
              </div>
          `

        document.body.appendChild(cartPanel)

        // Create overlay
        const overlay = document.createElement("div")
        overlay.id = "cartOverlay"
        overlay.className = "cart-overlay"
        document.body.appendChild(overlay)
    }

    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById("toastContainer")
    if (!toastContainer) {
        toastContainer = document.createElement("div")
        toastContainer.id = "toastContainer"
        toastContainer.className = "toast-container"
        document.body.appendChild(toastContainer)
    }

    // Add event listeners
    const closeCartBtn = document.querySelector(".close-cart-btn")
    const cartOverlay = document.getElementById("cartOverlay")
    const checkoutBtn = document.querySelector(".checkout-btn")
    const continueShoppingBtn = document.querySelector(".continue-shopping-btn")

    // Toggle cart panel
    if (cartIcon) {
        cartIcon.addEventListener("click", toggleCartPanel)
    }

    // Close cart panel
    if (closeCartBtn) {
        closeCartBtn.addEventListener("click", closeCartPanel)
    }

    // Close cart when clicking on overlay
    if (cartOverlay) {
        cartOverlay.addEventListener("click", closeCartPanel)
    }

    // Checkout button
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", () => {
            window.location.href = "/booking"
        })
    }

    // Continue shopping button
    if (continueShoppingBtn) {
        continueShoppingBtn.addEventListener("click", closeCartPanel)
    }

    // Update cart badge
    updateCartBadge()

    // Load cart items
    loadCartItems()

    // Add to cart function
    window.addToCart = (product) => {
        // Check if product already exists in cart
        const existingItemIndex = cart.findIndex(
            (item) =>
            item.productId === product.productId &&
            item.size.value === product.size.value &&
            item.sugar.value === product.sugar.value &&
            item.ice.value === product.ice.value &&
            JSON.stringify(item.toppings) === JSON.stringify(product.toppings),
        )

        if (existingItemIndex !== -1) {
            // Increase quantity
            cart[existingItemIndex].quantity += 1
            cart[existingItemIndex].totalPrice = cart[existingItemIndex].basePrice * cart[existingItemIndex].quantity

            // Show toast notification
            showToast(
                "Quantity Updated",
                `${product.name} quantity increased to ${cart[existingItemIndex].quantity}`,
                "success",
            )
        } else {
            // Add new item to cart
            cart.push(product)

            // Show toast notification
            showToast("Added to Cart", `${product.name} added to your cart`, "success")
        }

        // Save cart to localStorage
        saveCart()

        // Update cart badge
        updateCartBadge()

        // Reload cart items
        loadCartItems()

        // Show cart panel
        showCartPanel()
    }

    // Remove from cart function
    window.removeFromCart = (index) => {
        const product = cart[index]

        // Remove item from cart
        cart.splice(index, 1)

        // Save cart to localStorage
        saveCart()

        // Update cart badge
        updateCartBadge()

        // Reload cart items
        loadCartItems()

        // Show toast notification
        showToast("Removed from Cart", `${product.name} removed from your cart`, "info")
    }

    // Update quantity function
    window.updateQuantity = (index, change) => {
        const product = cart[index]

        // Update quantity
        product.quantity += change

        // Remove item if quantity is 0
        if (product.quantity <= 0) {
            cart.splice(index, 1)

            // Show toast notification
            showToast("Removed from Cart", `${product.name} removed from your cart`, "info")
        } else {
            // Update total price
            product.totalPrice = product.basePrice * product.quantity

            // Show toast notification
            showToast("Quantity Updated", `${product.name} quantity updated to ${product.quantity}`, "success")
        }

        // Save cart to localStorage
        saveCart()

        // Update cart badge
        updateCartBadge()

        // Reload cart items
        loadCartItems()
    }

    // Toggle cart panel
    function toggleCartPanel() {
        if (cartPanel.classList.contains("active")) {
            closeCartPanel()
        } else {
            showCartPanel()
        }
    }

    // Show cart panel
    function showCartPanel() {
        cartPanel.classList.add("active")
        cartOverlay.classList.add("active")

        // Add animation
        cartPanel.style.animation = "slideInRight 0.3s forwards"
    }

    // Close cart panel
    function closeCartPanel() {
        cartPanel.style.animation = "slideOutRight 0.3s forwards"

        setTimeout(() => {
            cartPanel.classList.remove("active")
            cartOverlay.classList.remove("active")
        }, 300)
    }

    // Load cart items
    function loadCartItems() {
        const cartItemsContainer = document.querySelector(".cart-items")
        const cartEmpty = document.querySelector(".cart-empty")
        const cartFooter = document.querySelector(".cart-footer")

        // Clear cart items
        cartItemsContainer.innerHTML = ""

        // Check if cart is empty
        if (cart.length === 0) {
            cartEmpty.style.display = "block"
            cartFooter.style.display = "none"
            return
        }

        // Hide empty cart message and show footer
        cartEmpty.style.display = "none"
        cartFooter.style.display = "block"

        // Calculate totals
        let subtotal = 0

        // Add cart items
        cart.forEach((item, index) => {
            // Calculate item subtotal
            const itemSubtotal = item.totalPrice * item.quantity
            subtotal += itemSubtotal

            // Format toppings
            let toppingsText = "None"
            if (item.toppings && item.toppings.length > 0) {
                toppingsText = item.toppings.map((t) => t.name).join(", ")
            }

            // Create cart item element
            const cartItem = document.createElement("div")
            cartItem.className = "cart-item"

            cartItem.innerHTML = `
                  <div class="cart-item-image">
                      <img src="${item.image}" alt="${item.name}">
                  </div>
                  <div class="cart-item-details">
                      <h4>${item.name}</h4>
                      <p class="cart-item-options">
                          Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}
                      </p>
                      <p class="cart-item-toppings">Toppings: ${toppingsText}</p>
                      <div class="cart-item-price">$${item.basePrice.toFixed(2)}</div>
                  </div>
                  <div class="cart-item-actions">
                      <div class="quantity-control">
                          <button class="quantity-btn minus" onclick="window.updateQuantity(${index}, -1)">-</button>
                          <span class="quantity">${item.quantity}</span>
                          <button class="quantity-btn plus" onclick="window.updateQuantity(${index}, 1)">+</button>
                      </div>
                      <div class="cart-item-subtotal">$${(item.basePrice * item.quantity).toFixed(2)}</div>
                      <button class="remove-btn" onclick="window.removeFromCart(${index})">
                          <i class="fas fa-trash-alt"></i>
                      </button>
                  </div>
              `

            cartItemsContainer.appendChild(cartItem)
        })

        // Calculate tax and total
        const tax = subtotal * 0.08
        const total = subtotal + tax

        // Update totals
        document.querySelector(".subtotal-amount").textContent = `$${subtotal.toFixed(2)}`
        document.querySelector(".tax-amount").textContent = `$${tax.toFixed(2)}`
        document.querySelector(".total-amount").textContent = `$${total.toFixed(2)}`
    }

    // Update cart badge
    function updateCartBadge() {
        if (cartBadge) {
            const totalItems = cart.reduce((total, item) => total + item.quantity, 0)
            cartBadge.textContent = totalItems
            cartBadge.style.display = totalItems > 0 ? "block" : "none"
        }
    }

    // Save cart to localStorage
    function saveCart() {
        localStorage.setItem("cart", JSON.stringify(cart))
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
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

    // Add CSS for cart
    const style = document.createElement("style")
    style.textContent = `
          /* Cart Panel Styles */
          .cart-panel {
              position: fixed;
              top: 0;
              right: -400px;
              width: 100%;
              max-width: 400px;
              height: 100vh;
              background-color: white;
              box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
              z-index: 1000;
              transition: right 0.3s ease;
              overflow-y: auto;
          }
          
          .cart-panel.active {
              right: 0;
          }
          
          .cart-panel-content {
              padding: 20px;
              height: 100%;
              display: flex;
              flex-direction: column;
          }
          
          .cart-header {
              display: flex;
              justify-content: space-between;
              align-items: center;
              margin-bottom: 20px;
              padding-bottom: 15px;
              border-bottom: 1px solid #eee;
          }
          
          .cart-header h3 {
              margin: 0;
              color: #333;
              font-size: 22px;
          }
          
          .close-cart-btn {
              background: none;
              border: none;
              font-size: 24px;
              cursor: pointer;
              color: #999;
              transition: transform 0.3s ease;
          }
          
          .close-cart-btn:hover {
              transform: rotate(90deg);
              color: #333;
          }
          
          .cart-items {
              flex: 1;
              overflow-y: auto;
              margin-bottom: 20px;
          }
          
          .cart-item {
              display: flex;
              margin-bottom: 15px;
              padding-bottom: 15px;
              border-bottom: 1px solid #eee;
              position: relative;
          }
          
          .cart-item-image {
              width: 70px;
              height: 70px;
              border-radius: 8px;
              overflow: hidden;
              margin-right: 15px;
          }
          
          .cart-item-image img {
              width: 100%;
              height: 100%;
              object-fit: cover;
          }
          
          .cart-item-details {
              flex: 1;
          }
          
          .cart-item-details h4 {
              margin: 0 0 5px;
              font-size: 16px;
              color: #333;
          }
          
          .cart-item-options {
              margin: 0 0 3px;
              font-size: 13px;
              color: #666;
          }
          
          .cart-item-toppings {
              margin: 0 0 5px;
              font-size: 13px;
              color: #666;
          }
          
          .cart-item-price {
              font-weight: bold;
              color: #ff5e62;
              font-size: 14px;
          }
          
          .cart-item-actions {
              display: flex;
              flex-direction: column;
              align-items: flex-end;
              justify-content: space-between;
              margin-left: 10px;
          }
          
          .quantity-control {
              display: flex;
              align-items: center;
              margin-bottom: 10px;
          }
          
          .quantity-btn {
              width: 28px;
              height: 28px;
              border-radius: 50%;
              border: 1px solid #ddd;
              background-color: white;
              display: flex;
              align-items: center;
              justify-content: center;
              cursor: pointer;
              font-size: 16px;
              font-weight: bold;
              color: #333;
              transition: all 0.3s ease;
          }
          
          .quantity-btn:hover {
              background-color: #f5f5f5;
          }
          
          .quantity-btn.minus:hover {
              background-color: #ffebee;
              color: #f44336;
              border-color: #ffcdd2;
          }
          
          .quantity-btn.plus:hover {
              background-color: #e8f5e9;
              color: #4caf50;
              border-color: #c8e6c9;
          }
          
          .quantity {
              margin: 0 10px;
              font-size: 16px;
              color: #333;
              min-width: 20px;
              text-align: center;
          }
          
          .cart-item-subtotal {
              font-weight: bold;
              color: #333;
              font-size: 16px;
              margin-bottom: 10px;
          }
          
          .remove-btn {
              background: none;
              border: none;
              color: #999;
              cursor: pointer;
              font-size: 16px;
              transition: color 0.3s ease;
          }
          
          .remove-btn:hover {
              color: #f44336;
          }
          
          .cart-empty {
              display: none;
              text-align: center;
              padding: 30px 0;
          }
          
          .cart-empty img {
              width: 120px;
              margin-bottom: 15px;
              opacity: 0.7;
          }
          
          .cart-empty h4 {
              margin: 0 0 10px;
              color: #333;
              font-size: 18px;
          }
          
          .cart-empty p {
              margin: 0 0 20px;
              color: #666;
              font-size: 14px;
          }
          
          .cart-footer {
              padding-top: 15px;
              border-top: 1px solid #eee;
          }
          
          .cart-subtotal, .cart-tax {
              display: flex;
              justify-content: space-between;
              margin-bottom: 10px;
              font-size: 14px;
              color: #666;
          }
          
          .cart-total {
              display: flex;
              justify-content: space-between;
              margin: 15px 0;
              font-size: 18px;
              font-weight: bold;
              color: #333;
          }
          
          .total-amount {
              color: #ff5e62;
          }
          
          .checkout-btn, .continue-shopping-btn {
              width: 100%;
              padding: 12px;
              border: none;
              border-radius: 5px;
              cursor: pointer;
              font-size: 16px;
              font-weight: 600;
              margin-bottom: 10px;
              transition: all 0.3s ease;
          }
          
          .checkout-btn {
              background-color: #ff5e62;
              color: white;
          }
          
          .checkout-btn:hover {
              background-color: #ff4146;
              transform: translateY(-2px);
              box-shadow: 0 5px 15px rgba(255, 94, 98, 0.3);
          }
          
          .continue-shopping-btn {
              background-color: #f5f5f5;
              color: #333;
          }
          
          .continue-shopping-btn:hover {
              background-color: #e5e5e5;
              transform: translateY(-2px);
              box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
          }
          
          .cart-overlay {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.5);
              z-index: 999;
              display: none;
          }
          
          .cart-overlay.active {
              display: block;
          }
          
          /* Cart Badge */
          .cart-badge {
              position: absolute;
              top: -8px;
              right: -8px;
              background-color: #ff5e62;
              color: white;
              border-radius: 50%;
              width: 20px;
              height: 20px;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 12px;
              font-weight: bold;
              box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
          }
          
          /* Animations */
          @keyframes slideInRight {
              from { transform: translateX(100%); }
              to { transform: translateX(0); }
          }
          
          @keyframes slideOutRight {
              from { transform: translateX(0); }
              to { transform: translateX(100%); }
          }
          
          @keyframes fadeIn {
              from { opacity: 0; }
              to { opacity: 1; }
          }
          
          @keyframes fadeOut {
              from { opacity: 1; }
              to { opacity: 0; }
          }
          
          /* Toast Notifications */
          .toast-container {
              position: fixed;
              bottom: 20px;
              right: 20px;
              z-index: 1000;
          }
          
          .toast {
              display: flex;
              align-items: center;
              background-color: white;
              border-radius: 5px;
              box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
              padding: 15px;
              margin-top: 10px;
              min-width: 300px;
              border-left: 4px solid #ff5e62;
              animation: fadeIn 0.3s ease;
              transition: opacity 0.3s ease;
          }
          
          .toast-close {
              background: none;
              border: none;
              font-size: 16px;
              cursor: pointer;
              color: #999;
              margin-left: 10px;
          }
          
          /* Responsive Styles */
          @media (max-width: 768px) {
              .cart-panel {
                  max-width: 100%;
              }
          }
      `
    document.head.appendChild(style)
})