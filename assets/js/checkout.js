document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const steps = document.querySelectorAll(".step")
    const stepContents = document.querySelectorAll(".checkout-step-content")
    const stepConnectors = document.querySelectorAll(".step-connector")
  
    const continueToPaymentBtn = document.getElementById("continue-to-payment")
    const backToDetailsBtn = document.getElementById("back-to-details")
  
    const paymentMethods = document.querySelectorAll(".payment-method")
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]')
  
    const verifyAbaPaymentBtn = document.getElementById("verify-aba-payment")
    const verifyAcledaPaymentBtn = document.getElementById("verify-acleda-payment")
    const processCardPaymentBtn = document.getElementById("process-card-payment")
    const confirmCashPaymentBtn = document.getElementById("confirm-cash-payment")
  
    const loadingModal = document.getElementById("loadingModal")
    const overlay = document.getElementById("overlay")
  
    // Form elements
    const firstNameInput = document.getElementById("first_name")
    const lastNameInput = document.getElementById("last_name")
    const emailInput = document.getElementById("email")
    const phoneInput = document.getElementById("phone")
    const addressInput = document.getElementById("address")
    const notesInput = document.getElementById("notes")
  
    // Hidden form elements
    const hiddenFirstName = document.getElementById("hidden_first_name")
    const hiddenLastName = document.getElementById("hidden_last_name")
    const hiddenEmail = document.getElementById("hidden_email")
    const hiddenPhone = document.getElementById("hidden_phone")
    const hiddenAddress = document.getElementById("hidden_address")
    const hiddenNotes = document.getElementById("hidden_notes")
    const hiddenTransactionId = document.getElementById("hidden_transaction_id")
  
    // Card form elements
    const cardNumber = document.getElementById("card_number")
    const expiryDate = document.getElementById("expiry_date")
    const cvv = document.getElementById("cvv")
    const cardName = document.getElementById("card_name")
  
    // Get cart items from localStorage
    const cartItems = JSON.parse(localStorage.getItem("cart")) || []
  
    // Calculate totals
    const subtotal = cartItems.reduce((total, item) => total + item.totalPrice, 0)
    const tax = subtotal * 0.08 // 8% tax
    const total = subtotal + tax
  
    // Initialize checkout
    initCheckout()
  
    function initCheckout() {
      // Load cart items
      loadCartItems()
  
      // Update totals
      updateTotals()
  
      // Set up event listeners
      setupEventListeners()
  
      // Pre-fill user data if available
      prefillUserData()
    }
  
    function loadCartItems() {
      const orderItemsContainer = document.getElementById("checkout-order-items")
  
      if (!orderItemsContainer) return
  
      if (cartItems.length === 0) {
        orderItemsContainer.innerHTML = `
                  <div class="empty-cart-message">
                      <p>Your cart is empty. Please add some items before checkout.</p>
                      <a href="/order" class="btn-primary">Go to Menu</a>
                  </div>
              `
  
        // Disable continue button
        if (continueToPaymentBtn) {
          continueToPaymentBtn.disabled = true
        }
  
        return
      }
  
      // Clear loading spinner
      orderItemsContainer.innerHTML = ""
  
      // Add cart items
      cartItems.forEach((item) => {
        const orderItemElement = document.createElement("div")
        orderItemElement.className = "order-item"
  
        // Format toppings
        let toppingsText = "None"
        if (item.toppings && item.toppings.length > 0) {
          toppingsText = item.toppings.map((t) => t.name).join(", ")
        }
  
        orderItemElement.innerHTML = `
                  <div class="item-image">
                      <img src="${item.image}" alt="${item.name}">
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
  
        orderItemsContainer.appendChild(orderItemElement)
      })
    }
  
    function updateTotals() {
      // Update subtotal, tax, and total
      const subtotalElement = document.getElementById("checkout-subtotal")
      const taxElement = document.getElementById("checkout-tax")
      const totalElement = document.getElementById("checkout-total")
  
      if (subtotalElement) subtotalElement.textContent = "$" + subtotal.toFixed(2)
      if (taxElement) taxElement.textContent = "$" + tax.toFixed(2)
      if (totalElement) totalElement.textContent = "$" + total.toFixed(2)
  
      // Update payment method amounts
      const abaAmountElement = document.getElementById("aba-amount")
      const acledaAmountElement = document.getElementById("acleda-amount")
      const cashAmountElement = document.getElementById("cash-amount")
  
      if (abaAmountElement) abaAmountElement.textContent = "$" + total.toFixed(2)
      if (acledaAmountElement) acledaAmountElement.textContent = "$" + total.toFixed(2)
      if (cashAmountElement) cashAmountElement.textContent = "$" + total.toFixed(2)
    }
  
    function setupEventListeners() {
      // Continue to payment button
      if (continueToPaymentBtn) {
        continueToPaymentBtn.addEventListener("click", () => {
          if (validateUserForm()) {
            // Transfer form data to hidden fields
            transferFormData()
            goToStep(2)
          }
        })
      }
  
      // Back to details button
      if (backToDetailsBtn) {
        backToDetailsBtn.addEventListener("click", () => {
          goToStep(1)
        })
      }
  
      // Payment method selection
      paymentRadios.forEach((radio) => {
        radio.addEventListener("change", function () {
          // Deactivate all payment methods
          paymentMethods.forEach((method) => {
            method.classList.remove("active")
          })
  
          // Activate selected payment method
          const selectedMethod = this.closest(".payment-method")
          if (selectedMethod) {
            selectedMethod.classList.add("active")
          }
        })
      })
  
      // Format card number with spaces
      if (cardNumber) {
        cardNumber.addEventListener("input", function (e) {
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
        expiryDate.addEventListener("input", function (e) {
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
        cvv.addEventListener("input", function (e) {
          this.value = this.value.replace(/\D/g, "")
        })
      }
  
      // Payment verification buttons
      if (verifyAbaPaymentBtn) {
        verifyAbaPaymentBtn.addEventListener("click", () => {
          const transactionId = document.getElementById("aba_transaction_id").value
          if (transactionId.trim() === "") {
            showToast("Error", "Please enter your ABA transaction ID", "error")
            return
          }
  
          // Set transaction ID in hidden field
          hiddenTransactionId.value = transactionId
  
          // Process payment
          processPayment("aba")
        })
      }
  
      if (verifyAcledaPaymentBtn) {
        verifyAcledaPaymentBtn.addEventListener("click", () => {
          const transactionId = document.getElementById("acleda_transaction_id").value
          if (transactionId.trim() === "") {
            showToast("Error", "Please enter your ACLEDA transaction ID", "error")
            return
          }
  
          // Set transaction ID in hidden field
          hiddenTransactionId.value = transactionId
  
          // Process payment
          processPayment("acleda")
        })
      }
  
      if (processCardPaymentBtn) {
        processCardPaymentBtn.addEventListener("click", () => {
          if (validateCardPayment()) {
            // Set transaction ID in hidden field (card number last 4 digits)
            const last4 = cardNumber.value.replace(/\s+/g, "").slice(-4)
            hiddenTransactionId.value = "CARD-" + last4
  
            // Process payment
            processPayment("card")
          }
        })
      }
  
      if (confirmCashPaymentBtn) {
        confirmCashPaymentBtn.addEventListener("click", () => {
          // Process payment
          processPayment("cash")
        })
      }
    }
  
    function transferFormData() {
      // Transfer form data to hidden fields
      if (hiddenFirstName) hiddenFirstName.value = firstNameInput.value
      if (hiddenLastName) hiddenLastName.value = lastNameInput.value
      if (hiddenEmail) hiddenEmail.value = emailInput.value
      if (hiddenPhone) hiddenPhone.value = phoneInput.value
      if (hiddenAddress) hiddenAddress.value = addressInput.value
      if (hiddenNotes) hiddenNotes.value = notesInput ? notesInput.value : ""
    }
  
    function prefillUserData() {
      // Check if user data is available in localStorage
      const userData = JSON.parse(localStorage.getItem("userData") || "null")
  
      if (userData) {
        if (firstNameInput && userData.firstName) {
          firstNameInput.value = userData.firstName
        }
  
        if (lastNameInput && userData.lastName) {
          lastNameInput.value = userData.lastName
        }
  
        if (emailInput && userData.email) {
          emailInput.value = userData.email
        }
  
        if (phoneInput && userData.phone) {
          phoneInput.value = userData.phone
        }
  
        if (addressInput && userData.address) {
          addressInput.value = userData.address
        }
      }
    }
  
    function validateUserForm() {
      // Check if form fields are filled
      if (!firstNameInput.value.trim()) {
        showToast("Error", "Please enter your first name", "error")
        firstNameInput.focus()
        return false
      }
  
      if (!lastNameInput.value.trim()) {
        showToast("Error", "Please enter your last name", "error")
        lastNameInput.focus()
        return false
      }
  
      if (!emailInput.value.trim()) {
        showToast("Error", "Please enter your email address", "error")
        emailInput.focus()
        return false
      }
  
      // Validate email format
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      if (!emailRegex.test(emailInput.value.trim())) {
        showToast("Error", "Please enter a valid email address", "error")
        emailInput.focus()
        return false
      }
  
      if (!phoneInput.value.trim()) {
        showToast("Error", "Please enter your phone number", "error")
        phoneInput.focus()
        return false
      }
  
      if (!addressInput.value.trim()) {
        showToast("Error", "Please enter your delivery address", "error")
        addressInput.focus()
        return false
      }
  
      // Save user data to localStorage for future use
      const userData = {
        firstName: firstNameInput.value.trim(),
        lastName: lastNameInput.value.trim(),
        email: emailInput.value.trim(),
        phone: phoneInput.value.trim(),
        address: addressInput.value.trim(),
      }
  
      localStorage.setItem("userData", JSON.stringify(userData))
  
      return true
    }
  
    function validateCardPayment() {
      if (!cardNumber || !cardNumber.value.trim()) {
        showToast("Error", "Please enter your card number", "error")
        cardNumber.focus()
        return false
      }
  
      // Validate card number (simple check for length)
      const cardNumberValue = cardNumber.value.replace(/\s+/g, "")
      if (cardNumberValue.length < 13 || cardNumberValue.length > 19) {
        showToast("Error", "Please enter a valid card number", "error")
        cardNumber.focus()
        return false
      }
  
      if (!expiryDate || !expiryDate.value.trim()) {
        showToast("Error", "Please enter your card expiry date", "error")
        expiryDate.focus()
        return false
      }
  
      // Validate expiry date format (MM/YY)
      const expiryRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/
      if (!expiryRegex.test(expiryDate.value.trim())) {
        showToast("Error", "Please enter a valid expiry date (MM/YY)", "error")
        expiryDate.focus()
        return false
      }
  
      if (!cvv || !cvv.value.trim()) {
        showToast("Error", "Please enter your CVV", "error")
        cvv.focus()
        return false
      }
  
      // Validate CVV (3-4 digits)
      if (cvv.value.length < 3 || cvv.value.length > 4) {
        showToast("Error", "Please enter a valid CVV", "error")
        cvv.focus()
        return false
      }
  
      if (!cardName || !cardName.value.trim()) {
        showToast("Error", "Please enter the name on card", "error")
        cardName.focus()
        return false
      }
  
      return true
    }
  
    function goToStep(stepNumber) {
      // Update step indicators
      steps.forEach((step, index) => {
        if (index + 1 < stepNumber) {
          step.classList.add("completed")
          step.classList.remove("active")
        } else if (index + 1 === stepNumber) {
          step.classList.add("active")
          step.classList.remove("completed")
        } else {
          step.classList.remove("active", "completed")
        }
      })
  
      // Update step connectors
      stepConnectors.forEach((connector, index) => {
        if (index + 2 <= stepNumber) {
          connector.classList.add("active")
        } else {
          connector.classList.remove("active")
        }
      })
  
      // Show the correct step content
      stepContents.forEach((content, index) => {
        if (index + 1 === stepNumber) {
          content.classList.add("active")
        } else {
          content.classList.remove("active")
        }
      })
  
      // Scroll to top
      window.scrollTo({ top: 0, behavior: "smooth" })
    }
  
    function processPayment(paymentMethod) {
      // Show loading modal
      if (loadingModal) loadingModal.style.display = "flex"
      if (overlay) overlay.style.display = "block"
  
      // Create booking from cart
      const booking = createBookingFromCart(paymentMethod)
  
      // Simulate payment processing
      setTimeout(() => {
        // Hide loading modal
        if (loadingModal) loadingModal.style.display = "none"
        if (overlay) overlay.style.display = "none"
  
        // Update confirmation page
        updateConfirmationPage(booking)
  
        // Go to confirmation step
        goToStep(3)
  
        // Clear cart
        localStorage.setItem("cart", JSON.stringify([]))
  
        // Update notification badge
        updateNotificationBadge()
      }, 2000)
    }
  
    function createBookingFromCart(paymentMethod) {
      // Calculate totals
      const subtotal = cartItems.reduce((total, item) => total + item.totalPrice, 0)
      const tax = subtotal * 0.08 // 8% tax
      const total = subtotal + tax
  
      // Generate a unique order ID
      const orderId = "ORD" + Date.now().toString().slice(-6)
  
      // Create booking
      const booking = {
        id: orderId,
        date: new Date().toISOString(),
        items: cartItems,
        subtotal,
        tax,
        total,
        status: "completed",
        payment_status: "completed",
        payment_method: paymentMethod,
        customer: {
          first_name: firstNameInput.value,
          last_name: lastNameInput.value,
          email: emailInput.value,
          phone: phoneInput.value,
          address: addressInput.value,
          notes: notesInput ? notesInput.value : "",
        },
      }
  
      // Get existing bookings
      const bookings = JSON.parse(localStorage.getItem("bookings")) || []
  
      // Add new booking
      bookings.unshift(booking)
  
      // Save to localStorage
      localStorage.setItem("bookings", JSON.stringify(bookings))
  
      // Add notification
      if (window.addNotification) {
        window.addNotification(
          "Order Placed Successfully",
          `Your order #${booking.id} has been placed and is being processed.`,
          "success",
        )
      }
  
      return booking
    }
  
    function updateConfirmationPage(booking) {
      // Update order details
      const orderNumberElement = document.getElementById("confirmation-order-number")
      const orderDateElement = document.getElementById("confirmation-order-date")
      const orderTotalElement = document.getElementById("confirmation-order-total")
      const paymentMethodElement = document.getElementById("confirmation-payment-method")
      const emailElement = document.getElementById("confirmation-email")
      const viewReceiptBtn = document.getElementById("view-receipt-btn")
  
      if (orderNumberElement) orderNumberElement.textContent = "#" + booking.id
  
      if (orderDateElement) {
        const date = new Date(booking.date)
        orderDateElement.textContent = date.toLocaleDateString() + " " + date.toLocaleTimeString()
      }
  
      if (orderTotalElement) orderTotalElement.textContent = "$" + booking.total.toFixed(2)
  
      if (paymentMethodElement) {
        let methodText = "Unknown"
        switch (booking.payment_method) {
          case "card":
            methodText = "Credit/Debit Card"
            break
          case "aba":
            methodText = "ABA Pay"
            break
          case "acleda":
            methodText = "ACLEDA Pay"
            break
          case "cash":
            methodText = "Cash on Delivery"
            break
        }
        paymentMethodElement.textContent = methodText
      }
  
      if (emailElement) emailElement.textContent = booking.customer.email
  
      if (viewReceiptBtn) viewReceiptBtn.href = "/receipt?order_id=" + booking.id
    }
  
    function updateNotificationBadge() {
      // Get bookings count
      const bookings = JSON.parse(localStorage.getItem("bookings")) || []
      const count = bookings.length
  
      // Update badge
      const badge = document.querySelector(".notification-badge")
      if (badge) {
        badge.textContent = count
        badge.style.display = count > 0 ? "flex" : "none"
      }
    }
  
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
      } else if (type === "warning") {
        icon = "exclamation-triangle"
        toast.classList.add("warning")
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
  
    // Add CSS for checkout steps
    const style = document.createElement("style")
    style.textContent = `
          /* Checkout Steps */
          .checkout-steps {
              display: flex;
              justify-content: space-between;
              align-items: center;
              margin-bottom: 30px;
              padding: 0 20px;
          }
          
          .step {
              display: flex;
              flex-direction: column;
              align-items: center;
              position: relative;
              z-index: 1;
          }
          
          .step-number {
              width: 40px;
              height: 40px;
              border-radius: 50%;
              background-color: #f5f5f5;
              border: 2px solid #ddd;
              display: flex;
              align-items: center;
              justify-content: center;
              font-weight: bold;
              color: #666;
              margin-bottom: 10px;
              transition: all 0.3s ease;
          }
          
          .step.active .step-number {
              background-color: #ff5e62;
              border-color: #ff5e62;
              color: white;
          }
          
          .step.completed .step-number {
              background-color: #4caf50;
              border-color: #4caf50;
              color: white;
          }
          
          .step-label {
              font-size: 14px;
              color: #666;
              text-align: center;
              transition: all 0.3s ease;
          }
          
          .step.active .step-label {
              color: #ff5e62;
              font-weight: bold;
          }
          
          .step.completed .step-label {
              color: #4caf50;
          }
          
          .step-connector {
              flex: 1;
              height: 2px;
              background-color: #ddd;
              margin: 0 10px;
              position: relative;
              top: -20px;
              z-index: 0;
              transition: all 0.3s ease;
          }
          
          .step-connector.active {
              background-color: #4caf50;
          }
          
          /* Step Content */
          .checkout-step-content {
              display: none;
          }
          
          .checkout-step-content.active {
              display: block;
              animation: fadeIn 0.5s ease;
          }
          
          @keyframes fadeIn {
              from { opacity: 0; }
              to { opacity: 1; }
          }
          
          /* Payment Methods */
          .payment-method {
              margin-bottom: 20px;
              border: 1px solid #ddd;
              border-radius: 8px;
              overflow: hidden;
              transition: all 0.3s ease;
          }
          
          .payment-method.active {
              border-color: #ff5e62;
              box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.1);
          }
          
          .payment-method-header {
              padding: 15px;
              background-color: #f9f9f9;
              cursor: pointer;
              display: flex;
              align-items: center;
          }
          
          .payment-method-header label {
              display: flex;
              align-items: center;
              gap: 10px;
              cursor: pointer;
              font-weight: 500;
              margin-left: 10px;
              flex: 1;
          }
          
          .payment-method-header label img {
              height: 30px;
              width: auto;
          }
          
          .payment-method-content {
              padding: 20px;
              border-top: 1px solid #eee;
              display: none;
          }
          
          .payment-method.active .payment-method-content {
              display: block;
          }
          
          /* QR Code Payment */
          .payment-qr-container {
              display: flex;
              flex-direction: column;
              align-items: center;
              gap: 15px;
              margin-bottom: 20px;
          }
          
          .payment-qr {
              max-width: 200px;
              height: auto;
              border: 1px solid #ddd;
              padding: 10px;
              border-radius: 8px;
          }
          
          .payment-details {
              background-color: #f9f9f9;
              padding: 15px;
              border-radius: 8px;
              margin-bottom: 20px;
          }
          
          .payment-detail-row {
              display: flex;
              justify-content: space-between;
              margin-bottom: 10px;
          }
          
          .payment-detail-row:last-child {
              margin-bottom: 0;
          }
          
          .payment-verification {
              margin-top: 20px;
          }
          
          /* Card Payment Form */
          .card-payment-form {
              max-width: 500px;
              margin: 0 auto;
          }
          
          .card-input-container {
              margin-bottom: 20px;
          }
          
          .card-front {
              background-color: #f9f9f9;
              border-radius: 10px;
              padding: 20px;
              box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          }
          
          .card-number-input {
              position: relative;
          }
          
          .card-icons {
              position: absolute;
              right: 10px;
              top: 50%;
              transform: translateY(-50%);
              display: flex;
              gap: 5px;
          }
          
          .card-icons i {
              font-size: 24px;
          }
          
          .cvv-info {
              position: relative;
              display: inline-block;
              margin-left: 5px;
          }
          
          .cvv-tooltip {
              position: absolute;
              bottom: 100%;
              left: 50%;
              transform: translateX(-50%);
              background-color: #333;
              color: white;
              padding: 5px 10px;
              border-radius: 4px;
              font-size: 12px;
              white-space: nowrap;
              opacity: 0;
              visibility: hidden;
              transition: all 0.3s ease;
          }
          
          .cvv-info:hover .cvv-tooltip {
              opacity: 1;
              visibility: visible;
          }
          
          /* Loading Modal */
          .loading-modal {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.5);
              display: none;
              justify-content: center;
              align-items: center;
              z-index: 1000;
          }
          
          .loading-spinner {
              background-color: white;
              padding: 30px;
              border-radius: 10px;
              text-align: center;
              box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
          }
          
          .loading-spinner i {
              font-size: 40px;
              color: #ff5e62;
              margin-bottom: 15px;
          }
          
          /* Confirmation Step */
          .order-confirmation {
              text-align: center;
              padding: 30px;
              background-color: white;
              border-radius: 10px;
              box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
          }
          
          .confirmation-icon {
              font-size: 60px;
              color: #4caf50;
              margin-bottom: 20px;
          }
          
          .order-details {
              background-color: #f9f9f9;
              padding: 20px;
              border-radius: 8px;
              margin: 20px 0;
              text-align: left;
          }
          
          .order-number, .order-date, .order-total, .payment-method-used {
              display: flex;
              justify-content: space-between;
              margin-bottom: 10px;
          }
          
          .confirmation-message {
              margin: 20px 0;
          }
          
          .confirmation-actions {
              display: flex;
              justify-content: center;
              gap: 15px;
              margin-top: 30px;
              flex-wrap: wrap;
          }
      `
    document.head.appendChild(style)
  })
  