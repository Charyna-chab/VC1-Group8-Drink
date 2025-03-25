<<<<<<< HEAD
// booking.js - Handles booking functionality
document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const bookingsList = document.querySelector(".bookings-list")
            const filterTabs = document.querySelectorAll(".filter-tab")
            const searchInput = document.getElementById("bookingSearch")
            const ctaButton = document.querySelector(".cta-button")
=======
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const filterTabs = document.querySelectorAll(".filter-tab")
    const bookingCards = document.querySelectorAll(".booking-card")
    const searchInput = document.getElementById("bookingSearch")
    const cancelButtons = document.querySelectorAll(".cancel-booking-btn")
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4

            // Get cart items from localStorage
            const cartItems = JSON.parse(localStorage.getItem("cart")) || []

<<<<<<< HEAD
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
                  <button class="btn-primary edit-booking" data-id="${booking.id}">
                    <i class="fas fa-edit"></i> Edit Order
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
      const editButtons = document.querySelectorAll(".edit-booking")
  
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
  
      editButtons.forEach((button) => {
        button.addEventListener("click", function () {
          const id = this.getAttribute("data-id")
          editBooking(id)
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
                <div class="order-status ${statusClass}">
                  ${booking.status}
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
                <button class="btn-primary edit-booking-modal" data-id="${booking.id}">Edit Order</button>
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
  
      const editButton = modal.querySelector(".edit-booking-modal")
      if (editButton) {
        editButton.addEventListener("click", function () {
          const id = this.getAttribute("data-id")
          editBooking(id)
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
  
    // Edit booking
    function editBooking(id) {
      const booking = bookings.find((b) => b.id === id)
      if (!booking) return
  
      // Add items back to cart
      localStorage.setItem("cart", JSON.stringify(booking.items))
  
      // Remove the booking
      const updatedBookings = bookings.filter((b) => b.id !== id)
      localStorage.setItem("bookings", JSON.stringify(updatedBookings))
  
      // Add notification
      if (window.addNotification) {
        window.addNotification(
          "Order Editing",
          `Your order #${booking.id} has been moved back to your cart for editing.`,
          "cart",
        )
      }
  
      // Redirect to order page
      window.location.href = "/order"
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
          <button class="btn-primary view-order-details" data-id="${booking.id}">View Order Details</button>
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
  
      // Auto remove after 5 seconds
      setTimeout(() => {
        successMessage.classList.add("fade-out")
=======
    // Filter bookings by status
    filterTabs.forEach((tab) => {
        tab.addEventListener("click", function() {
            // Remove active class from all tabs
            filterTabs.forEach((t) => t.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            const status = this.getAttribute("data-status")

            // Filter bookings
            bookingCards.forEach((card) => {
                if (status === "all" || card.getAttribute("data-status") === status) {
                    card.style.display = "block"
                } else {
                    card.style.display = "none"
                }
            })

            // Check if any bookings are visible
            checkEmptyState()
        })
    })

    // Search functionality
    searchInput.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase().trim()

        bookingCards.forEach((card) => {
            const orderNumber = card.querySelector("h3").textContent.toLowerCase()

            if (orderNumber.includes(searchTerm)) {
                card.style.display = "block"
            } else {
                card.style.display = "none"
            }
        })

        // Check if any bookings are visible
        checkEmptyState()
    })

    // Check if any bookings are visible and show empty state if needed
    function checkEmptyState() {
        let visibleCount = 0

        bookingCards.forEach((card) => {
            if (card.style.display !== "none") {
                visibleCount++
            }
        })

        // Get or create empty state element
        let emptyState = document.querySelector(".empty-state")

        if (visibleCount === 0) {
            if (!emptyState) {
                emptyState = document.createElement("div")
                emptyState.className = "empty-state"
                emptyState.innerHTML = `
                      <img src="/assets/images/empty-orders.svg" alt="No Orders">
                      <h3>No Orders Found</h3>
                      <p>No orders match your current filter. Try changing your search or filter criteria.</p>
                      <a href="/order" class="btn-primary">Order Now</a>
                  `
                document.querySelector(".bookings-list").appendChild(emptyState)
            } else {
                emptyState.style.display = "block"
            }
        } else if (emptyState) {
            emptyState.style.display = "none"
        }
    }

    // Cancel booking
    cancelButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const bookingId = this.getAttribute("data-id")
            const bookingCard = this.closest(".booking-card")

            // Show confirmation dialog
            if (confirm("Are you sure you want to cancel this order?")) {
                // In a real application, you would send an AJAX request to cancel the order
                // For demo purposes, we'll just update the UI

                // Update status
                const statusElement = bookingCard.querySelector(".booking-status")
                statusElement.textContent = "Cancelled"
                statusElement.className = "booking-status cancelled"

                // Remove cancel button
                this.remove()

                // Update data-status attribute
                bookingCard.setAttribute("data-status", "cancelled")

                // Show toast notification
                showToast("Order Cancelled", "Your order has been cancelled successfully.", "success")
            }
        })
    })

    // Show toast notification
    function showToast(title, message, type = "info") {
        const toast = document.createElement("div")
        toast.className = "toast"

        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
            toast.style.borderLeftColor = "#4caf50"
        } else if (type === "error") {
            icon = "exclamation-circle"
            toast.style.borderLeftColor = "#f44336"
        }

        toast.innerHTML = `
              <div>
                  <i class="fas fa-${icon}" style="color: ${type === "success" ? "#4caf50" : type === "error" ? "#f44336" : "#ff5e62"}; font-size: 20px; margin-right: 10px;"></i>
              </div>
              <div style="flex: 1;">
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
            toast.remove()
        })

        // Auto remove after 5 seconds
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4
        setTimeout(() => {
          successMessage.remove()
        }, 500)
      }, 5000)
    }
<<<<<<< HEAD
  
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
      
      /* Order Success Message */
      .order-success-message {
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          width: 90%;
          max-width: 400px;
          background-color: white;
          border-radius: 10px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
          z-index: 1000;
          overflow: hidden;
          animation: fadeIn 0.5s ease;
          transition: opacity 0.5s ease;
      }
      
      .order-success-message.fade-out {
          opacity: 0;
      }
      
      .success-content {
          padding: 30px 20px;
          text-align: center;
      }
      
      .success-icon {
          font-size: 60px;
          color: #4caf50;
          margin-bottom: 20px;
      }
      
      .success-content h3 {
          margin: 0 0 10px;
          font-size: 22px;
          color: #333;
      }
      
      .success-content p {
          margin: 0 0 20px;
          font-size: 16px;
          color: #666;
      }
      
      .success-content .order-summary {
          width: 80%;
          margin: 0 auto 20px;
      }
      
      @keyframes fadeIn {
          from { opacity: 0; transform: translate(-50%, -60%); }
          to { opacity: 1; transform: translate(-50%, -50%); }
      }
      
      /* Responsive Styles */
      @media (max-width: 768px) {
          .booking-footer {
              flex-direction: column;
              align-items: flex-start;
              gap: 15px;
          }
          
          .booking-actions {
              width: 100%;
              justify-content: space-between;
          }
          
          .order-header {
              flex-direction: column;
          }
          
          .order-status {
              margin-top: 10px;
              align-self: flex-start;
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
=======

    // Initialize - check if any bookings exist
    if (bookingCards.length === 0) {
        const emptyState = document.createElement("div")
        emptyState.className = "empty-state"
        emptyState.innerHTML = `
              <img src="/assets/images/empty-orders.svg" alt="No Orders">
              <h3>No Orders Yet</h3>
              <p>You haven't placed any orders yet. Start ordering your favorite drinks!</p>
              <a href="/order" class="btn-primary">Order Now</a>
          `
        document.querySelector(".bookings-list").appendChild(emptyState)
    }
})
>>>>>>> e1afa46761f16fc7671bbd4993a2db1bab8276b4
