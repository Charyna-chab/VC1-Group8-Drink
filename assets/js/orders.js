/**
 * Enhanced Order Management System
 * Provides a modern, user-friendly interface for ordering drinks with customizations
 */

document.addEventListener("DOMContentLoaded", () => {
    // ======== DOM ELEMENT REFERENCES ========
    const elements = {
        // Category and product elements
        categoryButtons: document.querySelectorAll(".category-btn"),
        productCards: document.querySelectorAll(".product-card"),
        searchInput: document.getElementById("productSearch"),
        orderButtons: document.querySelectorAll(".order-btn"),
        noProductMessage: document.getElementById("no-product-message"),

        // Panels and modals
        orderPanel: document.getElementById("orderPanel"),
        cartPanel: document.getElementById("cartPanel"),
        productDetailModal: document.getElementById("productDetailModal"),
        overlay: document.getElementById("overlay"),
        closeButtons: document.querySelectorAll(".close-btn"),

        // Product detail elements
        detailProductImage: document.getElementById("detailProductImage"),
        detailProductName: document.getElementById("detailProductName"),
        detailProductDescription: document.getElementById("detailProductDescription"),
        detailProductPrice: document.getElementById("detailProductPrice"),
        detailProductCategory: document.getElementById("detailProductCategory"),

        // Action buttons
        customizeOrderBtn: document.getElementById("customizeOrderBtn"),
        addToFavoritesBtn: document.getElementById("addToFavoritesBtn"),
        addToCartBtn: document.querySelector(".add-to-cart-btn"),
        checkoutBtn: document.getElementById("checkoutBtn"),
        clearCartBtn: document.getElementById("clearCartBtn"),

        // Form elements
        drinkSizeSelect: document.getElementById("drinkSize"),
        sugarLevelSelect: document.getElementById("sugarLevel"),
        iceLevelSelect: document.getElementById("iceLevel"),
        toppingCheckboxes: document.querySelectorAll('#toppings input[type="checkbox"]'),
        customerPhoneInput: document.getElementById("customerPhone"), // Added
        customerIdInput: document.getElementById("customerId"),       // Added

        // Order customization display elements
        productImage: document.getElementById("productImage"),
        productName: document.getElementById("productName"),
        productPrice: document.getElementById("productPrice"),
        quantityInput: document.getElementById("quantity"),
        basePrice: document.getElementById("basePrice"),
        sizePrice: document.getElementById("sizePrice"),
        toppingsPrice: document.getElementById("toppingsPrice"),
        totalPrice: document.getElementById("totalPrice"),

        // Cart elements
        cartItemsContainer: document.getElementById("cartItems"),
        cartSubtotal: document.getElementById("cartSubtotal"),
        cartTax: document.getElementById("cartTax"),
        cartTotal: document.getElementById("cartTotal"),
        cartCount: document.getElementById("cartCount"),

        // Notification elements
        notificationPanel: document.getElementById("notificationPanel"),
        notificationList: document.getElementById("notificationList"),
        notificationButtons: document.querySelectorAll(".notification-btn"),

        // Favorite buttons
        favoriteButtons: document.querySelectorAll(".favorite-btn"),
    };

    // ======== CART MANAGEMENT ========
    function addCurrentProductToCart() {
        if (!elements.drinkSizeSelect || !elements.sugarLevelSelect || !elements.iceLevelSelect) {
            console.error("Form elements not found");
            return;
        }

        // Disable the button to prevent multiple clicks
        if (elements.addToCartBtn) {
            elements.addToCartBtn.disabled = true;
            elements.addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        }

        // Get current selections
        const size = elements.drinkSizeSelect.options[elements.drinkSizeSelect.selectedIndex].text;
        const sizeValue = elements.drinkSizeSelect.value;
        const sizePrice = Number.parseFloat(
            elements.drinkSizeSelect.options[elements.drinkSizeSelect.selectedIndex].getAttribute("data-price") || "0"
        );

        const sugar = elements.sugarLevelSelect.options[elements.sugarLevelSelect.selectedIndex].text;
        const sugarValue = elements.sugarLevelSelect.value;

        const ice = elements.iceLevelSelect.options[elements.iceLevelSelect.selectedIndex].text;
        const iceValue = elements.iceLevelSelect.value;

        // Get customer details
        const customerPhone = elements.customerPhoneInput.value.trim();
        const customerId = elements.customerIdInput.value.trim();

        // Validate customer details
        if (!customerPhone || !customerId) {
            alert("Please enter your phone number and customer ID.");
            elements.addToCartBtn.disabled = false;
            elements.addToCartBtn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart';
            return;
        }

        // Calculate total price
        const basePrice = currentProduct.price;

        let toppingsPrice = 0;
        const selectedToppings = [];
        elements.toppingCheckboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const toppingPrice = Number.parseFloat(checkbox.getAttribute("data-price") || "0");
                toppingsPrice += toppingPrice;
                selectedToppings.push({
                    name: checkbox.value,
                    price: toppingPrice
                });
            }
        });

        const itemPrice = basePrice + sizePrice + toppingsPrice;
        const quantity = currentProduct.quantity;
        const totalPrice = itemPrice * quantity;

        // Create order item
        const orderItem = {
            id: Date.now().toString(), // Unique ID for the cart item
            productId: currentProduct.productId,
            name: currentProduct.name,
            image: currentProduct.image,
            description: currentProduct.description,
            basePrice: itemPrice,
            size: {
                name: size,
                value: sizeValue,
                price: sizePrice
            },
            sugar: {
                name: sugar,
                value: sugarValue
            },
            ice: {
                name: ice,
                value: iceValue
            },
            toppings: selectedToppings,
            quantity: quantity,
            totalPrice: totalPrice,
            customerPhone: customerPhone, // Added customer phone
            customerId: customerId,       // Added customer ID
            orderDate: new Date().toISOString(),
            status: "processing"
        };

        // Add to cart
        addToCart(orderItem);

        // Close order panel
        closeAllPanels();

        // Re-enable the button
        if (elements.addToCartBtn) {
            elements.addToCartBtn.disabled = false;
            elements.addToCartBtn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart';
        }

        // Show success message
        showToast("Added to Cart", `${orderItem.name} has been added to your cart.`, "success");
        addNotification("Added to Cart", `${orderItem.name} (${orderItem.size.name}) has been added to your cart.`, "cart");
    }

    function addToCart(item) {
        // Add item to cart array
        cart.push(item);

        // Save to localStorage
        localStorage.setItem("cart", JSON.stringify(cart));

        // Update cart count
        updateCartCount();

        // Update cart panel if it's open
        if (elements.cartPanel && elements.cartPanel.classList.contains("active")) {
            renderCartItems();
        }
    }

    // ======== INITIALIZATION ========
    function init() {
        updateCartCount();
        setupEventListeners();
    }

    // Initialize the application
    init();
});