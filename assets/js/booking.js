let bookings = [
    { id: "1", name: "John Doe", date: "2024-07-15", time: "10:00", service: "Haircut", status: "pending" },
    { id: "2", name: "Jane Smith", date: "2024-07-16", time: "14:00", service: "Manicure", status: "confirmed" },
    { id: "3", name: "Peter Jones", date: "2024-07-17", time: "11:00", service: "Facial", status: "cancelled" },
    { id: "4", name: "Alice Brown", date: "2024-07-18", time: "16:00", service: "Massage", status: "pending" },
    { id: "5", name: "Bob Williams", date: "2024-07-19", time: "09:00", service: "Pedicure", status: "confirmed" },
]

// Check if localStorage is supported
if (typeof Storage !== "undefined") {
    // Retrieve bookings from localStorage if available
    const storedBookings = localStorage.getItem("bookings")
    if (storedBookings) {
        bookings = JSON.parse(storedBookings)
    }
} else {
    console.log("localStorage is not supported in this browser.")
}

// Get DOM elements
const bookingsContainer = document.getElementById("bookings")
const searchInput = document.getElementById("search")
const filterTabs = document.querySelectorAll(".filter-tab")
const modal = document.getElementById("bookingModal")

// booking.js - Handles booking functionality
document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const bookingsList = document.querySelector(".bookings-list")
            const filterTabs = document.querySelectorAll(".filter-tab")
            const searchInput = document.getElementById("bookingSearch")
            const ctaButton = document.querySelector(".cta-button")

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

                // Show success message
                showOrderSuccessMessage(booking)
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
</div>
</div>
`

      bookingsList.appendChild(bookingCard)
    })

    // Add event listeners to buttons
    const viewDetailsButtons = document.querySelectorAll(".view-details")
    const cancelButtons = document.querySelectorAll(".cancel-booking")
    const completeButtons = document.querySelectorAll(".complete-booking")

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
        completeBooking(id)
      })
    })
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
  (booking.status === "processing" && booking.paymentStatus === "pending") || !booking.paymentStatus
    ? `
    <button class="btn-success pay-now-modal" data-id="${booking.id}">
      <i class="fas fa-credit-card"></i> Pay Now
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
        completeBooking(id)
        modal.remove()
      })
    }

    // Add event listener for Pay Now button
    const payNowButton = modal.querySelector(".pay-now-modal")
    if (payNowButton) {
      payNowButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        showPaymentModal(id)
        modal.remove()
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

    const booking = bookings[bookingIndex]

    // Always show payment modal when complete button is clicked
    showPaymentModal(id)
  }

  // Show payment confirmation dialog
  function showPaymentConfirmation(id) {
    const booking = bookings.find((b) => b.id === id)
    if (!booking) return

    // Create confirmation dialog
    const confirmationDialog = document.createElement("div")
    confirmationDialog.className = "payment-confirmation-dialog"

    confirmationDialog.innerHTML = `
<div class="confirmation-content">
<h3>Payment Required</h3>
<p>This order requires payment before it can be completed.</p>
<p>Would you like to make a payment now?</p>
<div class="confirmation-actions">
  <button class="btn-secondary cancel-payment">Not Now</button>
  <button class="btn-primary proceed-payment" data-id="${booking.id}">Pay Now</button>
</div>
</div>
`

    document.body.appendChild(confirmationDialog)

    // Add event listeners
    const cancelButton = confirmationDialog.querySelector(".cancel-payment")
    cancelButton.addEventListener("click", () => {
      confirmationDialog.remove()
    })

    const proceedButton = confirmationDialog.querySelector(".proceed-payment")
    proceedButton.addEventListener("click", function () {
      const id = this.getAttribute("data-id")
      showPaymentModal(id)
      confirmationDialog.remove()
    })
  }

  // Show payment modal
  function showPaymentReceipt(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId)
    if (!booking) return

    // Create receipt modal
    const receiptModal = document.createElement("div")
    receiptModal.className = "receipt-modal"

    // Format date
    const date = new Date()
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString()

    // Generate receipt ID
    const receiptId = "RCP" + Date.now().toString().slice(-6)

    receiptModal.innerHTML = `
      <div class="receipt-modal-content">
          <div class="receipt-modal-header">
              <h3>Payment Receipt</h3>
              <button class="close-receipt-modal">&times;</button>
          </div>
          <div class="receipt-modal-body" id="receipt-content">
              <div class="receipt-header">
                  <div class="receipt-logo">
                      <i class="fas fa-receipt"></i>
                  </div>
                  <h4>Payment Successful</h4>
                  <p class="receipt-date">${formattedDate}</p>
                  <p class="receipt-number">Receipt #${receiptId}</p>
              </div>
              
              <div class="receipt-details">
                  <div class="receipt-row">
                      <span>Order ID:</span>
                      <span>#${booking.id}</span>
                  </div>
                  <div class="receipt-row">
                      <span>Payment Method:</span>
                      <span>${
                        booking.paymentMethod === "credit-card"
                          ? "Credit/Debit Card"
                          : booking.paymentMethod === "qr-code"
                            ? "QR Code Payment"
                            : booking.paymentMethod === "apple-pay"
                              ? "Apple Pay"
                              : "Cash on Delivery"
                      }</span>
                  </div>
                  <div class="receipt-row">
                      <span>Payment Status:</span>
                      <span class="status-completed">Completed</span>
                  </div>
                  <div class="receipt-row">
                      <span>Payment Date:</span>
                      <span>${formattedDate}</span>
                  </div>
              </div>
              
              <div class="receipt-items">
                  <h5>Order Summary</h5>
                  ${booking.items
                    .map(
                      (item) => `
                      <div class="receipt-item">
                          <div class="receipt-item-details">
                              <div class="item-image-small">
                                  <img src="${item.image}" alt="${item.name}">
                              </div>
                              <div class="item-info">
                                  <h6>${item.name}</h6>
                                  <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                                  ${
                                    item.toppings && item.toppings.length > 0
                                      ? `<p>Toppings: ${item.toppings.map((t) => t.name).join(", ")}</p>`
                                      : ""
                                  }
                              </div>
                          </div>
                          <div class="item-price-qty">
                              <span>x${item.quantity}</span>
                              <span>$${item.totalPrice.toFixed(2)}</span>
                          </div>
                      </div>
                  `,
                    )
                    .join("")}
              </div>
              
              <div class="receipt-total">
                  <div class="receipt-row">
                      <span>Subtotal:</span>
                      <span>$${booking.subtotal.toFixed(2)}</span>
                  </div>
                  <div class="receipt-row">
                      <span>Tax (8%):</span>
                      <span>$${booking.tax.toFixed(2)}</span>
                  </div>
                  <div class="receipt-row total">
                      <span>Total Paid:</span>
                      <span>$${booking.total.toFixed(2)}</span>
                  </div>
              </div>
              
              <div class="receipt-thank-you">
                  <p>Thank you for your order!</p>
                  <div class="receipt-barcode">
                      <img src="/placeholder.svg?height=50&width=200" alt="Barcode">
                      <p>${receiptId}</p>
                  </div>
              </div>
          </div>
          <div class="receipt-modal-footer">
              <div class="receipt-actions">
                  <button class="btn-secondary download-receipt">
                      <i class="fas fa-download"></i> Download PDF
                  </button>
                  <button class="btn-secondary print-receipt">
                      <i class="fas fa-print"></i> Print Receipt
                  </button>
                  <button class="btn-primary close-receipt">Done</button>
              </div>
          </div>
      </div>
  `

    document.body.appendChild(receiptModal)

    // Add event listeners
    receiptModal.querySelector(".close-receipt-modal").addEventListener("click", () => {
      receiptModal.remove()
    })

    receiptModal.querySelector(".close-receipt").addEventListener("click", () => {
      receiptModal.remove()
    })

    receiptModal.querySelector(".print-receipt").addEventListener("click", () => {
      // Print the receipt
      const receiptContent = document.getElementById("receipt-content")
      const originalContents = document.body.innerHTML

      document.body.innerHTML = `
      <div class="print-only">
        <div class="print-header">
          <h2>Order Receipt</h2>
        </div>
        ${receiptContent.innerHTML}
      </div>
    `

      window.print()
      document.body.innerHTML = originalContents

      // Recreate the receipt modal after printing
      showPaymentReceipt(bookingId)
    })

    receiptModal.querySelector(".download-receipt").addEventListener("click", () => {
      // Create a virtual link to download the receipt as HTML
      const receiptContent = document.getElementById("receipt-content")
      const receiptHTML = `
      <!DOCTYPE html>
      <html>
      <head>
        <title>Receipt #${receiptId}</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
          }
          .receipt-header {
            text-align: center;
            margin-bottom: 20px;
          }
          .receipt-details, .receipt-items, .receipt-total {
            margin-bottom: 20px;
          }
          .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
          }
          .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #eee;
          }
          .receipt-total {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
          }
          .receipt-thank-you {
            text-align: center;
            margin: 20px 0;
          }
          .status-completed {
            color: #4caf50;
            font-weight: bold;
          }
          .total {
            font-weight: bold;
            font-size: 18px;
          }
        </style>
      </head>
      <body>
        <div class="print-header">
          <h2>Order Receipt</h2>
        </div>
        ${receiptContent.innerHTML}
      </body>
      </html>
    `

      const blob = new Blob([receiptHTML], { type: "text/html" })
      const url = URL.createObjectURL(blob)

      const downloadLink = document.createElement("a")
      downloadLink.href = url
      downloadLink.download = `Receipt-${booking.id}.html`
      document.body.appendChild(downloadLink)
      downloadLink.click()
      document.body.removeChild(downloadLink)
    })
  }

  // Show payment modal
  function showPaymentModal(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId)
    if (!booking) return

    // Create payment modal
    const paymentModal = document.createElement("div")
    paymentModal.className = "payment-modal"

    paymentModal.innerHTML = `
<div class="payment-modal-content">
<div class="payment-modal-header">
    <h3>Payment for Order #${booking.id}</h3>
    <button class="close-payment-modal">&times;</button>
</div>
<div class="payment-modal-body">
    <div class="payment-amount">
        <h4>Amount to Pay:</h4>
        <div class="amount">$${booking.total.toFixed(2)}</div>
    </div>
    
    <div class="payment-methods">
        <h4>Select Payment Method:</h4>
        <div class="method-options">
            <div class="method-option" data-method="credit-card">
                <input type="radio" id="credit-card" name="payment-method" checked>
                <label for="credit-card">
                    <i class="fas fa-credit-card"></i> Credit/Debit Card
                </label>
            </div>
            <div class="method-option" data-method="qr-code">
                <input type="radio" id="qr-code" name="payment-method">
                <label for="qr-code">
                    <i class="fas fa-qrcode"></i> QR Code Payment
                </label>
            </div>
            <div class="method-option" data-method="apple-pay">
                <input type="radio" id="apple-pay" name="payment-method">
                <label for="apple-pay">
                    <i class="fab fa-apple-pay"></i> Apple Pay
                </label>
            </div>
            <div class="method-option" data-method="cash">
                <input type="radio" id="cash" name="payment-method">
                <label for="cash">
                    <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                </label>
            </div>
        </div>
    </div>
    
    <div class="payment-details credit-card-details">
        <h4>Card Details</h4>
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
<div class="payment-modal-footer">
    <button class="btn-secondary cancel-payment">Cancel</button>
    <button class="process-payment" data-id="${booking.id}">
        <i class="fas fa-lock"></i> Pay Now
    </button>
</div>
</div>
`

    document.body.appendChild(paymentModal)

    // Add event listeners for payment method selection
    const methodOptions = paymentModal.querySelectorAll(".method-option")
    methodOptions.forEach((option) => {
      option.addEventListener("click", function () {
        // Update radio button
        const radio = this.querySelector("input[type='radio']")
        radio.checked = true

        // Add selected class to the clicked option and remove from others
        methodOptions.forEach((opt) => opt.classList.remove("selected"))
        this.classList.add("selected")

        // Update border color for selected option
        this.style.borderColor = "#ff5e62"
        this.style.borderWidth = "2px"

        // Hide all payment details
        paymentModal.querySelectorAll(".payment-details").forEach((detail) => {
          detail.style.display = "none"
        })

        // Show selected payment details
        const method = this.getAttribute("data-method")
        paymentModal.querySelector(`.${method}-details`).style.display = "block"
      })
    })

    // Select the first option by default
    methodOptions[0].classList.add("selected")
    methodOptions[0].style.borderColor = "#ff5e62"
    methodOptions[0].style.borderWidth = "2px"

    // Close button
    paymentModal.querySelector(".close-payment-modal").addEventListener("click", () => {
      paymentModal.remove()
    })

    // Cancel button
    paymentModal.querySelector(".cancel-payment").addEventListener("click", () => {
      paymentModal.remove()
    })

    // Process payment button
    paymentModal.querySelector(".process-payment").addEventListener("click", function () {
      const id = this.getAttribute("data-id")
      const selectedMethod = paymentModal.querySelector("input[name='payment-method']:checked").id

      // Process payment based on method
      processPayment(id, selectedMethod)
      paymentModal.remove()
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

    // Show payment receipt
    showPaymentReceipt(bookingId)

    // Re-render bookings
    const activeTab = document.querySelector(".filter-tab.active")
    const status = activeTab ? activeTab.getAttribute("data-status") : "all"
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : ""
    renderBookings(status, searchTerm)
  }

  // Show order success message
  function showOrderSuccessMessage(booking) {
    // Create success message
    const successMessage = document.createElement("div")
    successMessage.className = "order-success-message"

    successMessage.innerHTML = `
<div class="success-content">
<div class="success-icon">
<i class="fas fa-check-circle"></i>
</div>
<h3>Order Placed Successfully!</h3>
<p>Your order #${booking.id} has been placed and is being processed.</p>
<div class="order-summary">
<div class="summary-row">
  <span>Items:</span>
  <span>${booking.items.length}</span>
</div>
<div class="summary-row">
  <span>Total:</span>
  <span>$${booking.total.toFixed(2)}</span>
</div>
</div>
<div class="success-actions">
<button class="btn-primary view-order-details" data-id="${booking.id}">View Order Details</button>
${
  booking.paymentStatus === "pending" || !booking.paymentStatus
    ? `<button class="btn-success pay-now-btn" data-id="${booking.id}">Pay Now</button>`
    : ""
}
</div>
</div>
`

    document.body.appendChild(successMessage)

    // Add event listener to view details button
    const viewDetailsButton = successMessage.querySelector(".view-order-details")
    viewDetailsButton.addEventListener("click", function () {
      const id = this.getAttribute("data-id")
      successMessage.remove()
      showBookingDetails(id)
    })

    // Add event listener to pay now button if it exists
    const payNowButton = successMessage.querySelector(".pay-now-btn")
    if (payNowButton) {
      payNowButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id")
        successMessage.remove()
        showPaymentModal(id)
      })
    }

    // Auto remove after 5 seconds
    setTimeout(() => {
      successMessage.classList.add("fade-out")
      setTimeout(() => {
        successMessage.remove()
      }, 500)
    }, 5000)
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

