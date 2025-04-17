document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const customerForm = document.getElementById('customer-details-form');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const steps = document.querySelectorAll('.step');
    const stepContents = document.querySelectorAll('.checkout-step-content');

    // Buttons
    const continueToPaymentBtn = document.getElementById('continue-to-payment');
    const backToCustomerBtn = document.getElementById('back-to-customer');
    const verifyAbaPaymentBtn = document.getElementById('verify-aba-payment');
    const verifyAcledaPaymentBtn = document.getElementById('verify-acleda-payment');
    const processCardPaymentBtn = document.getElementById('process-card-payment');
    const confirmCodPaymentBtn = document.getElementById('confirm-cod-payment');
    const printReceiptBtn = document.getElementById('print-receipt');

    // Order summary
    const orderItemsContainer = document.getElementById('checkout-order-items');
    const checkoutSubtotal = document.getElementById('checkout-subtotal');
    const checkoutTax = document.getElementById('checkout-tax');
    const checkoutTotal = document.getElementById('checkout-total');

    // Confirmation
    const orderNumber = document.getElementById('order-number');
    const orderCustomer = document.getElementById('order-customer');
    const orderEmail = document.getElementById('order-email');
    const orderAddress = document.getElementById('order-address');
    const orderPaymentMethod = document.getElementById('order-payment-method');
    const orderItemsList = document.getElementById('order-items-list');
    const orderSubtotal = document.getElementById('order-subtotal');
    const orderTax = document.getElementById('order-tax');
    const orderTotal = document.getElementById('order-total');

    // Load order summary
    function loadOrderSummary() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (!cart.length) {
            orderItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
            return;
        }

        let subtotal = 0;
        const itemsHTML = cart.map(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            return `
                <div class="order-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="order-item-details">
                        <h4>${item.name}</h4>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Price: $$  {item.price.toFixed(2)}</p>
                        <p>Total:   $${itemTotal.toFixed(2)}</p>
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

        // Update payment method amounts
        document.getElementById('aba-amount').textContent = `$${total.toFixed(2)}`;
        document.getElementById('acleda-amount').textContent = `$${total.toFixed(2)}`;
        document.getElementById('cod-amount').textContent = `$${total.toFixed(2)}`;
    }

    // Navigate to a specific step
    function goToStep(step) {
        steps.forEach(s => s.classList.toggle('active', s.dataset.step <= step));
        stepContents.forEach(c => c.classList.toggle('active', c.id === `step-${step}`));
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Handle customer form submission
    customerForm.addEventListener('submit', e => {
        e.preventDefault();
        if (customerForm.checkValidity()) {
            // Store customer details
            ['first_name', 'last_name', 'email', 'phone', 'address', 'notes'].forEach(field => {
                document.getElementById(`hidden_${field}`).value = document.getElementById(field).value;
            });
            goToStep(2);
        } else {
            customerForm.reportValidity();
        }
    });

    // Handle payment method selection
    paymentMethods.forEach(method => {
        method.addEventListener('change', () => {
            document.querySelectorAll('.payment-method-content').forEach(content => {
                content.style.display = content.id === `${method.id}_content` ? 'block' : 'none';
            });
        });
    });

    // Process payment
    function processPayment(method) {
        // Simulate payment processing
        return new Promise(resolve => {
            setTimeout(() => {
                const orderId = `XF${Math.floor(100000 + Math.random() * 900000)}`;
                resolve({ success: true, orderId });
            }, 1500);
        });
    }

    // Payment button handlers
    verifyAbaPaymentBtn.addEventListener('click', async() => {
        const transactionId = document.getElementById('aba_transaction_id').value;
        if (!transactionId) {
            alert('Please enter a transaction ID.');
            return;
        }
        const result = await processPayment('aba');
        if (result.success) {
            finalizeOrder('ABA Pay', result.orderId);
        }
    });

    verifyAcledaPaymentBtn.addEventListener('click', async() => {
        const transactionId = document.getElementById('acleda_transaction_id').value;
        if (!transactionId) {
            alert('Please enter a transaction ID.');
            return;
        }
        const result = await processPayment('acleda');
        if (result.success) {
            finalizeOrder('ACLEDA Pay', result.orderId);
        }
    });

    processCardPaymentBtn.addEventListener('click', async() => {
        const cardNumber = document.getElementById('card_number').value.replace(/\s/g, '');
        const expiryDate = document.getElementById('expiry_date').value;
        const cvv = document.getElementById('cvv').value;
        const cardHolder = document.getElementById('card_holder').value;

        if (!/^\d{16}$/.test(cardNumber) || !/^\d{3,4}$/.test(cvv) || !/^\d{2}\/\d{2}$/.test(expiryDate) || !cardHolder) {
            alert('Please enter valid card details.');
            return;
        }

        const result = await processPayment('card');
        if (result.success) {
            finalizeOrder('Credit/Debit Card', result.orderId);
        }
    });

    confirmCodPaymentBtn.addEventListener('click', async() => {
        const result = await processPayment('cod');
        if (result.success) {
            finalizeOrder('Cash on Delivery', result.orderId);
        }
    });

    // Finalize order and show confirmation
    function finalizeOrder(paymentMethod, orderId) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        let subtotal = 0;
        const itemsHTML = cart.map(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            return `
                <div class="order-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="order-item-details">
                        <h4>${item.name}</h4>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Price: $$  {item.price.toFixed(2)}</p>
                        <p>Total:   $${itemTotal.toFixed(2)}</p>
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
        orderItemsList.innerHTML = itemsHTML;
        orderSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        orderTax.textContent = `$${tax.toFixed(2)}`;
        orderTotal.textContent = `$${total.toFixed(2)}`;

        localStorage.removeItem('cart');
        goToStep(3);
    }

    // Print receipt
    printReceiptBtn.addEventListener('click', () => {
        window.print();
    });

    // Back to customer details
    backToCustomerBtn.addEventListener('click', () => goToStep(1));

    // Initialize
    loadOrderSummary();
});