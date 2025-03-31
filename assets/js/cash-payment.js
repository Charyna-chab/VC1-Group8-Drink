// cash-payment.js - Handles cash payment processing
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const confirmCashPaymentBtn = document.getElementById("confirm-cash-payment");
    const paymentSuccessModal = document.getElementById("paymentSuccessModal");
    const orderNumberElement = document.getElementById("order-number");
    const overlay = document.getElementById("overlay");
    
    // Form elements
    const fullNameInput = document.getElementById("full_name");
    const phoneInput = document.getElementById("phone");
    const addressInput = document.getElementById("address");
    
    // Get order ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get("order_id");
    
    // Load order data from localStorage
    loadOrderData(orderId);
    
    // Confirm cash payment button
    if (confirmCashPaymentBtn) {
      confirmCashPaymentBtn.addEventListener("click", () => {
        // Validate form
        if (!validateForm()) {
          return;
        }
        
        // Process the cash payment
        processCashPayment();
      });
    }
    
    // Load order data from localStorage
    function loadOrderData(orderId) {
      if (!orderId) return;
      
      // Get bookings from localStorage
      const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
      
      // Find the booking with the matching ID
      const booking = bookings.find(b => b.id === orderId);
      
      if (!booking) {
        showToast("Error", "Order not found", "error");
        return;
      }
      
      // Update order summary
      updateOrderSummary(booking);
      
      // Update order number in success modal
      if (orderNumberElement) {
        orderNumberElement.textContent = "#" + orderId;
      }
    }
    
    // Update order summary
    function updateOrderSummary(booking) {
      // Update order items
      const orderItemsContainer = document.querySelector(".order-items");
      if (!orderItemsContainer) return;
      
      // Clear existing items
      orderItemsContainer.innerHTML = "";
      
      // Add each item
      booking.items.forEach(item => {
        const itemElement = document.createElement("div");
        itemElement.className = "order-item";
        
        // Format toppings
        let toppingsText = "None";
        if (item.toppings && item.toppings.length > 0) {
          toppingsText = item.toppings.map(t => t.name).join(", ");
        }
        
        itemElement.innerHTML = `
          <div class="item-image">
            <img src="${item.image || '/assets/images/default-product.png'}" alt="${item.name}">
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
        `;
        
        orderItemsContainer.appendChild(itemElement);
      });
      
      // Update totals
      const subtotalElement = document.querySelector(".total-row:nth-child(1) span:last-child");
      const taxElement = document.querySelector(".total-row:nth-child(2) span:last-child");
      const totalElement = document.querySelector(".grand-total span:last-child");
      
      if (subtotalElement) subtotalElement.textContent = `$${booking.subtotal.toFixed(2)}`;
      if (taxElement) taxElement.textContent = `$${booking.tax.toFixed(2)}`;
      if (totalElement) totalElement.textContent = `$${booking.total.toFixed(2)}`;
      
      // Update cash payment amount
      const cashPaymentAmount = document.querySelector(".info-card .info-content strong");
      if (cashPaymentAmount) cashPaymentAmount.textContent = `$${booking.total.toFixed(2)}`;
    }
    
    // Validate form
    function validateForm() {
      if (!fullNameInput || !phoneInput || !addressInput) {
        showToast("Error", "Form elements not found", "error");
        return false;
      }
      
      if (fullNameInput.value.trim() === "") {
        showToast("Error", "Please enter your full name", "error");
        fullNameInput.focus();
        return false;
      }
      
      if (phoneInput.value.trim() === "") {
        showToast("Error", "Please enter your phone number", "error");
        phoneInput.focus();
        return false;
      }
      
      if (addressInput.value.trim() === "") {
        showToast("Error", "Please enter your delivery address", "error");
        addressInput.focus();
        return false;
      }
      
      return true;
    }
    
    // Process cash payment
    function processCashPayment() {
      // Disable the button to prevent multiple clicks
      confirmCashPaymentBtn.disabled = true;
      confirmCashPaymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
      
      // In a real app, this would make an API call to process the order
      // For demo, we'll simulate a processing delay
      setTimeout(() => {
        // Update booking status in localStorage
        updateBookingStatus(orderId);
        
        // Show success modal
        showPaymentSuccessModal();
        
        // Reset button state
        confirmCashPaymentBtn.disabled = false;
        confirmCashPaymentBtn.innerHTML = '<i class="fas fa-check"></i> Confirm Order';
        
        // Add notification
        if (window.addNotification) {
          window.addNotification(
            "Order Confirmed",
            `Your cash on delivery order #${orderId} has been confirmed.`,
            "success"
          );
        }
        
        // Redirect to booking page after 3 seconds
        setTimeout(() => {
          window.location.href = "/booking";
        }, 3000);
      }, 2000); // 2 second delay to simulate processing
    }
    
    // Update booking status in localStorage
    function updateBookingStatus(orderId) {
      if (!orderId) return;
      
      // Get bookings from localStorage
      const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
      
      // Find the booking with the matching ID
      const bookingIndex = bookings.findIndex(b => b.id === orderId);
      
      if (bookingIndex === -1) return;
      
      // Update booking
      bookings[bookingIndex].status = "completed";
      bookings[bookingIndex].paymentMethod = "cash";
      bookings[bookingIndex].paymentDate = new Date().toISOString();
      bookings[bookingIndex].deliveryAddress = addressInput.value;
      bookings[bookingIndex].contactName = fullNameInput.value;
      bookings[bookingIndex].contactPhone = phoneInput.value;
      bookings[bookingIndex].deliveryNotes = document.getElementById("notes") ? document.getElementById("notes").value : "";
      
      // Save to localStorage
      localStorage.setItem("bookings", JSON.stringify(bookings));
    }
    
    // Show payment success modal
    function showPaymentSuccessModal() {
      if (paymentSuccessModal) {
        paymentSuccessModal.classList.add("active");
      }
      
      if (overlay) {
        overlay.style.display = "block";
      }
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
    
    // Add CSS for cash payment page
    const style = document.createElement("style");
    style.textContent = `
      /* Cash Payment Container */
      .cash-payment-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }
      
      .payment-header {
        margin-bottom: 30px;
        text-align: center;
      }
      
      .payment-header h2 {
        font-size: 28px;
        margin-bottom: 10px;
        color: #333;
      }
      
      .payment-header p {
        font-size: 16px;
        color: #666;
      }
      
      .payment-content {
        display: flex;
        flex-direction: column;
        gap: 30px;
      }
      
      @media (min-width: 768px) {
        .payment-content {
          flex-direction: row;
        }
        
        .order-summary-section {
          width: 40%;
        }
        
        .cash-payment-section {
          width: 60%;
        }
      }
      
      /* Info Cards */
      .cash-payment-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 30px;
      }
      
      .info-card {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      }
      
      .info-icon {
        width: 50px;
        height: 50px;
        background-color: #ff5e62;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
      }
      
      .info-content {
        flex: 1;
      }
      
      .info-content h4 {
        margin: 0 0 10px;
        font-size: 18px;
        color: #333;
      }
      
      .info-content p {
        margin: 0;
        font-size: 16px;
        color: #666;
        line-height: 1.5;
      }
      
      .info-content strong {
        color: #ff5e62;
        font-size: 18px;
      }
      
      /* Delivery Address */
      .delivery-address {
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      }
      
      .delivery-address h4 {
        margin: 0 0 20px;
        font-size: 18px;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
      }
      
      .address-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }
      
      .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
      }
      
      .form-group label {
        font-size: 16px;
        color: #666;
      }
      
      .form-group input,
      .form-group textarea {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
      }
      
      .form-group input:focus,
      .form-group textarea:focus {
        border-color: #ff5e62;
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.1);
      }
      
      .form-group textarea {
        min-height: 100px;
        resize: vertical;
      }
      
      /* Payment Actions */
      .payment-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
      }
      
      .btn-outline {
        padding: 12px 20px;
        background-color: transparent;
        color: #ff5e62;
        border: 1px solid #ff5e62;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      
      .btn-outline:hover {
        background-color: #fff0f0;
      }
      
      .btn-primary {
        padding: 12px 20px;
        background-color: #ff5e62;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      
      .btn-primary:hover {
        background-color: #ff4146;
      }
      
      .btn-primary:disabled {
        background-color: #ccc;
        cursor: not-allowed;
      }
      
      /* Payment Success Modal */
      .payment-success-modal {
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
      
      .payment-success-modal.active {
        display: flex;
      }
      
      /* Responsive Styles */
      @media (max-width: 768px) {
        .payment-actions {
          flex-direction: column;
          gap: 15px;
        }
        
        .payment-actions .btn-outline,
        .payment-actions .btn-primary {
          width: 100%;
          justify-content: center;
        }
      }
    `;
    
    document.head.appendChild(style);
  });