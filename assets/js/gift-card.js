document.addEventListener("DOMContentLoaded", () => {
    // Price option selection
    const priceOptions = document.querySelectorAll(".price-option")
    priceOptions.forEach((option) => {
        option.addEventListener("click", function() {
            // Remove active class from all options in the same group
            const parentGroup = this.closest(".price-options")
            parentGroup.querySelectorAll(".price-option").forEach((opt) => {
                opt.classList.remove("active")
            })

            // Add active class to clicked option
            this.classList.add("active")
        })
    })

    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll(".add-to-cart-btn")
    addToCartButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const cardItem = this.closest(".gift-card-item")
            const cardId = cardItem.dataset.id
            const cardName = cardItem.querySelector("h3").textContent
            const activeOption = cardItem.querySelector(".price-option.active")
            const discount = activeOption ? activeOption.dataset.value : "0"

            // Add to cart logic (this would typically send data to a server)
            addToCart(cardId, cardName, discount)

            // Show success message
            showToast(`Added ${cardName} to cart!`, "success")

            // Add animation to button
            this.classList.add("animate-pulse")
            setTimeout(() => {
                this.classList.remove("animate-pulse")
            }, 1000)
        })
    })

    // FAQ accordion functionality
    const faqItems = document.querySelectorAll(".faq-item")
    faqItems.forEach((item) => {
        const question = item.querySelector(".faq-question")
        question.addEventListener("click", () => {
            // Toggle active class
            item.classList.toggle("active")
        })
    })

    // Helper functions
    function addToCart(id, name, discount) {
        // This would typically send data to a server or store in localStorage
        console.log(`Added to cart: ${name} (ID: ${id}) with discount: ${discount}`)

        // For demo purposes, we'll just store in localStorage
        const cart = JSON.parse(localStorage.getItem("cart")) || []
        cart.push({
            id: id,
            name: name,
            discount: discount,
            type: "gift-card",
            timestamp: new Date().getTime(),
        })
        localStorage.setItem("cart", JSON.stringify(cart))

        // Update cart count in header if it exists
        updateCartCount()
    }

    function updateCartCount() {
        const cartCountElement = document.querySelector(".cart-count")
        if (cartCountElement) {
            const cart = JSON.parse(localStorage.getItem("cart")) || []
            cartCountElement.textContent = cart.length

            if (cart.length > 0) {
                cartCountElement.classList.add("has-items")
            } else {
                cartCountElement.classList.remove("has-items")
            }
        }
    }

    function showToast(message, type = "info") {
        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector(".toast-container")
        if (!toastContainer) {
            toastContainer = document.createElement("div")
            toastContainer.className = "toast-container"
            document.body.appendChild(toastContainer)
        }

        // Create toast element
        const toast = document.createElement("div")
        toast.className = `toast toast-${type}`
        toast.innerHTML = `
      <div class="toast-content">
        <i class="fas ${type === "success" ? "fa-check-circle" : type === "error" ? "fa-exclamation-circle" : "fa-info-circle"}"></i>
        <span>${message}</span>
      </div>
      <button class="toast-close"><i class="fas fa-times"></i></button>
    `

        // Add to document
        toastContainer.appendChild(toast)

        // Add close functionality
        const closeButton = toast.querySelector(".toast-close")
        closeButton.addEventListener("click", () => {
            toast.classList.add("toast-hiding")
            setTimeout(() => {
                toast.remove()
            }, 300)
        })

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.classList.add("toast-hiding")
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove()
                    }
                }, 300)
            }
        }, 5000)
    }

    // Initialize
    updateCartCount()
})
