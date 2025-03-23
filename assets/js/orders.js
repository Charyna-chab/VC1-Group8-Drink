// Enhanced order.js with improved functionality
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const categoryButtons = document.querySelectorAll(".category-btn")
    const productCards = document.querySelectorAll(".product-card")
    const searchInput = document.getElementById("productSearch")
    const orderButtons = document.querySelectorAll(".order-btn")
    const orderPanel = document.getElementById("orderPanel")
    const cartPanel = document.getElementById("cartPanel")
    const closeButtons = document.querySelectorAll(".close-btn")
    const overlay = document.getElementById("overlay")
    const noProductMessage = document.getElementById("no-product-message")
    const addToCartBtn = document.querySelector(".add-to-cart-btn")
    const checkoutBtn = document.getElementById("checkoutBtn")
    const clearCartBtn = document.getElementById("clearCartBtn")

    // Add this after the DOM Elements section
    // Product Detail Modal Elements
    const productDetailModal = document.getElementById("productDetailModal")
    const detailProductImage = document.getElementById("detailProductImage")
    const detailProductName = document.getElementById("detailProductName")
    const detailProductDescription = document.getElementById("detailProductDescription")
    const detailProductPrice = document.getElementById("detailProductPrice")
    const detailProductCategory = document.getElementById("detailProductCategory")
    const customizeOrderBtn = document.getElementById("customizeOrderBtn")
    const addToFavoritesBtn = document.getElementById("addToFavoritesBtn")
    const closeDetailBtn = productDetailModal ? productDetailModal.querySelector(".close-btn") : null

    // Form Elements
    const drinkSizeSelect = document.getElementById("drinkSize")
    const sugarLevelSelect = document.getElementById("sugarLevel")
    const iceLevelSelect = document.getElementById("iceLevel")
    const toppingCheckboxes = document.querySelectorAll('#toppings input[type="checkbox"]')
    const productImage = document.getElementById("productImage")
    const productName = document.getElementById("productName")
    const productPrice = document.getElementById("productPrice")
    const quantityInput = document.getElementById("quantity")
    const basePrice = document.getElementById("basePrice")
    const sizePrice = document.getElementById("sizePrice")
    const toppingsPrice = document.getElementById("toppingsPrice")
    const totalPrice = document.getElementById("totalPrice")

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

    // Initialize cart
    let cart = JSON.parse(localStorage.getItem("cart")) || []
    updateCartCount()

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
                noProductMessage.style.display = visibleCount === 0 ? "block" : "none"
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
                noProductMessage.style.display = visibleCount === 0 ? "block" : "none"
            }
        })
    }

    // Modify the closeAllPanels function to include the product detail modal
    function closeAllPanels() {
        // Close order panel
        if (orderPanel && orderPanel.classList.contains("active")) {
            orderPanel.classList.remove("active")
            orderPanel.style.display = "none"
        }

        // Close product detail modal
        if (productDetailModal && productDetailModal.classList.contains("active")) {
            productDetailModal.classList.remove("active")
            productDetailModal.style.display = "none"
        }

        // Close cart panel
        const cartPanel = document.getElementById("cartPanel")
        if (cartPanel && cartPanel.classList.contains("active")) {
            cartPanel.classList.remove("active")
            cartPanel.style.display = "none"
        }

        // Close notification panel
        const notificationPanel = document.getElementById("notificationPanel")
        if (notificationPanel && notificationPanel.classList.contains("active")) {
            notificationPanel.classList.remove("active")
        }

        // Hide overlay
        if (overlay) {
            overlay.style.display = "none"
            overlay.classList.remove("active")
        }

        // Remove any confirmation cards
        const confirmationCards = document.querySelectorAll(".order-confirmation-card")
        confirmationCards.forEach((card) => card.remove())
    }

    // Modify the orderButtons event listener to show product detail first
    orderButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault()
            e.stopPropagation()

            console.log("Order button clicked")

            // Close all other panels first
            closeAllPanels()

            const productCard = this.closest(".product-card")
            if (!productCard) {
                console.error("Product card not found")
                return
            }

            const productId = this.getAttribute("data-product-id")
            const productName = productCard.querySelector("h3").textContent
            const productDescription = productCard.querySelector(".product-desc").textContent
            const productPrice = Number.parseFloat(productCard.querySelector(".product-price").textContent.replace("$", ""))
            const productImage = productCard.querySelector(".product-image img").src
            const productCategory = productCard.getAttribute("data-category")

            // Store product data for later use
            currentProduct.productId = productId
            currentProduct.name = productName
            currentProduct.description = productDescription
            currentProduct.price = productPrice
            currentProduct.basePrice = productPrice
            currentProduct.image = productImage
            currentProduct.quantity = 1

            // Show product detail modal
            showProductDetail(productId, productName, productDescription, productPrice, productImage, productCategory)
        })
    })

    // Add function to show product detail
    function showProductDetail(id, name, description, price, image, category) {
        if (!productDetailModal) return

        // Update modal content
        if (detailProductImage) detailProductImage.src = image
        if (detailProductName) detailProductName.textContent = name
        if (detailProductDescription) detailProductDescription.textContent = description
        if (detailProductPrice) detailProductPrice.textContent = price.toFixed(2)
        if (detailProductCategory) {
            // Format category name (e.g., "milk-tea" -> "Milk Tea")
            const formattedCategory = category
                .split("-")
                .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
                .join(" ")
            detailProductCategory.textContent = formattedCategory
        }

        // Update favorites button
        if (addToFavoritesBtn) {
            const favorites = JSON.parse(localStorage.getItem("favorites")) || []
            const isFavorite = favorites.some((item) => item.id === id)

            const favoriteIcon = addToFavoritesBtn.querySelector("i")
            if (favoriteIcon) {
                if (isFavorite) {
                    favoriteIcon.classList.remove("far")
                    favoriteIcon.classList.add("fas")
                    addToFavoritesBtn.innerHTML = '<i class="fas fa-heart"></i> Remove from Favorites'
                } else {
                    favoriteIcon.classList.remove("fas")
                    favoriteIcon.classList.add("far")
                    addToFavoritesBtn.innerHTML = '<i class="far fa-heart"></i> Add to Favorites'
                }
            }
        }

        // Show modal and overlay
        productDetailModal.style.display = "block"
        productDetailModal.classList.add("active")

        if (overlay) {
            overlay.style.display = "block"
            overlay.classList.add("active")
        }
    }

    // Add event listener for customize order button
    if (customizeOrderBtn) {
        customizeOrderBtn.addEventListener("click", () => {
            // Close product detail modal
            if (productDetailModal) {
                productDetailModal.classList.remove("active")
                productDetailModal.style.display = "none"
            }

            // Update order panel with product details
            if (productImage) productImage.src = currentProduct.image
            if (productName) {
                productName.textContent = currentProduct.name
                productName.setAttribute("data-id", currentProduct.productId)
            }
            if (productPrice) productPrice.textContent = "$" + currentProduct.price.toFixed(2)
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
                // Make sure the panel is visible
                orderPanel.style.display = "block"
                orderPanel.classList.add("active")

                // Make sure the toppings section is visible
                const toppingsSection = document.getElementById("toppings")
                if (toppingsSection) {
                    toppingsSection.style.display = "block"
                }

                if (overlay) {
                    overlay.style.display = "block"
                    overlay.classList.add("active")
                }
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
    }

    // Add event listener for add to favorites button
    if (addToFavoritesBtn) {
        addToFavoritesBtn.addEventListener("click", function() {
            const favorites = JSON.parse(localStorage.getItem("favorites")) || []
            const isFavorite = favorites.some((item) => item.id === currentProduct.productId)

            if (isFavorite) {
                // Remove from favorites
                removeFavorite(currentProduct.productId)

                // Update button
                this.innerHTML = '<i class="far fa-heart"></i> Add to Favorites'

                // Show toast
                showToast("Removed from Favorites", `${currentProduct.name} has been removed from your favorites.`, "info")

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Removed from Favorites",
                        `${currentProduct.name} has been removed from your favorites.`,
                        "info",
                    )
                }
            } else {
                // Add to favorites
                saveFavorite(
                    currentProduct.productId,
                    currentProduct.name,
                    currentProduct.image,
                    currentProduct.price.toFixed(2),
                    currentProduct.description,
                )

                // Update button
                this.innerHTML = '<i class="fas fa-heart"></i> Remove from Favorites'

                // Show toast
                showToast("Added to Favorites", `${currentProduct.name} has been added to your favorites!`, "success")

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Added to Favorites",
                        `${currentProduct.name} has been added to your favorites.`,
                        "info",
                    )
                }

                // Add heart beat animation
                const icon = this.querySelector("i")
                if (icon) {
                    icon.style.animation = "heartBeat 0.5s ease-in-out"
                    setTimeout(() => {
                        icon.style.animation = ""
                    }, 500)
                }
            }
        })
    }

    // Add event listener for close detail button
    if (closeDetailBtn) {
        closeDetailBtn.addEventListener("click", () => {
            closeAllPanels()
        })
    }

    // Close panels
    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            closeAllPanels()
        })
    })

    if (overlay) {
        overlay.addEventListener("click", closeAllPanels)
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

    // Add event listeners to topping checkboxes
    if (toppingCheckboxes && toppingCheckboxes.length > 0) {
        toppingCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", () => {
                updateToppings()
                updateTotalPrice()
            })
        })
    }

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
        const baseItemPrice = currentProduct.price

        // Size price
        const sizeItemPrice = currentProduct.size.price || 0

        // Toppings price
        let toppingsItemPrice = 0
        currentProduct.toppings.forEach((topping) => {
            toppingsItemPrice += topping.price
        })

        // Update price displays
        if (sizePrice) sizePrice.textContent = "$" + sizeItemPrice.toFixed(2)
        if (toppingsPrice) toppingsPrice.textContent = "$" + toppingsItemPrice.toFixed(2)

        // Calculate total for one item
        const itemTotal = baseItemPrice + sizeItemPrice + toppingsItemPrice

        // Calculate total with quantity
        const total = itemTotal * currentProduct.quantity

        // Update current product total price
        currentProduct.totalPrice = total

        // Update display
        if (totalPrice) totalPrice.textContent = "$" + total.toFixed(2)
    }

    // Add to cart
    if (addToCartBtn) {
        addToCartBtn.addEventListener("click", addCurrentProductToCart)
    }

    function addCurrentProductToCart() {
        if (!drinkSizeSelect || !sugarLevelSelect || !iceLevelSelect) {
            console.error("Form elements not found")
            return
        }

        // Disable the button to prevent multiple clicks
        if (addToCartBtn) {
            addToCartBtn.disabled = true
            addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...'
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
            id: Date.now().toString(), // Unique ID for the cart item
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

        // Add to cart
        addToCart(orderItem)

        // Close order panel
        closeAllPanels()

        // Re-enable the button
        if (addToCartBtn) {
            addToCartBtn.disabled = false
            addToCartBtn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart'
        }

        // Show success message
        showToast("Added to Cart", `${orderItem.name} has been added to your cart.`, "success")

        // Add notification
        addNotification("Added to Cart", `${orderItem.name} (${orderItem.size.name}) has been added to your cart.`, "cart")
    }

    // Add to cart function
    function addToCart(item) {
        // Add item to cart array
        cart.push(item)

        // Save to localStorage
        localStorage.setItem("cart", JSON.stringify(cart))

        // Update cart count
        updateCartCount()

        // Update cart panel if it's open
        if (cartPanel && cartPanel.classList.contains("active")) {
            renderCartItems()
        }
    }

    // Update cart count
    function updateCartCount() {
        const cartCount = cart.length
        const cartCountElement = document.getElementById("cartCount")
        if (cartCountElement) {
            cartCountElement.textContent = cartCount
            cartCountElement.style.display = cartCount > 0 ? "block" : "none"
        }
    }

    // Render cart items
    function renderCartItems() {
        const cartItemsContainer = document.getElementById("cartItems")
        if (!cartItemsContainer) return

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                  <div class="empty-cart">
                      <i class="fas fa-shopping-cart"></i>
                      <p>Your cart is empty</p>
                      <button class="btn-primary" id="startShoppingBtn">Start Shopping</button>
                  </div>
              `

            const startShoppingBtn = document.getElementById("startShoppingBtn")
            if (startShoppingBtn) {
                startShoppingBtn.addEventListener("click", () => {
                    closeAllPanels()
                })
            }

            // Update cart summary
            updateCartSummary()
            return
        }

        // Render cart items
        cartItemsContainer.innerHTML = ""
        cart.forEach((item) => {
            const cartItemElement = document.createElement("div")
            cartItemElement.className = "cart-item"

            // Format toppings
            let toppingsText = "None"
            if (item.toppings && item.toppings.length > 0) {
                toppingsText = item.toppings.map((t) => t.name).join(", ")
            }

            cartItemElement.innerHTML = `
                  <div class="cart-item-image">
                      <img src="${item.image}" alt="${item.name}">
                  </div>
                  <div class="cart-item-details">
                      <h4>${item.name}</h4>
                      <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                      <p>Toppings: ${toppingsText}</p>
                      <div class="cart-item-quantity">
                          <button class="quantity-btn minus" data-id="${item.id}">-</button>
                          <input type="number" value="${item.quantity}" min="1" max="10" data-id="${item.id}">
                          <button class="quantity-btn plus" data-id="${item.id}">+</button>
                      </div>
                  </div>
                  <div class="cart-item-price">
                      <p>$${item.totalPrice.toFixed(2)}</p>
                      <button class="remove-item-btn" data-id="${item.id}">
                          <i class="fas fa-trash"></i>
                      </button>
                  </div>
              `

            cartItemsContainer.appendChild(cartItemElement)
        })

        // Add event listeners to quantity buttons and remove buttons
        const minusButtons = cartItemsContainer.querySelectorAll(".quantity-btn.minus")
        const plusButtons = cartItemsContainer.querySelectorAll(".quantity-btn.plus")
        const quantityInputs = cartItemsContainer.querySelectorAll(".cart-item-quantity input")
        const removeButtons = cartItemsContainer.querySelectorAll(".remove-item-btn")

        minusButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const itemId = button.getAttribute("data-id")
                updateCartItemQuantity(itemId, -1)
            })
        })

        plusButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const itemId = button.getAttribute("data-id")
                updateCartItemQuantity(itemId, 1)
            })
        })

        quantityInputs.forEach((input) => {
            input.addEventListener("change", () => {
                const itemId = input.getAttribute("data-id")
                const quantity = Number.parseInt(input.value)
                if (!isNaN(quantity) && quantity > 0) {
                    setCartItemQuantity(itemId, quantity)
                }
            })
        })

        removeButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const itemId = button.getAttribute("data-id")
                removeCartItem(itemId)
            })
        })

        // Update cart summary
        updateCartSummary()
    }

    // Update cart item quantity
    function updateCartItemQuantity(itemId, change) {
        const itemIndex = cart.findIndex((item) => item.id === itemId)
        if (itemIndex === -1) return

        const newQuantity = cart[itemIndex].quantity + change
        if (newQuantity < 1) return

        setCartItemQuantity(itemId, newQuantity)
    }

    // Set cart item quantity
    function setCartItemQuantity(itemId, quantity) {
        const itemIndex = cart.findIndex((item) => item.id === itemId)
        if (itemIndex === -1) return

        cart[itemIndex].quantity = quantity
        cart[itemIndex].totalPrice = cart[itemIndex].basePrice * quantity

        // Save to localStorage
        localStorage.setItem("cart", JSON.stringify(cart))

        // Update cart display
        renderCartItems()
    }

    // Remove cart item
    function removeCartItem(itemId) {
        const itemIndex = cart.findIndex((item) => item.id === itemId)
        if (itemIndex === -1) return

        const itemName = cart[itemIndex].name

        // Remove item from cart
        cart.splice(itemIndex, 1)

        // Save to localStorage
        localStorage.setItem("cart", JSON.stringify(cart))

        // Update cart count
        updateCartCount()

        // Update cart display
        renderCartItems()

        // Show toast
        showToast("Item Removed", `${itemName} has been removed from your cart.`, "info")

        // Add notification
        addNotification("Item Removed", `${itemName} has been removed from your cart.`, "cart")
    }

    // Update cart summary
    function updateCartSummary() {
        const subtotalElement = document.getElementById("cartSubtotal")
        const taxElement = document.getElementById("cartTax")
        const totalElement = document.getElementById("cartTotal")
        const checkoutBtn = document.getElementById("checkoutBtn")
        const clearCartBtn = document.getElementById("clearCartBtn")

        if (!subtotalElement || !taxElement || !totalElement) return

        // Calculate totals
        const subtotal = cart.reduce((total, item) => total + item.totalPrice, 0)
        const tax = subtotal * 0.08 // 8% tax
        const total = subtotal + tax

        // Update display
        subtotalElement.textContent = "$" + subtotal.toFixed(2)
        taxElement.textContent = "$" + tax.toFixed(2)
        totalElement.textContent = "$" + total.toFixed(2)

        // Disable checkout button if cart is empty
        if (checkoutBtn) {
            checkoutBtn.disabled = cart.length === 0
        }

        // Disable clear cart button if cart is empty
        if (clearCartBtn) {
            clearCartBtn.disabled = cart.length === 0
        }
    }

    // Open cart panel
    const cartButtons = document.querySelectorAll(".cart-btn")
    cartButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault()
            e.stopPropagation()

            // Close all other panels first
            closeAllPanels()

            // Render cart items
            renderCartItems()

            // Show cart panel and overlay
            if (cartPanel) {
                cartPanel.classList.add("active")
                if (overlay) {
                    overlay.style.display = "block"
                }
            }
        })
    })

    // Checkout button
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", () => {
            if (cart.length === 0) {
                showToast("Empty Cart", "Your cart is empty. Add some items before checking out.", "error")
                return
            }

            // In a real application, you would redirect to a checkout page
            // For now, we'll just create a booking from the cart
            createBookingFromCart()

            // Clear cart
            cart = []
            localStorage.setItem("cart", JSON.stringify(cart))

            // Update cart count
            updateCartCount()

            // Close cart panel
            closeAllPanels()

            // Show success message
            showToast("Order Placed", "Your order has been placed successfully!", "success")

            // Add notification
            addNotification("Order Placed", "Your order has been placed successfully!", "success")

            // Redirect to booking page
            window.location.href = "/booking"
        })
    }

    // Clear cart button
    if (clearCartBtn) {
        clearCartBtn.addEventListener("click", () => {
            if (cart.length === 0) return

            if (confirm("Are you sure you want to clear your cart?")) {
                // Clear cart
                cart = []
                localStorage.setItem("cart", JSON.stringify(cart))

                // Update cart count
                updateCartCount()

                // Update cart display
                renderCartItems()

                // Show toast
                showToast("Cart Cleared", "Your cart has been cleared.", "info")

                // Add notification
                addNotification("Cart Cleared", "Your cart has been cleared.", "cart")
            }
        })
    }

    // Create booking from cart
    function createBookingFromCart() {
        if (cart.length === 0) return

        // Calculate total
        const subtotal = cart.reduce((total, item) => total + item.totalPrice, 0)
        const tax = subtotal * 0.08 // 8% tax
        const total = subtotal + tax

        // Create booking
        const booking = {
            id: "ORD" + Date.now().toString().slice(-6),
            date: new Date().toISOString(),
            items: cart,
            subtotal,
            tax,
            total,
            status: "processing",
        }

        // Get existing bookings
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []

        // Add new booking
        bookings.unshift(booking)

        // Save to localStorage
        localStorage.setItem("bookings", JSON.stringify(bookings))
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
                addNotification("Added to Favorites", `${productName} has been added to your favorites.`, "info")
            } else {
                icon.classList.remove("fas")
                icon.classList.add("far")
                removeFavorite(productId)
                showToast("Removed from Favorites", "Item removed from your favorites", "info")

                // Add notification
                addNotification("Removed from Favorites", `${productName} has been removed from your favorites.`, "info")
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
        }
    }

    // Remove favorite from localStorage
    function removeFavorite(id) {
        let favorites = JSON.parse(localStorage.getItem("favorites")) || []
        favorites = favorites.filter((item) => item.id !== id)
        localStorage.setItem("favorites", JSON.stringify(favorites))
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector(".toast-container")
        if (!toastContainer) {
            toastContainer = document.createElement("div")
            toastContainer.className = "toast-container"
            document.body.appendChild(toastContainer)
        }

        const toast = document.createElement("div")
        toast.className = "toast"

        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
            toast.classList.add("success")
        } else if (type === "error") {
            icon = "exclamation-circle"
            toast.classList.add("error")
        } else if (type === "cart") {
            icon = "shopping-cart"
            toast.classList.add("cart")
        }

        toast.innerHTML = `
              <div class="toast-icon">
                  <i class="fas fa-${icon}"></i>
              </div>
              <div class="toast-content">
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
            toast.classList.add("toast-hide")
            setTimeout(() => {
                toast.remove()
            }, 300)
        })

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.classList.add("toast-hide")
            setTimeout(() => {
                toast.remove()
            }, 300)
        }, 5000)
    }

    // Add notification
    function addNotification(title, message, type = "info") {
        // Get notification list
        const notificationList = document.getElementById("notificationList")
        if (!notificationList) return

        // Remove empty notification message if present
        const emptyNotification = notificationList.querySelector(".empty-notification")
        if (emptyNotification) {
            emptyNotification.remove()
        }

        // Create notification item
        const notification = document.createElement("div")
        notification.className = "notification-item"

        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
            notification.classList.add("success")
        } else if (type === "error") {
            icon = "exclamation-circle"
            notification.classList.add("error")
        } else if (type === "cart") {
            icon = "shopping-cart"
            notification.classList.add("cart")
        } else if (type === "order") {
            icon = "receipt"
            notification.classList.add("order")
        }

        notification.innerHTML = `
              <div class="notification-icon">
                  <i class="fas fa-${icon}"></i>
              </div>
              <div class="notification-content">
                  <h4>${title}</h4>
                  <p>${message}</p>
                  <span class="notification-time">Just now</span>
              </div>
              <button class="notification-close">&times;</button>
          `

        // Add to notification list
        notificationList.insertBefore(notification, notificationList.firstChild)

        // Add close button functionality
        const closeButton = notification.querySelector(".notification-close")
        closeButton.addEventListener("click", () => {
            notification.remove()

            // Show empty notification message if no notifications
            if (notificationList.children.length === 0) {
                notificationList.innerHTML = `
                      <div class="empty-notification">
                          <i class="fas fa-bell-slash"></i>
                          <p>No notifications yet</p>
                      </div>
                  `
            }
        })
    }

    // Toggle notification panel
    const notificationButtons = document.querySelectorAll(".notification-btn")
    const notificationPanel = document.getElementById("notificationPanel")

    notificationButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault()
            e.stopPropagation()

            // Close all other panels first
            closeAllPanels()

            // Show notification panel and overlay
            if (notificationPanel) {
                notificationPanel.classList.add("active")
                if (overlay) {
                    overlay.style.display = "block"
                }
            }
        })
    })

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
})

