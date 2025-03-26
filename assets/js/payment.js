// payment.js - Handles payment processing functionality
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const paymentOptions = document.querySelectorAll(".payment-method-card")
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

    // Get order ID from URL or session storage
    const urlParams = new URLSearchParams(window.location.search)
    const orderId = urlParams.get("order_id") || sessionStorage.getItem("paymentOrderId")

    // Clear session storage order ID
    if (sessionStorage.getItem("paymentOrderId")) {
        sessionStorage.removeItem("paymentOrderId")
    }

    // Get booking details if order ID is provided
    let currentBooking = null
    if (orderId) {
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []
        currentBooking = bookings.find((booking) => booking.id === orderId)

        // Update order details in the UI
        if (currentBooking) {
            updateOrderDetails(currentBooking)
        }
    }

    // Initialize payment options
    paymentRadios.forEach((radio) => {
        radio.addEventListener("change", function() {
            // Remove active class from all payment options
            paymentOptions.forEach((option) => {
                option.classList.remove("active")
            })

            // Add active class to selected payment option
            const selectedOption = document.querySelector(`.payment-method-card[data-payment="${this.value}"]`)
            if (selectedOption) {
                selectedOption.classList.add("active")
            }

            // Show selected payment content
            const paymentContents = document.querySelectorAll(".payment-method-content")
            paymentContents.forEach((content) => {
                content.style.display = "none"
            })

            const selectedContent = document.getElementById(`${this.value}_payment_content`)
            if (selectedContent) {
                selectedContent.style.display = "block"
            }

            // Enable the complete payment button
            if (completePaymentBtn) {
                completePaymentBtn.disabled = false
            }
        })
    })

    // Set default payment method if none selected
    if (paymentRadios.length > 0 && !document.querySelector('input[name="payment_method"]:checked')) {
        paymentRadios[0].checked = true
        paymentRadios[0].dispatchEvent(new Event("change"))
    }

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

            // Disable the button to prevent multiple clicks
            completePaymentBtn.disabled = true
            completePaymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...'

            // Process the payment
            processPayment(paymentMethod)
        })
    }

    // Update order details in the UI
    function updateOrderDetails(booking) {
        // Update order number
        const orderNumberElements = document.querySelectorAll(".order-number span:last-child")
        orderNumberElements.forEach((el) => {
            if (el) el.textContent = "#" + booking.id
        })

        // Update total amount
        const totalAmountElements = document.querySelectorAll(".order-total span:last-child")
        orderNumberElements.forEach((el) => {
            if (el) el.textContent = "#" + booking.id
        })

        // Update total amount
        const totalAmountElements2 = document.querySelectorAll(".order-total span:last-child")
        totalAmountElements2.forEach((el) => {
            if (el) el.textContent = "$" + booking.total.toFixed(2)
        })

        // Update order items if there's a container for them
        const orderItemsContainer = document.querySelector(".order-items")
        if (orderItemsContainer && booking.items) {
            orderItemsContainer.innerHTML = booking.items
                .map(
                    (item) => `
                  <div class="order-item">
                      <div class="item-image">
                          <img src="${item.image}" alt="${item.name}">
                      </div>
                      <div class="item-details">
                          <h4>${item.name}</h4>
                          <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                          <p>Toppings: ${item.toppings && item.toppings.length > 0 ? item.toppings.map((t) => t.name).join(", ") : "None"}</p>
                          <div class="item-quantity-price">
                              <span>Qty: ${item.quantity}</span>
                              <span>$${item.totalPrice.toFixed(2)}</span>
                          </div>
                      </div>
                  </div>
              `,
                )
                .join("")
        }

        // Update subtotal, tax, and total in order summary
        const subtotalElement = document.querySelector(".total-row:nth-child(1) span:last-child")
        if (subtotalElement) subtotalElement.textContent = "$" + booking.subtotal.toFixed(2)

        const taxElement = document.querySelector(".total-row:nth-child(2) span:last-child")
        if (taxElement) taxElement.textContent = "$" + booking.tax.toFixed(2)

        const totalElement = document.querySelector(".total-row.grand-total span:last-child")
        if (totalElement) totalElement.textContent = "$" + booking.total.toFixed(2)
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
        // If we have a current booking, update it
        if (currentBooking) {
            processExistingBookingPayment(currentBooking.id, method)
            return
        }

        // Get cart items from localStorage
        const cartItems = JSON.parse(localStorage.getItem("cart")) || []

        // Calculate totals
        const subtotal = cartItems.reduce((total, item) => total + item.totalPrice, 0)
        const tax = subtotal * 0.08 // 8% tax
        const total = subtotal + tax

        // Generate a unique order ID if we don't have one
        const orderId = "ORD" + Date.now().toString().slice(-6)

        // In a real app, this would make an API call to process the payment
        // For demo, we'll just simulate a payment processing delay
        setTimeout(() => {
                // Create a booking from the order
                createBookingFromOrder(orderId, method, cartItems, subtotal, tax, total)

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

                // Update order number in success modal
                if (orderNumberElement) {
                    orderNumberElement.textContent = "#" + orderId
                }

                // Show success modal
                showPaymentSuccessModal()

                // Reset button state
                completePaymentBtn.disabled = false
                completePaymentBtn.innerHTML = '<i class="fas fa-lock"></i> Complete Payment'

                // Clear cart
                localStorage.setItem("cart", JSON.stringify([]))

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Payment Successful",
                        `Your payment for order #${orderId} has been processed successfully.`,
                        "success",
                    )
                }

                // Set flag for booking page to know we just checked out
                sessionStorage.setItem("justCheckedOut", "true")

                // Redirect to booking page after 3 seconds
                setTimeout(() => {
                    window.location.href = "/booking"
                }, 3000)
            }, 2000) // 2 second delay to simulate payment processing
    }

    // Process payment for an existing booking
    function processExistingBookingPayment(bookingId, method) {
        // Get bookings from localStorage
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []

        // Find the booking
        const bookingIndex = bookings.findIndex((b) => b.id === bookingId)

        if (bookingIndex === -1) {
            showToast("Error", "Booking not found", "error")
            return
        }

        // Update booking payment status and method
        bookings[bookingIndex].paymentStatus = "completed"
        bookings[bookingIndex].paymentMethod = method

        // Save to localStorage
        localStorage.setItem("bookings", JSON.stringify(bookings))

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

        // Update payment success modal
        if (paymentSuccessMessage) {
            paymentSuccessMessage.textContent = successMessage
        }

        // Update order number in success modal
        if (orderNumberElement) {
            orderNumberElement.textContent = "#" + bookingId
        }

        // Show success modal after a delay to simulate processing
        setTimeout(() => {
            // Show success modal
            showPaymentSuccessModal()

            // Reset button state
            completePaymentBtn.disabled = false
            completePaymentBtn.innerHTML = '<i class="fas fa-lock"></i> Complete Payment'

            // Add notification
            if (window.addNotification) {
                window.addNotification(
                    "Payment Successful",
                    `Your payment for order #${bookingId} has been processed successfully.`,
                    "success",
                )
            }

            // Redirect to receipt page after 3 seconds
            setTimeout(() => {
                window.location.href = `/receipt?order_id=${bookingId}`
            }, 3000)
        }, 2000)
    }

    // Create booking from order
    function createBookingFromOrder(orderId, paymentMethod, items, subtotal, tax, total) {
        // Get existing bookings
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []

        // Create new booking
        const booking = {
            id: orderId,
            order_number: orderId,
            date: new Date().toISOString(),
            time: new Date().toLocaleTimeString(),
            items: items,
            subtotal: subtotal,
            tax: tax,
            total: total,
            status: paymentMethod === "cash" ? "processing" : "completed",
            paymentStatus: paymentMethod === "cash" ? "pending" : "completed",
            paymentMethod: paymentMethod,
            delivery_address: "123 Main St, Apt 4B, New York, NY 10001", // In a real app, get from form
            contact: "+1 (555) 123-4567", // In a real app, get from form
        }

        // Add to bookings
        bookings.unshift(booking)

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

    // Add CSS for toast notifications and payment UI
    const style = document.createElement("style")
    style.textContent = `
            .toast-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            
            .toast {
                display: flex;
                align-items: flex-start;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                padding: 12px;
                min-width: 300px;
                max-width: 400px;
                animation: slideIn 0.3s ease;
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            
            .toast.toast-hide {
                opacity: 0;
                transform: translateX(20px);
            }
            
            .toast.success .toast-icon {
                color: #4caf50;
            }
            
            .toast.error .toast-icon {
                color: #f44336;
            }
            
            .toast-icon {
                font-size: 24px;
                margin-right: 12px;
                color: #2196f3;
            }
            
            .toast-content {
                flex: 1;
            }
            
            .toast-content h4 {
                margin: 0 0 5px;
                font-size: 16px;
                font-weight: 600;
            }
            
            .toast-content p {
                margin: 0;
                font-size: 14px;
                color: #666;
            }
            
            .toast-close {
                background: none;
                border: none;
                font-size: 18px;
                color: #999;
                cursor: pointer;
                padding: 0;
                margin-left: 8px;
            }
            
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            /* Payment Success Modal Styles */
            .payment-success-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1000;
                justify-content: center;
                align-items: center;
            }
            
            .payment-success-modal.active {
                display: flex;
            }
            
            .payment-success-content {
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                padding: 30px;
                text-align: center;
                max-width: 90%;
                width: 400px;
                animation: fadeIn 0.3s ease;
            }
            
            .success-icon {
                font-size: 60px;
                color: #4caf50;
                margin-bottom: 20px;
            }
            
            .order-details {
                background-color: #f9f9f9;
                border-radius: 8px;
                padding: 15px;
                margin: 20px 0;
                text-align: left;
            }
            
            .order-number, .order-total {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }
            
            .order-total {
                font-weight: 600;
                border-top: 1px dashed #ddd;
                padding-top: 10px;
                margin-top: 10px;
            }
            
            .success-actions {
                margin-top: 20px;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            /* Payment Method Styles */
            .payment-option {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
            }
            
            .payment-option.active {
                border-color: #ff5e62;
                box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.1);
            }
            
            .payment-option-header {
                padding: 15px;
                background-color: #f9f9f9;
                cursor: pointer;
                display: flex;
                align-items: center;
            }
            
            .payment-option-header label {
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                font-weight: 500;
                margin-left: 10px;
            }
            
            .payment-option-content {
                padding: 15px;
                display: none;
            }
            
            .card-payment-form {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
            
            .form-group {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
            
            .form-group label {
                font-size: 14px;
                color: #666;
            }
            
            .form-group input {
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
            }
            
            .form-group input:focus {
                border-color: #ff5e62;
                outline: none;
                box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.1);
            }
            
            .form-row {
                display: flex;
                gap: 15px;
            }
            
            .form-row .form-group {
                flex: 1;
            }
            
            .qr-code-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            
            .qr-code-container img {
                max-width: 200px;
                height: auto;
            }
            
            .qr-code-container p {
                text-align: center;
                font-size: 14px;
                color: #666;
            }
            
            .qr-verification {
                margin-top: 10px;
            }
            
            .cash-payment-info {
                font-size: 14px;
                color: #666;
                line-height: 1.6;
            }
            
            .cash-payment-info p {
                margin-bottom: 10px;
            }
            
            .cash-payment-info strong {
                color: #ff5e62;
                font-weight: 600;
            }
        `
    document.head.appendChild(style)
})