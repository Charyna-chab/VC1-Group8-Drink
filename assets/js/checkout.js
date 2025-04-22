document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const customerForm = document.getElementById("customer-details-form");
            const paymentCards = document.querySelectorAll(".payment-card");
            const steps = document.querySelectorAll(".step");
            const stepContents = document.querySelectorAll(".checkout-step-content");
            const continueToPaymentBtn = document.getElementById("continue-to-payment");
            const backToCustomerBtn = document.getElementById("back-to-customer");
            const processCardPaymentBtn = document.getElementById("process-card-payment");
            const printReceiptBtn = document.getElementById("print-receipt");
            const downloadReceiptBtn = document.getElementById("download-receipt");
            const emailReceiptBtn = document.getElementById("email-receipt");
            const shareReceiptBtn = document.getElementById("share-receipt");
            const orderItemsContainer = document.getElementById("checkout-order-items");
            const checkoutSubtotal = document.getElementById("checkout-subtotal");
            const checkoutTax = document.getElementById("checkout-tax");
            const checkoutTotal = document.getElementById("checkout-total");
            const orderNumber = document.getElementById("order-number");
            const orderCustomer = document.getElementById("order-customer");
            const orderEmail = document.getElementById("order-email");
            const orderAddress = document.getElementById("order-address");
            const orderPaymentMethod = document.getElementById("order-payment-method");
            const orderTransactionId = document.getElementById("order-transaction-id");
            const orderItemsList = document.getElementById("order-items-list");
            const orderSubtotal = document.getElementById("order-subtotal");
            const orderTax = document.getElementById("order-tax");
            const orderTotal = document.getElementById("order-total");
            const selectedPaymentMethodInput = document.getElementById("selected_payment_method");
            const qrModal = document.getElementById("qr-modal");
            const qrModalClose = document.querySelector(".qr-modal-close");
            const qrModalBody = document.getElementById("qr-modal-body");
            const checkoutHistoryContainer = document.getElementById("checkout-history") || document.createElement("div");
            const orderCount = document.createElement("div"); // Order count display
            orderCount.className = "order-count";

            // Get booking_id from URL
            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get("booking_id");
            const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
            let itemsSource = [];
            let currentTransactionId = "";

            // Initialize checkout history container
            const mainContent = document.querySelector(".main-content");
            if (!document.getElementById("checkout-history")) {
                checkoutHistoryContainer.id = "checkout-history";
                checkoutHistoryContainer.className = "checkout-history";
                if (mainContent) {
                    mainContent.appendChild(checkoutHistoryContainer);
                } else {
                    console.error("Main content element not found. Cannot append checkout history container.");
                }
            }

            // Display order count
            function updateOrderCount() {
                const count = bookings.filter(b => b.status === "processing").length;
                orderCount.textContent = count > 0 ? count : "0";

                // Only append orderCount if it doesn't exist in the DOM
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
                } else if (!mainContent) {
                    console.error("Main content element not found. Cannot append order count.");
                }
            }

            // Fallback utilities
            const formatPrice = (price) => `$${(price || 0).toFixed(2)}`;
            const generateId = (prefix) => `${prefix}-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
            const showRedirectNotification = (title, message, url) => {
                showToast(title, message, "info");
                setTimeout(() => {
                    window.location.href = url;
                }, 2000);
            };

            // Form validation for customer details
            function validateForm() {
                let isValid = true;
                const fields = [
                    { id: "first_name", errorId: "first_name_error", message: "First name is required (min 2 characters)", pattern: /^[A-Za-z\s]{2,}$/ },
                    { id: "last_name", errorId: "last_name_error", message: "Last name is required (min 2 characters)", pattern: /^[A-Za-z\s]{2,}$/ },
                    { id: "email", errorId: "email_error", message: "Valid email is required", pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ },
                    { id: "phone", errorId: "phone_error", message: "Valid phone number is required (10-15 digits)", pattern: /^\+?\d{10,15}$/ },
                    { id: "address", errorId: "address_error", message: "Delivery address is required", pattern: /.+/ },
                ];

                fields.forEach((field) => {
                    const input = document.getElementById(field.id);
                    const error = document.getElementById(field.errorId);

                    if (!input || !error) {
                        console.error(`Input or error element not found for field: ${field.id}`);
                        isValid = false;
                        return;
                    }

                    if (!input.value || !field.pattern.test(input.value)) {
                        error.textContent = field.message;
                        input.classList.add("error");
                        isValid = false;
                    } else {
                        error.textContent = "";
                        input.classList.remove("error");
                    }
                });

                return isValid;
            }

            // Form validation for card payment
            function validateCardForm() {
                let isValid = true;
                const fields = [
                    { id: "card_number", errorId: "card_number_error", message: "Valid card number is required (16 digits)", pattern: /^\d{16}$/ },
                    { id: "expiry_date", errorId: "expiry_date_error", message: "Valid expiry date is required (MM/YY)", pattern: /^(0[1-9]|1[0-2])\/([0-9]{2})$/ },
                    { id: "cvv", errorId: "cvv_error", message: "Valid CVV is required (3-4 digits)", pattern: /^\d{3,4}$/ },
                    { id: "card_holder", errorId: "card_holder_error", message: "Card holder name is required", pattern: /^[A-Za-z\s]{2,}$/ },
                ];

                fields.forEach((field) => {
                    const input = document.getElementById(field.id);
                    const error = document.getElementById(field.errorId);

                    if (!input || !error) {
                        console.error(`Input or error element not found for field: ${field.id}`);
                        isValid = false;
                        return;
                    }

                    let value = input.value.replace(/\s/g, "") || "";
                    if (field.id === "card_number") {
                        value = value.replace(/\D/g, "");
                    }

                    if (!value || !field.pattern.test(value)) {
                        error.textContent = field.message;
                        input.classList.add("error");
                        isValid = false;
                    } else {
                        error.textContent = "";
                        input.classList.remove("error");
                    }
                });

                return isValid;
            }

            // Load order summary
            function loadOrderSummary() {
                if (bookingId) {
                    const booking = bookings.find((b) => b.id === bookingId);
                    if (booking) {
                        itemsSource = booking.items.map((item) => ({
                            ...item,
                            basePrice: item.basePrice || item.totalPrice / item.quantity,
                        }));
                    } else {
                        orderItemsContainer.innerHTML = "<p>Booking not found. Please return to the order page.</p>";
                        showToast("Invalid Booking", "The specified booking was not found. Redirecting to order page...", "error");
                        setTimeout(() => {
                            window.location.href = "/order";
                        }, 3000);
                        return;
                    }
                } else {
                    itemsSource = JSON.parse(localStorage.getItem("cart")) || [];
                }

                if (!itemsSource.length) {
                    orderItemsContainer.innerHTML = "<p>Your order is empty. Please add items to proceed.</p>";
                    showToast("Empty Order", "No items found. Redirecting to order page...", "error");
                    setTimeout(() => {
                        window.location.href = "/order";
                    }, 3000);
                    return;
                }

                let subtotal = 0;
                const itemsHTML = itemsSource.map((item) => {
                    const itemTotal = item.basePrice * item.quantity;
                    subtotal += itemTotal;
                    const toppingsText = item.toppings && item.toppings.length > 0 ? item.toppings.map((t) => t.name).join(", ") : "None";
                    return `
                <div class="order-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="order-item-details">
                        <h4>${item.name}</h4>
                        <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                        <p>Toppings: ${toppingsText}</p>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Price: ${formatPrice(item.basePrice)}</p>
                        <p>Total: ${formatPrice(itemTotal)}</p>
                    </div>
                </div>
            `;
                }).join("");

                const tax = subtotal * 0.08;
                const total = subtotal + tax;

                orderItemsContainer.innerHTML = itemsHTML;
                checkoutSubtotal.textContent = formatPrice(subtotal);
                checkoutTax.textContent = formatPrice(tax);
                checkoutTotal.textContent = formatPrice(total);

                loadCheckoutHistory();
                updateOrderCount();
            }

            // Load checkout history
            function loadCheckoutHistory() {
                const completedBookings = bookings.filter(b => b.status === "completed");
                if (!completedBookings.length) {
                    checkoutHistoryContainer.innerHTML = `
                <div class="empty-state">
                    <h3>No Completed Checkouts</h3>
                    <p>You haven't completed any payments yet.</p>
                </div>
            `;
                    return;
                }

                checkoutHistoryContainer.innerHTML = `
            <h2>Checkout History</h2>
            ${completedBookings.map(booking => {
                const date = new Date(booking.checkoutTimestamp || booking.bookingTimestamp);
                const formattedDate = date.toLocaleDateString() + " " + date.toLocaleTimeString();
                return `
                    <div class="checkout-card">
                        <div class="checkout-header">
                            <h3>Order #${booking.id}</h3>
                            <p><i class="fas fa-calendar-alt"></i> ${formattedDate}</p>
                        </div>
                        <div class="checkout-details">
                            <p>Total: ${formatPrice(booking.total)}</p>
                            <p>Payment Method: ${booking.paymentMethod || "Unknown"}</p>
                        </div>
                    </div>
                `;
            }).join("")}
        `;
    }

    // Navigate to a specific step
    function goToStep(step) {
        steps.forEach((s) => s.classList.toggle("active", s.dataset.step <= step));
        stepContents.forEach((c) => c.classList.toggle("active", c.id === `step-${step}`));
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    // Show loading modal with progress
    function showLoadingModal(message = "Processing...", showProgress = false) {
        const existingModal = document.querySelector(".loading-modal");
        if (existingModal) existingModal.remove();

        const modal = document.createElement("div");
        modal.className = "loading-modal";
        modal.innerHTML = `
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
                <p>${message}</p>
                ${showProgress ? '<div class="progress-bar"><div class="progress-bar-fill"></div></div>' : ""}
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = "flex";

        if (showProgress) {
            let progress = 0;
            const progressBarFill = modal.querySelector(".progress-bar-fill");
            const interval = setInterval(() => {
                progress += 10;
                progressBarFill.style.width = `${progress}%`;
                if (progress >= 100) {
                    clearInterval(interval);
                }
            }, 200);
        }

        return modal;
    }

    // Hide loading modal
    function hideLoadingModal(modal) {
        modal.style.display = "none";
        modal.remove();
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

    // Show QR code modal
    function showQRModal(method) {
        const existingModal = document.querySelector(".qr-modal");
        if (existingModal) existingModal.style.display = "none";

        const qrImages = {
            aba: "/assets/image/ABA Vanda.jpg",
            acleda: "/assets/images/acleda-qr-code.png",
        };
        const methodNames = { aba: "ABA Pay", acleda: "ACLEDA Pay" };
        const total = checkoutTotal.textContent;

        qrModalBody.innerHTML = `
            <div class="payment-qr-container">
                <h3>${methodNames[method]} Payment</h3>
                <img src="${qrImages[method]}" alt="${methodNames[method]} QR Code" class="payment-qr">
                <p>Scan this QR code with your ${methodNames[method]} app to pay ${total}.</p>
                <p>After payment, click below to confirm.</p>
                <button type="button" id="confirm-qr-payment" class="btn-primary">Confirm Payment</button>
            </div>
        `;
        qrModal.style.display = "flex";

        document.getElementById("confirm-qr-payment").addEventListener("click", () => {
            qrModal.style.display = "none";
            processPayment(method);
        });
    }

    // Process payment
    function processPayment(method) {
        const modal = showLoadingModal("Processing your payment...", true);

        // Simulate payment failure (10% chance)
        const isPaymentSuccessful = Math.random() > 0.1;

        if (!isPaymentSuccessful) {
            hideLoadingModal(modal);
            showToast("Payment Failed", "There was an issue processing your payment. Please try again.", "error");
            return;
        }

        hideLoadingModal(modal);
        currentTransactionId = generateId("TX");
        updateReceipt(method);
        goToStep(3);
        clearCart();
        showToast("Payment Successful", "Your payment has been processed successfully!", "success");
        showCelebrationAnimation();
        updateOrderCount();
    }

    // Update receipt
    function updateReceipt(paymentMethod) {
        const firstName = document.getElementById("hidden_first_name")?.value || "";
        const lastName = document.getElementById("hidden_last_name")?.value || "";
        const email = document.getElementById("hidden_email")?.value || "";
        const address = document.getElementById("hidden_address")?.value || "";

        orderNumber.textContent = bookingId || generateId("ORD");
        orderCustomer.textContent = `${firstName} ${lastName}`;
        orderEmail.textContent = email;
        orderAddress.textContent = address;
        orderPaymentMethod.textContent = {
            card: "Visa Card",
            aba: "ABA Pay",
            acleda: "ACLEDA Pay",
        }[paymentMethod] || "Unknown";
        orderTransactionId.textContent = currentTransactionId;

        let subtotal = 0;
        const itemsHTML = itemsSource.map((item) => {
            const itemTotal = item.basePrice * item.quantity;
            subtotal += itemTotal;
            const toppingsText = item.toppings && item.toppings.length > 0 ? item.toppings.map((t) => t.name).join(", ") : "None";
            return `
                <div class="order-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="order-item-details">
                        <h4>${item.name}</h4>
                        <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                        <p>Toppings: ${toppingsText}</p>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Price: ${formatPrice(item.basePrice)}</p>
                        <p>Total: ${formatPrice(itemTotal)}</p>
                    </div>
                </div>
            `;
        }).join("");

        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        orderItemsList.innerHTML = itemsHTML;
        orderSubtotal.textContent = formatPrice(subtotal);
        orderTax.textContent = formatPrice(tax);
        orderTotal.textContent = formatPrice(total);

        // Update booking status
        if (bookingId) {
            const bookingIndex = bookings.findIndex((b) => b.id === bookingId);
            if (bookingIndex !== -1) {
                bookings[bookingIndex].status = "completed";
                bookings[bookingIndex].paymentStatus = "completed";
                bookings[bookingIndex].paymentMethod = paymentMethod;
                bookings[bookingIndex].customer = {
                    firstName,
                    lastName,
                    email,
                    address,
                };
                bookings[bookingIndex].checkoutTimestamp = new Date().toISOString();
                localStorage.setItem("bookings", JSON.stringify(bookings));
            }
        }

        // Add Continue Shopping button to receipt
        const receiptActions = document.querySelector(".receipt-actions");
        if (receiptActions) {
            const continueShoppingBtn = document.createElement("button");
            continueShoppingBtn.className = "btn-primary";
            continueShoppingBtn.innerHTML = '<i class="fas fa-shopping-cart"></i> Continue Shopping';
            continueShoppingBtn.addEventListener("click", () => {
                showRedirectNotification(
                    "Continue Shopping",
                    "Redirecting to order page...",
                    "/order"
                );
            });
            receiptActions.appendChild(continueShoppingBtn);
        }

        loadCheckoutHistory();
        updateOrderCount();
    }

    // Clear cart after successful payment
    function clearCart() {
        localStorage.removeItem("cart");
        if (bookingId) {
            const bookingIndex = bookings.findIndex((b) => b.id === bookingId);
            if (bookingIndex !== -1) {
                bookings[bookingIndex].status = "completed";
                localStorage.setItem("bookings", JSON.stringify(bookings));
            }
        }
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

    // Handle customer form submission
    if (customerForm) {
        customerForm.addEventListener("submit", (e) => {
            e.preventDefault();
            if (validateForm()) {
                ["first_name", "last_name", "email", "phone", "address", "notes", "booking_id"].forEach((field) => {
                    const input = document.getElementById(field);
                    if (input) {
                        document.getElementById(`hidden_${field}`).value = input.value;
                    }
                });
                goToStep(2);
            }
        });
    }

    // Handle payment card selection
    paymentCards.forEach((card) => {
        card.addEventListener("click", () => {
            paymentCards.forEach((c) => c.classList.remove("active"));
            document.querySelectorAll(".payment-method-content").forEach((content) => {
                content.classList.remove("active");
                content.style.display = "none";
            });

            card.classList.add("active");
            const method = card.dataset.method;
            selectedPaymentMethodInput.value = method;

            if (method === "card") {
                const content = document.getElementById("card_payment_content");
                content.classList.add("active");
                content.style.display = "block";
            } else {
                showQRModal(method);
            }
        });
    });

    // Handle card payment processing
    if (processCardPaymentBtn) {
        processCardPaymentBtn.addEventListener("click", () => {
            if (validateCardForm()) {
                processPayment("card");
            }
        });
    }

    // Handle back to customer details
    if (backToCustomerBtn) {
        backToCustomerBtn.addEventListener("click", () => goToStep(1));
    }

    // Handle QR modal close
    if (qrModalClose) {
        qrModalClose.addEventListener("click", () => {
            qrModal.style.display = "none";
        });
    }

    // Handle print receipt
    if (printReceiptBtn) {
        printReceiptBtn.addEventListener("click", () => {
            const receiptContent = document.querySelector(".order-confirmation");
            const printWindow = window.open("", "_blank");
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Xing Fu Cha Order Receipt</title>
                        <style>
                            body { font-family: 'Arial', sans-serif; padding: 20px; color: #333; }
                            .order-confirmation { max-width: 700px; margin: 0 auto; }
                            .receipt-header { text-align: center; margin-bottom: 20px; }
                            .receipt-logo { width: 120px; margin-bottom: 10px; }
                            h2 { font-size: 24px; color: #ff6769; }
                            .receipt-content { border: 1px solid #ddd; border-radius: 8px; padding: 20px; }
                            .receipt-section { margin-bottom: 20px; }
                            h3 { font-size: 18px; color: #ff6769; border-bottom: 2px solid #ff6769; padding-bottom: 5px; }
                            .receipt-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 14px; }
                            .receipt-row span:first-child { font-weight: 600; }
                            .order-item { display: flex; margin: 10px 0; border-bottom: 1px solid #eee; padding-bottom: 10px; }
                            .order-item img { width: 80px; height: 80px; object-fit: cover; margin-right: 15px; border-radius: 4px; }
                            .order-item-details h4 { font-size: 16px; margin: 0 0 5px; }
                            .order-item-details p { margin: 3px 0; font-size: 13px; }
                            .receipt-totals { border-top: 2px solid #eee; padding-top: 15px; }
                            .receipt-total-row { display: flex; justify-content: space-between; margin: 10px 0; font-size: 14px; }
                            .receipt-total-row.grand-total { font-weight: bold; font-size: 16px; color: #ff6769; }
                        </style>
                    </head>
                    <body>
                        ${receiptContent.outerHTML}
                        <script>
                            window.print();
                            window.close();
                            window.opener.showRedirectNotification(
                                "Continue Shopping",
                                "Redirecting to order page...",
                                "/order"
                            );
                        </script>
                    </body>
                </html>
            `);
            printWindow.document.close();
            showToast("Receipt Printed", "Your receipt is being printed.", "success");
        });
    }

    // Handle download receipt
    if (downloadReceiptBtn) {
        downloadReceiptBtn.addEventListener("click", () => {
            const receiptContent = document.querySelector(".order-confirmation");
            const modal = showLoadingModal("Generating PDF...", true);
            const opt = {
                margin: 0.5,
                filename: `XingFuCha_Receipt_${orderNumber.textContent}.pdf`,
                image: { type: "jpeg", quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
                pagebreak: { mode: ["avoid-all", "css", "legacy"] },
            };
            html2pdf()
                .from(receiptContent)
                .set(opt)
                .save()
                .then(() => {
                    hideLoadingModal(modal);
                    showToast("PDF Downloaded", "Your receipt has been downloaded successfully!", "success");
                    showRedirectNotification(
                        "Continue Shopping",
                        "Redirecting to order page...",
                        "/order"
                    );
                })
                .catch(() => {
                    hideLoadingModal(modal);
                    showToast("Error", "Failed to generate PDF. Please try again.", "error");
                });
        });
    }

    // Handle email receipt (simulated)
    if (emailReceiptBtn) {
        emailReceiptBtn.addEventListener("click", () => {
            const modal = showLoadingModal("Sending receipt to email...");
            setTimeout(() => {
                hideLoadingModal(modal);
                showToast("Email Sent", "The receipt has been sent to your email!", "success");
                showRedirectNotification(
                    "Continue Shopping",
                    "Redirecting to order page...",
                    "/order"
                );
            }, 500);
        });
    }

    // Handle share receipt
    if (shareReceiptBtn) {
        shareReceiptBtn.addEventListener("click", () => {
            const receiptLink = `${window.location.origin}/receipt?order=${orderNumber.textContent}`;
            navigator.clipboard.writeText(receiptLink).then(() => {
                showToast("Link Copied", "Receipt link copied to clipboard!", "success");
                showRedirectNotification(
                    "Continue Shopping",
                    "Redirecting to order page...",
                    "/order"
                );
            }).catch(() => {
                showToast("Error", "Failed to copy link. Please try again.", "error");
            });
        });
    }

    // Add CSS for checkout
    const style = document.createElement("style");
    style.textContent = `
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

        .checkout-history {
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .checkout-card {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .checkout-card:last-child {
            border-bottom: none;
        }

        .checkout-header h3 {
            margin: 0 0 5px;
            font-size: 18px;
            color: #333;
        }

        .checkout-header p {
            margin: 0;
            font-size: 14px;
            color: #666;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .checkout-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
    `;
    document.head.appendChild(style);

    // Initialize
    loadOrderSummary();
});