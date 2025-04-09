// booking.js - Modified version with payment and receipt functions removed
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
// Complete the booking directly instead of showing payment interface
completeBooking(id)
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

// Also update payment status
bookings[bookingIndex].paymentStatus = "completed"

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

// Show celebration animation
showCelebrationAnimation()

// Re-render bookings
const activeTab = document.querySelector(".filter-tab.active")
const status = activeTab ? activeTab.getAttribute("data-status") : "all"
const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : ""
renderBookings(status, searchTerm)
}

// Show celebration animation
function showCelebrationAnimation() {
// Create celebration container
const celebrationContainer = document.createElement("div")
celebrationContainer.className = "celebration-animation"
document.body.appendChild(celebrationContainer)

// Create confetti pieces
const colors = ["#ff5e62", "#4caf50", "#2196F3", "#ff9800", "#9C27B0"]
for (let i = 0; i < 100; i++) {
const confetti = document.createElement("div")
confetti.className = "confetti"
confetti.style.left = Math.random() * 100 + "vw"
confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)]
confetti.style.width = Math.random() * 10 + 5 + "px"
confetti.style.height = Math.random() * 10 + 10 + "px"
confetti.style.animationDuration = Math.random() * 3 + 2 + "s"
celebrationContainer.appendChild(confetti)
}

// Remove celebration after animation completes
setTimeout(() => {
celebrationContainer.classList.add("fade-out")
setTimeout(() => {
celebrationContainer.remove()
}, 1000)
}, 3000)
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

/* Order Success Notification */
.order-success-notification,
.thank-you-notification {
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
.thank-you-notification.left-notification {
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
.thank-you-notification.fade-out {
animation: fade-out-left 0.5s ease forwards;
}

/* Celebration Animation */
.celebration-animation {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
pointer-events: none;
z-index: 2000;
overflow: hidden;
}

.confetti {
position: absolute;
top: -10px;
width: 10px;
height: 20px;
animation: fall 3s linear forwards;
}

@keyframes fall {
0% {
transform: translateY(0) rotate(0deg);
opacity: 1;
}
100% {
transform: translateY(100vh) rotate(720deg);
opacity: 0;
}
}

.celebration-animation.fade-out {
animation: fade-out 1s forwards;
}

@keyframes fade-out {
from {
opacity: 1;
}
to {
opacity: 0;
}
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

@media (max-width: 768px) {
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

@media (max-width: 480px) {
.receipt-paper {
padding: 20px 15px;
}

.item-details {
font-size: 11px;
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