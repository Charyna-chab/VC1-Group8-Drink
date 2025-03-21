// order.js - Enhanced with notifications and cart functionality
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const categoryButtons = document.querySelectorAll(".category-btn")
    const productCards = document.querySelectorAll(".product-card")

    const searchInput = document.getElementById("productSearch")
    const orderButtons = document.querySelectorAll(".order-btn")
    const orderPanel = document.getElementById("orderPanel")
    const closeBtn = document.querySelector(".order-panel .close-btn")
    const overlay = document.getElementById("overlay")
    const noProductMessage = document.getElementById("no-product-message")
    const addToCartBtn = document.querySelector(".add-to-cart-btn")
    const confirmBtn = document.querySelector(".confirm-btn")

    console.log("Order elements:", {
        categoryButtons: categoryButtons.length,
        productCards: productCards.length,
        searchInput: !!searchInput,
        orderButtons: orderButtons.length,
        orderPanel: !!orderPanel,
        closeBtn: !!closeBtn,
        overlay: !!overlay,
        noProductMessage: !!noProductMessage,
        addToCartBtn: !!addToCartBtn,
        confirmBtn: !!confirmBtn,
    })

    // Form Elements
    const drinkSizeSelect = document.getElementById("drinkSize")
    const sugarLevelSelect = document.getElementById("sugarLevel")
    const iceLevelSelect = document.getElementById("iceLevel")
    const toppingCheckboxes = document.querySelectorAll('#toppings input[type="checkbox"]')
    const productImage = document.getElementById("productImage")
    const productName = document.getElementById("productName")
    const productPrice = document.getElementById("productPrice")
    const quantityInput = document.getElementById("quantity")

    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById("toastContainer")
    if (!toastContainer) {
        toastContainer = document.createElement("div")
        toastContainer.id = "toastContainer"
        toastContainer.className = "toast-container"
        document.body.appendChild(toastContainer)
    }

    // Current product data
    const currentProduct = {
        id: null,
        productId: null,
        name: "",
        price: 0,
        image: "",
        description: "",
        size: { name: "Small-Size", value: "small", price: 0 },
        sugar: { name: "50% Sugar", value: "50" },
        ice: { name: "Normal Ice", value: "normal" },
        toppings: [],
        quantity: 1,
        basePrice: 0,
        totalPrice: 0,
    }

    // Check URL parameters for product_id
    const urlParams = new URLSearchParams(window.location.search)
    const productIdFromUrl = urlParams.get("product_id")

    if (productIdFromUrl) {
        // Find the product with the matching ID
        const productButton = document.querySelector(`.order-btn[data-product-id="${productIdFromUrl}"]`)
        if (productButton) {
            // Simulate a click on the order button
            setTimeout(() => {
                productButton.click()
            }, 500)
        }
    }

    // Filter products by category
    categoryButtons.forEach((button) => {
        button.addEventListener("click", function() {
            // Remove active class from all buttons
            categoryButtons.forEach((btn) => btn.classList.remove("active"))

            // Add active class to clicked button
            this.classList.add("active")

            const category = this.getAttribute("data-category")

            // Filter products
            let visibleCount = 0
            productCards.forEach((card) => {
                if (category === "all" || card.getAttribute("data-category") === category) {
                    card.style.display = "block"
                    visibleCount++
                } else {
                    card.style.display = "none"
                }
            })

            // Show/hide no products message
            if (noProductMessage) {
                if (visibleCount === 0) {
                    noProductMessage.style.display = "block"
                } else {
                    noProductMessage.style.display = "none"
                }
            }
        })
    })

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener("input", function() {
            const searchTerm = this.value.toLowerCase().trim()
            let visibleCount = 0

            productCards.forEach((card) => {
                const productName = card.querySelector("h3").textContent.toLowerCase()
                const productDescription = card.querySelector(".product-desc").textContent.toLowerCase()

                if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                    card.style.display = "block"
                    visibleCount++
                } else {
                    card.style.display = "none"
                }
            })

            // Show/hide no products message
            if (noProductMessage) {
                if (visibleCount === 0) {
                    noProductMessage.style.display = "block"
                } else {
                    noProductMessage.style.display = "none"
                }
            }
        })
    }

    // Open order panel
    orderButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault()
            e.stopPropagation()

            const productCard = this.closest(".product-card")
            if (!productCard) {
                console.error("Product card not found")
                return
            }

            currentProduct.productId = this.getAttribute("data-product-id")
            currentProduct.name = productCard.querySelector("h3").textContent
            currentProduct.description = productCard.querySelector(".product-desc").textContent
            currentProduct.price = Number.parseFloat(productCard.querySelector(".product-price").textContent.replace("$", ""))
            currentProduct.basePrice = currentProduct.price
            currentProduct.image = productCard.querySelector(".product-image img").src
            currentProduct.quantity = 1

            // Update order panel with product details
            if (productImage) productImage.src = currentProduct.image
            if (productName) {
                productName.textContent = currentProduct.name
                productName.setAttribute("data-id", currentProduct.productId)
            }
            if (productPrice) productPrice.textContent = "$" + currentProduct.price.toFixed(2)

            const basePrice = document.getElementById("basePrice")
            if (basePrice) basePrice.textContent = "$" + currentProduct.price.toFixed(2)

            // Reset quantity
            if (quantityInput) {
                quantityInput.value = 1
            }

            // Reset form
            if (drinkSizeSelect) drinkSizeSelect.selectedIndex = 0
            if (sugarLevelSelect) sugarLevelSelect.selectedIndex = 2 // Default to 50% sugar
            if (iceLevelSelect) iceLevelSelect.selectedIndex = 2 // Default to normal ice
            toppingCheckboxes.forEach((checkbox) => (checkbox.checked = false))

            // Update total price
            updateTotalPrice()

            // Show order panel and overlay
            if (orderPanel) {
                orderPanel.classList.add("active")
                if (overlay) overlay.classList.add("active")

                // Add animation
                orderPanel.style.animation = "slideIn 0.3s forwards"
            }

            // Add notification for starting an order
            if (window.addNotification) {
                window.addNotification(
                    "Customizing Order",
                    `You're customizing ${currentProduct.name}. Add toppings and adjust options to your liking!`,
                    "info",
                )
            }
        })
    })

    // Close order panel
    if (closeBtn && orderPanel) {
        closeBtn.addEventListener("click", closeOrderPanel)
    }

    if (overlay && orderPanel) {
        overlay.addEventListener("click", closeOrderPanel)
    }

    function closeOrderPanel() {
        if (!orderPanel) return

        orderPanel.style.animation = "slideOut 0.3s forwards"
        setTimeout(() => {
            orderPanel.classList.remove("active")
            if (overlay) overlay.classList.remove("active")
        }, 300)
    }

    // Update price when options change
    if (drinkSizeSelect) {
        drinkSizeSelect.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex]
            const sizePrice = Number.parseFloat(selectedOption.getAttribute("data-price") || "0")
            const sizeName = selectedOption.text
            const sizeValue = this.value

            currentProduct.size = {
                name: sizeName,
                value: sizeValue,
                price: sizePrice,
            }

            updateTotalPrice()
        })
    }

    if (sugarLevelSelect) {
        sugarLevelSelect.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex]
            const sugarName = selectedOption.text
            const sugarValue = this.value

            currentProduct.sugar = {
                name: sugarName,
                value: sugarValue,
            }
        })
    }

    if (iceLevelSelect) {
        iceLevelSelect.addEventListener("change", function() {
            const selectedOption = this.options[this.selectedIndex]
            const iceName = selectedOption.text
            const iceValue = this.value

            currentProduct.ice = {
                name: iceName,
                value: iceValue,
            }
        })
    }

    // Quantity change
    if (quantityInput) {
        quantityInput.addEventListener("change", function() {
            let quantity = Number.parseInt(this.value)

            // Validate quantity
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1
                this.value = 1
            }

            currentProduct.quantity = quantity
            updateTotalPrice()
        })

        // Quantity buttons
        const minusBtn = document.querySelector(".quantity-btn.minus")
        const plusBtn = document.querySelector(".quantity-btn.plus")

        if (minusBtn) {
            minusBtn.addEventListener("click", () => {
                let quantity = Number.parseInt(quantityInput.value)
                if (quantity > 1) {
                    quantity--
                    quantityInput.value = quantity
                    currentProduct.quantity = quantity
                    updateTotalPrice()
                }
            })
        }

        if (plusBtn) {
            plusBtn.addEventListener("click", () => {
                let quantity = Number.parseInt(quantityInput.value)
                quantity++
                quantityInput.value = quantity
                currentProduct.quantity = quantity
                updateTotalPrice()
            })
        }
    }

    toppingCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            updateToppings()
            updateTotalPrice()
        })
    })

    // Update toppings array
    function updateToppings() {
        currentProduct.toppings = []
        toppingCheckboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                currentProduct.toppings.push({
                    name: checkbox.value,
                    price: Number.parseFloat(checkbox.getAttribute("data-price") || "0"),
                })
            }
        })
    }

    // Calculate and update total price
    function updateTotalPrice() {
        // Base price
        const basePrice = currentProduct.price

        // Size price
        const sizePrice = currentProduct.size.price || 0

        // Toppings price
        let toppingsPrice = 0
        currentProduct.toppings.forEach((topping) => {
            toppingsPrice += topping.price
        })

        // Update price displays
        const sizePriceElement = document.getElementById("sizePrice")
        const toppingsPriceElement = document.getElementById("toppingsPrice")
        const totalPriceElement = document.getElementById("totalPrice")

        if (sizePriceElement) sizePriceElement.textContent = "$" + sizePrice.toFixed(2)
        if (toppingsPriceElement) toppingsPriceElement.textContent = "$" + toppingsPrice.toFixed(2)

        // Calculate total for one item
        const itemTotal = basePrice + sizePrice + toppingsPrice

        // Calculate total with quantity
        const total = itemTotal * currentProduct.quantity

        // Update current product total price
        currentProduct.totalPrice = total

        // Update display
        if (totalPriceElement) totalPriceElement.textContent = "$" + total.toFixed(2)
    }

    // Add to cart
    if (addToCartBtn) {
        addToCartBtn.addEventListener("click", addCurrentProductToCart)
    }

    // Confirm button (legacy support)
    if (confirmBtn) {
        confirmBtn.addEventListener("click", addCurrentProductToCart)
    }

    function addCurrentProductToCart() {
        if (!drinkSizeSelect || !sugarLevelSelect || !iceLevelSelect) {
            console.error("Form elements not found")
            return
        }

        // Get current selections
        const size = drinkSizeSelect.options[drinkSizeSelect.selectedIndex].text
        const sizeValue = drinkSizeSelect.value
        const sizePrice = Number.parseFloat(
            drinkSizeSelect.options[drinkSizeSelect.selectedIndex].getAttribute("data-price") || "0",
        )

        const sugar = sugarLevelSelect.options[sugarLevelSelect.selectedIndex].text
        const sugarValue = sugarLevelSelect.value

        const ice = iceLevelSelect.options[iceLevelSelect.selectedIndex].text
        const iceValue = iceLevelSelect.value

        // Calculate total price
        const basePrice = currentProduct.price

        let toppingsPrice = 0
        const selectedToppings = []
        toppingCheckboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const toppingPrice = Number.parseFloat(checkbox.getAttribute("data-price") || "0")
                toppingsPrice += toppingPrice
                selectedToppings.push({
                    name: checkbox.value,
                    price: toppingPrice,
                })
            }
        })

        const itemPrice = basePrice + sizePrice + toppingsPrice
        const quantity = currentProduct.quantity
        const totalPrice = itemPrice * quantity

        // Create order item
        const orderItem = {
            id: Date.now(), // Unique ID for the cart item
            productId: currentProduct.productId,
            name: currentProduct.name,
            image: currentProduct.image,
            description: currentProduct.description,
            basePrice: itemPrice,
            size: {
                name: size,
                value: sizeValue,
                price: sizePrice,
            },
            sugar: {
                name: sugar,
                value: sugarValue,
            },
            ice: {
                name: ice,
                value: iceValue,
            },
            toppings: selectedToppings,
            quantity: quantity,
            totalPrice: totalPrice,
            orderDate: new Date().toISOString(),
            status: "processing",
        }

        // Add to cart using the cart.js function
        if (window.addToCart) {
            window.addToCart(orderItem)

            // Add notification
            if (window.addNotification) {
                window.addNotification(
                    "Added to Cart",
                    `${orderItem.name} (${orderItem.size.name}) has been added to your cart.`,
                    "cart",
                )
            }
        } else {
            // Fallback if cart.js is not loaded
            console.error("addToCart function not found")
            showToast("Error", "Cart functionality not available. Please refresh the page and try again.", "error")
        }

        // Close order panel
        closeOrderPanel()

        // Show order confirmation card
        showOrderConfirmation(orderItem)
    }

    // Show order confirmation card
    function showOrderConfirmation(orderItem) {
        // Create confirmation card
        const confirmationCard = document.createElement("div")
        confirmationCard.className = "order-confirmation-card"

        // Format toppings
        let toppingsText = "None"
        if (orderItem.toppings && orderItem.toppings.length > 0) {
            toppingsText = orderItem.toppings.map((t) => t.name).join(", ")
        }

        confirmationCard.innerHTML = `
      <div class="confirmation-content">
        <div class="confirmation-header">
          <h3>Added to Cart!</h3>
          <button class="close-confirmation">&times;</button>
        </div>
        <div class="confirmation-product">
          <img src="${orderItem.image}" alt="${orderItem.name}">
          <div class="confirmation-details">
            <h4>${orderItem.name}</h4>
            <p>Size: ${orderItem.size.name}</p>
            <p>Sugar: ${orderItem.sugar.name}</p>
            <p>Ice: ${orderItem.ice.name}</p>
            <p>Toppings: ${toppingsText}</p>
            <p>Quantity: ${orderItem.quantity}</p>
            <p class="confirmation-price">$${orderItem.totalPrice.toFixed(2)}</p>
          </div>
        </div>
        <div class="confirmation-actions">
          <button class="view-cart-btn">View Cart</button>
          <button class="checkout-btn">Checkout Now</button>
          <button class="continue-shopping-btn">Continue Shopping</button>
        </div>
      </div>
    `

        document.body.appendChild(confirmationCard)

        // Add event listeners
        const closeBtn = confirmationCard.querySelector(".close-confirmation")
        closeBtn.addEventListener("click", () => {
            confirmationCard.style.animation = "fadeOut 0.3s forwards"
            setTimeout(() => {
                confirmationCard.remove()
            }, 300)
        })

        const viewCartBtn = confirmationCard.querySelector(".view-cart-btn")
        viewCartBtn.addEventListener("click", () => {
            confirmationCard.remove()
                // Open cart panel if it exists
            if (document.getElementById("cartPanel")) {
                const cartPanel = document.getElementById("cartPanel")
                if (overlay) overlay.classList.add("active")
                cartPanel.classList.add("active")
            } else {
                console.error("Cart panel not found")
            }
        })

        const checkoutBtn = confirmationCard.querySelector(".checkout-btn")
        checkoutBtn.addEventListener("click", () => {
            confirmationCard.remove()
                // Redirect to booking page
            window.location.href = "/booking"
        })

        const continueShoppingBtn = confirmationCard.querySelector(".continue-shopping-btn")
        continueShoppingBtn.addEventListener("click", () => {
            confirmationCard.style.animation = "fadeOut 0.3s forwards"
            setTimeout(() => {
                confirmationCard.remove()
            }, 300)
        })

        // Add CSS for confirmation card
        if (!document.querySelector("#order-confirmation-styles")) {
            const style = document.createElement("style")
            style.id = "order-confirmation-styles"
            style.textContent = `
        .order-confirmation-card {
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          width: 90%;
          max-width: 500px;
          background-color: white;
          border-radius: 10px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
          z-index: 1000;
          animation: fadeIn 0.3s forwards;
          overflow: hidden;
        }
        
        .confirmation-content {
          padding: 20px;
        }
        
        .confirmation-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 15px;
          padding-bottom: 15px;
          border-bottom: 1px solid #eee;
        }
        
        .confirmation-header h3 {
          margin: 0;
          color: #4caf50;
          font-size: 22px;
        }
        
        .close-confirmation {
          background: none;
          border: none;
          font-size: 24px;
          cursor: pointer;
          color: #999;
        }
        
        .confirmation-product {
          display: flex;
          margin-bottom: 20px;
          background-color: #f9f9f9;
          border-radius: 8px;
          padding: 15px;
        }
        
        .confirmation-product img {
          width: 80px;
          height: 80px;
          border-radius: 8px;
          object-fit: cover;
          margin-right: 15px;
        }
        
        .confirmation-details {
          flex: 1;
        }
        
        .confirmation-details h4 {
          margin: 0 0 10px;
          color: #333;
        }
        
        .confirmation-details p {
          margin: 5px 0;
          color: #666;
          font-size: 14px;
        }
        
        .confirmation-price {
          font-weight: bold;
          color: #ff5e62 !important;
          font-size: 16px !important;
        }
        
        .confirmation-actions {
          display: flex;
          flex-wrap: wrap;
          gap: 10px;
        }
        
        .confirmation-actions button {
          flex: 1;
          padding: 12px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          font-weight: 600;
          transition: all 0.3s ease;
          min-width: 120px;
        }
        
        .view-cart-btn {
          background-color: #f5f5f5;
          color: #333;
        }
        
        .view-cart-btn:hover {
          background-color: #e5e5e5;
        }
        
        .checkout-btn {
          background-color: #4caf50;
          color: white;
        }
        
        .checkout-btn:hover {
          background-color: #3d9140;
        }
        
        .continue-shopping-btn {
          background-color: #ff5e62;
          color: white;
        }
        
        .continue-shopping-btn:hover {
          background-color: #ff4146;
        }
        
        @keyframes fadeIn {
          from { opacity: 0; transform: translate(-50%, -60%); }
          to { opacity: 1; transform: translate(-50%, -50%); }
        }
        
        @keyframes fadeOut {
          from { opacity: 1; transform: translate(-50%, -50%); }
          to { opacity: 0; transform: translate(-50%, -60%); }
        }
      `
            document.head.appendChild(style)
        }
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

    // Initialize favorite buttons
    const favoriteButtons = document.querySelectorAll(".favorite-btn")
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
                icon.classList.remove("far")
                icon.classList.add("fas")
                saveFavorite(productId, productName, productImage, productPrice, productDescription)
                showToast("Added to Favorites", "Item added to your favorites!", "success")

                // Add notification
                if (window.addNotification) {
                    window.addNotification("Added to Favorites", `${productName} has been added to your favorites.`, "info")
                }

                // Add heart beat animation
                icon.style.animation = "heartBeat 0.5s ease-in-out"
                setTimeout(() => {
                    icon.style.animation = ""
                }, 500)
            } else {
                icon.classList.remove("fas")
                icon.classList.add("far")
                removeFavorite(productId)
                showToast("Removed from Favorites", "Item removed from your favorites", "info")

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

    // Save favorite to localStorage
    function saveFavorite(id, name, image, price, description) {
        const favorites = JSON.parse(localStorage.getItem("favorites")) || []

        // Remove price formatting
        price = price.replace("$", "").trim()

        if (!favorites.some((item) => item.id === id)) {
            favorites.push({
                id,
                name,
                image,
                price,
                description: description || "A delicious drink from Xing Fu Cha",
            })
            localStorage.setItem("favorites", JSON.stringify(favorites))

            // If we're not on the favorites page, ask if they want to view favorites
            if (window.location.pathname !== "/favorites") {
                showFavoritesPrompt(name)
            }
        }
    }

    // Remove favorite from localStorage
    function removeFavorite(id) {
        let favorites = JSON.parse(localStorage.getItem("favorites")) || []
        favorites = favorites.filter((item) => item.id !== id)
        localStorage.setItem("favorites", JSON.stringify(favorites))
    }

    // Show favorites prompt
    function showFavoritesPrompt(productName) {
        const prompt = document.createElement("div")
        prompt.className = "favorites-prompt"

        prompt.innerHTML = `
      <div class="favorites-prompt-content">
        <div class="favorites-prompt-icon">
          <i class="fas fa-heart"></i>
        </div>
        <div class="favorites-prompt-text">
          <h4>Added to Favorites!</h4>
          <p>${productName} has been added to your favorites.</p>
        </div>
        <div class="favorites-prompt-actions">
          <button class="view-favorites-btn">View Favorites</button>
          <button class="close-prompt-btn">Continue Shopping</button>
        </div>
      </div>
    `

        document.body.appendChild(prompt)

        // Add event listeners
        const viewFavoritesBtn = prompt.querySelector(".view-favorites-btn")
        viewFavoritesBtn.addEventListener("click", () => {
            window.location.href = "/favorites"
        })

        const closePromptBtn = prompt.querySelector(".close-prompt-btn")
        closePromptBtn.addEventListener("click", () => {
            prompt.classList.add("fade-out")
            setTimeout(() => {
                prompt.remove()
            }, 300)
        })

        // Auto remove after 5 seconds
        setTimeout(() => {
            prompt.classList.add("fade-out")
            setTimeout(() => {
                prompt.remove()
            }, 300)
        }, 5000)

        // Add CSS for favorites prompt
        if (!document.querySelector("#favorites-prompt-styles")) {
            const style = document.createElement("style")
            style.id = "favorites-prompt-styles"
            style.textContent = `
        .favorites-prompt {
          position: fixed;
          bottom: 20px;
          left: 20px;
          background-color: white;
          border-radius: 10px;
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
          z-index: 1000;
          animation: slideInLeft 0.3s ease forwards;
          transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .favorites-prompt.fade-out {
          opacity: 0;
          transform: translateX(-20px);
        }
        
        .favorites-prompt-content {
          display: flex;
          padding: 15px;
          align-items: center;
          gap: 15px;
        }
        
        .favorites-prompt-icon {
          width: 40px;
          height: 40px;
          background-color: #fff0f0;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #ff5e62;
          font-size: 20px;
        }
        
        .favorites-prompt-text {
          flex: 1;
        }
        
        .favorites-prompt-text h4 {
          margin: 0 0 5px;
          font-size: 16px;
          color: #333;
        }
        
        .favorites-prompt-text p {
          margin: 0;
          font-size: 14px;
          color: #666;
        }
        
        .favorites-prompt-actions {
          display: flex;
          flex-direction: column;
          gap: 5px;
        }
        
        .view-favorites-btn {
          padding: 8px 12px;
          background-color: #ff5e62;
          color: white;
          border: none;
          border-radius: 5px;
          font-size: 12px;
          font-weight: 600;
          cursor: pointer;
          transition: background-color 0.3s ease;
        }
        
        .view-favorites-btn:hover {
          background-color: #ff4146;
        }
        
        .close-prompt-btn {
          padding: 8px 12px;
          background-color: transparent;
          color: #666;
          border: none;
          border-radius: 5px;
          font-size: 12px;
          font-weight: 600;
          cursor: pointer;
          transition: background-color 0.3s ease;
        }
        
        .close-prompt-btn:hover {
          background-color: #f5f5f5;
        }
        
        @keyframes slideInLeft {
          from { transform: translateX(-100%); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }
      `
            document.head.appendChild(style)
        }
    }

    // Check if products are in favorites and update UI
    function updateFavoriteButtons() {
        const favorites = JSON.parse(localStorage.getItem("favorites")) || []

        favoriteButtons.forEach((button) => {
            const productId = button.closest(".product-card").querySelector(".order-btn").getAttribute("data-product-id")
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

    // Call on page load
    updateFavoriteButtons()

    // Add CSS animations
    const style = document.createElement("style")
    style.textContent = `
    @keyframes slideIn {
      from { transform: translateX(100%); }
      to { transform: translateX(0); }
    }
    
    @keyframes slideOut {
      from { transform: translateX(0); }
      to { transform: translateX(100%); }
    }
    
    @keyframes heartBeat {
      0% { transform: scale(1); }
      25% { transform: scale(1.3); }
      50% { transform: scale(1); }
      75% { transform: scale(1.3); }
      100% { transform: scale(1); }
    }
    
    .order-panel {
      transition: transform 0.3s ease;
    }
    
    .product-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .order-btn {
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    
    .order-btn:hover {
      transform: scale(1.05);
    }
    
    .favorite-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: white;
      border: none;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      z-index: 2;
    }
    
    .favorite-btn:hover {
      transform: scale(1.2);
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }
    
    .favorite-btn i {
      color: #ff5e62;
      font-size: 18px;
    }
    
    .favorite-btn i.far {
      color: #666;
    }
    
    .favorite-btn i.fas {
      color: #ff5e62;
    }
    
    #no-product-message {
      display: none;
      text-align: center;
      padding: 30px;
      color: #666;
      font-size: 16px;
      grid-column: 1 / -1;
    }
  `
    document.head.appendChild(style)
})