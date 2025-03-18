// Updated booking.js with improved receipt functionality
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const filterTabs = document.querySelectorAll(".filter-tab")
    const bookingsList = document.querySelector(".bookings-list")
    const searchInput = document.getElementById("bookingSearch")
    const ctaButton = document.querySelector(".cta-button")

    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById("toastContainer")
    if (!toastContainer) {
        toastContainer = document.createElement("div")
        toastContainer.id = "toastContainer"
        toastContainer.className = "toast-container"
        document.body.appendChild(toastContainer)
    }

    // Load cart items from localStorage
    const cart = JSON.parse(localStorage.getItem("cart")) || []

    // Display cart items as bookings
    displayBookings()

    // Add event listener to CTA button
    if (ctaButton) {
        ctaButton.addEventListener("click", () => {
            window.location.href = "/order"
        })
    }

    // Filter bookings by status
    filterTabs.forEach((tab) => {
        tab.addEventListener("click", function() {
            // Remove active class from all tabs
            filterTabs.forEach((t) => t.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            const status = this.getAttribute("data-status")

            // Filter bookings
            const bookingCards = document.querySelectorAll(".booking-card")
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
        const bookingCards = document.querySelectorAll(".booking-card")

        bookingCards.forEach((card) => {
            const orderNumber = card.querySelector("h3").textContent.toLowerCase()
            const productName = card.querySelector(".item-details h4")?.textContent.toLowerCase() || ""

            if (orderNumber.includes(searchTerm) || productName.includes(searchTerm)) {
                card.style.display = "block"
            } else {
                card.style.display = "none"
            }
        })

        // Check if any bookings are visible
        checkEmptyState()
    })

    // Display bookings from cart
    function displayBookings() {
        // Clear existing bookings
        bookingsList.innerHTML = ""

        if (cart.length === 0) {
            // Show empty state
            const emptyState = document.createElement("div")
            emptyState.className = "empty-state"
            emptyState.innerHTML = `
                <img src="/assets/image/empty-orders.svg" alt="No Orders" onerror="this.src='/assets/image/logo/logo.png'; this.style.opacity='0.3';">
                <h3>No Orders Yet</h3>
                <p>You haven't placed any orders yet. Start ordering your favorite drinks!</p>
                <a href="/order" class="btn-primary">Order Now</a>
            `
            bookingsList.appendChild(emptyState)
            return
        }

        // Sort cart items by date (newest first)
        const sortedCart = [...cart].sort((a, b) => new Date(b.orderDate) - new Date(a.orderDate))

        // Create booking cards for each cart item
        sortedCart.forEach((item, index) => {
            const orderDate = new Date(item.orderDate)
            const formattedDate = orderDate.toLocaleDateString("en-US", {
                year: "numeric",
                month: "long",
                day: "numeric",
            })
            const formattedTime = orderDate.toLocaleTimeString("en-US", {
                hour: "2-digit",
                minute: "2-digit",
            })

            // Format toppings
            let toppingsText = "None"
            if (item.toppings && item.toppings.length > 0) {
                toppingsText = item.toppings.map((t) => t.name).join(", ")
            }

            const bookingCard = document.createElement("div")
            bookingCard.className = "booking-card"
            bookingCard.setAttribute("data-status", item.status || "processing")
            bookingCard.setAttribute("data-id", item.id)

            bookingCard.innerHTML = `
                <div class="booking-header">
                    <div class="booking-info">
                        <h3>Order #ORD-${1000 + index}</h3>
                        <p class="booking-date">
                            <i class="fas fa-calendar-alt"></i>
                            ${formattedDate} at ${formattedTime}
                        </p>
                    </div>
                    <div class="booking-status ${item.status || "processing"}">
                        ${(item.status || "processing").charAt(0).toUpperCase() + (item.status || "processing").slice(1)}
                    </div>
                </div>
                <div class="booking-items">
                    <div class="booking-item">
                        <div class="item-image">
                            <img src="${item.image}" alt="${item.name}" onerror="this.src='/assets/image/logo/logo.png'">
                        </div>
                        <div class="item-details">
                            <h4>${item.name}</h4>
                            <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                            <p>Toppings: ${toppingsText}</p>
                            <p>Quantity: <strong>${item.quantity}</strong></p>
                        </div>
                        <div class="item-price">
                            <div class="item-unit-price">$${(item.basePrice || 0).toFixed(2)} × ${item.quantity}</div>
                            <div class="item-total-price">$${(item.totalPrice || 0).toFixed(2)}</div>
                        </div>
                    </div>
                </div>
                <div class="booking-footer">
                    <div class="booking-total">
                        <span>Total:</span>
                        <span class="total-price">$${(item.totalPrice || 0).toFixed(2)}</span>
                    </div>
                    <div class="booking-actions">
                        <button class="btn-secondary view-receipt-btn" data-id="${item.id}">
                            <i class="fas fa-receipt"></i>
                            View Receipt
                        </button>
                        ${
                            (item.status || "processing") === "processing"
                            ? `
                            <button class="btn-danger cancel-booking-btn" data-id="${item.id}">
                                <i class="fas fa-times"></i>
                                Cancel
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
        addButtonEventListeners()
    }
    
    // Add event listeners to buttons
    function addButtonEventListeners() {
        // View receipt buttons
        const viewReceiptButtons = document.querySelectorAll(".view-receipt-btn")
        viewReceiptButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const itemId = this.getAttribute("data-id")
                showReceipt(itemId)
            })
        })
        
        // Cancel booking buttons
        const cancelButtons = document.querySelectorAll(".cancel-booking-btn")
        cancelButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const itemId = this.getAttribute("data-id")
                cancelBooking(itemId)
            })
        })
    }
    
    // Show receipt with improved styling and animations
    function showReceipt(itemId) {
        const item = cart.find((item) => item.id.toString() === itemId)
        if (!item) return
        
        // Create receipt overlay
        const receiptOverlay = document.createElement("div")
        receiptOverlay.className = "receipt-overlay"
        
        // Format toppings
        let toppingsHtml = "<p>None</p>"
        let toppingsTotal = 0
        if (item.toppings && item.toppings.length > 0) {
            toppingsHtml = item.toppings
                .map((t) => {
                    toppingsTotal += t.price || 0
                    return `
                        <div class="receipt-item">
                            <span>${t.name}</span>
                            <span>$${(t.price || 0).toFixed(2)}</span>
                        </div>
                    `
                })
                .join("")
        }
        
        // Format date
        const orderDate = new Date(item.orderDate)
        const formattedDate = orderDate.toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric",
        })
        const formattedTime = orderDate.toLocaleTimeString("en-US", {
            hour: "2-digit",
            minute: "2-digit",
        })
        
        // Calculate tax and total
        const subtotal = item.totalPrice || 0
        const tax = subtotal * 0.08
        const total = subtotal + tax
        
        // Generate random receipt ID
        const receiptId = `XFC-${Date.now().toString().slice(-8)}`
        
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
                        <div class="receipt-info-row">
                            <div class="receipt-info-col">
                                <p><strong>Order #:</strong> ORD-${cart.indexOf(item) + 1000}</p>
                                <p><strong>Date:</strong> ${formattedDate}</p>
                                <p><strong>Time:</strong> ${formattedTime}</p>
                            </div>
                            <div class="receipt-info-col">
                                <p><strong>Status:</strong> <span class="status-${item.status || "processing"}">${(item.status || "processing").charAt(0).toUpperCase() + (item.status || "processing").slice(1)}</span></p>
                                <p><strong>Payment:</strong> Credit Card</p>
                                <p><strong>Receipt ID:</strong> ${receiptId}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="receipt-divider"></div>
                    
                    <div class="receipt-items">
                        <h3>Order Details</h3>
                        
                        <div class="receipt-item receipt-item-main">
                            <span>${item.name} × ${item.quantity}</span>
                            <span>$${((item.basePrice || 0) * item.quantity).toFixed(2)}</span>
                        </div>
                        
                        <div class="receipt-item-options">
                            <p><strong>Size:</strong> ${item.size.name} ${item.size.price > 0 ? `(+$${item.size.price.toFixed(2)})` : ""}</p>
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
                            <span>$${subtotal.toFixed(2)}</span>
                        </div>
                        <div class="receipt-item">
                            <span>Tax (8%)</span>
                            <span>$${tax.toFixed(2)}</span>
                        </div>
                        <div class="receipt-item receipt-grand-total">
                            <span>Total</span>
                            <span>$${total.toFixed(2)}</span>
                        </div>
                    </div>
                    
                    <div class="receipt-footer">
                        <div class="receipt-thank-you">
                            <p>Thank you for your order!</p>
                            <p>Visit us again soon.</p>
                        </div>
                        
                        <div class="receipt-barcode">
                            <div class="barcode-lines">
                                ${Array(12).fill().map(() => `<div class="barcode-line" style="height: ${Math.floor(Math.random() * 30) + 20}px"></div>`).join('')}
                            </div>
                            <p class="barcode-number">${receiptId}</p>
                        </div>
                        
                        <div class="receipt-contact">
                            <p>123 Bubble Tea Street, Tea City</p>
                            <p>Tel: (123) 456-7890</p>
                            <p>www.xingfucha.com</p>
                        </div>
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
        `
        
        document.body.appendChild(receiptOverlay)
        
        // Add animation class after a small delay for the animation to work
        setTimeout(() => {
            receiptOverlay.classList.add("active")
        }, 10)
        
        // Add close button functionality
        const closeButton = receiptOverlay.querySelector(".close-receipt")
        closeButton.addEventListener("click", () => {
            receiptOverlay.classList.remove("active")
            setTimeout(() => {
                receiptOverlay.remove()
            }, 300)
        })
        
        // Add print functionality
        const printButton = receiptOverlay.querySelector(".print-receipt")
        printButton.addEventListener("click", () => {
            window.print()
        })
        
        // Add download functionality (simplified)
        const downloadButton = receiptOverlay.querySelector(".download-receipt")
        downloadButton.addEventListener("click", () => {
            // Create a PDF-like image of the receipt
            showToast("Download Started", "Your receipt is being prepared for download.", "success")
            
            // In a real app, you would use a library like html2canvas or jsPDF
            setTimeout(() => {
                showToast("Download Complete", "Your receipt has been downloaded successfully.", "success")
            }, 1500)
        })
        
        // Add CSS for receipt
        if (!document.querySelector("#receipt-styles")) {
            const style = document.createElement("style")
            style.id = "receipt-styles"
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
                    opacity: 0;
                    visibility: hidden;
                    transition: opacity 0.3s ease, visibility 0.3s ease;
                }
                
                .receipt-overlay.active {
                    opacity: 1;
                    visibility: visible;
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
                    transform: translateY(30px);
                    opacity: 0;
                    transition: transform 0.3s ease, opacity 0.3s ease;
                }
                
                .receipt-overlay.active .receipt-container {
                    transform: translateY(0);
                    opacity: 1;
                }
                
                .receipt {
                    padding: 20px;
                    background-color: #fff;
                    background-image: 
                        radial-gradient(#f5f5f5 1px, transparent 1px),
                        radial-gradient(#f5f5f5 1px, transparent 1px);
                    background-size: 20px 20px;
                    background-position: 0 0, 10px 10px;
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
                    transition: transform 0.3s ease;
                }
                
                .close-receipt:hover {
                    transform: rotate(90deg);
                }
                
                .receipt-header {
                    text-align: center;
                    margin-bottom: 20px;
                    padding-bottom: 15px;
                    border-bottom: 2px dashed #eee;
                }
                
                .receipt-logo {
                    width: 70px;
                    height: 70px;
                    margin-bottom: 10px;
                    border-radius: 50%;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
                    padding: 5px;
                    background-color: white;
                }
                
                .receipt-header h2 {
                    margin: 0;
                    color: #ff5e62;
                    font-size: 28px;
                    font-weight: 700;
                    letter-spacing: 1px;
                }
                
                .receipt-header p {
                    margin: 5px 0 0;
                    color: #666;
                    font-size: 16px;
                    font-weight: 500;
                }
                
                .receipt-info {
                    margin-bottom: 20px;
                }
                
                .receipt-info-row {
                    display: flex;
                    justify-content: space-between;
                }
                
                .receipt-info-col {
                    flex: 1;
                }
                
                .receipt-info p {
                    margin: 5px 0;
                    font-size: 14px;
                    color: #555;
                }
                
                .receipt-divider {
                    height: 2px;
                    background-image: linear-gradient(to right, #ddd 50%, transparent 50%);
                    background-size: 10px 1px;
                    background-repeat: repeat-x;
                    margin: 15px 0;
                }
                
                .receipt-items h3 {
                    margin: 0 0 15px;
                    font-size: 18px;
                    color: #333;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                
                .receipt-item {
                    display: flex;
                    justify-content: space-between;
                    margin: 8px 0;
                    font-size: 14px;
                    color: #555;
                }
                
                .receipt-item-main {
                    font-weight: bold;
                    font-size: 16px;
                    margin-bottom: 5px;
                    color: #333;
                }
                
                .receipt-item-options {
                    margin-left: 15px;
                    margin-bottom: 15px;
                    font-size: 13px;
                    background-color: #f9f9f9;
                    padding: 10px;
                    border-radius: 5px;
                    border-left: 3px solid #ff5e62;
                }
                
                .receipt-item-options p {
                    margin: 5px 0;
                    color: #666;
                }
                
                .receipt-section h4 {
                    margin: 15px 0 10px;
                    font-size: 16px;
                    color: #333;
                    font-weight: 600;
                }
                
                .receipt-total {
                    margin-top: 15px;
                    background-color: #f9f9f9;
                    padding: 15px;
                    border-radius: 5px;
                }
                
                .receipt-grand-total {
                    font-weight: bold;
                    font-size: 18px;
                    margin-top: 10px;
                    padding-top: 10px;
                    border-top: 2px dashed #ddd;
                    color: #ff5e62;
                }
                
                .receipt-footer {
                    text-align: center;
                    margin-top: 25px;
                    padding-top: 15px;
                    border-top: 2px dashed #eee;
                }
                
                .receipt-thank-you {
                    margin-bottom: 15px;
                }
                
                .receipt-thank-you p {
                    margin: 5px 0;
                    font-size: 14px;
                    color: #555;
                }
                
                .receipt-thank-you p:first-child {
                    font-weight: 600;
                    font-size: 16px;
                    color: #333;
                }
                
                .receipt-barcode {
                    margin: 20px auto;
                    width: 80%;
                }
                
                .barcode-lines {
                    display: flex;
                    justify-content: space-between;
                    height: 50px;
                    margin-bottom: 5px;
                }
                
                .barcode-line {
                    width: 2px;
                    background-color: #333;
                }
                
                .barcode-number {
                    font-size: 12px;
                    color: #999;
                    letter-spacing: 2px;
                }
                
                .receipt-contact {
                    margin-top: 15px;
                    font-size: 12px;
                    color: #999;
                }
                
                .receipt-contact p {
                    margin: 3px 0;
                }
                
                .receipt-actions {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 25px;
                }
                
                .receipt-actions button {
                    flex: 1;
                    margin: 0 5px;
                    padding: 12px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 14px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.3s ease;
                }
                
                .receipt-actions button i {
                    margin-right: 5px;
                }
                
                .btn-primary {
                    background-color: #ff5e62;
                    color: white;
                }
                
                .btn-primary:hover {
                    background-color: #ff4146;
                    transform: translateY(-2px);
                    box-shadow: 0 5px 10px rgba(255, 94, 98, 0.3);
                }
                
                .btn-secondary {
                    background-color: #f5f5f5;
                    color: #333;
                    border: 1px solid #ddd;
                }
                
                .btn-secondary:hover {
                    background-color: #e5e5e5;
                    transform: translateY(-2px);
                    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                }
                
                .status-processing {
                    color: #ff9800;
                    font-weight: 600;
                }
                
                .status-completed {
                    color: #4caf50;
                    font-weight: 600;
                }
                
                .status-cancelled {
                    color: #f44336;
                    font-weight: 600;
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
            `
            document.head.appendChild(style)
        }
    }
    
    // Cancel booking
    function cancelBooking(itemId) {
        // Show confirmation dialog
        if (confirm("Are you sure you want to cancel this order?")) {
            // Find the item in the cart
            const itemIndex = cart.findIndex((item) => item.id.toString() === itemId)
            if (itemIndex === -1) return
            
            // Update status
            cart[itemIndex].status = "cancelled"
            
            // Save to localStorage
            localStorage.setItem("cart", JSON.stringify(cart))
            
            // Update UI
            const bookingCard = document.querySelector(`.booking-card[data-id="${itemId}"]`)
            if (bookingCard) {
                const statusElement = bookingCard.querySelector(".booking-status")
                statusElement.textContent = "Cancelled"
                statusElement.className = "booking-status cancelled"
                
                // Remove cancel button
                const cancelButton = bookingCard.querySelector(".cancel-booking-btn")
                if (cancelButton) cancelButton.remove()
                
                // Update data-status attribute
                bookingCard.setAttribute("data-status", "cancelled")
            }
            
            // Show toast notification
            showToast("Order Cancelled", "Your order has been cancelled successfully.", "success")
        }
    }
    
    // Check if any bookings are visible and show empty state if needed
    function checkEmptyState() {
        const bookingCards = document.querySelectorAll(".booking-card")
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
                    <img src="/assets/images/empty-orders.svg" alt="No Orders" onerror="this.src='/assets/image/logo/logo.png'; this.style.opacity='0.3';">
                    <h3>No Orders Found</h3>
                    <p>No orders match your current filter. Try changing your search or filter criteria.</p>
                    <a href="/order" class="btn-primary">Order Now</a>
                `
                bookingsList.appendChild(emptyState)
            } else {
                emptyState.style.display = "block"
            }
        } else if (emptyState) {
            emptyState.style.display = "none"
        }
    }
    
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
        setTimeout(() => {
            toast.style.opacity = "0"
            setTimeout(() => {
                toast.remove()
            }, 300)
        }, 5000)
    }
    
    // Add CSS for booking page
    const style = document.createElement("style")
    style.textContent = `
        .booking-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s0,0,0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .booking-info h3 {
            margin: 0 0 5px;
            font-size: 18px;
            color: #333;
        }
        
        .booking-date {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .booking-date i {
            margin-right: 5px;
            color: #ff5e62;
        }
        
        .booking-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .booking-status.processing {
            background-color: #fff3e0;
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
            padding: 15px;
        }
        
        .booking-item {
            display: flex;
            align-items: center;
        }
        
        .item-image {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 15px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }
        
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-details h4 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #333;
        }
        
        .item-details p {
            margin: 3px 0;
            font-size: 14px;
            color: #666;
        }
        
        .item-price {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-left: 15px;
        }
        
        .item-unit-price {
            font-size: 14px;
            color: #666;
        }
        
        .item-total-price {
            font-weight: bold;
            font-size: 16px;
            color: #ff5e62;
            margin-top: 5px;
        }
        
        .booking-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
        }
        
        .booking-total {
            font-size: 16px;
            color: #333;
        }
        
        .total-price {
            font-weight: bold;
            color: #ff5e62;
            margin-left: 5px;
        }
        
        .booking-actions {
            display: flex;
        }
        
        .booking-actions button {
            margin-left: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .booking-actions button i {
            margin-right: 5px;
        }
        
        .btn-secondary {
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .btn-secondary:hover {
            background-color: #e5e5e5;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-danger {
            background-color: #ffebee;
            color: #f44336;
            border: 1px solid #ffcdd2;
        }
        
        .btn-danger:hover {
            background-color: #f44336;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(244, 67, 54, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .empty-state img {
            width: 150px;
            margin-bottom: 20px;
            opacity: 0.7;
        }
        
        .empty-state h3 {
            margin: 0 0 10px;
            color: #333;
            font-size: 22px;
        }
        
        .empty-state p {
            margin: 0 0 20px;
            color: #666;
            font-size: 16px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-primary {
            display: inline-block;
            background-color: #ff5e62;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background-color: #ff4146;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 94, 98, 0.3);
        }
        
        /* Toast notifications */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            display: flex;
            align-items: center;
            background-color: white;
            border-left: 4px solid #ff5e62;
            border-radius: 4px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            padding: 15px;
            min-width: 300px;
            max-width: 400px;
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        
        .toast h4 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #333;
        }
        
        .toast p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
        }
    `
    document.head.appendChild(style)
})