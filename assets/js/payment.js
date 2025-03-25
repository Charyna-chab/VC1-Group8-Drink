// payment.js - Enhanced payment processing
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const paymentMethodCards = document.querySelectorAll(".payment-method-card")
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

    // Get order ID from URL
    const urlParams = new URLSearchParams(window.location.search)
    const orderId = urlParams.get("order_id")

    // Update the button text to "Completed" initially
    if (completePaymentBtn) {
        completePaymentBtn.innerHTML = '<i class="fas fa-check-circle"></i> Completed'
    }

    // Load order data from localStorage
    loadOrderData(orderId)

    // Initialize payment method selection
    paymentRadios.forEach((radio) => {
        radio.addEventListener("change", function() {
            // Remove active class from all payment methods
            paymentMethodCards.forEach((card) => {
                card.classList.remove("active")
            })

            // Add active class to selected payment method
            const selectedCard = this.closest(".payment-method-card")
            if (selectedCard) {
                selectedCard.classList.add("active")
            }

            // Show selected payment content
            const selectedMethod = this.value
            const allContents = document.querySelectorAll(".payment-method-content")
            allContents.forEach((content) => {
                content.style.display = "none"
            })

            const selectedContent = document.getElementById(`${selectedMethod}_payment_content`)
            if (selectedContent) {
                selectedContent.style.display = "block"
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
                showToast("Error", "Please select a payment method", "error")
                return
            }

            const paymentMethod = selectedPaymentMethod.value

            // Validate payment details based on method
            if (paymentMethod === "card") {
                if (!validateCardPayment()) {
                    return
                }
            }

            // Show payment interface alert before processing
            showPaymentAlert("Payment interface activated. Your order will be processed.")

            // Process the payment
            processPayment(paymentMethod)
        })
    }

    // Custom payment alert function
    function showPaymentAlert(message) {
        // Create overlay
        const alertOverlay = document.createElement("div")
        alertOverlay.className = "payment-alert-overlay"

        // Create alert box
        const alertBox = document.createElement("div")
        alertBox.className = "payment-alert-box"

        // Add content
        alertBox.innerHTML = `
              <div class="payment-alert-icon">
                  <i class="fas fa-credit-card"></i>
              </div>
              <h3>Payment Notification</h3>
              <p>${message}</p>
              <button id="alert-ok" class="btn-primary">Proceed</button>
          `

        // Add to DOM
        alertOverlay.appendChild(alertBox)
        document.body.appendChild(alertOverlay)

        // Add event listener to OK button
        document.getElementById("alert-ok").addEventListener("click", () => {
            alertOverlay.classList.add("fade-out")
            setTimeout(() => {
                alertOverlay.remove()
            }, 300)
        })

        // Also close when clicking outside the alert box
        alertOverlay.addEventListener("click", (e) => {
            if (e.target === alertOverlay) {
                alertOverlay.classList.add("fade-out")
                setTimeout(() => {
                    alertOverlay.remove()
                }, 300)
            }
        })
    }

    // Load order data from localStorage
    function loadOrderData(orderId) {
        if (!orderId) return

        // Get bookings from localStorage
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []

        // Find the booking with the matching ID
        const booking = bookings.find((b) => b.id === orderId)

        if (!booking) {
            showToast("Error", "Order not found", "error")
            return
        }

        // Update order summary
        updateOrderSummary(booking)

        // Update order number in success modal
        if (orderNumberElement) {
            orderNumberElement.textContent = "#" + orderId
        }
    }

    // Update order summary
    function updateOrderSummary(booking) {
        // Update order items
        const orderItemsContainer = document.querySelector(".order-items")
        if (!orderItemsContainer) return

        // Clear existing items
        orderItemsContainer.innerHTML = ""

        // Add each item
        booking.items.forEach((item) => {
            const itemElement = document.createElement("div")
            itemElement.className = "order-item"

            // Format toppings
            let toppingsText = "None"
            if (item.toppings && item.toppings.length > 0) {
                toppingsText = item.toppings.map((t) => t.name).join(", ")
            }

            itemElement.innerHTML = `
          <div class="item-image">
            <img src="${item.image || "/assets/images/default-product.png"}" alt="${item.name}">
          </div>
          <div class="item-details">
            <h4>${item.name}</h4>
            <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
            <p>Toppings: ${toppingsText}</p>
            <div class="item-quantity-price">
              <span>Qty: ${item.quantity}</span>
              <span>$${item.totalPrice.toFixed(2)}</span>
            </div>
          </div>
        `

            orderItemsContainer.appendChild(itemElement)
        })

        // Update totals
        const subtotalElement = document.querySelector(".total-row:nth-child(1) span:last-child")
        const taxElement = document.querySelector(".total-row:nth-child(2) span:last-child")
        const totalElement = document.querySelector(".grand-total span:last-child")

        if (subtotalElement) subtotalElement.textContent = `$${booking.subtotal.toFixed(2)}`
        if (taxElement) taxElement.textContent = `$${booking.tax.toFixed(2)}`
        if (totalElement) totalElement.textContent = `$${booking.total.toFixed(2)}`

        // Update cash payment amount
        const cashPaymentAmount = document.querySelector(".cash-payment-info p:last-child strong")
        if (cashPaymentAmount) cashPaymentAmount.textContent = `$${booking.total.toFixed(2)}`
    }

    // Validate card payment details
    function validateCardPayment() {
        if (!cardNumber || !expiryDate || !cvv || !cardName) {
            showToast("Error", "Card form elements not found", "error")
            return false
        }

        if (cardNumber.value.replace(/\s/g, "").length < 16) {
            showToast("Error", "Please enter a valid card number", "error")
            cardNumber.focus()
            return false
        }

        if (expiryDate.value.length < 5) {
            showToast("Error", "Please enter a valid expiry date (MM/YY)", "error")
            expiryDate.focus()
            return false
        }

        if (cvv.value.length < 3) {
            showToast("Error", "Please enter a valid CVV", "error")
            cvv.focus()
            return false
        }

        if (cardName.value.trim() === "") {
            showToast("Error", "Please enter the name on card", "error")
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
                // Update booking status in localStorage
                updateBookingStatus(orderId, method)

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

                // Reset button state
                completePaymentBtn.disabled = false
                completePaymentBtn.innerHTML = '<i class="fas fa-check-circle"></i> Completed'

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Payment Successful",
                        `Your payment for order #${orderId} has been processed successfully.`,
                        "success",
                    )
                }

                // Redirect to booking page after 3 seconds
                setTimeout(() => {
                    window.location.href = "/booking"
                }, 3000)
            }, 2000) // 2 second delay to simulate payment processing
    }

    // Update booking status in localStorage
    function updateBookingStatus(orderId, paymentMethod) {
        if (!orderId) return

        // Get bookings from localStorage
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []

        // Find the booking with the matching ID
        const bookingIndex = bookings.findIndex((b) => b.id === orderId)

        if (bookingIndex === -1) return

        // Update booking
        bookings[bookingIndex].status = "completed"
        bookings[bookingIndex].paymentMethod = paymentMethod
        bookings[bookingIndex].paymentDate = new Date().toISOString()

        // Save to localStorage
        localStorage.setItem("bookings", JSON.stringify(bookings))
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
})