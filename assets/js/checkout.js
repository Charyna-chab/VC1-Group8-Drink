// checkout.js - Handles checkout functionality
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const paymentOptions = document.querySelectorAll(".payment-option")
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]')
    const completePaymentBtn = document.getElementById("complete-payment")
    const paymentSuccessModal = document.getElementById("paymentSuccessModal")
    const overlay = document.getElementById("overlay")

    // Get cart items from localStorage
    const cartItems = JSON.parse(localStorage.getItem("cart")) || []

    // Calculate totals
    const subtotal = cartItems.reduce((total, item) => total + item.totalPrice, 0)
    const tax = subtotal * 0.08 // 8% tax
    const total = subtotal + tax

    // Initialize payment options
    paymentRadios.forEach((radio) => {
        radio.addEventListener("change", function() {
            // Hide all payment option content
            document.querySelectorAll(".payment-option-content").forEach((content) => {
                content.style.display = "none"
            })

            // Show selected payment option content
            const selectedOption = document.querySelector(`.payment-option[data-payment="${this.value}"]`)
            if (selectedOption) {
                const content = selectedOption.querySelector(".payment-option-content")
                if (content) {
                    content.style.display = "block"
                }
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

    // Card form elements
    const cardNumber = document.getElementById("card_number")
    const expiryDate = document.getElementById("expiry_date")
    const cvv = document.getElementById("cvv")
    const cardName = document.getElementById("card_name")

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
    const verifyQrPaymentBtn = document.getElementById("verify-qr-payment")
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
        // Generate a unique order ID
        const orderId = "ORD" + Date.now().toString().slice(-6)

        // In a real app, this would make an API call to process the payment
        // For demo, we'll just simulate a payment processing delay
        setTimeout(() => {
                // Create a booking from the order
                createBookingFromOrder(orderId, method)

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
                const paymentSuccessMessage = document.getElementById("payment-success-message")
                if (paymentSuccessMessage) {
                    paymentSuccessMessage.textContent = successMessage
                }

                // Update order number in success modal
                const orderNumberElement = document.getElementById("order-number")
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

                // Set flag for booking page to know we just checked out
                sessionStorage.setItem("justCheckedOut", "true")

                // Redirect to booking page after 3 seconds
                setTimeout(() => {
                    window.location.href = "/booking"
                }, 3000)
            }, 2000) // 2 second delay to simulate payment processing
    }

    // Create booking from order
    function createBookingFromOrder(orderId, paymentMethod) {
        // Get existing bookings
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []

        // Create new booking
        const booking = {
            id: orderId,
            order_number: orderId,
            date: new Date().toISOString(),
            time: new Date().toLocaleTimeString(),
            items: cartItems,
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

    // Add CSS for toast notifications
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
      `
    document.head.appendChild(style)
})