/* Payment Modal */
.payment-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1100;
}

.payment-modal-content {
  width: 95%;
  max-width: 700px;
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
}

.payment-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 25px;
  border-bottom: 1px solid #eee;
  background-color: white;
}

.payment-modal-header h3 {
  margin: 0;
  font-size: 22px;
  color: #333;
  font-weight: 600;
}

.close-payment-modal {
  background: none;
  border: none;
  font-size: 28px;
  cursor: pointer;
  color: #999;
  transition: color 0.2s;
}

.close-payment-modal:hover {
  color: #333;
}

.payment-modal-body {
  padding: 25px;
  max-height: 65vh;
  overflow-y: auto;
  background-color: white;
}

.payment-amount {
  text-align: center;
  margin-bottom: 30px;
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 10px;
}

.payment-amount h4 {
  margin: 0 0 10px;
  font-size: 18px;
  color: #666;
}

.payment-amount .amount {
  font-size: 32px;
  font-weight: 700;
  color: #ff5e62;
}

.payment-methods {
  margin-bottom: 30px;
}

.payment-methods h4 {
  margin: 0 0 15px;
  font-size: 18px;
  color: #333;
}

.method-options {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
}

.method-option {
  display: flex;
  align-items: center;
  padding: 15px;
  border: 2px solid #ddd;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
  background-color: white;
}

