document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const customerForm = document.getElementById('customer-details-form');
    const paymentCards = document.querySelectorAll('.payment-card');
    const steps = document.querySelectorAll('.step');
    const stepContents = document.querySelectorAll('.checkout-step-content');
    const continueToPaymentBtn = document.getElementById('continue-to-payment');
    const backToCustomerBtn = document.getElementById('back-to-customer');
    const processCardPaymentBtn = document.getElementById('process-card-payment');
    const printReceiptBtn = document.getElementById('print-receipt');
    const downloadReceiptBtn = document.getElementById('download-receipt');
    const orderItemsContainer = document.getElementById('checkout-order-items');
    const checkoutSubtotal = document.getElementById('checkout-subtotal');
    const checkoutTax = document.getElementById('checkout-tax');
    const checkoutTotal = document.getElementById('checkout-total');
    const orderNumber = document.getElementById('order-number');
    const orderCustomer = document.getElementById('order-customer');
    const orderEmail = document.getElementById('order-email');
    const orderAddress = document.getElementById('order-address');
    const orderPaymentMethod = document.getElementById('order-payment-method');
    const orderTransactionId = document.getElementById('order-transaction-id');
    const orderItemsList = document.getElementById('order-items-list');
    const orderSubtotal = document.getElementById('order-subtotal');
    const orderTax = document.getElementById('order-tax');
    const orderTotal = document.getElementById('order-total');
    const selectedPaymentMethodInput = document.getElementById('selected_payment_method');
    const qrModal = document.getElementById('qr-modal');
    const qrModalClose = document.querySelector('.qr-modal-close');
    const qrModalBody = document.getElementById('qr-modal-body');

    // Get booking_id from URL
    const urlParams = new URLSearchParams(window.location.search);
    const bookingId = urlParams.get('booking_id');
    const bookings = JSON.parse(localStorage.getItem('bookings')) || [];
    let itemsSource = [];
    let currentTransactionId = '';

    // Form validation for customer details
    function validateForm() {
        let isValid = true;
        const fields = [
            { id: 'first_name', errorId: 'first_name_error', message: 'First name is required (min 2 characters)', pattern: /^[A-Za-z\s]{2,}$/ },
            { id: 'last_name', errorId: 'last_name_error', message: 'Last name is required (min 2 characters)', pattern: /^[A-Za-z\s]{2,}$/ },
            { id: 'email', errorId: 'email_error', message: 'Valid email is required', pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ },
            { id: 'phone', errorId: 'phone_error', message: 'Valid phone number is required (10-15 digits)', pattern: /^\+?\d{10,15}$/ },
            { id: 'address', errorId: 'address_error', message: 'Delivery address is required', pattern: /.+/ }
        ];

        fields.forEach(field => {
            const input = document.getElementById(field.id);
            const error = document.getElementById(field.errorId);
            if (!input.value || !field.pattern.test(input.value)) {
                error.textContent = field.message;
                input.classList.add('error');
                isValid = false;
            } else {
                error.textContent = '';
                input.classList.remove('error');
            }
        });

        return isValid;
    }

    // Load order summary
    function loadOrderSummary() {
        if (bookingId) {
            const booking = bookings.find(b => b.id === bookingId);
            if (booking) {
                itemsSource = booking.items.map(item => ({
                    ...item,
                    price: item.totalPrice / item.quantity,
                }));
            } else {
                orderItemsContainer.innerHTML = '<p>Booking not found.</p>';
                return;
            }
        } else {
            itemsSource = JSON.parse(localStorage.getItem('cart')) || [];
        }

        if (!itemsSource.length) {
            orderItemsContainer.innerHTML = '<p>Your order is empty.</p>';
            return;
        }

        let subtotal = 0;
        const itemsHTML = itemsSource.map(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            return `
                <div class="order-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="order-item-details">
                        <h4>${item.name}</h4>
                        <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Price: $${item.price.toFixed(2)}</p>
                        <p>Total: $${itemTotal.toFixed(2)}</p>
                    </div>
                </div>
            `;
        }).join('');

        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        orderItemsContainer.innerHTML = itemsHTML;
        checkoutSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        checkoutTax.textContent = `$${tax.toFixed(2)}`;
        checkoutTotal.textContent = `$${total.toFixed(2)}`;
    }

    // Navigate to a specific step
    function goToStep(step) {
        steps.forEach(s => s.classList.toggle('active', s.dataset.step <= step));
        stepContents.forEach(c => c.classList.toggle('active', c.id === `step-${step}`));
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Show loading modal
    function showLoadingModal() {
        const modal = document.createElement('div');
        modal.className = 'loading-modal';
        modal.innerHTML = `
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Processing your payment...</p>
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = 'flex';
        return modal;
    }

    // Hide loading modal
    function hideLoadingModal(modal) {
        modal.style.display = 'none';
        modal.remove();
    }

    // Handle customer form submission
    customerForm.addEventListener('submit', e => {
        e.preventDefault();
        if (validateForm()) {
            ['first_name', 'last_name', 'email', 'phone', 'address', 'notes', 'booking_id'].forEach(field => {
                document.getElementById(`hidden_${field}`).value = document.getElementById(field).value;
            });
            goToStep(2);
        }
    });

    // Handle payment card selection
    paymentCards.forEach(card => {
        card.addEventListener('click', () => {
            paymentCards.forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.payment-method-content').forEach(content => {
                content.classList.remove('active');
                content.style.display = 'none';
            });

            card.classList.add('active');
            const method = card.dataset.method;
            selectedPaymentMethodInput.value = method;

            if (method === 'card') {
                const content = document.getElementById('card_payment_content');
                content.classList.add('active');
                content.style.display = 'block';
            } else {
                showQRModal(method);
            }
        });
    });

    // Show QR code modal
    function showQRModal(method) {
        const qrImages = {
            aba: 'assets/image/ABA Vanda.jpg',
            acleda: '/assets/images/acleda-qr-code.png'
        };
        const methodNames = { aba: 'ABA Pay', acleda: 'ACLEDA Pay' };
        const total = checkoutTotal.textContent;

        qrModalBody.innerHTML = `
            <div class="payment-qr-container">
                <h3>${methodNames[method]} Payment</h3>
                <img src="${qrImages[method]}" alt="${methodNames[method]} QR Code" class="payment-qr">
                <p>Scan this QR code with your ${methodNames[method]} mobile app to complete the payment</p>
                <div class="payment-details">
                    <div class="payment-detail-row">
                        <span>Account Name:</span>
                        <span>Xing Fu Cha</span>
                    </div>
                    <div class="payment-detail-row">
                        <span>Account Number:</span>
                        <span>${method === 'aba' ? '000 123 456' : '000 987 654'}</span>
                    </div>
                    <div class="payment-detail-row">
                        <span>Amount:</span>
                        <span>${total}</span>
                    </div>
                </div>
                <div class="payment-verification">
                    <div class="form-group">
                        <label for="${method}_transaction_id">Enter Transaction ID *</label>
                        <input type="text" id="${method}_transaction_id" placeholder="e.g. ${method.toUpperCase()}123456789" required>
                        <span class="error-message" id="${method}_transaction_id_error"></span>
                    </div>
                    <button id="verify-${method}-payment" class="btn-primary">
                        <i class="fas fa-check-circle"></i> Verify Payment
                    </button>
                </div>
            </div>
        `;
        qrModal.style.display = 'flex';

        document.getElementById(`verify-${method}-payment`).addEventListener('click', async() => {
            const transactionId = document.getElementById(`${method}_transaction_id`).value;
            const error = document.getElementById(`${method}_transaction_id_error`);
            if (!transactionId) {
                error.textContent = 'Transaction ID is required';
                return;
            }
            error.textContent = '';
            const modal = showLoadingModal();
            const result = await processPayment(method);
            hideLoadingModal(modal);
            if (result.success) {
                currentTransactionId = transactionId;
                qrModal.style.display = 'none';
                finalizeOrder(methodNames[method], result.orderId);
            } else {
                alert('Payment verification failed. Please try again.');
            }
        });
    }

    // Close QR modal
    qrModalClose.addEventListener('click', () => {
        qrModal.style.display = 'none';
    });

    // Process payment
    function processPayment(method) {
        return new Promise(resolve => {
            setTimeout(() => {
                const orderId = bookingId || `XF${Math.floor(100000 + Math.random() * 900000)}`;
                resolve({ success: true, orderId });
            }, 1500);
        });
    }

    // Update booking status
    function updateBookingStatus(orderId, paymentMethod) {
        if (!bookingId) return;
        const bookingIndex = bookings.findIndex(b => b.id === orderId);
        if (bookingIndex !== -1) {
            bookings[bookingIndex].status = 'completed';
            bookings[bookingIndex].paymentStatus = 'completed';
            bookings[bookingIndex].paymentMethod = paymentMethod;
            bookings[bookingIndex].customer = {
                firstName: document.getElementById('hidden_first_name').value,
                lastName: document.getElementById('hidden_last_name').value,
                email: document.getElementById('hidden_email').value,
                phone: document.getElementById('hidden_phone').value,
                address: document.getElementById('hidden_address').value,
                notes: document.getElementById('hidden_notes').value,
            };
            localStorage.setItem('bookings', JSON.stringify(bookings));

            if (window.addNotification) {
                window.addNotification(
                    'Order Completed',
                    `Your order #${orderId} has been successfully completed.`,
                    'order'
                );
            }
        }
    }

    // Validate card payment
    function validateCardPayment() {
        let isValid = true;
        const fields = [
            { id: 'card_number', errorId: 'card_number_error', message: 'Valid 16-digit card number is required', pattern: /^\d{16}$/ },
            { id: 'expiry_date', errorId: 'expiry_date_error', message: 'Valid expiry date (MM/YY) is required', pattern: /^\d{2}\/\d{2}$/ },
            { id: 'cvv', errorId: 'cvv_error', message: 'Valid 3-4 digit CVV is required', pattern: /^\d{3,4}$/ },
            { id: 'card_holder', errorId: 'card_holder_error', message: 'Card holder name is required', pattern: /^[A-Za-z\s]{2,}$/ }
        ];

        fields.forEach(field => {
            const input = document.getElementById(field.id);
            const error = document.getElementById(field.errorId);
            const value = field.id === 'card_number' ? input.value.replace(/\s/g, '') : input.value;
            if (!value || !field.pattern.test(value)) {
                error.textContent = field.message;
                input.classList.add('error');
                isValid = false;
            } else {
                error.textContent = '';
                input.classList.remove('error');
            }
        });

        return isValid;
    }

    // Process card payment
    processCardPaymentBtn.addEventListener('click', async() => {
        if (!validateCardPayment()) {
            return;
        }
        const modal = showLoadingModal();
        const result = await processPayment('card');
        hideLoadingModal(modal);
        if (result.success) {
            currentTransactionId = 'VISA' + Math.floor(100000 + Math.random() * 900000);
            finalizeOrder('Visa Card', result.orderId);
        } else {
            alert('Card payment failed. Please try again.');
        }
    });

    // Finalize order and show receipt
    function finalizeOrder(paymentMethod, orderId) {
        let subtotal = 0;
        const itemsHTML = itemsSource.map(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            return `
                <div class="order-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="order-item-details">
                        <h4>${item.name}</h4>
                        <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Price: $${item.price.toFixed(2)}</p>
                        <p>Total: $${itemTotal.toFixed(2)}</p>
                    </div>
                </div>
            `;
        }).join('');

        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        orderNumber.textContent = orderId;
        orderCustomer.textContent = `${document.getElementById('hidden_first_name').value} ${document.getElementById('hidden_last_name').value}`;
        orderEmail.textContent = document.getElementById('hidden_email').value;
        orderAddress.textContent = document.getElementById('hidden_address').value;
        orderPaymentMethod.textContent = paymentMethod;
        orderTransactionId.textContent = currentTransactionId || 'N/A';
        orderItemsList.innerHTML = itemsHTML;
        orderSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        orderTax.textContent = `$${tax.toFixed(2)}`;
        orderTotal.textContent = `$${total.toFixed(2)}`;

        updateBookingStatus(orderId, paymentMethod);

        if (!bookingId) {
            localStorage.removeItem('cart');
        }

        goToStep(3);
    }

    // Print receipt
    printReceiptBtn.addEventListener('click', () => {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Order Receipt</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .order-confirmation { max-width: 600px; margin: 0 auto; text-align: center; }
                        .order-details, .order-items { margin: 20px 0; }
                        .order-detail-row, .order-total-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                        .order-total-row.grand-total { font-weight: bold; font-size: 1.2em; }
                        h2, h3 { color: #333; }
                        img { max-width: 60px; }
                        .order-item { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; }
                        .confirmation-icon, .confirmation-actions { display: none; }
                    </style>
                </head>
                <body>
                    ${document.querySelector('.order-confirmation').innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    });

    // Download receipt as PDF
    downloadReceiptBtn.addEventListener('click', () => {
        const element = document.querySelector('.order-confirmation');
        const opt = {
            margin: 0.5,
            filename: `Receipt_${orderNumber.textContent}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(element).set(opt).save();
    });

    // Back to customer details
    backToCustomerBtn.addEventListener('click', () => goToStep(1));

    // Initialize
    loadOrderSummary();
});