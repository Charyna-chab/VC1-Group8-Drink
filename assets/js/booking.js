// booking.js - Enhanced with improved payment methods, receipt handling, and better UX
document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const bookingsList = document.querySelector(".bookings-list")
            const filterTabs = document.querySelectorAll(".filter-tab")
            const searchInput = document.getElementById("bookingSearch")
            const ctaButton = document.querySelector(".cta-button")
            const mainContent = document.querySelector(".main-content")
            const contentArea = document.querySelector(".content-area") || mainContent

            // Get cart items from localStorage
            const cartItems = JSON.parse(localStorage.getItem("cart")) || []

            // Create bookings from cart items
            const bookings = JSON.parse(localStorage.getItem("bookings")) || []

            // Check if we just came from checkout
            const justCheckedOut = sessionStorage.getItem("justCheckedOut")
            if (justCheckedOut) {
                // Clear the flag
                sessionStorage.removeItem("justCheckedOut")

                // Create a new booking from cart items if there are any
                if (cartItems.length > 0) {
                    createBookingFromCart()
                }
            }

            // Initialize bookings
            renderBookings()

            // Filter bookings by status
            filterTabs.forEach((tab) => {
                tab.addEventListener("click", function() {
                    // Remove active class from all tabs
                    filterTabs.forEach((t) => t.classList.remove("active"))

                    // Add active class to clicked tab
                    this.classList.add("active")

                    // Filter bookings
                    const status = this.getAttribute("data-status")
                    renderBookings(status)
                })
            })

            // Search bookings
            if (searchInput) {
                searchInput.addEventListener("input", function() {
                    const searchTerm = this.value.toLowerCase().trim()
                    const activeStatus = document.querySelector(".filter-tab.active").getAttribute("data-status")

                    renderBookings(activeStatus, searchTerm)
                })
            }

            // CTA button click
            if (ctaButton) {
                ctaButton.addEventListener("click", () => {
                    window.location.href = "/order"
                })
            }

            // Create booking from cart
            function createBookingFromCart() {
                if (cartItems.length === 0) return

                // Calculate total
                const subtotal = cartItems.reduce((total, item) => total + item.totalPrice, 0)
                const tax = subtotal * 0.08
                const total = subtotal + tax

                // Create booking
                const booking = {
                    id: "ORD" + Date.now().toString().slice(-6),
                    date: new Date().toISOString(),
                    items: cartItems,
                    subtotal,
                    tax,
                    total,
                    status: "processing",
                    paymentStatus: "pending", // Add payment status
                    paymentMethod: null, // Will be set when payment is made
                }

                // Add to bookings
                bookings.unshift(booking)

                // Save to localStorage
                localStorage.setItem("bookings", JSON.stringify(bookings))

                // Clear cart
                localStorage.setItem("cart", JSON.stringify([]))

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Order Placed Successfully",
                        `Your order #${booking.id} has been placed and is being processed.`,
                        "order",
                    )
                }
            }

            // Render bookings
            function renderBookings(status = "all", searchTerm = "") {
                if (!bookingsList) return

                // Filter bookings by status
                let filteredBookings = bookings
                if (status !== "all") {
                    filteredBookings = bookings.filter((booking) => booking.status === status)
                }
                // Fix: When in "all" tab, don't show cancelled orders
                else {
                    filteredBookings = bookings.filter((booking) => booking.status !== "cancelled")
                }

                // Filter by search term
                if (searchTerm) {
                    filteredBookings = filteredBookings.filter((booking) => booking.id.toLowerCase().includes(searchTerm))
                }

                // Clear bookings list
                bookingsList.innerHTML = ""

                // Show empty state if no bookings
                if (filteredBookings.length === 0) {
                    bookingsList.innerHTML = `
        <div class="empty-state">
          <img src="/assets/image/empty-orders.svg" alt="No Orders">
          <h3>No Orders Found</h3>
          <p>${status === "all" ? "You haven't placed any orders yet." : `You don't have any ${status} orders.`}</p>
          <a href="/order" class="btn-primary">Order Now</a>
        </div>
      `
      return
    }

    // Render each booking
    filteredBookings.forEach((booking) => {
      const bookingCard = document.createElement("div")
      bookingCard.className = "booking-card"
      bookingCard.setAttribute("data-id", booking.id)
      bookingCard.setAttribute("data-status", booking.status)

      // Format date
      const date = new Date(booking.date)
      const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString()

      // Get status class
      let statusClass = ""
      switch (booking.status) {
        case "processing":
          statusClass = "processing"
          break
        case "completed":
          statusClass = "completed"
          break
        case "cancelled":
          statusClass = "cancelled"
          break
      }

      // Create booking card HTML
      bookingCard.innerHTML = `
        <div class="booking-header">
          <div class="booking-info">
            <h3>Order #${booking.id}</h3>
            <div class="booking-date">
              <i class="fas fa-calendar-alt"></i>
              <span>${formattedDate}</span>
            </div>
          </div>
          <div class="booking-status ${statusClass}">
            ${booking.status}
          </div>
        </div>
        <div class="booking-items">
          ${booking.items
            .map(
              (item) => `
              <div class="booking-item">
                <div class="item-details">
                  <h4>${item.name}</h4>
                  <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                  <p>Quantity: ${item.quantity}</p>
                </div>
                <div class="item-price">$${item.totalPrice.toFixed(2)}</div>
              </div>
            `,
            )
            .join("")}
        </div>
        <div class="booking-footer">
          <div class="booking-total">
            Total: <span class="total-price">$${booking.total.toFixed(2)}</span>
          </div>
          <div class="booking-actions">
            <a href="#" class="btn-secondary view-details" data-id="${booking.id}">
              <i class="fas fa-eye"></i> View Details
            </a>
            ${
              booking.status === "processing"
                ? `
                <button class="btn-outline-danger cancel-booking" data-id="${booking.id}">
                  <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn-primary complete-booking" data-id="${booking.id}">
                  <i class="fas fa-check"></i> Complete
                </button>
              `
                : ""
            }
            ${
              booking.status === "completed" || booking.status === "cancelled"
                ? `
                <button class="btn-outline-danger delete-booking" data-id="${booking.id}">
                  <i class="fas fa-trash"></i> Delete
                </button>
              `
                : ""
            }
          </div>
        </div>
      `

      bookingsList.appendChild(bookingCard)
    })

    // Add event listeners to buttons
    const viewDetailsButtons = document.querySelectorAll(".view-details")
    const cancelButtons = document.querySelectorAll(".cancel-booking")
    const completeButtons = document.querySelectorAll(".complete-booking")
    const deleteButtons = document.querySelectorAll(".delete-booking")

    viewDetailsButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault()
        const id = this.getAttribute("data-id")
        showBookingDetails(id)
      })
    })

    cancelButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        cancelBooking(id)
      })
    })

    completeButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        // Show payment interface directly when complete button is clicked
        showPaymentInterface(id)
      })
    })

    deleteButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        deleteBooking(id)
      })
    })
  }

  // Delete booking
  function deleteBooking(id) {
    const bookingIndex = bookings.findIndex((b) => b.id === id)
    if (bookingIndex === -1) return

    // Remove booking from array
    bookings.splice(bookingIndex, 1)

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings))

    // Add notification
    if (window.addNotification) {
      window.addNotification("Order Deleted", `Order #${id} has been permanently deleted.`, "order")
    }

    // Find and remove the booking card from the DOM
    const bookingCard = document.querySelector(`.booking-card[data-id="${id}"]`)
    if (bookingCard) {
      // Add fade-out animation
      bookingCard.style.transition = "opacity 0.3s ease, transform 0.3s ease"
      bookingCard.style.opacity = "0"
      bookingCard.style.transform = "translateX(20px)"

      // Remove after animation completes
      setTimeout(() => {
        bookingCard.remove()

        // Check if there are no more bookings and show empty state if needed
        if (bookingsList.children.length === 0) {
          bookingsList.innerHTML = `
            <div class="empty-state">
              <img src="/assets/image/empty-orders.svg" alt="No Orders">
              <h3>No Orders Found</h3>
              <p>You haven't placed any orders yet.</p>
              <a href="/order" class="btn-primary">Order Now</a>
            </div>
          `
        }
      }, 300)
    }
  }

  // Show booking details
  function showBookingDetails(id) {
    const booking = bookings.find((b) => b.id === id)
    if (!booking) return

    // Create modal
    const modal = document.createElement("div")
    modal.className = "booking-details-modal"

    // Format date
    const date = new Date(booking.date)
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString()

    // Get status class
    let statusClass = ""
    switch (booking.status) {
      case "processing":
        statusClass = "processing"
        break
      case "completed":
        statusClass = "completed"
        break
      case "cancelled":
        statusClass = "cancelled"
        break
    }

    // Get payment status
    const paymentStatus = booking.paymentStatus || "pending"
    const paymentStatusClass = paymentStatus === "completed" ? "completed" : "processing"

    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <h3>Order Details</h3>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="order-info">
            <div class="order-header">
              <div>
                <h4>Order #${booking.id}</h4>
                <p><i class="fas fa-calendar-alt"></i> ${formattedDate}</p>
              </div>
              <div class="order-status-container">
                <div class="order-status ${statusClass}">
                  ${booking.status}
                </div>
                <div class="payment-status ${paymentStatusClass}">
                  Payment: ${paymentStatus}
                </div>
              </div>
            </div>
            
            <div class="order-items">
              <h4>Items</h4>
              ${booking.items
                .map(
                  (item) => `
                  <div class="order-item">
                    <div class="item-image">
                      <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="item-details">
                      <h5>${item.name}</h5>
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
                .join("")}
            </div>
            
            <div class="order-summary">
              <h4>Order Summary</h4>
              <div class="summary-row">
                <span>Subtotal:</span>
                <span>$${booking.subtotal.toFixed(2)}</span>
              </div>
              <div class="summary-row">
                <span>Tax (8%):</span>
                <span>$${booking.tax.toFixed(2)}</span>
              </div>
              <div class="summary-row total">
                <span>Total:</span>
                <span>$${booking.total.toFixed(2)}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn-secondary close-details">Close</button>
          ${
            booking.status === "processing"
              ? `
              <button class="btn-outline-danger cancel-booking-modal" data-id="${booking.id}">Cancel Order</button>
              <button class="btn-primary complete-booking-modal" data-id="${booking.id}">Complete Order</button>
            `
              : ""
          }
          ${
            booking.status === "cancelled" || booking.status === "completed"
              ? `
              <button class="btn-outline-danger delete-booking-modal" data-id="${booking.id}">
                <i class="fas fa-trash"></i> Delete Order
              </button>
            `
              : ""
          }
          ${
            (booking.status === "processing" && booking.paymentStatus === "pending") || !booking.paymentStatus
              ? `
              <button class="btn-success pay-now-modal" data-id="${booking.id}">
                <i class="fas fa-credit-card"></i> Pay Now
              </button>
            `
              : ""
          }
          ${
            booking.paymentStatus === "completed"
              ? `
              <button class="btn-success view-receipt-modal" data-id="${booking.id}">
                <i class="fas fa-receipt"></i> View Receipt
              </button>
            `
              : ""
          }
        </div>
      </div>
    `

    document.body.appendChild(modal)

    // Add event listeners
    const closeButtons = modal.querySelectorAll(".close-modal, .close-details")
    closeButtons.forEach((button) => {
      button.addEventListener("click", () => {
        modal.remove()
      })
    })

    const cancelButton = modal.querySelector(".cancel-booking-modal")
    if (cancelButton) {
      cancelButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        cancelBooking(id)
        modal.remove()
      })
    }

    const completeButton = modal.querySelector(".complete-booking-modal")
    if (completeButton) {
      completeButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        // Show payment interface directly when complete button is clicked
        modal.remove()
        showPaymentInterface(id)
      })
    }

    const deleteButton = modal.querySelector(".delete-booking-modal")
    if (deleteButton) {
      deleteButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        deleteBooking(id)
        modal.remove()
      })
    }

    // Add event listener for Pay Now button
    const payNowButton = modal.querySelector(".pay-now-modal")
    if (payNowButton) {
      payNowButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        modal.remove()
        showPaymentInterface(id)
      })
    }

    // Add event listener for View Receipt button
    const viewReceiptButton = modal.querySelector(".view-receipt-modal")
    if (viewReceiptButton) {
      viewReceiptButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        modal.remove()
        showReceiptInterface(id)
      })
    }

    // Close when clicking outside
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.remove()
      }
    })
  }

  // Cancel booking
  function cancelBooking(id) {
    const bookingIndex = bookings.findIndex((b) => b.id === id)
    if (bookingIndex === -1) return

    // Update booking status
    bookings[bookingIndex].status = "cancelled"

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings))

    // Add notification
    if (window.addNotification) {
      window.addNotification("Order Cancelled", `Your order #${bookings[bookingIndex].id} has been cancelled.`, "order")
    }

    // Find and remove the booking card from the DOM if in "all" tab
    const activeTab = document.querySelector(".filter-tab.active")
    if (activeTab && activeTab.getAttribute("data-status") === "all") {
      const bookingCard = document.querySelector(`.booking-card[data-id="${id}"]`)
      if (bookingCard) {
        // Add fade-out animation
        bookingCard.style.transition = "opacity 0.3s ease, transform 0.3s ease"
        bookingCard.style.opacity = "0"
        bookingCard.style.transform = "translateX(20px)"

        // Remove after animation completes
        setTimeout(() => {
          bookingCard.remove()

          // Check if there are no more bookings and show empty state if needed
          if (bookingsList.children.length === 0) {
            bookingsList.innerHTML = `
              <div class="empty-state">
                <img src="/assets/image/empty-orders.svg" alt="No Orders">
                <h3>No Orders Found</h3>
                <p>You haven't placed any orders yet.</p>
                <a href="/order" class="btn-primary">Order Now</a>
              </div>
            `
          }
        }, 300)
      }
    } else {
      // Re-render bookings for other tabs
      const status = activeTab ? activeTab.getAttribute("data-status") : "all"
      const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : ""
      renderBookings(status, searchTerm)
    }
  }

  // Complete booking
  function completeBooking(id) {
    const bookingIndex = bookings.findIndex((b) => b.id === id)
    if (bookingIndex === -1) return

    // Update booking status
    bookings[bookingIndex].status = "completed"

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings))

    // Add notification
    if (window.addNotification) {
      window.addNotification(
        "Order Completed",
        `Your order #${bookings[bookingIndex].id} has been marked as completed.`,
        "order",
      )
    }

    // Show success notification on the left side
    showOrderSuccessNotification(bookings[bookingIndex])

    // Re-render bookings
    const activeTab = document.querySelector(".filter-tab.active")
    const status = activeTab ? activeTab.getAttribute("data-status") : "all"
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : ""
    renderBookings(status, searchTerm)
  }

  // Show order success notification on the left side
  function showOrderSuccessNotification(booking) {
    const notification = document.createElement("div")
    notification.className = "order-success-notification left-notification"

    notification.innerHTML = `
      <div class="notification-content">
        <div class="success-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="notification-text">
          <h4>Your order drink success!</h4>
          <p>Order #${booking.id} has been successfully completed.</p>
        </div>
        <button class="close-notification">&times;</button>
      </div>
    `

    document.body.appendChild(notification)

    // Auto remove after 5 seconds
    setTimeout(() => {
      notification.classList.add("fade-out")
      setTimeout(() => {
        notification.remove()
      }, 500)
    }, 5000)

    // Close button
    notification.querySelector(".close-notification").addEventListener("click", () => {
      notification.remove()
    })
  }

  // Show payment interface (as a section in the page, not a modal)
  function showPaymentInterface(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId)
    if (!booking) return

    // Save original bookings list content
    const originalBookingsContent = bookingsList.innerHTML

    // Create payment interface content
    const paymentInterfaceContent = `
      <div class="payment-interface-container">
        <div class="payment-interface-header">
          <button class="back-to-bookings">
            <i class="fas fa-arrow-left"></i> Back to Orders
          </button>
          <h2>Payment</h2>
        </div>
        
        <div class="payment-interface-content">
          <div class="payment-amount-section">
            <h3>Amount to Pay</h3>
            <div class="amount-display">$${booking.total.toFixed(2)}</div>
            <div class="order-id">Order #${booking.id}</div>
          </div>
          
          <div class="payment-methods-section">
            <h3>Select Payment Method</h3>
            <div class="payment-methods-grid">
              <div class="payment-method-card selected" data-method="credit-card">
                <input type="radio" id="credit-card" name="payment-method" checked>
                <label for="credit-card">
                  <i class="fas fa-credit-card"></i>
                  <span>Credit/Debit Card</span>
                </label>
              </div>
              
              <div class="payment-method-card" data-method="qr-code">
                <input type="radio" id="qr-code" name="payment-method">
                <label for="qr-code">
                  <i class="fas fa-qrcode"></i>
                  <span>QR Code Payment</span>
                </label>
              </div>
              
              <div class="payment-method-card" data-method="aba">
                <input type="radio" id="aba" name="payment-method">
                <label for="aba">
                  <i class="fas fa-university"></i>
                  <span>ABA Payment</span>
                </label>
              </div>
              
              <div class="payment-method-card" data-method="apple-pay">
                <input type="radio" id="apple-pay" name="payment-method">
                <label for="apple-pay">
                  <i class="fab fa-apple-pay"></i>
                  <span>Apple Pay</span>
                </label>
              </div>
              
              <div class="payment-method-card" data-method="cash">
                <input type="radio" id="cash" name="payment-method">
                <label for="cash">
                  <i class="fas fa-money-bill-wave"></i>
                  <span>Cash on Delivery</span>
                </label>
              </div>
            </div>
          </div>
          
          <div class="payment-details-section">
            <div class="payment-details credit-card-details">
              <h3>Card Details</h3>
              <div class="form-group">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" placeholder="1234 5678 9012 3456">
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="expiry-date">Expiry Date</label>
                  <input type="text" id="expiry-date" placeholder="MM/YY">
                </div>
                <div class="form-group">
                  <label for="cvv">CVV</label>
                  <input type="text" id="cvv" placeholder="123">
                </div>
              </div>
              <div class="form-group">
                <label for="card-name">Name on Card</label>
                <input type="text" id="card-name" placeholder="John Doe">
              </div>
            </div>
            
            <div class="payment-details qr-code-details" style="display: none;">
              <div class="qr-code-container">
                <div class="qr-code-image">
                  <img src="/placeholder.svg?height=200&width=200" alt="QR Code">
                </div>
                <p>Scan this QR code with your mobile payment app to complete the payment.</p>
                <div class="qr-code-timer">
                  <p>This QR code will expire in <span class="timer">05:00</span></p>
                </div>
              </div>
            </div>
            
            <div class="payment-details aba-details" style="display: none;">
              <div class="aba-container">
                <div class="aba-logo">
                  <img src="/placeholder.svg?height=80&width=150" alt="ABA Logo">
                </div>
                <div class="aba-info">
                  <h5>ABA Bank Transfer</h5>
                  <div class="aba-account-info">
                    <div class="info-row">
                      <span>Account Name:</span>
                      <span>Your Business Name</span>
                    </div>
                    <div class="info-row">
                      <span>Account Number:</span>
                      <span>000 123 456 789</span>
                    </div>
                    <div class="info-row">
                      <span>Reference:</span>
                      <span>${booking.id}</span>
                    </div>
                  </div>
                  <p class="aba-instructions">Please use your Order ID as the payment reference. Your order will be processed once payment is confirmed.</p>
                </div>
              </div>
            </div>
            
            <div class="payment-details apple-pay-details" style="display: none;">
              <div class="apple-pay-container">
                <div class="apple-pay-logo">
                  <i class="fab fa-apple-pay"></i>
                </div>
                <button class="apple-pay-button">
                  <span>Pay with</span>
                  <i class="fab fa-apple"></i> Pay
                </button>
                <p>Click the button above to pay with Apple Pay.</p>
              </div>
            </div>
            
            <div class="payment-details cash-details" style="display: none;">
              <div class="cash-icon">
                <i class="fas fa-money-bill-wave"></i>
              </div>
              <p>Pay with cash when your order is delivered.</p>
              <div class="cash-instructions">
                <p>Please have the exact amount ready: <strong>$${booking.total.toFixed(2)}</strong></p>
                <p>Our delivery person will provide you with a receipt upon payment.</p>
              </div>
            </div>
          </div>
          
          <div class="payment-actions">
            <button class="btn-secondary cancel-payment">Cancel</button>
            <button class="btn-success process-payment" data-id="${booking.id}">
              <i class="fas fa-lock"></i> Pay Now $${booking.total.toFixed(2)}
            </button>
          </div>
        </div>
      </div>
    `

    // Replace bookings list content with payment interface
    bookingsList.innerHTML = paymentInterfaceContent

    // Store original content for returning
    sessionStorage.setItem("originalBookingsContent", originalBookingsContent)

    // Add event listeners for payment method selection
    const methodCards = document.querySelectorAll(".payment-method-card")
    methodCards.forEach((card) => {
      card.addEventListener("click", function () {
        // Update radio button
        const radio = this.querySelector("input[type='radio']")
        radio.checked = true

        // Add selected class to clicked card and remove from others
        methodCards.forEach((c) => c.classList.remove("selected"))
        this.classList.add("selected")

        // Hide all payment details
        document.querySelectorAll(".payment-details").forEach((detail) => {
          detail.style.display = "none"
        })

        // Show selected payment details
        const method = this.getAttribute("data-method")
        document.querySelector(`.${method}-details`).style.display = "block"
      })
    })

    // Back button
    document.querySelector(".back-to-bookings").addEventListener("click", () => {
      bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent")
      sessionStorage.removeItem("originalBookingsContent")

      // Re-initialize event listeners
      initializeEventListeners()
    })

    // Cancel button
    document.querySelector(".cancel-payment").addEventListener("click", () => {
      bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent")
      sessionStorage.removeItem("originalBookingsContent")

      // Re-initialize event listeners
      initializeEventListeners()
    })

    // Process payment button
    document.querySelector(".process-payment").addEventListener("click", function () {
      const id = this.getAttribute("data-id")
      const selectedMethod = document.querySelector("input[name='payment-method']:checked").id

      // Process payment
      processPayment(id, selectedMethod)
    })
  }

  // Process payment
  function processPayment(bookingId, paymentMethod) {
    const bookingIndex = bookings.findIndex((b) => b.id === bookingId)
    if (bookingIndex === -1) return

    // Update booking payment status
    bookings[bookingIndex].paymentStatus = "completed"
    bookings[bookingIndex].paymentMethod = paymentMethod

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings))

    // Add notification
    if (window.addNotification) {
      window.addNotification(
        "Payment Successful",
        `Payment for order #${bookingId} has been processed successfully.`,
        "payment",
      )
    }

    // Show success notification on the left side
    showPaymentSuccessNotification(bookings[bookingIndex])

    // Show receipt interface as a modal in the center
    showReceiptModal(bookingId)
  }

  // Show payment success notification on the left side
  function showPaymentSuccessNotification(booking) {
    const notification = document.createElement("div")
    notification.className = "payment-success-notification left-notification"

    notification.innerHTML = `
      <div class="notification-content">
        <div class="success-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="notification-text">
          <h4>Payment Successful!</h4>
          <p>Your payment for order #${booking.id} has been processed.</p>
        </div>
        <button class="close-notification">&times;</button>
      </div>
    `

    document.body.appendChild(notification)

    // Auto remove after 5 seconds
    setTimeout(() => {
      notification.classList.add("fade-out")
      setTimeout(() => {
        notification.remove()
      }, 500)
    }, 5000)

    // Close button
    notification.querySelector(".close-notification").addEventListener("click", () => {
      notification.remove()
    })
  }

  // Show receipt as a modal in the center
  function showReceiptModal(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId)
    if (!booking) return

    // Format date
    const date = new Date()
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString()

    // Generate receipt ID
    const receiptId = "RCP" + Date.now().toString().slice(-6)

    // Create receipt modal
    const receiptModal = document.createElement("div")
    receiptModal.className = "receipt-modal"

    receiptModal.innerHTML = `
      <div class="receipt-modal-content">
        <div class="receipt-paper">
          <div class="receipt-header">
            <h2>CASH RECEIPT</h2>
            <div class="receipt-info">
              <div class="shop-info">
                <p>Shop Name</p>
                <p>Date: ${formattedDate}</p>
                <p>Manager: John Doe</p>
                <p>Cashier: Jane Doe</p>
              </div>
              <div class="shop-address">
                <p>Shop Address</p>
                <p>XXXXXXXXXX</p>
              </div>
            </div>
            <div class="receipt-divider">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
          </div>
          
          <div class="receipt-body">
            <div class="receipt-items-header">
              <span class="item-description">Description</span>
              <span class="item-price">Price</span>
            </div>
            
            ${booking.items
              .map(
                (item) => `
              <div class="receipt-item-row">
                <div class="item-description">
                  <div class="item-image-small">
                    <img src="${item.image}" alt="${item.name}">
                  </div>
                  <div class="item-text">
                    <p>${item.name}</p>
                    <p class="item-details">Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                    ${
                      item.toppings && item.toppings.length > 0
                        ? `<p class="item-details">Toppings: ${item.toppings.map((t) => t.name).join(", ")}</p>`
                        : ""
                    }
                    <p class="item-quantity">x${item.quantity}</p>
                  </div>
                </div>
                <div class="item-price">$${item.totalPrice.toFixed(2)}</div>
              </div>
            `,
              )
              .join("")}
            
            <div class="receipt-divider">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
            
            <div class="receipt-total-section">
              <div class="total-row">
                <span>Total</span>
                <span>$${booking.subtotal.toFixed(2)}</span>
              </div>
              <div class="total-row">
                <span>Tax</span>
                <span>$${booking.tax.toFixed(2)}</span>
              </div>
              <div class="total-row grand-total">
                <span>Grand Total</span>
                <span>$${booking.total.toFixed(2)}</span>
              </div>
            </div>
            
            <div class="receipt-divider">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
            
            <div class="receipt-footer">
              <p>Thank you for shopping!</p>
              <div class="receipt-barcode">
                <img src="/placeholder.svg?height=50&width=200" alt="Barcode">
                <p>${receiptId}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="receipt-actions">
          <button class="btn-secondary print-receipt">
            <i class="fas fa-print"></i> Print Receipt
          </button>
          <button class="btn-primary continue-order" data-id="${booking.id}">
            <i class="fas fa-check"></i> Continue Order
          </button>
        </div>
      </div>
    `

    document.body.appendChild(receiptModal)

    // Print button
    receiptModal.querySelector(".print-receipt").addEventListener("click", () => {
      // Print the receipt
      const receiptContent = receiptModal.querySelector(".receipt-paper")
      const originalContents = document.body.innerHTML

      document.body.innerHTML = `
        <div class="print-only">
          ${receiptContent.outerHTML}
        </div>
      `

      window.print()

      // Restore the page
      document.body.innerHTML = originalContents

      // Show receipt modal again
      showReceiptModal(bookingId)
    })

    // Continue Order button
    receiptModal.querySelector(".continue-order").addEventListener("click", function () {
      const id = this.getAttribute("data-id")

      // Complete the booking
      completeBooking(id)

      // Close the receipt modal
      receiptModal.remove()

      // Return to original bookings list
      if (sessionStorage.getItem("originalBookingsContent")) {
        bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent")
        sessionStorage.removeItem("originalBookingsContent")
      } else {
        // If original content is not available, just render bookings
        renderBookings()
      }

      // Re-initialize event listeners
      initializeEventListeners()
    })

    // Close when clicking outside
    receiptModal.addEventListener("click", (e) => {
      if (e.target === receiptModal) {
        receiptModal.remove()

        // Return to original bookings list
        if (sessionStorage.getItem("originalBookingsContent")) {
          bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent")
          sessionStorage.removeItem("originalBookingsContent")
        } else {
          // If original content is not available, just render bookings
          renderBookings()
        }

        // Re-initialize event listeners
        initializeEventListeners()
      }
    })
  }

  // Show receipt interface (as a section in the page, not a modal)
  function showReceiptInterface(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId)
    if (!booking) return

    // Format date
    const date = new Date()
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString()

    // Generate receipt ID
    const receiptId = "RCP" + Date.now().toString().slice(-6)

    // Create receipt interface content
    const receiptInterfaceContent = `
      <div class="receipt-interface-container">
        <div class="receipt-interface-content">
          <div class="receipt-paper">
            <div class="receipt-header">
              <h2>CASH RECEIPT</h2>
              <div class="receipt-info">
                <div class="shop-info">
                  <p>Shop Name</p>
                  <p>Date: ${formattedDate}</p>
                  <p>Manager: John Doe</p>
                  <p>Cashier: Jane Doe</p>
                </div>
                <div class="shop-address">
                  <p>Shop Address</p>
                  <p>XXXXXXXXXX</p>
                </div>
              </div>
              <div class="receipt-divider">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
            </div>
            
            <div class="receipt-body">
              <div class="receipt-items-header">
                <span class="item-description">Description</span>
                <span class="item-price">Price</span>
              </div>
              
              ${booking.items
                .map(
                  (item) => `
                <div class="receipt-item-row">
                  <div class="item-description">
                    <div class="item-image-small">
                      <img src="${item.image}" alt="${item.name}">
                    </div>
                    <div class="item-text">
                      <p>${item.name}</p>
                      <p class="item-details">Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                      ${
                        item.toppings && item.toppings.length > 0
                          ? `<p class="item-details">Toppings: ${item.toppings.map((t) => t.name).join(", ")}</p>`
                          : ""
                      }
                      <p class="item-quantity">x${item.quantity}</p>
                    </div>
                  </div>
                  <div class="item-price">$${item.totalPrice.toFixed(2)}</div>
                </div>
              `,
                )
                .join("")}
              
              <div class="receipt-divider">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
              
              <div class="receipt-total-section">
                <div class="total-row">
                  <span>Total</span>
                  <span>$${booking.subtotal.toFixed(2)}</span>
                </div>
                <div class="total-row">
                  <span>Tax</span>
                  <span>$${booking.tax.toFixed(2)}</span>
                </div>
                <div class="total-row grand-total">
                  <span>Grand Total</span>
                  <span>$${booking.total.toFixed(2)}</span>
                </div>
              </div>
              
              <div class="receipt-divider">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
              
              <div class="receipt-footer">
                <p>Thank you for shopping!</p>
                <div class="receipt-barcode">
                  <img src="/placeholder.svg?height=50&width=200" alt="Barcode">
                  <p>${receiptId}</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="receipt-actions">
            <button class="btn-secondary print-receipt">
              <i class="fas fa-print"></i> Print Receipt
            </button>
            <button class="btn-primary continue-order" data-id="${booking.id}">
              <i class="fas fa-check"></i> Continue Order
            </button>
          </div>
        </div>
      </div>
    `

    // Replace content with receipt interface
    bookingsList.innerHTML = receiptInterfaceContent

    // Print button
    document.querySelector(".print-receipt").addEventListener("click", () => {
      // Print the receipt
      const receiptContent = document.querySelector(".receipt-paper")
      const originalContents = document.body.innerHTML

      document.body.innerHTML = `
        <div class="print-only">
          ${receiptContent.outerHTML}
        </div>
      `

      window.print()

      // Restore the page
      document.body.innerHTML = originalContents

      // Show receipt interface again
      showReceiptInterface(bookingId)
    })

    // Continue Order button
    document.querySelector(".continue-order").addEventListener("click", function () {
      const id = this.getAttribute("data-id")

      // Complete the booking
      completeBooking(id)

      // Return to original bookings list
      if (sessionStorage.getItem("originalBookingsContent")) {
        bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent")
        sessionStorage.removeItem("originalBookingsContent")
      } else {
        // If original content is not available, just render bookings
        renderBookings()
      }

      // Re-initialize event listeners
      initializeEventListeners()
    })
  }

  // Initialize event listeners after DOM changes
  function initializeEventListeners() {
    // Re-attach event listeners to filter tabs
    const filterTabs = document.querySelectorAll(".filter-tab")
    filterTabs.forEach((tab) => {
      tab.addEventListener("click", function () {
        filterTabs.forEach((t) => t.classList.remove("active"))
        this.classList.add("active")
        const status = this.getAttribute("data-status")
        renderBookings(status)
      })
    })

    // Re-attach search functionality
    const searchInput = document.getElementById("bookingSearch")
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase().trim()
        const activeStatus = document.querySelector(".filter-tab.active").getAttribute("data-status")
        renderBookings(activeStatus, searchTerm)
      })
    }

    // Re-render bookings
    renderBookings()
  }

  // Add CSS for booking
  const style = document.createElement("style")
  style.textContent = `
    /* Booking Card Styles */
    .booking-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      margin-bottom: 20px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .booking-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .booking-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-bottom: 1px solid #eee;
      background-color: #f9f9f9;
    }

    .booking-info h3 {
      margin: 0 0 5px;
      font-size: 18px;
      color: #333;
    }

    .booking-date {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 14px;
      color: #666;
    }

    .booking-status {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .booking-status.processing {
      background-color: #fff8e1;
      color: #ff9800;
    }

    .booking-status.completed {
      background-color: #e8f5e9;
      color: #4caf50;
    }

    .booking-status.cancelled {
      background-color: #ffebee;
      color: #f44336;
    }

    .payment-status {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      margin-top: 5px;
    }

    .payment-status.processing {
      background-color: #e3f2fd;
      color: #2196f3;
    }

    .payment-status.completed {
      background-color: #e8f5e9;
      color: #4caf50;
    }

    .order-status-container {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
    }

    .booking-items {
      padding: 15px 20px;
    }

    .booking-item {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px dashed #eee;
    }

    .booking-item:last-child {
      border-bottom: none;
    }

    .item-details h4 {
      margin: 0 0 5px;
      font-size: 16px;
      color: #333;
    }

    .item-details p {
      margin: 0;
      font-size: 14px;
      color: #666;
    }

    .item-price {
      font-size: 16px;
      font-weight: 600;
      color: #ff5e62;
      align-self: center;
    }

    .booking-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-top: 1px solid #eee;
      background-color: #f9f9f9;
    }

    .booking-total {
      font-size: 16px;
      font-weight: 600;
      color: #333;
    }

    .total-price {
      color: #ff5e62;
    }

    .booking-actions {
      display: flex;
      gap: 10px;
    }

    .btn-secondary {
      padding: 8px 15px;
      background-color: #f5f5f5;
      color: #333;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 5px;
      text-decoration: none;
    }

    .btn-secondary:hover {
      background-color: #e5e5e5;
    }

    .btn-outline-danger {
      padding: 8px 15px;
      background-color: transparent;
      color: #f44336;
      border: 1px solid #f44336;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-outline-danger:hover {
      background-color: #f44336;
      color: white;
    }

    .btn-primary {
      padding: 8px 15px;
      background-color: #ff5e62;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-primary:hover {
      background-color: #ff4146;
    }

    .btn-success {
      padding: 8px 15px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-success:hover {
      background-color: #43a047;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .empty-state img {
      width: 120px;
      height: auto;
      margin-bottom: 20px;
      opacity: 0.7;
    }

    .empty-state h3 {
      margin: 0 0 10px;
      font-size: 20px;
      color: #333;
    }

    .empty-state p {
      margin: 0 0 20px;
      font-size: 16px;
      color: #666;
    }

    /* Booking Details Modal */
    .booking-details-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-content {
      width: 90%;
      max-width: 600px;
      max-height: 90vh;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-bottom: 1px solid #eee;
    }

    .modal-header h3 {
      margin: 0;
      font-size: 20px;
      color: #333;
    }

    .close-modal {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #999;
    }

    .modal-body {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 20px;
    }

    .order-header h4 {
      margin: 0 0 5px;
      font-size: 18px;
      color: #333;
    }

    .order-header p {
      margin: 0;
      font-size: 14px;
      color: #666;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .order-items {
      margin-bottom: 20px;
    }

    .order-items h4 {
      margin: 0 0 15px;
      font-size: 18px;
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }

    .order-item {
      display: flex;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px dashed #eee;
    }

    .order-item:last-child {
      margin-bottom: 0;
      padding-bottom: 0;
      border-bottom: none;
    }

    .item-image {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      overflow: hidden;
      margin-right: 15px;
    }

    .item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .item-details {
      flex: 1;
    }

    .item-details h5 {
      margin: 0 0 5px;
      font-size: 16px;
      color: #333;
    }

    .item-details p {
      margin: 0 0 5px;
      font-size: 14px;
      color: #666;
    }

    .item-quantity-price {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      color: #333;
      margin-top: 5px;
    }

    .order-summary {
      background-color: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
    }

    .order-summary h4 {
      margin: 0 0 15px;
      font-size: 18px;
      color: #333;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 14px;
      color: #666;
    }

    .summary-row.total {
      font-size: 18px;
      font-weight: 600;
      color: #333;
      border-top: 1px dashed #ddd;
      padding-top: 10px;
      margin-top: 10px;
    }

    .summary-row.total span:last-child {
      color: #ff5e62;
    }

    .modal-footer {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      padding: 15px 20px;
      border-top: 1px solid #eee;
    }

    /* Payment Interface Styles */
    .payment-interface-container {
      max-width: 800px;
      margin: 0 auto;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .payment-interface-header {
      display: flex;
      align-items: center;
      padding: 20px;
      border-bottom: 1px solid #eee;
      position: relative;
    }

    .payment-interface-header h2 {
      text-align: center;
      flex: 1;
      font-size: 24px;
      color: #333;
      margin: 0;
    }

    .back-to-bookings {
      background: none;
      border: none;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 16px;
      color: #666;
      cursor: pointer;
      transition: color 0.3s;
    }

    .back-to-bookings:hover {
      color: #ff5e62;
    }

    .payment-interface-content {
      padding: 30px;
    }

    .payment-amount-section {
      text-align: center;
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 1px dashed #eee;
    }

    .payment-amount-section h3 {
      font-size: 18px;
      color: #666;
      margin: 0 0 10px;
    }

    .amount-display {
      font-size: 36px;
      font-weight: 700;
      color: #ff5e62;
      margin-bottom: 5px;
    }

    .order-id {
      font-size: 14px;
      color: #666;
    }

    .payment-methods-section {
      margin-bottom: 30px;
    }

    .payment-methods-section h3 {
      font-size: 18px;
      color: #333;
      margin: 0 0 15px;
    }

    .payment-methods-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 15px;
    }

    .payment-method-card {
      border: 2px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      background-color: white;
    }

    .payment-method-card:hover {
      border-color: #ff5e62;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .payment-method-card.selected {
      border-color: #ff5e62;
      background-color: #fff5f5;
    }

    .payment-method-card input[type="radio"] {
      display: none;
    }

    .payment-method-card label {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      width: 100%;
    }

    .payment-method-card i {
      font-size: 28px;
    }

    .payment-method-card[data-method="credit-card"] i {
      color: #2196F3;
    }

    .payment-method-card[data-method="qr-code"] i {
      color: #9C27B0;
    }

    .payment-method-card[data-method="aba"] i {
      color: #E91E63;
    }

    .payment-method-card[data-method="apple-pay"] i {
      color: #000;
    }

    .payment-method-card[data-method="cash"] i {
      color: #4CAF50;
    }

    .payment-details-section {
      margin-bottom: 30px;
    }

    .payment-details {
      padding: 20px;
      border: 1px solid #eee;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .payment-details h3 {
      font-size: 18px;
      color: #333;
      margin: 0 0 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
      color: #555;
      font-weight: 500;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      transition: border-color 0.3s;
    }

    .form-group input:focus {
      border-color: #ff5e62;
      outline: none;
    }

    .form-row {
      display: flex;
      gap: 15px;
    }

    .form-row .form-group {
      flex: 1;
    }

    .qr-code-container, .aba-container, .apple-pay-container, .cash-icon {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 15px;
    }

    .qr-code-image {
      width: 200px;
      height: 200px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      padding: 10px;
      background-color: white;
      border-radius: 10px;
    }

    .qr-code-image img {
      width: 100%;
      height: 100%;
    }

    .payment-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .payment-actions button {
      padding: 12px 25px;
      font-size: 16px;
      font-weight: 500;
    }

    .process-payment {
      background-color: #ff5e62;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: 500;
    }

    .process-payment:hover {
      background-color: #ff4146;
    }

    /* Receipt Modal Styles */
    .receipt-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .receipt-modal-content {
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      width: 90%;
      max-width: 500px;
      max-height: 90vh;
      overflow-y: auto;
      padding: 30px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
    }

    /* Receipt Interface Styles */
    .receipt-interface-container {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .receipt-interface-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      max-width: 500px;
      width: 100%;
    }

    .receipt-paper {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      padding: 30px 20px;
      width: 100%;
      position: relative;
      overflow: hidden;
    }

    .receipt-paper::before,
    .receipt-paper::after {
      content: "";
      position: absolute;
      width: 100%;
      height: 20px;
      left: 0;
      background-image: radial-gradient(circle, transparent 0, transparent 10px, white 10px);
      background-size: 20px 20px;
      background-position: 0 -10px;
    }

    .receipt-paper::before {
      top: 0;
    }

    .receipt-paper::after {
      bottom: 0;
      transform: rotate(180deg);
    }

    .receipt-header {
      text-align: center;
      margin-bottom: 15px;
    }

    .receipt-header h2 {
      font-size: 20px;
      margin: 0 0 10px;
      font-weight: 700;
    }

    .receipt-info {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: #666;
    }

    .shop-info p, .shop-address p {
      margin: 3px 0;
    }

    .receipt-divider {
      margin: 10px 0;
      color: #999;
      font-size: 12px;
      text-align: center;
    }

    .receipt-items-header {
      display: flex;
      justify-content: space-between;
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 14px;
    }

    .receipt-item-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      align-items: center;
    }

    .item-description {
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1;
    }

    .item-image-small {
      width: 40px;
      height: 40px;
      border-radius: 5px;
      overflow: hidden;
    }

    .item-image-small img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .item-text {
      flex: 1;
    }

    .item-text p {
      margin: 0 0 3px;
      font-size: 14px;
    }

    .item-details {
      font-size: 12px;
      color: #666;
    }

    .item-quantity {
      font-size: 12px;
      color: #666;
      font-style: italic;
    }

    .receipt-total-section {
      margin: 10px 0;
    }

    .total-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
      font-size: 14px;
    }

    .grand-total {
      font-weight: 700;
      font-size: 16px;
    }

    .receipt-footer {
      text-align: center;
      margin-top: 15px;
    }

    .receipt-footer p {
      margin: 0 0 10px;
      font-size: 14px;
    }

    .receipt-barcode {
      margin: 10px auto;
      max-width: 180px;
    }

    .receipt-barcode p {
      font-size: 12px;
      color: #666;
      margin-top: 5px;
    }

    .receipt-actions {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 20px;
    }

    .receipt-actions button {
      padding: 10px 20px;
      font-size: 14px;
      min-width: 150px;
      font-weight: 500;
    }

    /* Order Success Notification */
    .order-success-notification,
    .payment-success-notification {
      position: fixed;
      top: 20px;
      left: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
      width: 300px;
      z-index: 1300;
      overflow: hidden;
      animation: slide-in-left 0.3s ease;
    }

    /* Left notification for order completed */
    .order-success-notification.left-notification,
    .payment-success-notification.left-notification {
      left: 20px;
      right: auto;
    }

    .notification-content {
      display: flex;
      padding: 15px;
      align-items: center;
      position: relative;
    }

    .success-icon {
      font-size: 24px;
      color: #4caf50;
      margin-right: 15px;
    }

    .notification-text {
      flex: 1;
    }

    .notification-text h4 {
      margin: 0 0 5px;
      font-size: 16px;
      color: #333;
    }

    .notification-text p {
      margin: 0;
      font-size: 14px;
      color: #666;
    }

    .close-notification {
      background: none;
      border: none;
      font-size: 20px;
      color: #999;
      cursor: pointer;
      position: absolute;
      top: 5px;
      right: 5px;
    }

    .order-success-notification.fade-out,
    .payment-success-notification.fade-out {
      animation: fade-out-left 0.5s ease forwards;
    }

    @keyframes slide-in-left {
      from {
        transform: translateX(-100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes fade-out-left {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(-100%);
        opacity: 0;
      }
    }

    @media print {
      body * {
        visibility: hidden;
      }
      .print-only, .print-only * {
        visibility: visible;
      }
      .print-only {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .payment-methods-grid {
        grid-template-columns: 1fr;
      }
      
      .form-row {
        flex-direction: column;
        gap: 15px;
      }
      
      .receipt-info {
        flex-direction: column;
        gap: 15px;
      }
      
      .receipt-actions {
        flex-direction: column;
        width: 100%;
      }
      
      .receipt-actions button {
        width: 100%;
      }
    }
  `
  document.head.appendChild(style)

  // Check if we need to create a booking from cart
  if (window.location.pathname === "/booking" && cartItems.length > 0) {
    // Set flag to create booking on page load
    sessionStorage.setItem("justCheckedOut", "true")

    // Reload page to trigger booking creation
    if (!justCheckedOut) {
      window.location.reload()
    }
  }
})