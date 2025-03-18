// assets/js/booking.js
document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const filterTabs = document.querySelectorAll(".filter-tab");
            const bookingsList = document.querySelector(".bookings-list");
            const searchInput = document.getElementById("bookingSearch");

            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById("toastContainer");
            if (!toastContainer) {
                toastContainer = document.createElement("div");
                toastContainer.id = "toastContainer";
                toastContainer.className = "toast-container";
                document.body.appendChild(toastContainer);
            }

            // Load cart items from localStorage
            const cart = JSON.parse(localStorage.getItem("cart")) || [];

            // Display cart items as bookings
            displayBookings();

            // Filter bookings by status
            filterTabs.forEach((tab) => {
                tab.addEventListener("click", function() {
                    // Remove active class from all tabs
                    filterTabs.forEach((t) => t.classList.remove("active"));

                    // Add active class to clicked tab
                    this.classList.add("active");

                    const status = this.getAttribute("data-status");

                    // Filter bookings
                    const bookingCards = document.querySelectorAll(".booking-card");
                    bookingCards.forEach((card) => {
                        if (status === "all" || card.getAttribute("data-status") === status) {
                            card.style.display = "block";
                        } else {
                            card.style.display = "none";
                        }
                    });

                    // Check if any bookings are visible
                    checkEmptyState();
                });
            });

            // Search functionality
            searchInput.addEventListener("input", function() {
                const searchTerm = this.value.toLowerCase().trim();
                const bookingCards = document.querySelectorAll(".booking-card");

                bookingCards.forEach((card) => {
                    const orderNumber = card.querySelector("h3").textContent.toLowerCase();
                    const productName = card.querySelector(".item-details h4").textContent.toLowerCase();

                    if (orderNumber.includes(searchTerm) || productName.includes(searchTerm)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });

                // Check if any bookings are visible
                checkEmptyState();
            });

            // Display bookings from cart
            function displayBookings() {
                // Clear existing bookings
                bookingsList.innerHTML = '';

                if (cart.length === 0) {
                    // Show empty state
                    const emptyState = document.createElement("div");
                    emptyState.className = "empty-state";
                    emptyState.innerHTML = `
                <img src="/assets/images/empty-orders.svg" alt="No Orders">
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet. Start ordering your favorite drinks!</p>
                <a href="/order" class="btn-primary">Order Now</a>
            `;
                    bookingsList.appendChild(emptyState);
                    return;
                }

                // Sort cart items by date (newest first)
                const sortedCart = [...cart].sort((a, b) => new Date(b.orderDate) - new Date(a.orderDate));

                // Create booking cards for each cart item
                sortedCart.forEach((item, index) => {
                            const orderDate = new Date(item.orderDate);
                            const formattedDate = orderDate.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            const formattedTime = orderDate.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            // Format toppings
                            let toppingsText = "None";
                            if (item.toppings && item.toppings.length > 0) {
                                toppingsText = item.toppings.map(t => t.name).join(", ");
                            }

                            const bookingCard = document.createElement("div");
                            bookingCard.className = "booking-card";
                            bookingCard.setAttribute("data-status", item.status);
                            bookingCard.setAttribute("data-id", item.id);

                            bookingCard.innerHTML = `
                <div class="booking-header">
                    <div class="booking-info">
                        <h3>Order #ORD-${1000 + index}</h3>
                        <p class="booking-date">
                            <i class="fas fa-calendar-alt"></i>
                            ${formattedDate} at ${formattedTime}
                        </p>
                    </div>
                    <div class="booking-status ${item.status}">
                        ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                    </div>
                </div>
                <div class="booking-items">
                    <div class="booking-item">
                        <div class="item-image">
                            <img src="${item.image}" alt="${item.name}">
                        </div>
                        <div class="item-details">
                            <h4>${item.name}</h4>
                            <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                            <p>Toppings: ${toppingsText}</p>
                        </div>
                        <div class="item-price">
                            $${item.totalPrice.toFixed(2)}
                        </div>
                    </div>
                </div>
                <div class="booking-footer">
                    <div class="booking-total">
                        <span>Total:</span>
                        <span class="total-price">$${item.totalPrice.toFixed(2)}</span>
                    </div>
                    <div class="booking-actions">
                        <button class="btn-secondary view-receipt-btn" data-id="${item.id}">
                            <i class="fas fa-receipt"></i>
                            View Receipt
                        </button>
                        ${item.status === "processing" ? `
                            <button class="btn-danger cancel-booking-btn" data-id="${item.id}">
                                <i class="fas fa-times"></i>
                                Cancel
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;
            
            bookingsList.appendChild(bookingCard);
        });
        
        // Add event listeners to buttons
        addButtonEventListeners();
    }
    
    // Add event listeners to buttons
    function addButtonEventListeners() {
        // View receipt buttons
        const viewReceiptButtons = document.querySelectorAll(".view-receipt-btn");
        viewReceiptButtons.forEach(button => {
            button.addEventListener("click", function() {
                const itemId = this.getAttribute("data-id");
                showReceipt(itemId);
            });
        });
        
        // Cancel booking buttons
        const cancelButtons = document.querySelectorAll(".cancel-booking-btn");
        cancelButtons.forEach(button => {
            button.addEventListener("click", function() {
                const itemId = this.getAttribute("data-id");
                cancelBooking(itemId);
            });
        });
    }
    
    // Show receipt
    function showReceipt(itemId) {
        const item = cart.find(item => item.id.toString() === itemId);
        if (!item) return;
        
        // Create receipt overlay
        const receiptOverlay = document.createElement("div");
        receiptOverlay.className = "receipt-overlay";
        
        // Format toppings
        let toppingsHtml = "<p>None</p>";
        if (item.toppings && item.toppings.length > 0) {
            toppingsHtml = item.toppings.map(t => `
                <div class="receipt-item">
                    <span>${t.name}</span>
                    <span>$${t.price.toFixed(2)}</span>
                </div>
            `).join("");
        }
        
        // Format date
        const orderDate = new Date(item.orderDate);
        const formattedDate = orderDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        const formattedTime = orderDate.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        
        receiptOverlay.innerHTML = `
            <div class="receipt-container">
                <button class="close-receipt">&times;</button>
                <div class="receipt">
                    <div class="receipt-header">
                        <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo" class="receipt-logo">
                        <h2>XING FU CHA</h2>
                        <p>Order Receipt</p>
                    </div>
                    
                    <div class="receipt-info">
                        <p><strong>Order #:</strong> ORD-${1000 + cart.indexOf(item)}</p>
                        <p><strong>Date:</strong> ${formattedDate}</p>
                        <p><strong>Time:</strong> ${formattedTime}</p>
                        <p><strong>Status:</strong> <span class="status-${item.status}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span></p>
                    </div>
                    
                    <div class="receipt-divider"></div>
                    
                    <div class="receipt-items">
                        <h3>Order Details</h3>
                        
                        <div class="receipt-item receipt-item-main">
                            <span>${item.name}</span>
                            <span>$${item.basePrice.toFixed(2)}</span>
                        </div>
                        
                        <div class="receipt-item-options">
                            <p><strong>Size:</strong> ${item.size.name} ${item.size.price > 0 ? `(+$${item.size.price.toFixed(2)})` : ''}</p>
                            <p><strong>Sugar:</strong> ${item.sugar.name}</p>
                            <p><strong>Ice:</strong> ${item.ice.name}</p>
                        </div>
                        
                        <div class="receipt-section">
                            <h4>Toppings</h4>
                            ${toppingsHtml}
                        </div>
                    </div>
                    
                    <div class="receipt-divider"></div>
                    
                    <div class="receipt-total">
                        <div class="receipt-item">
                            <span>Subtotal</span>
                            <span>$${item.totalPrice.toFixed(2)}</span>
                        </div>
                        <div class="receipt-item">
                            <span>Tax</span>
                            <span>$${(item.totalPrice * 0.08).toFixed(2)}</span>
                        </div>
                        <div class="receipt-item receipt-grand-total">
                            <span>Total</span>
                            <span>$${(item.totalPrice * 1.08).toFixed(2)}</span>
                        </div>
                    </div>
                    
                    <div class="receipt-footer">
                        <p>Thank you for your order!</p>
                        <p>Visit us again soon.</p>
                        <div class="receipt-barcode">
                            <div class="barcode-line"></div>
                            <div class="barcode-line"></div>
                            <div class="barcode-line"></div>
                            <div class="barcode-line"></div>
                            <div class="barcode-line"></div>
                            <div class="barcode-line"></div>
                            <div class="barcode-line"></div>
                            <div class="barcode-line"></div>
                        </div>
                        <p class="receipt-id">Receipt ID: XFC-${Date.now().toString().slice(-8)}</p>
                    </div>
                    
                    <div class="receipt-actions">
                        <button class="btn-primary print-receipt">
                            <i class="fas fa-print"></i> Print Receipt
                        </button>
                        <button class="btn-secondary download-receipt">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(receiptOverlay);
        
        // Add close button functionality
        const closeButton = receiptOverlay.querySelector(".close-receipt");
        closeButton.addEventListener("click", () => {
            receiptOverlay.remove();
        });
        
        // Add print functionality
        const printButton = receiptOverlay.querySelector(".print-receipt");
        printButton.addEventListener("click", () => {
            window.print();
        });
        
        // Add download functionality (simplified)
        const downloadButton = receiptOverlay.querySelector(".download-receipt");
        downloadButton.addEventListener("click", () => {
            alert("Download functionality would be implemented here in a real application.");
        });
        
        // Add CSS for receipt
        const style = document.createElement('style');
        style.textContent = `
            .receipt-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                animation: fadeIn 0.3s ease;
            }
            
            .receipt-container {
                position: relative;
                max-width: 400px;
                width: 100%;
                max-height: 90vh;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                overflow-y: auto;
                animation: slideUp 0.3s ease;
            }
            
            .receipt {
                padding: 20px;
            }
            
            .close-receipt {
                position: absolute;
                top: 10px;
                right: 10px;
                background: none;
                border: none;
                font-size: 24px;
                cursor: pointer;
                color: #333;
                z-index: 1;
            }
            
            .receipt-header {
                text-align: center;
                margin-bottom: 20px;
            }
            
            .receipt-logo {
                width: 60px;
                height: 60px;
                margin-bottom: 10px;
            }
            
            .receipt-header h2 {
                margin: 0;
                color: #333;
                font-size: 24px;
            }
            
            .receipt-header p {
                margin: 5px 0 0;
                color: #666;
                font-size: 14px;
            }
            
            .receipt-info {
                margin-bottom: 20px;
            }
            
            .receipt-info p {
                margin: 5px 0;
                font-size: 14px;
            }
            
            .receipt-divider {
                height: 1px;
                background-color: #ddd;
                margin: 15px 0;
            }
            
            .receipt-items h3 {
                margin: 0 0 10px;
                font-size: 18px;
            }
            
            .receipt-item {
                display: flex;
                justify-content: space-between;
                margin: 5px 0;
                font-size: 14px;
            }
            
            .receipt-item-main {
                font-weight: bold;
                font-size: 16px;
                margin-bottom: 5px;
            }
            
            .receipt-item-options {
                margin-left: 15px;
                margin-bottom: 15px;
                font-size: 13px;
            }
            
            .receipt-item-options p {
                margin: 3px 0;
            }
            
            .receipt-section h4 {
                margin: 10px 0 5px;
                font-size: 16px;
            }
            
            .receipt-total {
                margin-top: 10px;
            }
            
            .receipt-grand-total {
                font-weight: bold;
                font-size: 16px;
                margin-top: 5px;
                padding-top: 5px;
                border-top: 1px dashed #ddd;
            }
            
            .receipt-footer {
                text-align: center;
                margin-top: 20px;
                font-size: 14px;
            }
            
            .receipt-footer p {
                margin: 5px 0;
            }
            
            .receipt-barcode {
                display: flex;
                justify-content: space-between;
                margin: 15px auto;
                width: 80%;
                height: 40px;
            }
            
            .barcode-line {
                width: 2px;
                height: 100%;
                background-color: #333;
            }
            
            .receipt-id {
                font-size: 12px;
                color: #999;
            }
            
            .receipt-actions {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }
            
            .receipt-actions button {
                flex: 1;
                margin: 0 5px;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .receipt-actions button i {
                margin-right: 5px;
            }
            
            .btn-primary {
                background-color: #ff6b6b;
                color: white;
            }
            
            .btn-secondary {
                background-color: #f5f5f5;
                color: #333;
                border: 1px solid #ddd;
            }
            
            .status-processing {
                color: #ff9800;
            }
            
            .status-completed {
                color: #4caf50;
            }
            
            .status-cancelled {
                color: #f44336;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            @keyframes slideUp {
                from { transform: translateY(50px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            
            @media print {
                body * {
                    visibility: hidden;
                }
                
                .receipt-container, .receipt-container * {
                    visibility: visible;
                }
                
                .receipt-container {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    box-shadow: none;
                }
                
                .receipt-actions, .close-receipt {
                    display: none;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Cancel booking
    function cancelBooking(itemId) {
        // Show confirmation dialog
        if (confirm("Are you sure you want to cancel this order?")) {
            // Find the item in the cart
            const itemIndex = cart.findIndex(item => item.id.toString() === itemId);
            if (itemIndex === -1) return;
            
            // Update status
            cart[itemIndex].status = "cancelled";
            
            // Save to localStorage
            localStorage.setItem("cart", JSON.stringify(cart));
            
            // Update UI
            const bookingCard = document.querySelector(`.booking-card[data-id="${itemId}"]`);
            if (bookingCard) {
                const statusElement = bookingCard.querySelector(".booking-status");
                statusElement.textContent = "Cancelled";
                statusElement.className = "booking-status cancelled";
                
                // Remove cancel button
                const cancelButton = bookingCard.querySelector(".cancel-booking-btn");
                if (cancelButton) cancelButton.remove();
                
                // Update data-status attribute
                bookingCard.setAttribute("data-status", "cancelled");
            }
            
            // Show toast notification
            showToast("Order Cancelled", "Your order has been cancelled successfully.", "success");
        }
    }
    
    // Check if any bookings are visible and show empty state if needed
    function checkEmptyState() {
        const bookingCards = document.querySelectorAll(".booking-card");
        let visibleCount = 0;

        bookingCards.forEach((card) => {
            if (card.style.display !== "none") {
                visibleCount++;
            }
        });

        // Get or create empty state element
        let emptyState = document.querySelector(".empty-state");

        if (visibleCount === 0) {
            if (!emptyState) {
                emptyState = document.createElement("div");
                emptyState.className = "empty-state";
                emptyState.innerHTML = `
                    <img src="/assets/images/empty-orders.svg" alt="No Orders">
                    <h3>No Orders Found</h3>
                    <p>No orders match your current filter. Try changing your search or filter criteria.</p>
                    <a href="/order" class="btn-primary">Order Now</a>
                `;
                bookingsList.appendChild(emptyState);
            } else {
                emptyState.style.display = "block";
            }
        } else if (emptyState) {
            emptyState.style.display = "none";
        }
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        const toast = document.createElement("div");
        toast.className = "toast";

        let icon = "info-circle";
        if (type === "success") {
            icon = "check-circle";
            toast.style.borderLeftColor = "#4caf50";
        } else if (type === "error") {
            icon = "exclamation-circle";
            toast.style.borderLeftColor = "#f44336";
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
        `;

        // Add to container
        toastContainer.appendChild(toast);

        // Add close button functionality
        const closeButton = toast.querySelector(".toast-close");
        closeButton.addEventListener("click", () => {
            toast.remove();
        });

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }

    // Add CSS for booking page
    const style = document.createElement('style');
    style.textContent = `
        .booking-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .item-image {
            width: 60px;
            height: 60px;
            margin-right: 15px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .booking-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
        }
        
        .btn-danger {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            margin-left: 10px;
        }
        
        .btn-danger i {
            margin-right: 5px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-state img {
            width: 150px;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #666;
            margin-bottom: 20px;
        }
    `;
    document.head.appendChild(style);
});