.method-option:hover {
  border-color: #ff5e62;
  background-color: #fff5f5;
  transform: translateY(-2px);
}

.method-option input[type="radio"] {
  margin-right: 12px;
  width: 18px;
  height: 18px;
}

.method-option label {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 500;
  width: 100%;
}

.method-option i {
  font-size: 24px;
}

.method-option[data-method="credit-card"] i {
  color: #2196F3;
}

.method-option[data-method="qr-code"] i {
  color: #9C27B0;
}

.method-option[data-method="apple-pay"] i {
  color: #000;
  font-size: 28px;
}

.method-option[data-method="cash"] i {
  color: #4CAF50;
}

.payment-details {
  margin-top: 25px;
  padding: 20px;
  border: 1px solid #eee;
  border-radius: 10px;
  background-color: white;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.payment-details h4 {
  margin: 0 0 20px;
  font-size: 18px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-size: 15px;
  color: #555;
  font-weight: 500;
}

.form-group input {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
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

.qr-code-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}

.qr-code-image {
  width: 220px;
  height: 220px;
  margin-bottom: 25px;
  border: 1px solid #ddd;
  padding: 15px;
  background-color: white;
  border-radius: 10px;
}

.qr-code-image img {
  width: 100%;
  height: 100%;
}

.qr-code-timer {
  margin-top: 15px;
  font-size: 15px;
  color: #ff5e62;
  font-weight: 500;
}

.apple-pay-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}

