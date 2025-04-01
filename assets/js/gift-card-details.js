document.addEventListener("DOMContentLoaded", () => {
    // Discount option selection
    const optionItems = document.querySelectorAll(".option-item")
    optionItems.forEach((item) => {
        item.addEventListener("click", function() {
            // Remove active class from all options in the same group
            const parentGroup = this.closest(".options-list")
            parentGroup.querySelectorAll(".option-item").forEach((opt) => {
                opt.classList.remove("active")
            })

            // Add active class to clicked option
            this.classList.add("active")

            // Check the radio input
            const radioInput = this.querySelector("input[type='radio']")
            if (radioInput) {
                radioInput.checked = true
            }
        })
    })

    // Delivery method selection
    const deliveryOptions = document.querySelectorAll(".delivery-options .option-item")
    deliveryOptions.forEach((option) => {
        option.addEventListener("click", function() {
            // Remove active class from all options
            deliveryOptions.forEach((opt) => {
                opt.classList.remove("active")
            })

            // Add active class to clicked option
            this.classList.add("active")

            // Check the radio input
            const radioInput = this.querySelector("input[type='radio']")
            if (radioInput) {
                radioInput.checked = true
            }
        })
    })

    // Quantity selector
    const minusBtn = document.querySelector(".quantity-btn.minus")
    const plusBtn = document.querySelector(".quantity-btn.plus")
    const quantityInput = document.querySelector("#quantity")

    if (minusBtn && plusBtn && quantityInput) {
        minusBtn.addEventListener("click", () => {
            const currentValue = Number.parseInt(quantityInput.value)
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1
            }
        })

        plusBtn.addEventListener("click", () => {
            const currentValue = Number.parseInt(quantityInput.value)
            if (currentValue < 10) {
                quantityInput.value = currentValue + 1
            }
        })

        quantityInput.addEventListener("change", () => {
            let value = Number.parseInt(quantityInput.value)
            if (isNaN(value) || value < 1) {
                value = 1
            } else if (value > 10) {
                value = 10
            }
            quantityInput.value = value
        })
    }

    // Character counter for message
    const messageTextarea = document.querySelector("#message")
    const messageChars = document.querySelector("#message-chars")

    if (messageTextarea && messageChars) {
        messageTextarea.addEventListener("input", () => {
            const count = messageTextarea.value.length
            messageChars.textContent = count

            if (count > 180) {
                messageChars.style.color = "#dc3545"
            } else {
                messageChars.style.color = ""
            }
        })
    }

    // Thumbnails
    const thumbnails = document.querySelectorAll(".thumbnail")
    const mainImage = document.querySelector(".gift-card-image img")

    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach((thumbnail) => {
            thumbnail.addEventListener("click", function() {
                // Remove active class from all thumbnails
                thumbnails.forEach((thumb) => {
                    thumb.classList.remove("active")
                })

                // Add active class to clicked thumbnail
                this.classList.add("active")

                // Update main image
                const imgSrc = this.querySelector("img").src
                mainImage.src = imgSrc

                // Add fade animation
                mainImage.style.opacity = "0"
                setTimeout(() => {
                    mainImage.style.opacity = "1"
                }, 100)
            })
        })
    }

    // Tabs functionality
    const tabButtons = document.querySelectorAll(".tab-btn")
    const tabPanels = document.querySelectorAll(".tab-panel")

    if (tabButtons.length > 0 && tabPanels.length > 0) {
        tabButtons.forEach((button) => {
            button.addEventListener("click", function() {
                // Remove active class from all buttons and panels
                tabButtons.forEach((btn) => {
                    btn.classList.remove("active")
                })
                tabPanels.forEach((panel) => {
                    panel.classList.remove("active")
                })

                // Add active class to clicked button
                this.classList.add("active")

                // Show corresponding panel
                const tabId = this.dataset.tab
                const panel = document.getElementById(tabId)
                if (panel) {
                    panel.classList.add("active")
                }
            })
        })
    }

    // Add to cart functionality
    const addToCartBtn = document.querySelector(".btn-add-to-cart")
    const buyNowBtn = document.querySelector(".btn-buy-now")

    if (addToCartBtn) {
        addToCartBtn.addEventListener("click", function() {
            const cardId = this.dataset.id
            const cardName = document.querySelector(".gift-card-info h2").textContent
            const activeOption = document.querySelector(".option-item.active input")
            const discount = activeOption ? activeOption.value : "0"
            const quantity = Number.parseInt(document.querySelector("#quantity").value) || 1
            const recipientName = document.querySelector("#recipient-name").value
            const recipientEmail = document.querySelector("#recipient-email").value
            const message = document.querySelector("#message").value
            const deliveryMethod = document.querySelector(".delivery-options .option-item.active input").value

            // Validate required fields
            if (!recipientName || !recipientEmail) {
                showToast("Please fill in recipient information", "error")
                return
            }

            // Add to cart logic
            addToCart(cardId, cardName, discount, quantity, recipientName, recipientEmail, message, deliveryMethod)

            // Show success message
            showToast(`Added ${cardName} to cart!`, "success")

            // Add animation to button
            this.classList.add("animate-pulse")
            setTimeout(() => {
                this.classList.remove("animate-pulse")
            }, 1000)
        })
    }

    if (buyNowBtn) {
        buyNowBtn.addEventListener("click", () => {
            const cardId = document.querySelector(".btn-add-to-cart").dataset.id
            const cardName = document.querySelector(".gift-card-info h2").textContent
            const activeOption = document.querySelector(".option-item.active input")
            const discount = activeOption ? activeOption.value : "0"
            const quantity = Number.parseInt(document.querySelector("#quantity").value) || 1
            const recipientName = document.querySelector("#recipient-name").value
            const recipientEmail = document.querySelector("#recipient-email").value
            const message = document.querySelector("#message").value
            const deliveryMethod = document.querySelector(".delivery-options .option-item.active input").value

            // Validate required fields
            if (!recipientName || !recipientEmail) {
                showToast("Please fill in recipient information", "error")
                return
            }

            // Add to cart and redirect to checkout
            addToCart(cardId, cardName, discount, quantity, recipientName, recipientEmail, message, deliveryMethod)

            // Redirect to checkout
            window.location.href = "/checkout"
        })
    }

    // Load more reviews
    const loadMoreBtn = document.querySelector(".load-more-btn")
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function() {
            // This would typically load more reviews from the server
            // For demo purposes, we'll just show a message
            this.textContent = "Loading..."
            setTimeout(() => {
                this.textContent = "No more reviews"
                this.disabled = true
            }, 1000)
        })
    }

    // Helper functions
    function addToCart(id, name, discount, quantity, recipientName, recipientEmail, message, deliveryMethod) {
        // This would typically send data to a server or store in localStorage
        console.log(`Added to cart: ${name} (ID: ${id}) with discount: ${discount}, quantity: ${quantity}`)
        console.log(`Recipient: ${recipientName} (${recipientEmail})`)
        console.log(`Message: ${message}`)
        console.log(`Delivery Method: ${deliveryMethod}`)

        // For demo purposes, we'll just store in localStorage
        const cart = JSON.parse(localStorage.getItem("cart")) || []
        cart.push({
            id: id,
            name: name,
            discount: discount,
            quantity: quantity,
            recipientName: recipientName,
            recipientEmail: recipientEmail,
            message: message,
            deliveryMethod: deliveryMethod,
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