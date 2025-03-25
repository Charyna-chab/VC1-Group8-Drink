// booking.js - Fixed with proper View Details and enhanced payment interface
document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const bookingsList = document.querySelector(".bookings-list");
  const filterTabs = document.querySelectorAll(".filter-tab");
  const searchInput = document.getElementById("bookingSearch");
  const ctaButton = document.querySelector(".cta-button");

  // Get bookings from localStorage
  const bookings = JSON.parse(localStorage.getItem("bookings")) || [];

  // Check if we just came from checkout
  const justCheckedOut = sessionStorage.getItem("justCheckedOut");
  if (justCheckedOut) {
    // Clear the flag
    sessionStorage.removeItem("justCheckedOut");
    
    // Show success notification
    showToast("Order Placed", "Your order has been placed successfully!", "success");
    
    // Add notification
    if (window.addNotification) {
      window.addNotification(
        "Order Placed",
        "Your order has been placed successfully. You can track it in your orders.",
        "success"
      );
    }
  }

  // Initialize bookings
  renderBookings();

  // Filter bookings by status
  filterTabs.forEach((tab) => {
    tab.addEventListener("click", function() {
      // Remove active class from all tabs
      filterTabs.forEach((t) => t.classList.remove("active"));

      // Add active class to clicked tab
      this.classList.add("active");

      // Filter bookings
      const status = this.getAttribute("data-status");
      renderBookings(status);
    });
  });

  // Search bookings
  if (searchInput) {
    searchInput.addEventListener("input", function() {
      const searchTerm = this.value.toLowerCase().trim();
      const activeStatus = document.querySelector(".filter-tab.active").getAttribute("data-status");

      renderBookings(activeStatus, searchTerm);
    });
  }

  // CTA button click
  if (ctaButton) {
    ctaButton.addEventListener("click", () => {
      window.location.href = "/order";
    });
  }

  // Render bookings
  function renderBookings(status = "all", searchTerm = "") {
    if (!bookingsList) return;

    // Filter bookings by status
    let filteredBookings = bookings;
    if (status !== "all") {
      filteredBookings = bookings.filter((booking) => booking.status === status);
    }
    // Fix: When in "all" tab, don't show cancelled orders
    else {
      filteredBookings = bookings.filter((booking) => booking.status !== "cancelled");
    }

    // Filter by search term
    if (searchTerm) {
      filteredBookings = filteredBookings.filter((booking) => 
        booking.id.toLowerCase().includes(searchTerm) || 
        booking.items.some(item => item.name.toLowerCase().includes(searchTerm))
      );
    }

    // Clear bookings list
    bookingsList.innerHTML = "";

    // Show empty state if no bookings
    if (filteredBookings.length === 0) {
      bookingsList.innerHTML = `
        <div class="empty-state">
          <img src="/assets/image/empty-orders.svg" alt="No Orders">
          <h3>No Orders Found</h3>
          <p>${status === "all" ? "You haven't placed any orders yet." : `You don't have any ${status} orders.`}</p>
          <a href="/order" class="btn-primary">Order Now</a>
        </div>
      `;
      return;
    }

    // Render each booking
    filteredBookings.forEach((booking) => {
      const bookingCard = document.createElement("div");
      bookingCard.className = "booking-card";
      bookingCard.setAttribute("data-id", booking.id);
      bookingCard.setAttribute("data-status", booking.status);

      // Format date
      const date = new Date(booking.date);
      const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();

      // Get status class
      let statusClass = "";
      let statusIcon = "";
      switch (booking.status) {
        case "processing":
          statusClass = "processing";
          statusIcon = "clock";
          break;
        case "completed":
          statusClass = "completed";
          statusIcon = "check-circle";
          break;
        case "cancelled":
          statusClass = "cancelled";
          statusIcon = "times-circle";
          break;
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
            <i class="fas fa-${statusIcon}"></i>
            ${booking.status}
          </div>
        </div>
        <div class="booking-items">
          ${booking.items
            .map(
              (item) => `
              <div class="booking-item">
                <div class="item-image">
                  <img src="${item.image || '/assets/images/default-product.png'}" alt="${item.name}">
                </div>
                <div class="item-details">
                  <h4>${item.name}</h4>
                  <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                  <p>Quantity: ${item.quantity}</p>
                </div>
                <div class="item-price">$${item.totalPrice.toFixed(2)}</div>
              </div>
            `
            )
            .join("")}
        </div>
        <div class="booking-footer">
          <div class="booking-total">
            Total: <span class="total-price">$${booking.total.toFixed(2)}</span>
          </div>
          <div class="booking-actions">
            <button class="btn-secondary view-details" data-id="${booking.id}">
              <i class="fas fa-eye"></i> View Details
            </button>
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
              : booking.status === "cancelled"
              ? `
                <button class="btn-outline-danger delete-booking" data-id="${booking.id}">
                  <i class="fas fa-trash"></i> Delete
                </button>
              `
              : ""
            }
          </div>
        </div>
      `;

      bookingsList.appendChild(bookingCard);
    });

    // Add event listeners to buttons
    const viewDetailsButtons = document.querySelectorAll(".view-details");
    const cancelButtons = document.querySelectorAll(".cancel-booking");
    const completeButtons = document.querySelectorAll(".complete-booking");
    const deleteButtons = document.querySelectorAll(".delete-booking");

    viewDetailsButtons.forEach((button) => {
      button.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        showBookingDetails(id);
      });
    });

    cancelButtons.forEach((button) => {
      button.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        cancelBooking(id);
      });
    });

    completeButtons.forEach((button) => {
      button.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        completeBooking(id);
      });
    });
    
    deleteButtons.forEach((button) => {
      button.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        deleteBooking(id);
      });
    });
  }

  // Show booking details - FIXED FUNCTION
  function showBookingDetails(id) {
    const booking = bookings.find((b) => b.id === id);
    if (!booking) {
      showToast("Error", "Order not found", "error");
      return;
    }

    // Create overlay
    const overlay = document.createElement("div");
    overlay.className = "modal-overlay";
    document.body.appendChild(overlay);

    // Create modal
    const modal = document.createElement("div");
    modal.className = "booking-details-modal";

    // Format date
    const date = new Date(booking.date);
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();

    // Get status class
    let statusClass = "";
    let statusIcon = "";
    switch (booking.status) {
      case "processing":
        statusClass = "processing";
        statusIcon = "clock";
        break;
      case "completed":
        statusClass = "completed";
        statusIcon = "check-circle";
        break;
      case "cancelled":
        statusClass = "cancelled";
        statusIcon = "times-circle";
        break;
    }

    // Get payment method if available
    let paymentMethodHtml = "";
    if (booking.paymentMethod) {
      let paymentIcon = "";
      let paymentText = "";
      
      switch (booking.paymentMethod) {
        case "card":
          paymentIcon = "credit-card";
          paymentText = "Credit/Debit Card";
          break;
        case "qr":
          paymentIcon = "qrcode";
          paymentText = "QR Code Payment";
          break;
        case "cash":
          paymentIcon = "money-bill-wave";
          paymentText = "Cash on Delivery";
          break;
      }
      
      paymentMethodHtml = `
        <div class="payment-method">
          <h4>Payment Method</h4>
          <div class="payment-method-info">
            <i class="fas fa-${paymentIcon}"></i>
            <span>${paymentText}</span>
          </div>
        </div>
      `;
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
              <div class="order-id-date">
                <h4>Order #${booking.id}</h4>
                <p><i class="fas fa-calendar-alt"></i> ${formattedDate}</p>
              </div>
              <div class="order-status ${statusClass}">
                <i class="fas fa-${statusIcon}"></i>
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
                      <img src="${item.image || '/assets/images/default-product.png'}" alt="${item.name}">
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
            
            ${paymentMethodHtml}
            
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
              <button class="btn-outline-danger cancel-booking-modal" data-id="${booking.id}">
                <i class="fas fa-times"></i> Cancel Order
              </button>
              <button class="btn-primary complete-booking-modal" data-id="${booking.id}">
                <i class="fas fa-check"></i> Complete Order
              </button>
            `
            : booking.status === "cancelled"
            ? `
              <button class="btn-outline-danger delete-booking-modal" data-id="${booking.id}">
                <i class="fas fa-trash"></i> Delete Order
              </button>
            `
            : ""
          }
        </div>
      </div>
    `;

    document.body.appendChild(modal);

    // Add event listeners
    const closeButtons = modal.querySelectorAll(".close-modal, .close-details");
    closeButtons.forEach((button) => {
      button.addEventListener("click", () => {
        modal.remove();
        overlay.remove();
      });
    });

    const cancelButton = modal.querySelector(".cancel-booking-modal");
    if (cancelButton) {
      cancelButton.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        cancelBooking(id);
        modal.remove();
        overlay.remove();
      });
    }

    const completeButton = modal.querySelector(".complete-booking-modal");
    if (completeButton) {
      completeButton.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        completeBooking(id);
        modal.remove();
        overlay.remove();
      });
    }
    
    const deleteButton = modal.querySelector(".delete-booking-modal");
    if (deleteButton) {
      deleteButton.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        deleteBooking(id);
        modal.remove();
        overlay.remove();
      });
    }

    // Close when clicking outside
    overlay.addEventListener("click", () => {
      modal.remove();
      overlay.remove();
    });
  }

  // Cancel booking
  function cancelBooking(id) {
    const bookingIndex = bookings.findIndex((b) => b.id === id);
    if (bookingIndex === -1) return;

    // Update booking status
    bookings[bookingIndex].status = "cancelled";

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings));

    // Add notification
    if (window.addNotification) {
      window.addNotification("Order Cancelled", `Your order #${bookings[bookingIndex].id} has been cancelled.`, "order");
    }

    // Find and remove the booking card from the DOM if in "all" tab
    const activeTab = document.querySelector(".filter-tab.active");
    if (activeTab && activeTab.getAttribute("data-status") === "all") {
      const bookingCard = document.querySelector(`.booking-card[data-id="${id}"]`);
      if (bookingCard) {
        // Add fade-out animation
        bookingCard.style.transition = "opacity 0.3s ease, transform 0.3s ease";
        bookingCard.style.opacity = "0";
        bookingCard.style.transform = "translateX(20px)";

        // Remove after animation completes
        setTimeout(() => {
          bookingCard.remove();

          // Check if there are no more bookings and show empty state if needed
          if (bookingsList.children.length === 0) {
            bookingsList.innerHTML = `
              <div class="empty-state">
                <img src="/assets/image/empty-orders.svg" alt="No Orders">
                <h3>No Orders Found</h3>
                <p>You haven't placed any orders yet.</p>
                <a href="/order" class="btn-primary">Order Now</a>
              </div>
            `;
          }
        }, 300);
      }
    } else {
      // Re-render bookings for other tabs
      const status = activeTab ? activeTab.getAttribute("data-status") : "all";
      const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : "";
      renderBookings(status, searchTerm);
    }
    
    // Show toast notification
    showToast("Order Cancelled", "Your order has been cancelled successfully.", "info");
  }
  
  // Delete booking (for cancelled orders)
  function deleteBooking(id) {
    const bookingIndex = bookings.findIndex((b) => b.id === id);
    if (bookingIndex === -1) return;
    
    // Remove the booking from the array
    bookings.splice(bookingIndex, 1);
    
    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings));
    
    // Add notification
    if (window.addNotification) {
      window.addNotification("Order Deleted", `Order #${id} has been deleted from your history.`, "order");
    }
    
    // Find and remove the booking card from the DOM
    const bookingCard = document.querySelector(`.booking-card[data-id="${id}"]`);
    if (bookingCard) {
      // Add fade-out animation
      bookingCard.style.transition = "opacity 0.3s ease, transform 0.3s ease";
      bookingCard.style.opacity = "0";
      bookingCard.style.transform = "translateX(20px)";
      
      // Remove after animation completes
      setTimeout(() => {
        bookingCard.remove();
        
        // Check if there are no more bookings and show empty state if needed
        if (bookingsList.children.length === 0) {
          const activeTab = document.querySelector(".filter-tab.active");
          const status = activeTab ? activeTab.getAttribute("data-status") : "all";
          
          bookingsList.innerHTML = `
            <div class="empty-state">
              <img src="/assets/image/empty-orders.svg" alt="No Orders">
              <h3>No Orders Found</h3>
              <p>${status === "all" ? "You haven't placed any orders yet." : `You don't have any ${status} orders.`}</p>
              <a href="/order" class="btn-primary">Order Now</a>
            </div>
          `;
        }
      }, 300);
    }
    
    // Show toast notification
    showToast("Order Deleted", "Your order has been deleted from your history.", "info");
  }

  // Complete booking - IMPROVED FUNCTION
  function completeBooking(id) {
    const booking = bookings.find((b) => b.id === id);
    if (!booking) {
      showToast("Error", "Order not found", "error");
      return;
    }
    
    // Redirect to payment page with order ID
    window.location.href = `/payment?order_id=${id}`;
  }
  
  // Show toast notification
  function showToast(title, message, type = "info") {
    // Create toast container if it doesn't exist
    let toastContainer = document.querySelector(".toast-container");
    if (!toastContainer) {
      toastContainer = document.createElement("div");
      toastContainer.className = "toast-container";
      document.body.appendChild(toastContainer);
    }
    
    const toast = document.createElement("div");
    toast.className = "toast";
    
    let icon = "info-circle";
    if (type === "success") {
      icon = "check-circle";
      toast.classList.add("success");
    } else if (type === "error") {
      icon = "exclamation-circle";
      toast.classList.add("error");
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
    `;
    
    // Add to container
    toastContainer.appendChild(toast);
    
    // Add close button functionality
    const closeButton = toast.querySelector(".toast-close");
    closeButton.addEventListener("click", () => {
      toast.classList.add("toast-hide");
      setTimeout(() => {
        toast.remove();
      }, 300);
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
      toast.classList.add("toast-hide");
      setTimeout(() => {
        toast.remove();
      }, 300);
    }, 5000);
  }
  
  // Add CSS for modals and notifications
  const style = document.createElement("style");
  style.textContent = `
    /* Modal Overlay */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }
    
    /* Booking Details Modal */
    .booking-details-modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 90%;
      max-width: 800px;
      max-height: 90vh;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      overflow: hidden;
      animation: fadeIn 0.3s ease;
    }
    
    .modal-content {
      display: flex;
      flex-direction: column;
      height: 100%;
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
      color: #999;
      cursor: pointer;
    }
    
    .modal-body {
      padding: 20px;
      overflow-y: auto;
      flex: 1;
    }
    
    .modal-footer {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      padding: 15px 20px;
      border-top: 1px solid #eee;
    }
    
    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 20px;
    }
    
    .order-id-date h4 {
      margin: 0 0 5px;
      font-size: 18px;
    }
    
    .order-id-date p {
      margin: 0;
      font-size: 14px;
      color: #666;
    }
    
    .order-status {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    .order-status.processing {
      background-color: #fff8e1;
      color: #ffa000;
    }
    
    .order-status.completed {
      background-color: #e8f5e9;
      color: #4caf50;
    }
    
    .order-status.cancelled {
      background-color: #ffebee;
      color: #f44336;
    }
    
    .order-items {
      margin-bottom: 20px;
    }
    
    .order-items h4 {
      margin: 0 0 15px;
      font-size: 16px;
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }
    
    .order-item {
      display: flex;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #f5f5f5;
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
    
    .payment-method {
      margin-bottom: 20px;
    }
    
    .payment-method h4 {
      margin: 0 0 10px;
      font-size: 16px;
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }
    
    .payment-method-info {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px;
      background-color: #f9f9f9;
      border-radius: 5px;
    }
    
    .payment-method-info i {
      font-size: 18px;
      color: #ff5e62;
    }
    
    .order-summary {
      background-color: #f9f9f9;
      border-radius: 8px;
      padding: 15px;
    }
    
    .order-summary h4 {
      margin: 0 0 15px;
      font-size: 16px;
      color: #333;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }
    
    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 14px;
      color: #666;
    }
    
    .summary-row.total {
      font-size: 16px;
      font-weight: 600;
      color: #333;
      border-top: 1px dashed #ddd;
      padding-top: 10px;
      margin-top: 10px;
    }
    
    .summary-row.total span:last-child {
      color: #ff5e62;
    }
    
    /* Toast Notifications */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1100;
      display: flex;
      flex-direction: column;
      gap: 10px;
      max-width: 300px;
    }
    
    .toast {
      display: flex;
      align-items: flex-start;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      padding: 12px;
      animation: slideIn 0.3s ease;
      transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    .toast.toast-hide {
      opacity: 0;
      transform: translateX(20px);
    }
    
    .toast.success {
      border-left: 4px solid #4caf50;
    }
    
    .toast.error {
      border-left: 4px solid #f44336;
    }
    
    .toast-icon {
      font-size: 20px;
      margin-right: 12px;
      color: #666;
    }
    
    .toast.success .toast-icon {
      color: #4caf50;
    }
    
    .toast.error .toast-icon {
      color: #f44336;
    }
    
    .toast-content {
      flex: 1;
    }
    
    .toast-content h4 {
      margin: 0 0 5px;
      font-size: 16px;
      color: #333;
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
    
    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    @keyframes slideIn {
      from { transform: translateX(20px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
      .modal-body {
        padding: 15px;
      }
      
      .modal-footer {
        padding: 10px 15px;
      }
    }
  `;
  
  document.head.appendChild(style);
});