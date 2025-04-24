// cart.js
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const cartPanel = document.getElementById("cartPanel");
    const cartItemsContainer = document.getElementById("cartItems");
    const cartSubtotal = document.getElementById("cartSubtotal");
    const cartTax = document.getElementById("cartTax");
    const cartTotal = document.getElementById("cartTotal");
    const clearCartBtn = document.getElementById("clearCartBtn");
    const checkoutBtn = document.getElementById("checkoutBtn");
    const addToCartBtn = document.querySelector(".add-to-cart-btn");
    const userIdInput = document.getElementById("userId");

    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Update cart display
    function updateCart() {
        if (!cartItemsContainer) return;
        cartItemsContainer.innerHTML = "";
        let subtotal = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <p>Your cart is empty</p>
                </div>
            `;
        } else {
            cart.forEach((item, index) => {
                const itemTotal = item.totalPrice;
                subtotal += itemTotal;
                const toppingsText = item.toppings.length > 0 ? item.toppings.map(t => t.name).join(", ") : "None";
                const cartItem = document.createElement("div");
                cartItem.className = "cart-item";
                cartItem.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <div class="cart-item-details">
                        <h4>${item.name}</h4>
                        <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
                        <p>Toppings: ${toppingsText}</p>
                        <p>Quantity: ${item.quantity}</p>
                    </div>
                    <div class="cart-item-price">$${itemTotal.toFixed(2)}</div>
                    <button class="remove-item" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                cartItemsContainer.appendChild(cartItem);
            });
        }

        const tax = subtotal * 0.08;
        const total = subtotal + tax;
        cartSubtotal.textContent = formatPrice(subtotal);
        cartTax.textContent = formatPrice(tax);
        cartTotal.textContent = formatPrice(total);

        localStorage.setItem("cart", JSON.stringify(cart));
    }

    // Add item to cart
    if (addToCartBtn) {
        addToCartBtn.addEventListener("click", () => {
            const productImage = document.getElementById("productImage").src;
            const productName = document.getElementById("productName").textContent;
            const basePrice = parseFloat(document.getElementById("basePrice").textContent.replace("$", ""));
            const sizePrice = parseFloat(document.getElementById("sizePrice").textContent.replace("$", ""));
            const toppingsPrice = parseFloat(document.getElementById("toppingsPrice").textContent.replace("$", ""));
            const totalPrice = parseFloat(document.getElementById("totalPrice").textContent.replace("$", ""));
            const quantity = parseInt(document.getElementById("quantity").value);
            const size = { name: document.getElementById("drinkSize").options[document.getElementById("drinkSize").selectedIndex].text, price: sizePrice };
            const sugar = { name: document.getElementById("sugarLevel").options[document.getElementById("sugarLevel").selectedIndex].text };
            const ice = { name: document.getElementById("iceLevel").options[document.getElementById("iceLevel").selectedIndex].text };
            const toppings = Array.from(document.querySelectorAll("#toppings input:checked")).map(input => ({
                name: input.value,
                price: parseFloat(input.dataset.price)
            }));

            const cartItem = {
                image: productImage,
                name: productName,
                basePrice,
                size,
                sugar,
                ice,
                toppings,
                quantity,
                totalPrice: totalPrice * quantity
            };

            cart.push(cartItem);
            updateCart();

            // Create booking and redirect
            createBookingFromCart();
            showRedirectNotification(
                "Order Added",
                "Your order has been added to bookings. Redirecting to bookings page...",
                "/booking"
            );

            // Close order panel
            document.getElementById("orderPanel").classList.remove("active");
            document.getElementById("overlay").classList.remove("active");
        });
    }

    // Create booking from cart
    function createBookingFromCart() {
        if (cart.length === 0) return;

        const subtotal = cart.reduce((total, item) => total + item.totalPrice, 0);
        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        const booking = {
            id: generateId("ORD"),
            date: new Date().toISOString(),
            items: cart,
            subtotal,
            tax,
            total,
            status: "processing",
            paymentStatus: "pending",
            paymentMethod: null
        };

        let bookings = JSON.parse(localStorage.getItem("bookings")) || [];
        bookings.unshift(booking);
        localStorage.setItem("bookings", JSON.stringify(bookings));

        // Clear cart after creating booking
        cart = [];
        updateCart();
    }

    // Remove item from cart
    cartItemsContainer.addEventListener("click", (e) => {
        if (e.target.closest(".remove-item")) {
            const index = e.target.closest(".remove-item").dataset.index;
            cart.splice(index, 1);
            updateCart();
            window.addNotification("Item Removed", "The item has been removed from your cart.", "cart");
        }
    });

    // Clear cart
    if (clearCartBtn) {
        clearCartBtn.addEventListener("click", () => {
            cart = [];
            updateCart();
            window.addNotification("Cart Cleared", "Your cart has been cleared.", "cart");
        });
    }

    // Checkout
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", () => {
            if (cart.length === 0) {
                window.addNotification("Empty Cart", "Please add items to your cart before checking out.", "error");
                return;
            }
            // Create booking and redirect to checkout
            createBookingFromCart();
            const bookingId = JSON.parse(localStorage.getItem("bookings"))[0].id;
            showRedirectNotification(
                "Proceeding to Checkout",
                "Your order has been saved. Redirecting to checkout...",
                `/checkout?booking_id=${bookingId}`
            );
        });
    }

    // Initialize cart
    updateCart();
});