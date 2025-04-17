document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const customerForm = document.getElementById('customer-details-form');
    const continueToPaymentBtn = document.getElementById('continue-to-payment');
    const backToDetailsBtn = document.getElementById('back-to-details');
    const steps = document.querySelectorAll('.step');
    const stepContents = document.querySelectorAll('.checkout-step-content');
    const loadingModal = document.getElementById('loadingModal');
    const overlay = document.getElementById('overlay');

    // Payment method elements
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const verifyAbaBtn = document.getElementById('verify-aba-payment');
    const verifyAcledaBtn = document.getElementById('verify-acleda-payment');
    const processCardBtn = document.getElementById('process-card-payment');
    const confirmCashBtn = document.getElementById('confirm-cash-payment');

    // Order summary elements
    const orderItemsContainer = document.getElementById('checkout-order-items');
    const subtotalElement = document.getElementById('checkout-subtotal');
    const taxElement = document.getElementById('checkout-tax');
    const totalElement = document.getElementById('checkout-total');

    // Confirmation elements
    const confirmationOrderNumber = document.getElementById('confirmation-order-number');
    const confirmationOrderDate = document.getElementById('confirmation-order-date');
    const confirmationOrderTotal = document.getElementById('confirmation-order-total');
    const confirmationPaymentMethod = document.getElementById('confirmation-payment-method');
    const confirmationEmail = document.getElementById('confirmation-email');

    // Load cart items from localStorage or API
    function loadOrderSummary() {
        // In a real app, you would fetch this from your backend or cart system
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

        if (cartItems.length === 0) {
            orderItemsContainer.innerHTML = '<p>Your cart is empty</p>';
            return;
        }

        let itemsHTML = '';
        let subtotal = 0;

        cartItems.forEach(item => {
            subtotal += item.price * item.quantity;
            itemsHTML += `
              <div class="checkout-order-item">
                  <div class="checkout-item-image">
                      <img src="${item.image}" alt="${item.name}">
                  </div>
                  <div class="checkout-item-details">
                      <h4>${item.name}</h4>
                      <p>Size: ${item.size} | Sugar: ${item.sugar} | Ice: ${item.ice}</p>
                      <p>Toppings: ${item.toppings ? item.toppings.join(', ') : 'None'}</p>
                      <div class="checkout-item-price-quantity">
                          <span>$${item.price.toFixed(2)} × ${item.quantity}</span>
                          <span>$${(item.price * item.quantity).toFixed(2)}</span>
                      </div>
                  </div>
              </div>
          `;
        });

        const tax = subtotal * 0.08; // 8% tax
        const total = subtotal + tax;

        orderItemsContainer.innerHTML = itemsHTML;
        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
        taxElement.textContent = `$${tax.toFixed(2)}`;
        totalElement.textContent = `$${total.toFixed(2)}`;

        // Update amounts in payment methods
        document.getElementById('aba-amount').textContent = `$${total.toFixed(2)}`;
        document.getElementById('acleda-amount').textContent = `$${total.toFixed(2)}`;
        document.getElementById('cash-amount').textContent = `$${total.toFixed(2)}`;
    }

    // Handle step navigation
    function goToStep(stepNumber) {
        // Update step indicators
        steps.forEach(step => {
            if (parseInt(step.dataset.step) <= stepNumber) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });

        // Show the correct content
        stepContents.forEach(content => {
            if (content.id === `step-${stepNumber}`) {
                content.classList.add('active');
            } else {
                content.classList.remove('active');
            }
        });

        // Scroll to top of step
        window.scrollTo(0, 0);
    }

    // Save customer details to hidden fields when proceeding to payment
    customerForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Save data to hidden fields
        document.getElementById('hidden_first_name').value = document.getElementById('first_name').value;
        document.getElementById('hidden_last_name').value = document.getElementById('last_name').value;
        document.getElementById('hidden_email').value = document.getElementById('email').value;
        document.getElementById('hidden_phone').value = document.getElementById('phone').value;
        document.getElementById('hidden_address').value = document.getElementById('address').value;
        document.getElementById('hidden_notes').value = document.getElementById('notes').value;

        // Also set confirmation email
        confirmationEmail.textContent = document.getElementById('email').value;

        goToStep(2);
    });

    // Back to details button
    backToDetailsBtn.addEventListener('click', function() {
        goToStep(1);
    });

    // Payment method selection
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            const contentId = `${this.id}_content`;
            document.querySelectorAll('.payment-method-content').forEach(content => {
                content.style.display = 'none';
            });

            if (this.checked) {
                document.getElementById(contentId).style.display = 'block';
            }
        });
    });

    // Payment verification handlers
    verifyAbaBtn.addEventListener('click', processPayment);
    verifyAcledaBtn.addEventListener('click', processPayment);
    processCardBtn.addEventListener('click', processPayment);
    confirmCashBtn.addEventListener('click', processPayment);

    function processPayment(e) {
        e.preventDefault();
        showLoading();

        // In a real app, you would send this to your backend
        setTimeout(() => {
            hideLoading();

            // Generate a random order number if not already set
            if (!confirmationOrderNumber.textContent.startsWith('#')) {
                confirmationOrderNumber.textContent = `#${Math.floor(100000 + Math.random() * 900000)}`;
            }

            // Set payment method in confirmation
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedMethod) {
                let methodName = '';
                switch (selectedMethod.value) {
                    case 'aba':
                        methodName = 'ABA Pay';
                        break;
                    case 'acleda':
                        methodName = 'ACLEDA Pay';
                        break;
                    case 'card':
                        methodName = 'Credit/Debit Card';
                        break;
                    case 'cash':
                        methodName = 'Cash on Delivery';
                        break;
                }
                confirmationPaymentMethod.textContent = methodName;
            }

            // Set order total in confirmation
            confirmationOrderTotal.textContent = totalElement.textContent;

            // Go to confirmation step
            goToStep(3);

            // Clear cart
            localStorage.removeItem('cart');
        }, 2000);
    }

    // Print receipt
    document.getElementById('print-receipt').addEventListener('click', function() {
        window.print();
    });

    // Loading functions
    function showLoading() {
        loadingModal.style.display = 'flex';
        overlay.style.display = 'block';
    }

    function hideLoading() {
        loadingModal.style.display = 'none';
        overlay.style.display = 'none';
    }

    // Initialize
    loadOrderSummary();
});