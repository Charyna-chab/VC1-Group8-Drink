// Enhanced order_details.js with improved functionality
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const customizeForm = document.getElementById("customizeForm")
    const cancelOrderButton = document.getElementById("cancelOrder")
    const quantityInput = document.querySelector('input[name="quantity"]')
    const minusBtn = document.querySelector(".minus-btn")
    const plusBtn = document.querySelector(".plus-btn")

    // Price elements
    const priceElements = document.querySelectorAll("input[data-price]")
    const totalPriceElement = document.querySelector(".price-value")

    // Base price from the product
    const basePrice = Number.parseFloat(totalPriceElement.textContent.replace("$", ""))

    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById("toastContainer")
    if (!toastContainer) {
        toastContainer = document.createElement("div")
        toastContainer.id = "toastContainer"
        toastContainer.className = "toast-container"
        document.body.appendChild(toastContainer)
    }

    // Quantity buttons
    if (minusBtn) {
        minusBtn.addEventListener("click", () => {
            const quantity = Number.parseInt(quantityInput.value)
            if (quantity > 1) {
                quantityInput.value = quantity - 1
                updateTotalPrice()
            }
        })
    }

    if (plusBtn) {
        plusBtn.addEventListener("click", () => {
            const quantity = Number.parseInt(quantityInput.value)
            if (quantity < 10) {
                quantityInput.value = Number(quantity) + 1
                updateTotalPrice()
            }
        })
    }

    // Update total price when options change
    if (priceElements && priceElements.length > 0) {
        priceElements.forEach((element) => {
            element.addEventListener("change", updateTotalPrice)
        })
    }

    if (quantityInput) {
        quantityInput.addEventListener("change", function() {
            // Ensure quantity is between 1 and 10
            const quantity = Number.parseInt(this.value)
            if (isNaN(quantity) || quantity < 1) {
                this.value = 1
            } else if (quantity > 10) {
                this.value = 10
            }
            updateTotalPrice()
        })
    }

    // Calculate and update total price
    function updateTotalPrice() {
        // Get size price
        const selectedSize = document.querySelector('input[name="size"]:checked')
        const sizePrice = selectedSize ? Number.parseFloat(selectedSize.dataset.price) : 0

        // Get toppings price
        let toppingsPrice = 0
        const selectedToppings = document.querySelectorAll('input[name="toppings[]"]:checked')
        selectedToppings.forEach((topping) => {
            toppingsPrice += Number.parseFloat(topping.dataset.price)
        })

        // Get quantity
        const quantity = Number.parseInt(quantityInput.value)

        // Calculate total
        const total = (basePrice + sizePrice + toppingsPrice) * quantity

        // Update total price display
        totalPriceElement.textContent = "$" + total.toFixed(2)
    }

    // Cancel order button
    if (cancelOrderButton) {
        cancelOrderButton.addEventListener("click", () => {
            window.location.href = "/order"
        })
    }

    // Handle form submission
    if (customizeForm) {
        customizeForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Disable the submit button to prevent multiple submissions
            const submitButton = this.querySelector('button[type="submit"]')
            submitButton.disabled = true
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...'

            // Get form data
            const formData = new FormData(this)

            // Create product object from form data
            const product = {
                id: Date.now(), // Unique ID for the cart item
                productId: formData.get("product_id"),
                name: document.querySelector(".product-details-info h3").textContent,
                price: basePrice,
                image: document.querySelector(".product-details-image img").src,
                description: document.querySelector(".product-description").textContent,
                size: {
                    name: document.querySelector('input[name="size"]:checked').nextElementSibling.textContent,
                    value: formData.get("size"),
                    price: Number.parseFloat(document.querySelector('input[name="size"]:checked').dataset.price || "0"),
                },
                sugar: {
                    name: document.querySelector('input[name="sugar"]:checked').nextElementSibling.textContent,
                    value: formData.get("sugar"),
                },
                ice: {
                    name: document.querySelector('input[name="ice"]:checked').nextElementSibling.textContent,
                    value: formData.get("ice"),
                },
                toppings: [],
                quantity: Number.parseInt(formData.get("quantity")),
                instructions: formData.get("instructions"),
                orderDate: new Date().toISOString(),
                status: "processing",
            }

            // Get selected toppings
            const selectedToppings = document.querySelectorAll('input[name="toppings[]"]:checked')
            selectedToppings.forEach((topping) => {
                product.toppings.push({
                    name: topping.nextElementSibling.textContent,
                    price: Number.parseFloat(topping.dataset.price),
                })
            })

            // Calculate total price
            const sizePrice = product.size.price || 0
            let toppingsPrice = 0
            product.toppings.forEach((topping) => {
                toppingsPrice += topping.price
            })

            const itemPrice = basePrice + sizePrice + toppingsPrice
            product.basePrice = itemPrice
            product.totalPrice = itemPrice * product.quantity

            // Add to cart (if cart.js is loaded)
            if (window.addToCart) {
                window.addToCart(product)
            } else {
                // Store in localStorage as fallback
                const cart = JSON.parse(localStorage.getItem("cart")) || []
                cart.push(product)
                localStorage.setItem("cart", JSON.stringify(cart))

                // Dispatch custom event for cart update
                document.dispatchEvent(new CustomEvent("cartUpdated"))
            }

            // Show success toast
            showToast("Success", "Item added to cart!", "success")

            // Redirect to order page after a short delay
            setTimeout(() => {
                window.location.href = "/order"
            }, 1000)
        })
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        const toast = document.createElement("div")
        toast.className = `toast ${type}`

        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
        } else if (type === "error") {
            icon = "exclamation-circle"
        }

        toast.innerHTML = `
        <div>
          <i class="fas fa-${icon} toast-icon"></i>
        </div>
        <div class="toast-content">
          <h4 class="toast-title">${title}</h4>
          <p class="toast-message">${message}</p>
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

    // Initialize total price on page load
    updateTotalPrice()
})