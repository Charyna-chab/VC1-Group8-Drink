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
    minusBtn.addEventListener("click", () => {
        const quantity = Number.parseInt(quantityInput.value)
        if (quantity > 1) {
            quantityInput.value = quantity - 1
            updateTotalPrice()
        }
    })

    plusBtn.addEventListener("click", () => {
        const quantity = Number.parseInt(quantityInput.value)
        if (quantity < 10) {
            quantityInput.value = quantity + 1
            updateTotalPrice()
        }
    })

    // Update total price when options change
    priceElements.forEach((element) => {
        element.addEventListener("change", updateTotalPrice)
    })

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
    cancelOrderButton.addEventListener("click", () => {
        window.location.href = "/order"
    })

    // Handle form submission
    customizeForm.addEventListener("submit", function(e) {
        e.preventDefault()

        // Get form data
        const formData = new FormData(this)

        // In a real application, you would send this data to the server
        // For demo purposes, we'll just show a success toast

        // Show success toast
        showToast("Success", "Item added to cart!", "success")

        // Redirect to order page after a delay
        setTimeout(() => {
            window.location.href = "/order"
        }, 2000)
    })

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
})