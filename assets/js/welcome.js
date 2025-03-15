document.addEventListener("DOMContentLoaded", () => {
    // Category filtering
    const categoryItems = document.querySelectorAll(".category-item")
    const productCards = document.querySelectorAll(".product-card")
    const noProductMessage = document.getElementById("no-product-message")

    // Search functionality
    const searchInput = document.getElementById("productSearch")

    // Order modal elements
    const orderModal = document.getElementById("orderModal")
    const orderButtons = document.querySelectorAll(".order-btn")
    const closeModalButton = document.querySelector(".close-modal")
    const cancelOrderButton = document.getElementById("cancelOrder")
    const customizeForm = document.getElementById("customizeForm")
    const quantityInput = document.querySelector('input[name="quantity"]')
    const minusBtn = document.querySelector(".minus-btn")
    const plusBtn = document.querySelector(".plus-btn")

    // Favorite buttons
    const favoriteButtons = document.querySelectorAll(".favorite-btn")

    // Toast container
    const toastContainer = document.getElementById("toastContainer")

    // Filter products by category
    function filterProducts(category) {
        let visibleCount = 0

        productCards.forEach((card) => {
            const cardCategory = card.dataset.category

            if (category === "all" || cardCategory === category) {
                card.style.display = "block"
                visibleCount++
            } else {
                card.style.display = "none"
            }
        })

        // Show/hide no products message
        if (visibleCount === 0) {
            noProductMessage.style.display = "block"
        } else {
            noProductMessage.style.display = "none"
        }
    }

    // Set active category
    categoryItems.forEach((item) => {
        item.addEventListener("click", function() {
            // Remove active class from all items
            categoryItems.forEach((cat) => cat.classList.remove("active"))

            // Add active class to clicked item
            this.classList.add("active")

            // Filter products
            filterProducts(this.dataset.category)
        })
    })

    // Search functionality
    searchInput.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase().trim()
        let visibleCount = 0

        productCards.forEach((card) => {
            const productName = card.querySelector("h4").textContent.toLowerCase()
            const productDescription = card.querySelector(".description").textContent.toLowerCase()

            if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                card.style.display = "block"
                visibleCount++
            } else {
                card.style.display = "none"
            }
        })

        // Show/hide no products message
        if (visibleCount === 0) {
            noProductMessage.style.display = "block"
        } else {
            noProductMessage.style.display = "none"
        }
    })

    // Open order modal
    orderButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault()
            e.stopPropagation()

            const productId = this.dataset.productId
            const productCard = this.closest(".product-card")
            const productName = productCard.querySelector("h4").textContent
            const productDescription = productCard.querySelector(".description").textContent
            const productPrice = productCard.querySelector(".product-price").textContent
            const productImage = productCard.querySelector("img").src

            // Set product details in modal
            document.getElementById("product_id").value = productId
            document.querySelector(".modal-product-name").textContent = productName
            document.querySelector(".modal-product-description").textContent = productDescription
            document.querySelector(".modal-product-price").textContent = productPrice
            document.querySelector(".modal-product-image").src = productImage

            // Reset form
            customizeForm.reset()
            quantityInput.value = 1
            updateTotalPrice()

            // Show modal
            orderModal.classList.add("active")
            document.body.style.overflow = "hidden"
        })
    })

    // Close modal
    function closeModal() {
        orderModal.classList.remove("active")
        document.body.style.overflow = ""
    }

    closeModalButton.addEventListener("click", closeModal)
    cancelOrderButton.addEventListener("click", closeModal)

    // Close modal when clicking outside
    orderModal.addEventListener("click", (e) => {
        if (e.target === orderModal) {
            closeModal()
        }
    })

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
    const priceElements = document.querySelectorAll("input[data-price]")
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
        // Get base price
        const basePrice = Number.parseFloat(document.querySelector(".modal-product-price").textContent.replace("$", ""))

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
        document.querySelector(".price-value").textContent = "$" + total.toFixed(2)
    }

    // Handle form submission
    customizeForm.addEventListener("submit", function(e) {
        e.preventDefault()

        // Get form data
        const formData = new FormData(this)

        // In a real application, you would send this data to the server
        // For demo purposes, we'll just show a success toast

        // Close modal
        closeModal()

        // Show success toast
        showToast("Success", "Item added to cart!", "success")
    })

    // Toggle favorite
    favoriteButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault()
            e.stopPropagation()

            const icon = this.querySelector("i")

            if (icon.classList.contains("far")) {
                // Add to favorites
                icon.classList.remove("far")
                icon.classList.add("fas")
                showToast("Added to Favorites", "Item added to your favorites!", "success")
            } else {
                // Remove from favorites
                icon.classList.remove("fas")
                icon.classList.add("far")
                showToast("Removed from Favorites", "Item removed from your favorites", "info")
            }
        })
    })

    // Show toast notification
    function showToast(title, message, type = "info") {
        const toast = document.createElement("div")
        toast.className = `toast ${type}`
        toast.innerHTML = `
            <i class="toast-icon fas fa-${type === "success" ? "check-circle" : type === "error" ? "exclamation-circle" : "info-circle"}"></i>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">&times;</button>
        `

        toastContainer.appendChild(toast)

        // Auto remove toast after 3 seconds
        setTimeout(() => {
            toast.style.opacity = "0"
            setTimeout(() => {
                toast.remove()
            }, 300)
        }, 3000)

        // Close button
        toast.querySelector(".toast-close").addEventListener("click", () => {
            toast.style.opacity = "0"
            setTimeout(() => {
                toast.remove()
            }, 300)
        })
    }
})