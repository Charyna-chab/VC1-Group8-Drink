// payment.js - Enhanced payment processing
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const paymentMethodCards = document.querySelectorAll(".payment-method-card");
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const completePaymentBtn = document.getElementById("complete-payment");
    const paymentSuccessModal = document.getElementById("paymentSuccessModal");
    const paymentSuccessMessage = document.getElementById("payment-success-message");
    const orderNumberElement = document.getElementById("order-number");
    const overlay = document.getElementById("overlay");
    const verifyQrPaymentBtn = document.getElementById("verify-qr-payment");
  
    // Card form elements
    const cardNumber = document.getElementById("card_number");
    const expiryDate = document.getElementById("expiry_date");
    const cvv = document.getElementById("cvv");
    const cardName = document.getElementById("card_name");
  
    // Get order ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get("order_id");
  
    // Load order data from localStorage
    loadOrderData(orderId);
  
    // Initialize payment method selection
    paymentRadios.forEach((radio) => {
      radio.addEventListener("change", function() {
        // Remove active class from all payment methods
        paymentMethodCards.forEach((card) => {
          card.classList.remove("active");
        });
  
        // Add active class to selected payment method
        const selectedCard = this.closest(".payment-method-card");
        if (selectedCard) {
          selectedCard.classList.add("active");
        }
  
        // Show selected payment content
        const selectedMethod = this.value;
        const allContents = document.querySelectorAll('.payment-method-content');
        allContents.forEach(content => {
          content.style.display = 'none';
        });
        
        const selectedContent = document.getElementById(`${selectedMethod}_payment_content`);
        if (selectedContent) {
          selectedContent.style.display = 'block';
        }
  
        // Enable the complete payment button
        completePaymentBtn.disabled = false;
      });
    });
  
    // Format card number with spaces
    if (cardNumber) {
      cardNumber.addEventListener("input", function(e) {
        const value = this.value.replace(/\s+/g, "").replace(/[^0-9]/gi, "");
        let formattedValue = "";
  
        for (let i = 0; i < value.length; i++) {
          if (i > 0 && i % 4 === 0) {
            formattedValue += " ";
          }
          formattedValue += value[i];
        }
  
        this.value = formattedValue;
      });
    }
  
    // Format expiry date (MM/YY)
    if (expiryDate) {
      expiryDate.addEventListener("input", function(e) {
        const value = this.value.replace(/\D/g, "");
  
        if (value.length > 2) {
          this.value = value.substring(0, 2) + "/" + value.substring(2, 4);
        } else {
          this.value = value;
        }
      });
    }
  
    // Only allow numbers in CVV
    if (cvv) {
      cvv.addEventListener("input", function(e) {
        this.value = this.value.replace(/\D/g, "");
      });
    }
  
    // Verify QR payment button
    if (verifyQrPaymentBtn) {
      verifyQrPaymentBtn.addEventListener("click", () => {
        // In a real app, this would verify the payment with the server
        // For demo, we'll just simulate a successful payment
        processPayment("qr");
      });
    }
  
    // Complete payment button
    if (completePaymentBtn) {
      completePaymentBtn.addEventListener("click", () => {
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
  
        if (!selectedPaymentMethod) {
          showToast("Error", "Please select a payment method", "error");
          return;
        }
  
        const paymentMethod = selectedPaymentMethod.value;
  
        // Validate payment details based on method
        if (paymentMethod === "card") {
          if (!validateCardPayment()) {
            return;
          }
        }
  
        // Process the payment
        processPayment(paymentMethod);
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
      const cashPaymentAmount = document.querySelector(".cash-payment-info p:last-child strong");
      if (cashPaymentAmount) cashPaymentAmount.textContent = `$${booking.total.toFixed(2)}`;
    }
  
    // Validate card payment details
    function validateCardPayment() {
      if (!cardNumber || !expiryDate || !cvv || !cardName) {
        showToast("Error", "Card form elements not found", "error");
        return false;
      }
  
      if (cardNumber.value.replace(/\s/g, "").length < 16) {
        showToast("Error", "Please enter a valid card number", "error");
        cardNumber.focus();
        return false;
      }
  
      if (expiryDate.value.length < 5) {
        showToast("Error", "Please enter a valid expiry date (MM/YY)", "error");
        expiryDate.focus();
        return false;
      }
  
      if (cvv.value.length < 3) {
        showToast("Error", "Please enter a valid CVV", "error");
        cvv.focus();
        return false;
      }
  
      if (cardName.value.trim() === "") {
        showToast("Error", "Please enter the name on card", "error");
        cardName.focus();
        return false;
      }
  
      return true;
    }
  
    // Process payment based on method
    function processPayment(method) {
      // Disable the button to prevent multiple clicks
      completePaymentBtn.disabled = true;
      completePaymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
  
      // In a real app, this would make an API call to process the payment
      // For demo, we'll simulate a payment processing delay
      setTimeout(() => {
        // Update booking status in localStorage
        updateBookingStatus(orderId, method);
  
        // Set success message based on payment method
        let successMessage = "";
        switch (method) {
          case "card":
            successMessage = "Your card payment has been processed successfully.";
            break;
          case "qr":
            successMessage = "Your QR code payment has been verified successfully.";
            break;
          case "cash":
            successMessage = "Your cash on delivery order has been confirmed.";
            break;
          default:
            successMessage = "Your payment has been processed successfully.";
        }
  
        if (paymentSuccessMessage) {
          paymentSuccessMessage.textContent = successMessage;
        }
  
        // Show success modal
        showPaymentSuccessModal();
  
        // Reset button state
        completePaymentBtn.disabled = false;
        completePaymentBtn.innerHTML = '<i class="fas fa-lock"></i> Complete Payment';
        
        // Add notification
        if (window.addNotification) {
          window.addNotification(
            "Payment Successful",
            `Your payment for order #${orderId} has been processed successfully.`,
            "success"
          );
        }
        
        // Redirect to booking page after 3 seconds
        setTimeout(() => {
          window.location.href = "/booking";
        }, 3000);
      }, 2000); // 2 second delay to simulate payment processing
    }
  
    // Update booking status in localStorage
    function updateBookingStatus(orderId, paymentMethod) {
      if (!orderId) return;
  
      // Get bookings from localStorage
      const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
      
      // Find the booking with the matching ID
      const bookingIndex = bookings.findIndex(b => b.id === orderId);
      
      if (bookingIndex === -1) return;
      
      // Update booking
      bookings[bookingIndex].status = "completed";
      bookings[bookingIndex].paymentMethod = paymentMethod;
      bookings[bookingIndex].paymentDate = new Date().toISOString();
      
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
    
    // Add CSS for payment page
    const style = document.createElement("style");
    style.textContent = `
      /* Payment Method Cards */
      .payment-method-card {
        border: 2px solid #ddd;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
      }
      
      .payment-method-card:hover {
        border-color: #ff5e62;
        box-shadow: 0 5px 15px rgba(255, 94, 98, 0.1);
      }
      
      .payment-method-card.active {
        border-color: #ff5e62;
        background-color: #fff0f0;
        box-shadow: 0 5px 15px rgba(255, 94, 98, 0.2);
      }
      
      .payment-method-header {
        display: flex;
        align-items: center;
        padding: 20px;
        cursor: pointer;
        gap: 15px;
      }
      
      .payment-method-header input[type="radio"] {
        width: 20px;
        height: 20px;
        margin: 0;
      }
      
      .payment-method-header label {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
        cursor: pointer;
        font-weight: 600;
        font-size: 18px;
      }
      
      .payment-method-header label i {
        font-size: 24px;
        color: #ff5e62;
        width: 40px;
        text-align: center;
      }
      
      .payment-method-content {
        padding: 20px;
        border-top: 1px solid #eee;
        display: none;
      }
      
      .payment-method-card.active .payment-method-content {
        display: block;
      }
      
      /* Card Payment Form */
      .card-payment-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
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
      
      .form-group input {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
      }
      
      .form-group input:focus {
        border-color: #ff5e62;
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.1);
      }
      
      .form-row {
        display: flex;
        gap: 20px;
      }
      
      .form-row .form-group {
        flex: 1;
      }
      
      /* QR Code Payment */
      .qr-code-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        padding: 20px;
      }
      
      .qr-code-container img {
        width: 250px;
        height: 250px;
        object-fit: contain;
        border: 1px solid #eee;
        padding: 15px;
        border-radius: 12px;
      }
      
      .qr-code-container p {
        text-align: center;
        font-size: 16px;
        color: #666;
      }
      
      .qr-verification {
        margin-top: 20px;
      }
      
      /* Cash Payment */
      .cash-payment-info {
        padding: 20px;
      }
      
      .cash-payment-info p {
        margin: 0 0 20px;
        font-size: 16px;
        color: #666;
        line-height: 1.6;
      }
      
      .cash-payment-info p:last-child {
        margin-bottom: 0;
      }
      
      .cash-payment-info strong {
        color: #ff5e62;
        font-size: 20px;
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
      
      .payment-success-content {
        width: 90%;
        max-width: 500px;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        padding: 40px 30px;
        text-align: center;
        animation: fadeIn 0.3s ease;
      }
      
      .success-icon {
        font-size: 80px;
        color: #4caf50;
        margin-bottom: 25px;
        animation: scaleIn 0.5s ease;
      }
      
      .payment-success-content h3 {
        margin: 0 0 15px;
        font-size: 28px;
        color: #333;
      }
      
      .payment-success-content p {
        margin: 0 0 25px;
        font-size: 18px;
        color: #666;
      }
      
      .order-details {
        background-color: #f9f9f9;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        text-align: left;
      }
      
      .order-number, .order-total {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 16px;
      }
      
      .order-total {
        margin-bottom: 0;
        font-weight: 600;
      }
      
      .success-actions {
        display: flex;
        justify-content: center;
      }
      
      /* Animations */
      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }
      
      @keyframes scaleIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
      }
      
      /* Responsive Styles */
      @media (max-width: 768px) {
        .form-row {
          flex-direction: column;
          gap: 15px;
        }
        
        .payment-success-content {
          padding: 30px 20px;
        }
      }
    `;
    
    document.head.appendChild(style);
  });