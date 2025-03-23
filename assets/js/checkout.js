document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const paymentOptions = document.querySelectorAll(".payment-option")
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]')
    const completePaymentBtn = document.getElementById("complete-payment")
    const paymentSuccessModal = document.getElementById("paymentSuccessModal")
    const paymentSuccessMessage = document.getElementById("payment-success-message")
    const orderNumberElement = document.getElementById("order-number")
    const overlay = document.getElementById("overlay")
    const verifyQrPaymentBtn = document.getElementById("verify-qr-payment")

    // Card form elements
    const cardNumber = document.getElementById("card_number")
    const expiryDate = document.getElementById("expiry_date")
    const cvv = document.getElementById("cvv")
    const cardName = document.getElementById("card_name")

    // Initialize payment method selection
    paymentRadios.forEach((radio) => {
        radio.addEventListener("change", function() {
            // Remove active class from all payment options
            paymentOptions.forEach((option) => {
                option.classList.remove("active")
            })

            // Add active class to selected payment option
            const selectedOption = this.closest(".payment-option")
            if (selectedOption) {
                selectedOption.classList.add("active")
            }

            // Enable the complete payment button
            completePaymentBtn.disabled = false
        })
    })

    // Format card number with spaces
    if (cardNumber) {
        cardNumber.addEventListener("input", function(e) {
            const value = this.value.replace(/\s+/g, "").replace(/[^0-9]/gi, "")
            let formattedValue = ""

            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += " "
                }
                formattedValue += value[i]
            }

            this.value = formattedValue
        })
    }

    // Format expiry date (MM/YY)
    if (expiryDate) {
        expiryDate.addEventListener("input", function(e) {
            const value = this.value.replace(/\D/g, "")

            if (value.length > 2) {
                this.value = value.substring(0, 2) + "/" + value.substring(2, 4)
            } else {
                this.value = value
            }
        })
    }

    // Only allow numbers in CVV
    if (cvv) {
        cvv.addEventListener("input", function(e) {
            this.value = this.value.replace(/\D/g, "")
        })
    }

    // Verify QR payment button
    if (verifyQrPaymentBtn) {
        verifyQrPaymentBtn.addEventListener("click", () => {
            // In a real app, this would verify the payment with the server
            // For demo, we'll just simulate a successful payment
            processPayment("qr")
        })
    }

    // Complete payment button
    if (completePaymentBtn) {
        completePaymentBtn.addEventListener("click", () => {
            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked')

            if (!selectedPaymentMethod) {
                showToast("Please select a payment method", "error")
                return
            }

            const paymentMethod = selectedPaymentMethod.value

            // Validate payment details based on method
            if (paymentMethod === "card") {
                if (!validateCardPayment()) {
                    return
                }
            }

            // Process the payment
            processPayment(paymentMethod)
        })
    }

    // Validate card payment details
    function validateCardPayment() {
        if (!cardNumber || !expiryDate || !cvv || !cardName) {
            return false
        }

        if (cardNumber.value.replace(/\s/g, "").length < 16) {
            showToast("Please enter a valid card number", "error")
            cardNumber.focus()
            return false
        }

        if (expiryDate.value.length < 5) {
            showToast("Please enter a valid expiry date (MM/YY)", "error")
            expiryDate.focus()
            return false
        }

        if (cvv.value.length < 3) {
            showToast("Please enter a valid CVV", "error")
            cvv.focus()
            return false
        }

        if (cardName.value.trim() === "") {
            showToast("Please enter the name on card", "error")
            cardName.focus()
            return false
        }

        return true
    }

    // Process payment based on method
    function processPayment(method) {
        // Disable the button to prevent multiple clicks
        completePaymentBtn.disabled = true
        completePaymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...'

        // In a real app, this would make an API call to process the payment
        // For demo, we'll simulate a payment processing delay
        setTimeout(() => {
                // Generate a random order number
                const orderNumber = "ORD" + Math.floor(Math.random() * 900000 + 100000)

                // Update order number in success modal
                if (orderNumberElement) {
                    orderNumberElement.textContent = "#" + orderNumber
                }

                // Set success message based on payment method
                let successMessage = ""
                switch (method) {
                    case "card":
                        successMessage = "Your card payment has been processed successfully."
                        break
                    case "qr":
                        successMessage = "Your QR code payment has been verified successfully."
                        break
                    case "cash":
                        successMessage = "Your cash on delivery order has been confirmed."
                        break
                    default:
                        successMessage = "Your payment has been processed successfully."
                }

                if (paymentSuccessMessage) {
                    paymentSuccessMessage.textContent = successMessage
                }

                // Show success modal
                showPaymentSuccessModal()

                // Create a booking from the cart
                createBookingFromCart(method, orderNumber)

                // Reset button state
                completePaymentBtn.disabled = false
                completePaymentBtn.innerHTML = '<i class="fas fa-lock"></i> Complete Payment'
            }, 2000) // 2 second delay to simulate payment processing
    }

    // Show payment success modal
    function showPaymentSuccessModal() {
        if (paymentSuccessModal) {
            paymentSuccessModal.classList.add("active")
        }

        if (overlay) {
            overlay.style.display = "block"
        }
    }

    // Create booking from cart
    function createBookingFromCart(paymentMethod, orderNumber) {
        // Get cart items from localStorage
        const cart = JSON.parse(localStorage.getItem("cart")) || []

        if (cart.length === 0) return

        // Calculate total
        const subtotal = cart.reduce((total, item) => total + item.totalPrice, 0)
        const tax = subtotal * 0.08 // 8% tax
        const total = subtotal + tax

        // Create booking
        const booking = {
            id: orderNumber,
            date: new Date().toISOString(),
            items: cart,
            subtotal,
            tax,
            total,
            status: "processing",
            paymentMethod: paymentMethod,
            paymentStatus: "paid",
        }

        // Get existing bookings
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []

        // Add new booking
        bookings.unshift(booking)

        // Save to localStorage
        localStorage.setItem("bookings", JSON.stringify(bookings))

        // Clear cart
        localStorage.setItem("cart", JSON.stringify([]))

        // Add notification
        addNotification("Order Placed", `Your order #${orderNumber} has been placed successfully.`, "order")
    }

    // Show toast notification
    function showToast(message, type = "info") {
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
        }

        toast.innerHTML = `
              <div class="toast-icon">
                  <i class="fas fa-${icon}"></i>
              </div>
              <div class="toast-content">
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
        // Check if notification function exists in window scope
        if (typeof window.addNotification === "function") {
            window.addNotification(title, message, type)
        }
    }
})