.apple-pay-logo {
  font-size: 60px;
  margin-bottom: 20px;
}

.apple-pay-button {
  background-color: #000;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 12px 24px;
  font-size: 18px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  margin-bottom: 15px;
}

.apple-pay-button i {
  font-size: 22px;
}

.cash-icon {
  text-align: center;
  margin-bottom: 20px;
}

.cash-icon i {
  font-size: 60px;
  color: #4CAF50;
}

.cash-instructions {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  margin-top: 15px;
}

.payment-modal-footer {
  display: flex;
  justify-content: space-between;
  padding: 20px 25px;
  border-top: 1px solid #eee;
  background-color: white;
}

.payment-modal-footer button {
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
  z-index: 1200;
}

.receipt-modal-content {
  width: 95%;
  max-width: 600px;
  max-height: 90vh;
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  overflow: hidden;
}

.receipt-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 25px;
  border-bottom: 1px solid #eee;
  background-color: white;
}

.receipt-modal-header h3 {
  margin: 0;
  font-size: 22px;
  color: #333;
  font-weight: 600;
}

.close-receipt-modal {
  background: none;
  border: none;
  font-size: 28px;
  cursor: pointer;
  color: #999;
  transition: color 0.2s;
}

.close-receipt-modal:hover {
  color: #333;
}