// Add this to the style element at the end of the file
const style = document.createElement("style")
document.head.appendChild(style)

style.textContent += `
      /* Product Detail Modal Styles */
      .product-detail-modal {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: none;
          justify-content: center;
          align-items: center;
          z-index: 1000;
      }
      
      .product-detail-modal.active {
          display: flex;
      }
      
      .product-detail-content {
          position: relative;
          width: 90%;
          max-width: 500px;
          background-color: white;
          border-radius: 10px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
          display: flex;
          flex-direction: column;
          overflow: hidden;
          animation: fadeIn 0.3s ease;
          max-height: 90vh;
          overflow-y: auto;
      }
      
      .product-detail-image {
          width: 100%;
          padding: 30px;
          display: flex;
          justify-content: center;
          align-items: center;
          background-color: #fff;
      }
      
      .product-detail-image img {
          max-width: 100%;
          height: 250px;
          object-fit: contain;
      }
      
      .product-detail-info {
          padding: 0 20px 20px;
          display: flex;
          flex-direction: column;
      }
      
      .product-detail-info h3 {
          margin: 0 0 15px;
          font-size: 24px;
          color: #333;
          font-weight: 600;
      }
      
      .product-detail-desc {
          margin: 0 0 20px;
          font-size: 16px;
          color: #666;
          line-height: 1.6;
      }
      
      .product-detail-price {
          font-size: 24px;
          font-weight: 700;
          color: #ff5e62;
          margin-bottom: 15px;
      }
      
      .product-detail-category {
          margin-bottom: 20px;
          font-size: 14px;
          color: #666;
      }
      
      .product-detail-category span:first-child {
          font-weight: 600;
      }
      
      .product-detail-actions {
          display: flex;
          gap: 10px;
          margin-top: 20px;
      }
      
      .product-detail-actions button {
          flex: 1;
          padding: 12px;
          font-size: 16px;
          font-weight: 600;
          border-radius: 5px;
          cursor: pointer;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          transition: all 0.3s ease;
      }
      
      .product-detail-content .close-btn {
          position: absolute;
          top: 10px;
          right: 10px;
          background: none;
          border: none;
          font-size: 24px;
          color: #999;
          cursor: pointer;
          z-index: 10;
          width: 30px;
          height: 30px;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 50%;
          background-color: rgba(255, 255, 255, 0.8);
      }
      
      .product-detail-content .close-btn:hover {
          background-color: rgba(0, 0, 0, 0.1);
          color: #333;
      }
      
      .btn-primary {
          background-color: #ff5e62;
          color: white;
          border: none;
      }
      
      .btn-primary:hover {
          background-color: #ff4146;
      }
      
      .btn-outline {
          background-color: transparent;
          color: #ff5e62;
          border: 1px solid #ff5e62;
      }
      
      .btn-outline:hover {
          background-color: #fff0f0;
      }
      
      @keyframes fadeIn {
          from { opacity: 0; transform: translateY(-20px); }
          to { opacity: 1; transform: translateY(0); }
      }
  `