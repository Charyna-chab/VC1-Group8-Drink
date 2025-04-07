// booking.js - Enhanced with improved payment methods, receipt handling, and better UX
document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const bookingsList = document.querySelector(".bookings-list");
            const filterTabs = document.querySelectorAll(".filter-tab");
            const searchInput = document.getElementById("bookingSearch");
            const ctaButton = document.querySelector(".cta-button");
            const mainContent = document.querySelector(".main-content");
            const contentArea = document.querySelector(".content-area") || mainContent;

            // Get cart items from localStorage
            const cartItems = JSON.parse(localStorage.getItem("cart")) || [];

            // Create bookings from cart items
            const bookings = JSON.parse(localStorage.getItem("bookings")) || [];

            // Check if we just came from checkout
            const justCheckedOut = sessionStorage.getItem("justCheckedOut");
            if (justCheckedOut) {
                // Clear the flag
                sessionStorage.removeItem("justCheckedOut");

                // Create a new booking from cart items if there are any
                if (cartItems.length > 0) {
                    createBookingFromCart();
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

            // Create booking from cart
            function createBookingFromCart() {
                if (cartItems.length === 0) return;

                // Calculate total
                const subtotal = cartItems.reduce((total, item) => total + item.totalPrice, 0);
                const tax = subtotal * 0.08;
                const total = subtotal + tax;

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
                };

                // Add to bookings
                bookings.unshift(booking);

                // Save to localStorage
                localStorage.setItem("bookings", JSON.stringify(bookings));

                // Clear cart
                localStorage.setItem("cart", JSON.stringify([]));

                // Add notification
                if (window.addNotification) {
                    window.addNotification(
                        "Order Placed Successfully",
                        `Your order #${booking.id} has been placed and is being processed.`,
                        "order"
                    );
                }
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
                    filteredBookings = filteredBookings.filter((booking) => booking.id.toLowerCase().includes(searchTerm));
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
      switch (booking.status) {
        case "processing":
          statusClass = "processing";
          break;
        case "completed":
          statusClass = "completed";
          break;
        case "cancelled":
          statusClass = "cancelled";
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
            `
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
      `;

      bookingsList.appendChild(bookingCard);
    });

    // Add event listeners to buttons
    const viewDetailsButtons = document.querySelectorAll(".view-details");
    const cancelButtons = document.querySelectorAll(".cancel-booking");
    const completeButtons = document.querySelectorAll(".complete-booking");
    const deleteButtons = document.querySelectorAll(".delete-booking");

    viewDetailsButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const id = this.getAttribute("data-id");
        showBookingDetails(id);
      });
    });

    cancelButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        cancelBooking(id);
      });
    });

    completeButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        // Show payment interface directly when complete button is clicked
        showPaymentInterface(id);
      });
    });

    deleteButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        deleteBooking(id);
      });
    });
  }

  // Delete booking
  function deleteBooking(id) {
    const bookingIndex = bookings.findIndex((b) => b.id === id);
    if (bookingIndex === -1) return;

    // Remove booking from array
    bookings.splice(bookingIndex, 1);

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings));

    // Add notification
    if (window.addNotification) {
      window.addNotification("Order Deleted", `Order #${id} has been permanently deleted.`, "order");
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
  }

  // Show booking details
  function showBookingDetails(id) {
    const booking = bookings.find((b) => b.id === id);
    if (!booking) return;

    // Create modal
    const modal = document.createElement("div");
    modal.className = "booking-details-modal";

    // Format date
    const date = new Date(booking.date);
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();

    // Get status class
    let statusClass = "";
    switch (booking.status) {
      case "processing":
        statusClass = "processing";
        break;
      case "completed":
        statusClass = "completed";
        break;
      case "cancelled":
        statusClass = "cancelled";
        break;
    }

    // Get payment status
    const paymentStatus = booking.paymentStatus || "pending";
    const paymentStatusClass = paymentStatus === "completed" ? "completed" : "processing";

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
                `
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
    `;

    document.body.appendChild(modal);

    // Add event listeners
    const closeButtons = modal.querySelectorAll(".close-modal, .close-details");
    closeButtons.forEach((button) => {
      button.addEventListener("click", () => {
        modal.remove();
      });
    });

    // Add event listener for Pay Now button
    const payNowButton = modal.querySelector(".pay-now-modal");
    if (payNowButton) {
      payNowButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        modal.remove();
        showPaymentInterface(id);
      });
    }

    // Add event listener for View Receipt button
    const viewReceiptButton = modal.querySelector(".view-receipt-modal");
    if (viewReceiptButton) {
      viewReceiptButton.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        modal.remove();
        showReceiptInterface(id);
      });
    }

    // Close when clicking outside
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.remove();
      }
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
  }

  // Complete booking
  function completeBooking(id) {
    const bookingIndex = bookings.findIndex((b) => b.id === id);
    if (bookingIndex === -1) return;

    // Update booking status
    bookings[bookingIndex].status = "completed";

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings));

    // Add notification
    if (window.addNotification) {
      window.addNotification(
        "Order Completed",
        `Your order #${bookings[bookingIndex].id} has been marked as completed.`,
        "order"
      );
    }

    // Show success notification on the left side
    showOrderSuccessNotification(bookings[bookingIndex]);

    // Show celebration animation
    showCelebrationAnimation();

    // Re-render bookings
    const activeTab = document.querySelector(".filter-tab.active");
    const status = activeTab ? activeTab.getAttribute("data-status") : "all";
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : "";
    renderBookings(status, searchTerm);
  }

  // Show celebration animation
  function showCelebrationAnimation() {
    // Create celebration container
    const celebrationContainer = document.createElement("div");
    celebrationContainer.className = "celebration-animation";
    document.body.appendChild(celebrationContainer);

    // Create confetti pieces
    const colors = ["#ff5e62", "#4caf50", "#2196F3", "#ff9800", "#9C27B0"];
    for (let i = 0; i < 100; i++) {
      const confetti = document.createElement("div");
      confetti.className = "confetti";
      confetti.style.left = Math.random() * 100 + "vw";
      confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      confetti.style.width = Math.random() * 10 + 5 + "px";
      confetti.style.height = Math.random() * 10 + 10 + "px";
      confetti.style.animationDuration = Math.random() * 3 + 2 + "s";
      celebrationContainer.appendChild(confetti);
    }

    // Remove celebration after animation completes
    setTimeout(() => {
      celebrationContainer.classList.add("fade-out");
      setTimeout(() => {
        celebrationContainer.remove();
      }, 1000);
    }, 3000);
  }

  // Show order success notification on the left side
  function showOrderSuccessNotification(booking) {
    const notification = document.createElement("div");
    notification.className = "order-success-notification left-notification";

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
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
      notification.classList.add("fade-out");
      setTimeout(() => {
        notification.remove();
      }, 500);
    }, 5000);

    // Close button
    notification.querySelector(".close-notification").addEventListener("click", () => {
      notification.remove();
    });
  }

  // Show payment interface (as a section in the page, not a modal)
  function showPaymentInterface(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId);
    if (!booking) return;

    // Save original bookings list content
    const originalBookingsContent = bookingsList.innerHTML;

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
              
              <div class="payment-method-card" data-method="cash">
                <input type="radio" id="cash" name="payment-method">
                <label for="cash">
                  <i class="fas fa-money-bill-wave"></i>
                  <span>Cash on Delivery</span>
                </label>
              </div>
              
              <div class="payment-method-card" data-method="money-out">
                <input type="radio" id="money-out" name="payment-method">
                <label for="money-out">
                  <i class="fas fa-wallet"></i>
                  <span>Money Out</span>
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
            
            <div class="payment-details money-out-details" style="display: none;">
              <div class="money-out-icon">
                <i class="fas fa-wallet"></i>
              </div>
              <p>Pay using your Money Out account.</p>
              <div class="form-group">
                <label for="money-out-id">Money Out ID</label>
                <input type="text" id="money-out-id" placeholder="Enter your Money Out ID">
              </div>
              <div class="form-group">
                <label for="money-out-password">Password</label>
                <input type="password" id="money-out-password" placeholder="Enter your password">
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
    `;

    // Replace bookings list content with payment interface
    bookingsList.innerHTML = paymentInterfaceContent;

    // Store original content for returning
    sessionStorage.setItem("originalBookingsContent", originalBookingsContent);

    // Add event listeners for payment method selection
    const methodCards = document.querySelectorAll(".payment-method-card");
    methodCards.forEach((card) => {
      card.addEventListener("click", function () {
        // Update radio button
        const radio = this.querySelector("input[type='radio']");
        radio.checked = true;

        // Add selected class to clicked card and remove from others
        methodCards.forEach((c) => c.classList.remove("selected"));
        this.classList.add("selected");

        // Hide all payment details
        document.querySelectorAll(".payment-details").forEach((detail) => {
          detail.style.display = "none";
        });

        // Show selected payment details
        const method = this.getAttribute("data-method");
        document.querySelector(`.${method}-details`).style.display = "block";
      });
    });

    // Back button
    document.querySelector(".back-to-bookings").addEventListener("click", () => {
      bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent");
      sessionStorage.removeItem("originalBookingsContent");

      // Re-initialize event listeners
      initializeEventListeners();
    });

    // Cancel button
    document.querySelector(".cancel-payment").addEventListener("click", () => {
      bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent");
      sessionStorage.removeItem("originalBookingsContent");

      // Re-initialize event listeners
      initializeEventListeners();
    });

    // Process payment button
    document.querySelector(".process-payment").addEventListener("click", function () {
      const id = this.getAttribute("data-id");
      const selectedMethod = document.querySelector("input[name='payment-method']:checked").id;

      // Process payment
      processPayment(id, selectedMethod);
    });
  }

  // Process payment
  function processPayment(bookingId, paymentMethod) {
    const bookingIndex = bookings.findIndex((b) => b.id === bookingId);
    if (bookingIndex === -1) return;

    // Update booking payment status
    bookings[bookingIndex].paymentStatus = "completed";
    bookings[bookingIndex].paymentMethod = paymentMethod;

    // Save to localStorage
    localStorage.setItem("bookings", JSON.stringify(bookings));

    // Add notification
    if (window.addNotification) {
      window.addNotification(
        "Payment Successful",
        `Payment for order #${bookingId} has been processed successfully.`,
        "payment"
      );
    }

    // Show success notification on the left side
    showPaymentSuccessNotification(bookings[bookingIndex]);

    // Show receipt interface as a modal in the center
    showReceiptModal(bookingId);
  }

  // Show payment success notification on the left side
  function showPaymentSuccessNotification(booking) {
    const notification = document.createElement("div");
    notification.className = "payment-success-notification left-notification";

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
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
      notification.classList.add("fade-out");
      setTimeout(() => {
        notification.remove();
      }, 500);
    }, 5000);

    // Close button
    notification.querySelector(".close-notification").addEventListener("click", () => {
      notification.remove();
    });
  }

  // Show receipt as a modal in the center
  function showReceiptModal(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId);
    if (!booking) return;

    // Format date
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();

    // Generate receipt ID
    const receiptId = "RCP" + Date.now().toString().slice(-6);

    // Create receipt modal
    const receiptModal = document.createElement("div");
    receiptModal.className = "receipt-modal";

    receiptModal.innerHTML = `
      <div class="receipt-modal-content">
        <div class="receipt-paper">
          <div class="receipt-header">
            <div class="receipt-logo">
              <img src="/placeholder.svg?height=80&width=80" alt="Logo">
            </div>
            <h2>BUBBLE TEA SHOP</h2>
            <div class="receipt-info">
              <div class="shop-info">
                <p class="shop-name">Premium Bubble Tea</p>
                <p>123 Tea Street, Bubble City</p>
                <p>Tel: (123) 456-7890</p>
                <p>Date: ${formattedDate}</p>
                <p>Receipt #: ${receiptId}</p>
                <p>Order #: ${booking.id}</p>
              </div>
            </div>
            <div class="receipt-divider"></div>
          </div>
          
          <div class="receipt-body">
            <div class="receipt-items-header">
              <span class="item-image-header"></span>
              <span class="item-name">Item</span>
              <span class="item-qty">Qty</span>
              <span class="item-price">Price</span>
            </div>
            
            ${booking.items
              .map(
                (item) => `
              <div class="receipt-item-row">
                <div class="item-image-container">
                  <img src="${item.image}" alt="${item.name}" class="item-thumbnail">
                </div>
                <div class="item-name">
                  <p class="item-title">${item.name}</p>
                  <p class="item-details">Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                  ${
                    item.toppings && item.toppings.length > 0
                      ? `<p class="item-details">+ ${item.toppings.map((t) => t.name).join(", ")}</p>`
                      : ""
                  }
                </div>
                <div class="item-qty">${item.quantity}</div>
                <div class="item-price">$${item.totalPrice.toFixed(2)}</div>
              </div>
            `
              )
              .join("")}
            
            <div class="receipt-divider"></div>
            
            <div class="receipt-total-section">
              <div class="total-row">
                <span>Subtotal</span>
                <span>$${booking.subtotal.toFixed(2)}</span>
              </div>
              <div class="total-row">
                <span>Tax (8%)</span>
                <span>$${booking.tax.toFixed(2)}</span>
              </div>
              <div class="total-row grand-total">
                <span>Total</span>
                <span>$${booking.total.toFixed(2)}</span>
              </div>
              <div class="payment-method-row">
                <span>Payment Method</span>
                <span>${booking.paymentMethod ? booking.paymentMethod.replace(/-/g, ' ').toUpperCase() : 'Cash'}</span>
              </div>
            </div>
            
            <div class="receipt-divider"></div>
            
            <div class="receipt-footer">
              <p>Thank you for your purchase!</p>
              <p>We hope to see you again soon.</p>
              <div class="receipt-barcode">
                <img src="/placeholder.svg?height=40&width=200" alt="Barcode">
                <p>${receiptId}</p>
              </div>
            </div>
          </div>
        </div>
        
        <div class="receipt-actions">
          <button class="btn-secondary print-receipt">
            <i class="fas fa-print"></i> Print
          </button>
          <button class="btn-secondary download-receipt">
            <i class="fas fa-download"></i> Download
          </button>
          <button class="btn-primary continue-order" data-id="${booking.id}">
            <i class="fas fa-check"></i> Done
          </button>
        </div>
      </div>
    `;

    document.body.appendChild(receiptModal);

    // Print button
    receiptModal.querySelector(".print-receipt").addEventListener("click", () => {
      // Create a printable version of the receipt
      const printContent = document.createElement('div');
      printContent.className = 'print-only-receipt';
      
      // Clone the receipt paper for printing
      const receiptPaper = receiptModal.querySelector(".receipt-paper").cloneNode(true);
      printContent.appendChild(receiptPaper);
      
      // Store the current page content
      const originalContent = document.body.innerHTML;
      
      // Replace with print-friendly content
      document.body.innerHTML = '';
      document.body.appendChild(printContent);
      
      // Print
      window.print();
      
      // Restore original content
      document.body.innerHTML = originalContent;
      
      // Show receipt modal again
      showReceiptModal(bookingId);
    });

    // Download button - PDF version
    receiptModal.querySelector(".download-receipt").addEventListener("click", () => {
      // Check if jsPDF is loaded
      if (typeof window.jspdf === "undefined") {
        // Load jsPDF dynamically if not already loaded
        const jsPDFScript = document.createElement("script");
        jsPDFScript.src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js";
        jsPDFScript.onload = () => {
          // Load html2canvas if not already loaded
          if (typeof html2canvas === "undefined") {
            const html2canvasScript = document.createElement("script");
            html2canvasScript.src = "https://html2canvas.hertzen.com/dist/html2canvas.min.js";
            html2canvasScript.onload = () => {
              generatePDF();
            };
            html2canvasScript.onerror = () => {
              alert("Failed to load html2canvas. Please try again or use the print option.");
            };
            document.head.appendChild(html2canvasScript);
          } else {
            generatePDF();
          }
        };
        jsPDFScript.onerror = () => {
          alert("Failed to load PDF generator. Please try again or use the print option.");
        };
        document.head.appendChild(jsPDFScript);
      } else {
        generatePDF();
      }

      function generatePDF() {
        const receiptContent = receiptModal.querySelector(".receipt-paper");
        
        html2canvas(receiptContent).then((canvas) => {
          const imgData = canvas.toDataURL("image/png");
          const pdf = new window.jspdf.jsPDF({
            orientation: "portrait",
            unit: "mm",
            format: "a4"
          });
          
          // Calculate dimensions to fit the receipt on the PDF
          const imgWidth = 210; // A4 width in mm (210mm)
          const imgHeight = canvas.height * imgWidth / canvas.width;
          
          pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
          pdf.save(`Receipt-${receiptId}.pdf`);
        });
      }
    });

    // Continue Order button - Ensure it always works properly
    receiptModal.querySelector(".continue-order").addEventListener("click", function () {
      const id = this.getAttribute("data-id");

      // First remove the modal to prevent any issues
      receiptModal.remove();

      // Complete the booking
      completeBooking(id);

      // Show thank you notification
      showThankYouNotification();

      // Return to original bookings list
      if (sessionStorage.getItem("originalBookingsContent")) {
        bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent");
        sessionStorage.removeItem("originalBookingsContent");
      } else {
        // If original content is not available, just render bookings
        renderBookings();
      }

      // Re-initialize event listeners
      initializeEventListeners();
    });

    // Close when clicking outside
    receiptModal.addEventListener("click", (e) => {
      if (e.target === receiptModal) {
        receiptModal.remove();

        // Return to original bookings list
        if (sessionStorage.getItem("originalBookingsContent")) {
          bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent");
          sessionStorage.removeItem("originalBookingsContent");
        } else {
          // If original content is not available, just render bookings
          renderBookings();
        }

        // Re-initialize event listeners
        initializeEventListeners();
      }
    });
  }

  // Show thank you notification
  function showThankYouNotification() {
    const notification = document.createElement("div");
    notification.className = "thank-you-notification left-notification";

    notification.innerHTML = `
      <div class="notification-content">
        <div class="success-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="notification-text">
          <h4>Thank You For Your Order!</h4>
          <p>We hope you enjoy your drinks. Please visit us again soon!</p>
        </div>
        <button class="close-notification">&times;</button>
      </div>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
      notification.classList.add("fade-out");
      setTimeout(() => {
        notification.remove();
      }, 500);
    }, 5000);

    // Close button
    notification.querySelector(".close-notification").addEventListener("click", () => {
      notification.remove();
    });
  }

  // Show receipt interface (as a section in the page, not a modal)
  function showReceiptInterface(bookingId) {
    const booking = bookings.find((b) => b.id === bookingId);
    if (!booking) return;

    // Format date
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();

    // Generate receipt ID
    const receiptId = "RCP" + Date.now().toString().slice(-6);

    // Create receipt interface content
    const receiptInterfaceContent = `
      <div class="receipt-interface-container">
        <div class="receipt-interface-header">
          <button class="back-to-bookings">
            <i class="fas fa-arrow-left"></i> Back to Orders
          </button>
          <h2>Receipt</h2>
        </div>
        <div class="receipt-interface-content">
          <div class="receipt-paper">
            <div class="receipt-header">
              <div class="receipt-logo">
                <img src="/placeholder.svg?height=80&width=80" alt="Logo">
              </div>
              <h2>BUBBLE TEA SHOP</h2>
              <div class="receipt-info">
                <div class="shop-info">
                  <p class="shop-name">Premium Bubble Tea</p>
                  <p>123 Tea Street, Bubble City</p>
                  <p>Tel: (123) 456-7890</p>
                  <p>Date: ${formattedDate}</p>
                  <p>Receipt #: ${receiptId}</p>
                  <p>Order #: ${booking.id}</p>
                </div>
              </div>
              <div class="receipt-divider"></div>
            </div>
            
            <div class="receipt-body">
              <div class="receipt-items-header">
                <span class="item-image-header"></span>
                <span class="item-name">Item</span>
                <span class="item-qty">Qty</span>
                <span class="item-price">Price</span>
              </div>
              
              ${booking.items
                .map(
                  (item) => `
                <div class="receipt-item-row">
                  <div class="item-image-container">
                    <img src="${item.image}" alt="${item.name}" class="item-thumbnail">
                  </div>
                  <div class="item-name">
                    <p class="item-title">${item.name}</p>
                    <p class="item-details">Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                    ${
                      item.toppings && item.toppings.length > 0
                        ? `<p class="item-details">+ ${item.toppings.map((t) => t.name).join(", ")}</p>`
                        : ""
                    }
                  </div>
                  <div class="item-qty">${item.quantity}</div>
                  <div class="item-price">$${item.totalPrice.toFixed(2)}</div>
                </div>
              `
                )
                .join("")}
              
              <div class="receipt-divider"></div>
              
              <div class="receipt-total-section">
                <div class="total-row">
                  <span>Subtotal</span>
                  <span>$${booking.subtotal.toFixed(2)}</span>
                </div>
                <div class="total-row">
                  <span>Tax (8%)</span>
                  <span>$${booking.tax.toFixed(2)}</span>
                </div>
                <div class="total-row grand-total">
                  <span>Total</span>
                  <span>$${booking.total.toFixed(2)}</span>
                </div>
                <div class="payment-method-row">
                  <span>Payment Method</span>
                  <span>${booking.paymentMethod ? booking.paymentMethod.replace(/-/g, ' ').toUpperCase() : 'Cash'}</span>
                </div>
              </div>
              
              <div class="receipt-divider"></div>
              
              <div class="receipt-footer">
                <p>Thank you for your purchase!</p>
                <p>We hope to see you again soon.</p>
                <div class="receipt-barcode">
                  <img src="/placeholder.svg?height=40&width=200" alt="Barcode">
                  <p>${receiptId}</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="receipt-actions">
            <button class="btn-secondary print-receipt">
              <i class="fas fa-print"></i> Print
            </button>
            <button class="btn-secondary download-receipt">
              <i class="fas fa-download"></i> Download
            </button>
            <button class="btn-primary continue-order" data-id="${booking.id}">
              <i class="fas fa-check"></i> Done
            </button>
          </div>
        </div>
      </div>
    `;

    // Save original bookings list content
    const originalBookingsContent = bookingsList.innerHTML;
    sessionStorage.setItem("originalBookingsContent", originalBookingsContent);

    // Replace content with receipt interface
    bookingsList.innerHTML = receiptInterfaceContent;

    // Back button
    document.querySelector(".back-to-bookings").addEventListener("click", () => {
      bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent");
      sessionStorage.removeItem("originalBookingsContent");

      // Re-initialize event listeners
      initializeEventListeners();
    });

    // Print button
    document.querySelector(".print-receipt").addEventListener("click", () => {
      // Create a printable version of the receipt
      const printContent = document.createElement('div');
      printContent.className = 'print-only-receipt';
      
      // Clone the receipt paper for printing
      const receiptPaper = document.querySelector(".receipt-paper").cloneNode(true);
      printContent.appendChild(receiptPaper);
      
      // Store the current page content
      const originalContent = document.body.innerHTML;
      
      // Replace with print-friendly content
      document.body.innerHTML = '';
      document.body.appendChild(printContent);
      
      // Print
      window.print();
      
      // Restore original content
      document.body.innerHTML = originalContent;
      
      // Show receipt interface again
      showReceiptInterface(bookingId);
    });

    // Download button - PDF version
    document.querySelector(".download-receipt").addEventListener("click", () => {
      // Check if jsPDF is loaded
      if (typeof window.jspdf === "undefined") {
        // Load jsPDF dynamically if not already loaded
        const jsPDFScript = document.createElement("script");
        jsPDFScript.src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js";
        jsPDFScript.onload = () => {
          // Load html2canvas if not already loaded
          if (typeof html2canvas === "undefined") {
            const html2canvasScript = document.createElement("script");
            html2canvasScript.src = "https://html2canvas.hertzen.com/dist/html2canvas.min.js";
            html2canvasScript.onload = () => {
              generatePDF();
            };
            html2canvasScript.onerror = () => {
              alert("Failed to load html2canvas. Please try again or use the print option.");
            };
            document.head.appendChild(html2canvasScript);
          } else {
            generatePDF();
          }
        };
        jsPDFScript.onerror = () => {
          alert("Failed to load PDF generator. Please try again or use the print option.");
        };
        document.head.appendChild(jsPDFScript);
      } else {
        generatePDF();
      }

      function generatePDF() {
        const receiptContent = document.querySelector(".receipt-paper");
        
        html2canvas(receiptContent).then((canvas) => {
          const imgData = canvas.toDataURL("image/png");
          const pdf = new window.jspdf.jsPDF({
            orientation: "portrait",
            unit: "mm",
            format: "a4"
          });
          
          // Calculate dimensions to fit the receipt on the PDF
          const imgWidth = 210; // A4 width in mm (210mm)
          const imgHeight = canvas.height * imgWidth / canvas.width;
          
          pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
          pdf.save(`Receipt-${receiptId}.pdf`);
        });
      }
    });

    // Continue Order button - Ensure it always works properly
    document.querySelector(".continue-order").addEventListener("click", function () {
      const id = this.getAttribute("data-id");

      // Complete the booking
      completeBooking(id);

      // Show thank you notification
      showThankYouNotification();

      // Return to original bookings list immediately
      if (sessionStorage.getItem("originalBookingsContent")) {
        bookingsList.innerHTML = sessionStorage.getItem("originalBookingsContent");
        sessionStorage.removeItem("originalBookingsContent");
      } else {
        // If original content is not available, just render bookings
        renderBookings();
      }

      // Re-initialize event listeners
      initializeEventListeners();
    });
  }

  // Initialize event listeners after DOM changes
  function initializeEventListeners() {
    // Re-attach event listeners to filter tabs
    const filterTabs = document.querySelectorAll(".filter-tab");
    filterTabs.forEach((tab) => {
      tab.addEventListener("click", function () {
        filterTabs.forEach((t) => t.classList.remove("active"));
        this.classList.add("active");
        const status = this.getAttribute("data-status");
        renderBookings(status);
      });
    });

    // Re-attach search functionality
    const searchInput = document.getElementById("bookingSearch");
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase().trim();
        const activeStatus = document.querySelector(".filter-tab.active").getAttribute("data-status");
        renderBookings(activeStatus, searchTerm);
      });
    }

    // Re-render bookings
    renderBookings();
  }

  // Add CSS for booking
  const style = document.createElement("style");
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

    .payment-method-card[data-method="cash"] i {
      color: #4CAF50;
    }
    
    .payment-method-card[data-method="money-out"] i {
      color: #FF9800;
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

    .qr-code-container, .cash-icon, .money-out-icon {
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
      object-fit: cover;
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
      flex-direction: column;
      width: 100%;
      max-width: 800px;
      margin: 0 auto;
      background-color: white;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .receipt-interface-header {
      display: flex;
      align-items: center;
      padding: 20px;
      border-bottom: 1px solid #eee;
      position: relative;
    }

    .receipt-interface-header h2 {
      text-align: center;
      flex: 1;
      font-size: 24px;
      color: #333;
      margin: 0;
    }

    .receipt-interface-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
      padding: 30px;
    }

    /* Enhanced Modern Receipt Styles */
    .receipt-paper {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      padding: 30px 20px;
      width: 100%;
      max-width: 500px;
      position: relative;
      overflow: hidden;
    }

    .receipt-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .receipt-header h2 {
      font-size: 24px;
      margin: 0 0 15px;
      font-weight: 700;
      color: #333;
      letter-spacing: 1px;
    }

    .receipt-logo {
      margin: 0 auto 15px;
      width: 80px;
      height: 80px;
      background-color: #f5f5f5;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .receipt-logo img {
      width: 80%;
      height: 80%;
      object-fit: contain;
    }

    .receipt-info {
      text-align: center;
      margin-bottom: 10px;
    }

    .shop-info {
      margin: 0 auto;
    }

    .shop-info p {
      margin: 3px 0;
      font-size: 14px;
      color: #666;
    }

    .shop-name {
      font-size: 16px !important;
      font-weight: 600;
      color: #333 !important;
    }

    .receipt-divider {
      height: 1px;
      background: linear-gradient(to right, transparent, #ddd, transparent);
      margin: 15px 0;
    }

    .receipt-items-header {
      display: grid;
      grid-template-columns: 50px 1fr 40px 70px;
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 14px;
      color: #555;
      padding-bottom: 5px;
      border-bottom: 1px solid #eee;
    }

    .item-image-header {
      width: 50px;
    }

    .receipt-item-row {
      display: grid;
      grid-template-columns: 50px 1fr 40px 70px;
      margin-bottom: 12px;
      align-items: center;
      padding-bottom: 8px;
      border-bottom: 1px dashed #eee;
    }

    .receipt-item-row:last-child {
      border-bottom: none;
    }

    .item-image-container {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .item-thumbnail {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .item-name {
      padding-right: 10px;
    }

    .item-title {
      margin: 0 0 3px;
      font-size: 14px;
      font-weight: 500;
      color: #333;
    }

    .item-details {
      font-size: 12px;
      color: #777;
      margin: 2px 0;
    }

    .item-qty {
      text-align: center;
      font-size: 14px;
      color: #555;
    }

    .item-price {
      text-align: right;
      font-size: 14px;
      font-weight: 500;
      color: #333;
    }

    .receipt-total-section {
      padding: 10px 0;
    }

    .total-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      font-size: 14px;
      color: #555;
    }

    .grand-total {
      font-weight: 700;
      font-size: 16px;
      color: #333;
      margin-top: 5px;
    }

    .grand-total span:last-child {
      color: #ff5e62;
    }

    .payment-method-row {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      color: #555;
      margin-top: 8px;
      padding-top: 8px;
      border-top: 1px dashed #eee;
    }

    .receipt-footer {
      text-align: center;
      margin-top: 15px;
    }

    .receipt-footer p {
      margin: 0 0 8px;
      font-size: 14px;
      color: #666;
    }

    .receipt-barcode {
      margin: 15px auto 0;
      max-width: 200px;
    }

    .receipt-barcode img {
      width: 100%;
      height: auto;
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
      min-width: 120px;
      font-weight: 500;
    }

    /* Print Styles */
    .print-only-receipt {
      padding: 20px;
      max-width: 400px;
      margin: 0 auto;
    }

    /* Order Success Notification */
    .order-success-notification,
    .payment-success-notification,
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
    .payment-success-notification.left-notification,
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
    .payment-success-notification.fade-out,
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

    @media print {
      body * {
        visibility: hidden;
      }
      .print-only-receipt, .print-only-receipt * {
        visibility: visible;
      }
      .print-only-receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .payment-methods-grid {
        grid-template-columns: 1fr 1fr;
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
      
      .receipt-items-header,
      .receipt-item-row {
        grid-template-columns: 40px 1fr 30px 60px;
      }
    }
    
    @media (max-width: 480px) {
      .payment-methods-grid {
        grid-template-columns: 1fr;
      }
      
      .receipt-paper {
        padding: 20px 15px;
      }
      
      .receipt-items-header,
      .receipt-item-row {
        grid-template-columns: 30px 1fr 30px 60px;
        font-size: 13px;
      }
      
      .item-details {
        font-size: 11px;
      }
    }
  `;
  document.head.appendChild(style);

  // Add jsPDF script for PDF generation
  const jsPDFScript = document.createElement("script");
  jsPDFScript.src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js";
  document.head.appendChild(jsPDFScript);

  // Add html2canvas script for receipt download functionality
  const html2canvasScript = document.createElement("script");
  html2canvasScript.src = "https://html2canvas.hertzen.com/dist/html2canvas.min.js";
  document.head.appendChild(html2canvasScript);

  // Check if we need to create a booking from cart
  if (window.location.pathname === "/booking" && cartItems.length > 0) {
    // Set flag to create booking on page load
    sessionStorage.setItem("justCheckedOut", "true");

    // Reload page to trigger booking creation
    if (!justCheckedOut) {
      window.location.reload();
    }
  }
});