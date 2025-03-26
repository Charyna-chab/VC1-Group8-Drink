// receipt.js - Handles receipt functionality
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const printReceiptBtn = document.getElementById("print-receipt")
    const receiptOrderNumber = document.getElementById("receipt-order-number")
    const receiptDate = document.getElementById("receipt-date")
    const receiptPaymentMethod = document.getElementById("receipt-payment-method")
    const receiptStatus = document.getElementById("receipt-status")
    const receiptItemsList = document.getElementById("receipt-items-list")
    const receiptSubtotal = document.getElementById("receipt-subtotal")
    const receiptTax = document.getElementById("receipt-tax")
    const receiptTotal = document.getElementById("receipt-total")

    // Get order ID from URL
    const urlParams = new URLSearchParams(window.location.search)
    const orderId = urlParams.get("order_id")

    // Load receipt data
    if (orderId) {
        loadReceiptData(orderId)
    }

    // Print receipt
    if (printReceiptBtn) {
        printReceiptBtn.addEventListener("click", printReceipt)
    }

    // Load receipt data from localStorage
    function loadReceiptData(orderId) {
        const bookings = JSON.parse(localStorage.getItem("bookings")) || []
        const booking = bookings.find((b) => b.id === orderId)

        if (!booking) {
            showError("Order not found")
            return
        }

        // Format date
        const date = new Date(booking.date)
        const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString()

        // Update receipt info
        if (receiptOrderNumber) receiptOrderNumber.textContent = "#" + booking.id
        if (receiptDate) receiptDate.textContent = formattedDate
        if (receiptPaymentMethod) {
            const paymentMethod = booking.paymentMethod || "Not specified"
            let formattedPaymentMethod = "Unknown"

            switch (paymentMethod) {
                case "card":
                    formattedPaymentMethod = "Credit/Debit Card"
                    break
                case "qr":
                    formattedPaymentMethod = "QR Code Payment"
                    break
                case "cash":
                    formattedPaymentMethod = "Cash on Delivery"
                    break
                default:
                    formattedPaymentMethod = paymentMethod
            }

            receiptPaymentMethod.textContent = formattedPaymentMethod
        }

        if (receiptStatus) {
            const status = booking.status || "processing"
            let statusClass = ""

            switch (status) {
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

            receiptStatus.textContent = status.charAt(0).toUpperCase() + status.slice(1)
            receiptStatus.className = statusClass
        }

        // Render items
        if (receiptItemsList && booking.items) {
            receiptItemsList.innerHTML = ""

            booking.items.forEach((item) => {
                const itemElement = document.createElement("div")
                itemElement.className = "receipt-item"

                // Format toppings
                let toppingsText = "None"
                if (item.toppings && item.toppings.length > 0) {
                    toppingsText = item.toppings.map((t) => t.name).join(", ")
                }

                itemElement.innerHTML = `
                    <div class="receipt-item-details">
                        <h5>${item.name} <span class="receipt-item-quantity">x${item.quantity}</span></h5>
                        <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                        <p>Toppings: ${toppingsText}</p>
                    </div>
                    <div class="receipt-item-price">
                        $${item.totalPrice.toFixed(2)}
                    </div>
                `

                receiptItemsList.appendChild(itemElement)
            })
        }

        // Update totals
        if (receiptSubtotal) receiptSubtotal.textContent = "$" + booking.subtotal.toFixed(2)
        if (receiptTax) receiptTax.textContent = "$" + booking.tax.toFixed(2)
        if (receiptTotal) receiptTotal.textContent = "$" + booking.total.toFixed(2)
    }

    // Print receipt
    function printReceipt() {
        const printContent = document.getElementById("receipt-printable")

        if (!printContent) return

        // Create a new window for printing
        const printWindow = window.open("", "_blank")

        // Add print styles
        const printStyles = `
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                }
                
                .receipt-container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                }
                
                .receipt-brand {
                    text-align: center;
                    margin-bottom: 20px;
                }
                
                .receipt-logo {
                    max-width: 100px;
                    height: auto;
                }
                
                .receipt-brand h3 {
                    margin: 10px 0 5px;
                    font-size: 24px;
                }
                
                .receipt-brand p {
                    margin: 0;
                    color: #666;
                }
                
                .receipt-info {
                    margin-bottom: 20px;
                }
                
                .receipt-info-item {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 5px;
                }
                
                .receipt-divider {
                    border-top: 1px dashed #ddd;
                    margin: 15px 0;
                }
                
                .receipt-items h4 {
                    margin: 0 0 10px;
                }
                
                .receipt-item {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 10px;
                    padding-bottom: 10px;
                    border-bottom: 1px solid #eee;
                }
                
                .receipt-item:last-child {
                    border-bottom: none;
                }
                
                .receipt-item-details {
                    flex: 1;
                }
                
                .receipt-item-details h5 {
                    margin: 0 0 5px;
                    font-size: 16px;
                }
                
                .receipt-item-quantity {
                    font-weight: normal;
                    color: #666;
                }
                
                .receipt-item-details p {
                    margin: 0;
                    font-size: 14px;
                    color: #666;
                }
                
                .receipt-item-price {
                    font-weight: bold;
                    min-width: 80px;
                    text-align: right;
                }
                
                .receipt-summary {
                    margin-top: 20px;
                }
                
                .receipt-summary-item {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 5px;
                }
                
                .receipt-summary-item.total {
                    font-weight: bold;
                    font-size: 18px;
                    border-top: 1px solid #ddd;
                    padding-top: 10px;
                    margin-top: 10px;
                }
                
                .receipt-footer {
                    margin-top: 30px;
                    text-align: center;
                    font-size: 14px;
                    color: #666;
                }
                
                .receipt-footer p {
                    margin: 5px 0;
                }
                
                @media print {
                    body {
                        padding: 0;
                    }
                    
                    .receipt-container {
                        border: none;
                        padding: 0;
                    }
                }
            </style>
        `

        // Write to the new window
        printWindow.document.write("<html><head><title>Order Receipt</title>")
        printWindow.document.write(printStyles)
        printWindow.document.write("</head><body>")
        printWindow.document.write('<div class="receipt-container">')
        printWindow.document.write(printContent.innerHTML)
        printWindow.document.write("</div>")
        printWindow.document.write("</body></html>")

        printWindow.document.close()
        printWindow.focus()

        // Print after content is loaded
        printWindow.onload = () => {
            printWindow.print()
            printWindow.close()
        }
    }

    // Show error message
    function showError(message) {
        if (receiptItemsList) {
            receiptItemsList.innerHTML = `
                <div class="receipt-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>${message}</p>
                </div>
            `
        }
    }

    // Add CSS for receipt
    const style = document.createElement("style")
    style.textContent = `
        .receipt-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin: 20px auto;
            max-width: 800px;
            overflow: hidden;
        }
        
        .receipt-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            position: relative;
        }
        
        .receipt-header h2 {
            margin: 0 0 5px;
            font-size: 24px;
            color: #333;
        }
        
        .receipt-header p {
            margin: 0;
            font-size: 16px;
            color: #666;
        }
        
        .receipt-actions {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }
        
        .receipt-content {
            padding: 20px;
        }
        
        .receipt-brand {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .receipt-logo {
            max-width: 100px;
            height: auto;
        }
        
        .receipt-brand h3 {
            margin: 10px 0 5px;
            font-size: 24px;
        }
        
        .receipt-brand p {
            margin: 0;
            color: #666;
        }
        
        .receipt-info {
            margin-bottom: 20px;
        }
        
        .receipt-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .receipt-divider {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }
        
        .receipt-items h4 {
            margin: 0 0 10px;
        }
        
        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .receipt-item:last-child {
            border-bottom: none;
        }
        
        .receipt-item-details {
            flex: 1;
        }
        
        .receipt-item-details h5 {
            margin: 0 0 5px;
            font-size: 16px;
        }
        
        .receipt-item-quantity {
            font-weight: normal;
            color: #666;
        }
        
        .receipt-item-details p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .receipt-item-price {
            font-weight: bold;
            min-width: 80px;
            text-align: right;
        }
        
        .receipt-summary {
            margin-top: 20px;
        }
        
        .receipt-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .receipt-summary-item.total {
            font-weight: bold;
            font-size: 18px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .receipt-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        
        .receipt-footer p {
            margin: 5px 0;
        }
        
        .receipt-loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        
        .receipt-error {
            text-align: center;
            padding: 20px;
            color: #f44336;
        }
        
        .receipt-error i {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .btn-outline {
            padding: 8px 15px;
            background-color: transparent;
            color: #ff5e62;
            border: 1px solid #ff5e62;
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
        
        .btn-outline:hover {
            background-color: #fff0f0;
        }
        
        /* Status colors */
        .processing {
            color: #ff9800;
        }
        
        .completed {
            color: #4caf50;
        }
        
        .cancelled {
            color: #f44336;
        }
        
        @media print {
            .receipt-actions {
                display: none;
            }
            
            .receipt-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }
            
            .receipt-header {
                border-bottom: 1px solid #000;
            }
            
            .receipt-divider {
                border-top: 1px dashed #000;
            }
            
            .receipt-item {
                border-bottom: 1px solid #000;
            }
            
            .receipt-summary-item.total {
                border-top: 1px solid #000;
            }
        }
    `
    document.head.appendChild(style)
})