.receipt-modal-body {
  padding: 25px;
  max-height: 60vh;
  overflow-y: auto;
  background-color: white;
}

.receipt-header {
  text-align: center;
  margin-bottom: 25px;
  padding-bottom: 20px;
  border-bottom: 1px dashed #ddd;
}

.receipt-logo {
  font-size: 50px;
  color: #4caf50;
  margin-bottom: 15px;
}

.receipt-header h4 {
  margin: 0 0 10px;
  font-size: 24px;
  color: #333;
}

.receipt-date, .receipt-number {
  font-size: 14px;
  color: #666;
  margin: 5px 0;
}

.receipt-details {
  margin-bottom: 25px;
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 10px;
}

.receipt-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
  font-size: 14px;
}

.status-completed {
  color: #4caf50;
  font-weight: 600;
}

.receipt-items {
  margin-bottom: 25px;
}

.receipt-items h5 {
  margin: 0 0 15px;
  font-size: 18px;
  color: #333;
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
}

.receipt-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  padding-bottom: 15px;
  border-bottom: 1px dashed #eee;
}

.receipt-item:last-child {
  margin-bottom: 0;
  padding-bottom: 0;
  border-bottom: none;
}

.receipt-item-details {
  display: flex;
  width: 70%;
}

.item-image-small {
  width: 50px;
  height: 50px;
  border-radius: 6px;
  overflow: hidden;
  margin-right: 12px;
}

.item-image-small img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.item-info {
  flex: 1;
}

.item-info h6 {
  margin: 0 0 5px;
  font-size: 16px;
  color: #333;
}

.item-info p {
  margin: 0 0 3px;
  font-size: 13px;
  color: #666;
}

.item-price-qty {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: center;
  gap: 5px;
}

.item-price-qty span:last-child {
  font-weight: 600;
  color: #ff5e62;
}

.receipt-total {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 20px;
}

.receipt-row.total {
  font-size: 18px;
  font-weight: 600;
  color: #333;
  border-top: 1px dashed #ddd;
  padding-top: 10px;
  margin-top: 10px;
}

.receipt-row.total span:last-child {
  color: #ff5e62;
}

.receipt-thank-you {
  text-align: center;
  margin: 25px 0;
  font-size: 16px;
  color: #333;
}

.receipt-barcode {
  margin-top: 15px;
  text-align: center;
}

.receipt-barcode img {
  margin-bottom: 5px;
}

.receipt-barcode p {
  font-size: 12px;
  color: #666;
  margin: 0;
}

.receipt-modal-footer {
  display: flex;
  justify-content: center;
  padding: 20px 25px;
  border-top: 1px solid #eee;
  background-color: white;
}

.receipt-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  justify-content: center;
}

.receipt-actions button {
  padding: 10px 20px;
}

.print-only {
  padding: 30px;
  max-width: 800px;
  margin: 0 auto;
  font-family: Arial, sans-serif;
}

.print-header {
  text-align: center;
  margin-bottom: 30px;
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
  .method-options {
    grid-template-columns: 1fr;
  }
  
  .receipt-actions {
    flex-direction: column;
  }
  
  .receipt-item-details {
    width: 60%;
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