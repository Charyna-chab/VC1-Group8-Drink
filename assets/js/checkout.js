document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const customerForm = document.getElementById("customer-details-form");
    const paymentOptions = document.querySelectorAll(".payment-option");
    const steps = document.querySelectorAll(".step");
    const stepContents = document.querySelectorAll(".checkout-step-content");
    const continueToPaymentBtn = document.getElementById("continue-to-payment");
    const backToCustomerBtn = document.getElementById("back-to-customer");
    const processCardPaymentBtn = document.getElementById("process-card-payment");
    const processAbaPaymentBtn = document.getElementById("process-aba-payment");
    const processAcledaPaymentBtn = document.getElementById("process-acleda-payment");
    const printReceiptBtn = document.getElementById("print-receipt");
    const downloadReceiptBtn = document.getElementById("download-receipt");
    const orderItemsContainer = document.getElementById("checkout-order-items");
    const checkoutSubtotal = document.getElementById("checkout-subtotal");
    const checkoutTax = document.getElementById("checkout-tax");
    const checkoutTotal = document.getElementById("checkout-total");
    const paymentTotalDisplay = document.getElementById("payment-total");
    const abaPaymentAmount = document.getElementById("aba-payment-amount");
    const acledaPaymentAmount = document.getElementById("acleda-payment-amount");
    const cardPaymentAmount = document.getElementById("card-payment-amount");
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
    const paymentPhoneNumberInput = document.getElementById("payment_phone_number");

    // Get booking_id from URL
    const urlParams = new URLSearchParams(window.location.search);
    const bookingId = urlParams.get("booking_id");
    const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
    let itemsSource = [];
    let currentTransactionId = "";
    let map, marker, autocomplete, geocoder;
    let currentTotal = 0;

    // Initialize Google Maps
    window.initMap = () => {
        const mapElement = document.getElementById("map");
        const addressSearchInput = document.getElementById("address_search");
        const useMyLocationBtn = document.getElementById("use-my-location");
        const latInput = document.getElementById("lat");
        const lngInput = document.getElementById("lng");
        const formattedAddressInput = document.getElementById("formatted_address");
        const addressTextarea = document.getElementById("address");

        // Default location (center of the city or your business location)
        const defaultLocation = { lat: 11.5564, lng: 104.9282 }; // Phnom Penh, Cambodia

        // Create map
        map = new google.maps.Map(mapElement, {
            center: defaultLocation,
            zoom: 15,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
        });

        // Create marker
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
        });

        // Initialize geocoder
        geocoder = new google.maps.Geocoder();

        // Initialize autocomplete
        autocomplete = new google.maps.places.Autocomplete(addressSearchInput, {
            types: ["address"],
        });

        // Bias autocomplete results to current map bounds
        autocomplete.bindTo("bounds", map);

        // Handle place selection
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();

            if (!place.geometry) {
                showToast("Error", "No location details available for this address.", "error");
                return;
            }

            // Update map and marker
            map.setCenter(place.geometry.location);
            map.setZoom(17);
            marker.setPosition(place.geometry.location);

            // Update hidden inputs
            updateLocationInputs(place.geometry.location, place.formatted_address);
        });

        // Handle marker drag
        marker.addListener("dragend", () => {
            const position = marker.getPosition();
            geocoder.geocode({ location: position }, (results, status) => {
                if (status === "OK" && results[0]) {
                    updateLocationInputs(position, results[0].formatted_address);
                } else {
                    showToast("Warning", "Could not find address for this location.", "warning");
                    updateLocationInputs(position, "Custom location");
                }
            });
        });

        // Handle "Use My Location" button
        useMyLocationBtn.addEventListener("click", () => {
            if (navigator.geolocation) {
                const loadingToast = showToast("Finding Location", "Getting your current location...", "info");

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        // Update map and marker
                        map.setCenter(userLocation);
                        map.setZoom(17);
                        marker.setPosition(userLocation);

                        // Get address from coordinates
                        geocoder.geocode({ location: userLocation }, (results, status) => {
                            if (status === "OK" && results[0]) {
                                updateLocationInputs(userLocation, results[0].formatted_address);
                                addressSearchInput.value = results[0].formatted_address;
                            } else {
                                updateLocationInputs(userLocation, "Custom location");
                                addressSearchInput.value = "Custom location";
                                showToast("Warning", "Could not find address for your location.", "warning");
                            }
                        });
                    },
                    (error) => {
                        let errorMessage = "Could not get your location.";
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = "Location access denied. Please enable location services.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = "Location information is unavailable.";
                                break;
                            case error.TIMEOUT:
                                errorMessage = "Location request timed out.";
                                break;
                        }
                        showToast("Error", errorMessage, "error");
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0,
                    }
                );
            } else {
                showToast("Error", "Geolocation is not supported by this browser.", "error");
            }
        });

        // Helper function to update location inputs
        function updateLocationInputs(location, formattedAddress) {
            latInput.value = location.lat();
            lngInput.value = location.lng();
            formattedAddressInput.value = formattedAddress;

            // Update address textarea with formatted address as a starting point
            if (addressTextarea.value === "") {
                addressTextarea.value = formattedAddress;
            }
        }
    };

    // Fallback utilities
    const formatPrice = (price) => `$${(price || 0).toFixed(2)}`;
    const formatPriceWithoutSymbol = (price) => (price || 0).toFixed(2);
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
        let errorMessages = [];
        const fields = [{
                id: "first_name",
                errorId: "first_name_error",
                message: "First name is required (min 2 characters)",
                pattern: /^[A-Za-z\s]{2,}$/,
            },
            {
                id: "last_name",
                errorId: "last_name_error",
                message: "Last name is required (min 2 characters)",
                pattern: /^[A-Za-z\s]{2,}$/,
            },
            {
                id: "email",
                errorId: "email_error",
                message: "Valid email is required",
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            },
            {
                id: "phone",
                errorId: "phone_error",
                message: "Valid phone number is required (10-15 digits)",
                pattern: /^\+?\d{10,15}$/,
            },
            { id: "address", errorId: "address_error", message: "Delivery address is required", pattern: /.+/ },
        ];

        fields.forEach((field) => {
            const input = document.getElementById(field.id);
            const error = document.getElementById(field.errorId);

            if (!input || !error) {
                console.error(`Input or error element not found for field: ${field.id}`);
                isValid = false;
                errorMessages.push(`Field ${field.id} is missing`);
                return;
            }

            if (!input.value || !field.pattern.test(input.value)) {
                error.textContent = field.message;
                input.classList.add("error");
                isValid = false;
                errorMessages.push(field.message);
            } else {
                error.textContent = "";
                input.classList.remove("error");
            }
        });

        // Validate map location
        const latInput = document.getElementById("lat");
        const lngInput = document.getElementById("lng");
        const addressSearchError = document.getElementById("address_search_error");

        if (!latInput.value || !lngInput.value || isNaN(latInput.value) || isNaN(lngInput.value)) {
            addressSearchError.textContent = "Please select a valid delivery location on the map";
            isValid = false;
            errorMessages.push("Invalid or missing map location");
        } else {
            addressSearchError.textContent = "";
        }

        // Log validation errors for debugging
        if (!isValid) {
            console.log("Form validation failed:", errorMessages);
            showToast("Validation Error", "Please fix the errors in the form: " + errorMessages.join(", "), "error");
        } else {
            console.log("Form validation passed!");
        }

        return isValid;
    }

    // Validate phone number for QR payments
    function validatePhoneNumber(phoneId, errorId) {
        const phoneInput = document.getElementById(phoneId);
        const phoneError = document.getElementById(errorId);

        if (!phoneInput || !phoneError) {
            console.error(`Phone input or error element not found: ${phoneId}, ${errorId}`);
            return false;
        }

        if (!phoneInput.value || !/^\+?\d{10,15}$/.test(phoneInput.value)) {
            phoneError.textContent = "Please enter a valid phone number";
            phoneInput.classList.add("error");
            return false;
        } else {
            phoneError.textContent = "";
            phoneInput.classList.remove("error");
            return true;
        }
    }

    // Form validation for card payment
    function validateCardForm() {
        let isValid = true;
        const fields = [{
                id: "card_number",
                errorId: "card_number_error",
                message: "Valid card number is required (16 digits)",
                pattern: /^\d{16}$/,
            },
            {
                id: "expiry_date",
                errorId: "expiry_date_error",
                message: "Valid expiry date is required (MM/YY)",
                pattern: /^(0[1-9]|1[0-2])\/([0-9]{2})$/,
            },
            { id: "cvv", errorId: "cvv_error", message: "Valid CVV is required (3-4 digits)", pattern: /^\d{3,4}$/ },
            {
                id: "card_holder",
                errorId: "card_holder_error",
                message: "Card holder name is required",
                pattern: /^[A-Za-z\s]{2,}$/,
            },
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

        let subtotal = 0;
        const itemsHTML = itemsSource
            .map((item) => {
                const itemTotal = item.basePrice * item.quantity;
                subtotal += itemTotal;
                const toppingsText =
                    item.toppings && item.toppings.length > 0 ? item.toppings.map((t) => t.name).join(", ") : "None";
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
            })
            .join("");

        const tax = subtotal * 0.08;
        const total = subtotal + tax;
        currentTotal = total;

        orderItemsContainer.innerHTML = itemsHTML;
        checkoutSubtotal.textContent = formatPrice(subtotal);
        checkoutTax.textContent = formatPrice(tax);
        checkoutTotal.textContent = formatPrice(total);

        // Update payment amount displays
        paymentTotalDisplay.textContent = formatPrice(total);
        if (abaPaymentAmount) abaPaymentAmount.textContent = formatPriceWithoutSymbol(total);
        if (acledaPaymentAmount) acledaPaymentAmount.textContent = formatPriceWithoutSymbol(total);
        if (cardPaymentAmount) cardPaymentAmount.textContent = formatPriceWithoutSymbol(total);
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

        return toast;
    }

    // Process payment
    function processPayment(method, phoneNumber = null) {
        const modal = showLoadingModal("Processing your payment...", true);

        // Store phone number if provided
        if (phoneNumber) {
            paymentPhoneNumberInput.value = phoneNumber;
        }

        // Simulate payment processing (2 seconds)
        setTimeout(() => {
            if (!modal) return; // Ensure modal exists before hiding
            hideLoadingModal(modal);
            currentTransactionId = generateId("TX");
            updateReceipt(method);
            goToStep(3);
            clearCart();
            showToast("Payment Successful", "Your payment has been processed successfully!", "success");
            showCelebrationAnimation();
        }, 2000);
    }

    // Update receipt
    function updateReceipt(paymentMethod) {
        const firstName = document.getElementById("hidden_first_name").value || "";
        const lastName = document.getElementById("hidden_last_name").value || "";
        const email = document.getElementById("hidden_email").value || "";
        const address = document.getElementById("hidden_address").value || "";
        const phoneNumber = document.getElementById("payment_phone_number").value || "";

        orderNumber.textContent = bookingId || generateId("ORD");
        orderCustomer.textContent = `${firstName} ${lastName}`;
        orderEmail.textContent = email;
        orderAddress.textContent = address;

        const paymentMethodText = {
            card: "Visa Card",
            aba: `ABA Pay (${phoneNumber})`,
            acleda: `ACLEDA Pay (${phoneNumber})`,
        }[paymentMethod] || "Unknown";

        orderPaymentMethod.textContent = paymentMethodText;
        orderTransactionId.textContent = currentTransactionId;

        let subtotal = 0;
        const itemsHTML = itemsSource
            .map((item) => {
                const itemTotal = item.basePrice * item.quantity;
                subtotal += itemTotal;
                const toppingsText =
                    item.toppings && item.toppings.length > 0 ? item.toppings.map((t) => t.name).join(", ") : "None";
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
            })
            .join("");

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
                    phoneNumber,
                };
                bookings[bookingIndex].checkoutTimestamp = new Date().toISOString();
                localStorage.setItem("bookings", JSON.stringify(bookings));
            }
        }
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

    // Format card number with spaces
    function formatCardNumber(input) {
        let value = input.value.replace(/\D/g, "");
        if (value.length > 16) value = value.substr(0, 16);

        // Add spaces after every 4 digits
        let formattedValue = "";
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedValue += " ";
            }
            formattedValue += value[i];
        }

        input.value = formattedValue;
    }

    // Format expiry date
    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, "");
        if (value.length > 4) value = value.substr(0, 4);

        if (value.length > 2) {
            input.value = value.substr(0, 2) + "/" + value.substr(2);
        } else {
            input.value = value;
        }
    }

    // Handle customer form submission
    if (customerForm) {
        customerForm.addEventListener("submit", (e) => {
            e.preventDefault();
            console.log("Customer form submitted");

            // Disable the submit button to prevent multiple submissions
            continueToPaymentBtn.disabled = true;
            continueToPaymentBtn.textContent = "Validating...";

            // Validate the form
            if (validateForm()) {
                // Copy form data to hidden inputs for step 2
                [
                    "first_name",
                    "last_name",
                    "email",
                    "phone",
                    "address",
                    "notes",
                    "booking_id",
                    "lat",
                    "lng",
                    "formatted_address",
                ].forEach((field) => {
                    const input = document.getElementById(field);
                    if (input) {
                        document.getElementById(`hidden_${field}`).value = input.value;
                    }
                });

                // Move to payment step
                goToStep(2);
                showToast("Success", "Customer details validated. Proceed to payment.", "success");
            } else {
                // Show error toast if validation fails
                showToast("Validation Error", "Please fix the errors in the form before proceeding.", "error");
            }

            // Re-enable the submit button
            continueToPaymentBtn.disabled = false;
            continueToPaymentBtn.textContent = "Continue to Payment";
        });
    }

    // Handle payment option selection
    paymentOptions.forEach((option) => {
        option.addEventListener("click", () => {
            paymentOptions.forEach((o) => o.classList.remove("active"));
            option.classList.add("active");

            const method = option.dataset.method;
            selectedPaymentMethodInput.value = method;

            // Hide all payment method contents
            document.querySelectorAll(".payment-method-content").forEach((content) => {
                content.style.display = "none";
            });

            // Hide default message
            document.getElementById("payment-method-default").style.display = "none";

            // Show selected payment method content
            const selectedContent = document.getElementById(`${method}_payment_content`);
            if (selectedContent) {
                selectedContent.style.display = "block";
            }
        });
    });

    // Handle card input formatting
    const cardNumberInput = document.getElementById("card_number");
    if (cardNumberInput) {
        cardNumberInput.addEventListener("input", () => formatCardNumber(cardNumberInput));
    }

    const expiryDateInput = document.getElementById("expiry_date");
    if (expiryDateInput) {
        expiryDateInput.addEventListener("input", () => formatExpiryDate(expiryDateInput));
    }

    // Handle payment processing buttons
    if (processCardPaymentBtn) {
        processCardPaymentBtn.addEventListener("click", () => {
            if (validateCardForm()) {
                processPayment("card");
            }
        });
    }

    if (processAbaPaymentBtn) {
        processAbaPaymentBtn.addEventListener("click", () => {
            if (validatePhoneNumber("aba_phone", "aba_phone_error")) {
                const phoneNumber = document.getElementById("aba_phone").value;
                processPayment("aba", phoneNumber);
            }
        });
    }

    if (processAcledaPaymentBtn) {
        processAcledaPaymentBtn.addEventListener("click", () => {
            if (validatePhoneNumber("acleda_phone", "acleda_phone_error")) {
                const phoneNumber = document.getElementById("acleda_phone").value;
                processPayment("acleda", phoneNumber);
            }
        });
    }

    // Handle back to customer details
    if (backToCustomerBtn) {
        backToCustomerBtn.addEventListener("click", () => goToStep(1));
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
                              window.onload = function() {
                                  window.print();
                                  setTimeout(function() {
                                      window.close();
                                  }, 500);
                              };
                          </script>
                      </body>
                  </html>
              `);
            printWindow.document.close();
            showToast("Receipt Printed", "Your receipt is being printed.", "success");
        });
    }

    // Handle download receipt as PDF
    if (downloadReceiptBtn) {
        downloadReceiptBtn.addEventListener("click", () => {
            const receiptContent = document.getElementById("receipt-container")
            const modal = showLoadingModal("Generating PDF...", true)

            const opt = {
                margin: 0.5,
                filename: `XingFuCha_Receipt_${orderNumber.textContent}.pdf`,
                image: { type: "jpeg", quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
            }

            // Check if html2pdf is defined before using it
            if (typeof html2pdf !== "undefined") {
                html2pdf()
                    .from(receiptContent)
                    .set(opt)
                    .save()
                    .then(() => {
                        hideLoadingModal(modal)
                        showToast("PDF Downloaded", "Your receipt has been downloaded successfully!", "success")
                    })
                    .catch((error) => {
                        hideLoadingModal(modal)
                        console.error("PDF generation error:", error)
                        showToast("Error", "Failed to generate PDF. Please try again.", "error")
                    })
            } else {
                hideLoadingModal(modal)
                console.error("html2pdf is not defined. Ensure it is properly imported.")
                showToast("Error", "Failed to generate PDF. html2pdf is not available.", "error")
            }
        })
    }

    // Initialize
    loadOrderSummary()
})