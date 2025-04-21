document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const bookingsList = document.querySelector(".bookings-list");
            const filterTabs = document.querySelectorAll(".filter-tab");
            const searchInput = document.getElementById("bookingSearch");
            const ctaButton = document.querySelector(".cta-button");
            const mainContent = document.querySelector(".main-content");
            const contentArea = document.querySelector(".content-area") || mainContent;
            const orderCount = document.createElement("div"); // Order count display
            orderCount.className = "order-count";

            // Get cart items from localStorage
            const cartItems = JSON.parse(localStorage.getItem("cart")) || [];

            // Create bookings from cart items
            const bookings = JSON.parse(localStorage.getItem("bookings")) || [];

            // Check if we just came from checkout
            const justCheckedOut = sessionStorage.getItem("justCheckedOut");
            if (justCheckedOut) {
                sessionStorage.removeItem("justCheckedOut");
                if (cartItems.length > 0) {
                    createBookingFromCart();
                }
            }

            // Display order count
            function updateOrderCount() {
                const count = bookings.filter(b => b.status !== "cancelled").length;
                orderCount.textContent = count > 0 ? count : "0";
                if (!document.querySelector(".order-count") && mainContent) {
                    orderCount.style.position = "absolute";
                    orderCount.style.top = "10px";
                    orderCount.style.right = "10px";
                    orderCount.style.background = "#ff5e62";
                    orderCount.style.color = "white";
                    orderCount.style.borderRadius = "50%";
                    orderCount.style.width = "24px";
                    orderCount.style.height = "24px";
                    orderCount.style.display = "flex";
                    orderCount.style.alignItems = "center";
                    orderCount.style.justifyContent = "center";
                    orderCount.style.fontSize = "14px";
                    mainContent.appendChild(orderCount);
                }
            }

            // Initialize bookings
            renderBookings();
            updateOrderCount();

            // Filter bookings by status
            filterTabs.forEach((tab) => {
                tab.addEventListener("click", function() {
                    filterTabs.forEach((t) => t.classList.remove("active"));
                    this.classList.add("active");
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

                const subtotal = cartItems.reduce((total, item) => total + item.totalPrice, 0);
                const tax = subtotal * 0.08;
                const total = subtotal + tax;

                const booking = {
                    id: generateId("ORD"),
                    bookingTimestamp: new Date().toISOString(),
                    items: cartItems.map(item => ({...item, basePrice: item.totalPrice / item.quantity })),
                    subtotal,
                    tax,
                    total,
                    status: "processing",
                    paymentStatus: "pending",
                    paymentMethod: null
                };

                bookings.unshift(booking);
                localStorage.setItem("bookings", JSON.stringify(bookings));
                localStorage.setItem("cart", JSON.stringify([]));
                updateOrderCount();

                if (window.addNotification) {
                    window.addNotification(
                        "Order Placed Successfully",
                        `Your order #${booking.id} has been placed and is being processed.`,
                        "order"
                    );
                } else {
                    showToast("Order Placed", `Your order #${booking.id} has been placed.`, "success");
                }

                renderBookings();
            }

            // Render bookings
            function renderBookings(status = "all", searchTerm = "") {
                if (!bookingsList) return;

                let filteredBookings = bookings;
                if (status !== "all") {
                    filteredBookings = bookings.filter((booking) => booking.status === status);
                } else {
                    filteredBookings = bookings.filter((booking) => booking.status !== "cancelled");
                }

                if (searchTerm) {
                    filteredBookings = filteredBookings.filter((booking) => booking.id.toLowerCase().includes(searchTerm));
                }

                bookingsList.innerHTML = "";

                if (filteredBookings.length === 0) {
                    bookingsList.innerHTML = `
                <div class="empty-state">
                    <h3>No Orders Found</h3>
                    <p>${status === "all" ? "You haven't placed any orders yet." : `You don't have any ${status} orders.`}</p>
                    <a href="/order" class="btn-primary">Order Now</a>
                </div>
            `;
            return;
        }

        filteredBookings.forEach((booking) => {
            const bookingCard = document.createElement("div");
            bookingCard.className = "booking-card";
            bookingCard.setAttribute("data-id", booking.id);
            bookingCard.setAttribute("data-status", booking.status);

            const date = new Date(booking.bookingTimestamp);
            const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();

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
                            booking.status === "completed"
                                ? `
                                    <a href="/receipt?order_id=${booking.id}" class="btn-primary">
                                        <i class="fas fa-receipt"></i> View Receipt
                                    </a>
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

            // Attach event listeners to buttons within this booking card
            const cancelButton = bookingCard.querySelector(".cancel-booking");
            const completeButton = bookingCard.querySelector(".complete-booking");
            const deleteButton = bookingCard.querySelector(".delete-booking");
            const viewDetailsButton = bookingCard.querySelector(".view-details");

            if (viewDetailsButton) {
                viewDetailsButton.addEventListener("click", (e) => {
                    e.preventDefault();
                    const id = viewDetailsButton.getAttribute("data-id");
                    showBookingDetails(id);
                });
            }

            if (cancelButton) {
                cancelButton.addEventListener("click", () => {
                    const id = cancelButton.getAttribute("data-id");
                    cancelBooking(id);
                });
            }

            if (completeButton) {
                completeButton.addEventListener("click", () => {
                    const id = completeButton.getAttribute("data-id");
                    completeBooking(id);
                });
            }

            if (deleteButton) {
                deleteButton.addEventListener("click", () => {
                    const id = deleteButton.getAttribute("data-id");
                    deleteBooking(id);
                });
            }
        });
    }

    // Delete booking
    function deleteBooking(id) {
        const bookingIndex = bookings.findIndex((b) => b.id === id);
        if (bookingIndex === -1) return;

        bookings.splice(bookingIndex, 1);
        localStorage.setItem("bookings", JSON.stringify(bookings));
        updateOrderCount();

        showToast("Order Deleted", `Order #${id} has been permanently deleted.`, "success");

        // Re-render bookings based on current filter and search
        const activeTab = document.querySelector(".filter-tab.active");
        const status = activeTab ? activeTab.getAttribute("data-status") : "all";
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : "";
        renderBookings(status, searchTerm);
    }

    // Show booking details
    function showBookingDetails(id) {
        const existingModal = document.querySelector(".booking-details-modal");
        if (existingModal) existingModal.remove();

        const booking = bookings.find((b) => b.id === id);
        if (!booking) return;

        const modal = document.createElement("div");
        modal.className = "booking-details-modal";

        const date = new Date(booking.bookingTimestamp);
        const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();

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

        const paymentStatus = booking.paymentStatus || "pending";
        const paymentStatusClass = paymentStatus === "completed" ? "completed" : "processing";

        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Order Details</h3>
                    <button class="close-modal">×</button>
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
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        const closeButtons = modal.querySelectorAll(".close-modal, .close-details");
        closeButtons.forEach((button) => {
            button.addEventListener("click", () => {
                modal.remove();
            });
        });

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

        bookings[bookingIndex].status = "cancelled";
        localStorage.setItem("bookings", JSON.stringify(bookings));
        updateOrderCount();

        showToast("Order Cancelled", `Your order #${bookings[bookingIndex].id} has been cancelled.`, "success");

        // Re-render bookings based on current filter and search
        const activeTab = document.querySelector(".filter-tab.active");
        const status = activeTab ? activeTab.getAttribute("data-status") : "all";
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : "";
        renderBookings(status, searchTerm);
    }

    // Complete booking
    function completeBooking(id) {
        const bookingIndex = bookings.findIndex((b) => b.id === id);
        if (bookingIndex === -1) return;

        showRedirectNotification(
            "Proceeding to Payment",
            `Order #${bookings[bookingIndex].id} is ready for payment. Redirecting to checkout...`,
            `/checkout?booking_id=${id}`
        );

        bookings[bookingIndex].status = "processing";
        bookings[bookingIndex].paymentStatus = "pending";
        localStorage.setItem("bookings", JSON.stringify(bookings));
        updateOrderCount();

        renderBookings();
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        let toastContainer = document.querySelector(".toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.className = "toast-container";
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement("div");
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${type === "success" ? "check-circle" : type === "error" ? "exclamation-circle" : "info-circle"}"></i>
            </div>
            <div class="toast-content">
                <h4>${title}</h4>
                <p>${message}</p>
            </div>
            <button class="toast-close">×</button>
        `;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.add("toast-hide");
            setTimeout(() => toast.remove(), 300);
        }, 5000);

        toast.querySelector(".toast-close").addEventListener("click", () => {
            toast.classList.add("toast-hide");
            setTimeout(() => toast.remove(), 300);
        });
    }

    // Show redirect notification
    function showRedirectNotification(title, message, url) {
        showToast(title, message, "info");
        setTimeout(() => {
            window.location.href = url;
        }, 2000);
    }

    // Show celebration animation
    function showCelebrationAnimation() {
        const celebrationContainer = document.createElement("div");
        celebrationContainer.className = "celebration-animation";
        document.body.appendChild(celebrationContainer);

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

        setTimeout(() => {
            celebrationContainer.classList.add("fade-out");
            setTimeout(() => {
                celebrationContainer.remove();
            }, 1000);
        }, 3000);
    }

    // Generate unique ID
    function generateId(prefix) {
        return `${prefix}-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
    }

    // Initialize event listeners after DOM changes
    function initializeEventListeners() {
        const filterTabs = document.querySelectorAll(".filter-tab");
        filterTabs.forEach((tab) => {
            tab.addEventListener("click", function () {
                filterTabs.forEach((t) => t.classList.remove("active"));
                this.classList.add("active");
                const status = this.getAttribute("data-status");
                renderBookings(status);
            });
        });

        const searchInput = document.getElementById("bookingSearch");
        if (searchInput) {
            searchInput.addEventListener("input", function () {
                const searchTerm = this.value.toLowerCase().trim();
                const activeStatus = document.querySelector(".filter-tab.active").getAttribute("data-status");
                renderBookings(activeStatus, searchTerm);
            });
        }

        renderBookings();
        updateOrderCount();
    }

    // Add CSS for booking
    const style = document.createElement("style");
    style.textContent = `
        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1500;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            max-width: 400px;
            opacity: 0;
            animation: slide-in-right 0.3s ease forwards;
        }

        .toast.success {
            border-left: 4px solid #4caf50;
        }

        .toast.error {
            border-left: 4px solid #f44336;
        }

        .toast.info {
            border-left: 4px solid #2196f3;
        }

        .toast-icon {
            font-size: 24px;
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
            font-size: 20px;
            color: #999;
            cursor: pointer;
        }

        .toast-hide {
            animation: slide-out-right 0.3s ease forwards;
        }

        @keyframes slide-in-right {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slide-out-right {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(20px);
            }
        }

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
    `;
    document.head.appendChild(style);

    // Check if we need to create a booking from cart
    if (window.location.pathname === "/booking" && cartItems.length > 0) {
        sessionStorage.setItem("justCheckedOut", "true");
        if (!justCheckedOut) {
            createBookingFromCart();
        }
    }
});