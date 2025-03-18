// assets/js/order.js
document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const categoryButtons = document.querySelectorAll(".category-btn");
            const productCards = document.querySelectorAll(".product-card");
            const searchInput = document.getElementById("productSearch");
            const orderButtons = document.querySelectorAll(".order-btn");
            const orderPanel = document.getElementById("orderPanel");
            const closeBtn = document.querySelector(".order-panel .close-btn");
            const overlay = document.getElementById("overlay");
            const noProductMessage = document.getElementById("no-product-message");

            // Form Elements
            const drinkSizeSelect = document.getElementById("drinkSize");
            const sugarLevelSelect = document.getElementById("sugarLevel");
            const iceLevelSelect = document.getElementById("iceLevel");
            const toppingCheckboxes = document.querySelectorAll('#toppings input[type="checkbox"]');
            const confirmBtn = document.querySelector(".confirm-btn");
            const productImage = document.getElementById("productImage");
            const productName = document.getElementById("productName");
            const productPrice = document.getElementById("productPrice");

            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById("toastContainer");
            if (!toastContainer) {
                toastContainer = document.createElement("div");
                toastContainer.id = "toastContainer";
                toastContainer.className = "toast-container";
                document.body.appendChild(toastContainer);
            }

            // Cart data
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            updateCartCount();

            // Current product data
            const currentProduct = {
                id: null,
                name: "",
                price: 0,
                image: "",
                size: "small",
                sugar: "50",
                ice: "normal",
                toppings: [],
                quantity: 1
            };

            // Filter products by category
            categoryButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    // Remove active class from all buttons
                    categoryButtons.forEach((btn) => btn.classList.remove("active"));

                    // Add active class to clicked button
                    this.classList.add("active");

                    const category = this.getAttribute("data-category");

                    // Filter products
                    let visibleCount = 0;
                    productCards.forEach((card) => {
                        if (category === "all" || card.getAttribute("data-category") === category) {
                            card.style.display = "block";
                            visibleCount++;
                        } else {
                            card.style.display = "none";
                        }
                    });

                    // Show/hide no products message
                    if (visibleCount === 0) {
                        noProductMessage.style.display = "block";
                    } else {
                        noProductMessage.style.display = "none";
                    }
                });
            });

            // Search functionality
            searchInput.addEventListener("input", function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                productCards.forEach((card) => {
                    const productName = card.querySelector("h3").textContent.toLowerCase();
                    const productDescription = card.querySelector("p").textContent.toLowerCase();

                    if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                        card.style.display = "block";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                });

                // Show/hide no products message
                if (visibleCount === 0) {
                    noProductMessage.style.display = "block";
                } else {
                    noProductMessage.style.display = "none";
                }
            });

            // Open order panel
            orderButtons.forEach((button) => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productCard = this.closest(".product-card");
                    currentProduct.id = this.getAttribute("data-product-id");
                    currentProduct.name = productCard.querySelector("h3").textContent;
                    currentProduct.price = Number.parseFloat(productCard.querySelector(".product-price").textContent.replace("$", ""));
                    currentProduct.image = productCard.querySelector(".product-image img").src;

                    // Update order panel with product details
                    productImage.src = currentProduct.image;
                    productName.textContent = currentProduct.name;
                    productName.setAttribute("data-id", currentProduct.id);
                    productPrice.textContent = "$" + currentProduct.price.toFixed(2);
                    document.getElementById("basePrice").textContent = "$" + currentProduct.price.toFixed(2);

                    // Reset form
                    drinkSizeSelect.selectedIndex = 0;
                    sugarLevelSelect.selectedIndex = 2; // Default to 50% sugar
                    iceLevelSelect.selectedIndex = 2; // Default to normal ice
                    toppingCheckboxes.forEach((checkbox) => (checkbox.checked = false));

                    // Update total price
                    updateTotalPrice();

                    // Show order panel and overlay
                    orderPanel.classList.add("active");
                    overlay.classList.add("active");

                    // Add animation
                    orderPanel.style.animation = "slideIn 0.3s forwards";
                });
            });

            // Close order panel
            closeBtn.addEventListener("click", closeOrderPanel);
            overlay.addEventListener("click", closeOrderPanel);

            function closeOrderPanel() {
                orderPanel.style.animation = "slideOut 0.3s forwards";
                setTimeout(() => {
                    orderPanel.classList.remove("active");
                    overlay.classList.remove("active");
                }, 300);
            }

            // Update price when options change
            drinkSizeSelect.addEventListener("change", function() {
                currentProduct.size = this.value;
                updateTotalPrice();
            });

            sugarLevelSelect.addEventListener("change", function() {
                currentProduct.sugar = this.value;
            });

            iceLevelSelect.addEventListener("change", function() {
                currentProduct.ice = this.value;
            });

            toppingCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener("change", () => {
                    updateToppings();
                    updateTotalPrice();
                });
            });

            // Update toppings array
            function updateToppings() {
                currentProduct.toppings = [];
                toppingCheckboxes.forEach((checkbox) => {
                    if (checkbox.checked) {
                        currentProduct.toppings.push({
                            name: checkbox.value,
                            price: Number.parseFloat(checkbox.getAttribute("data-price")),
                        });
                    }
                });
            }

            // Calculate and update total price
            function updateTotalPrice() {
                // Base price
                const basePrice = currentProduct.price;

                // Size price
                let sizePrice = 0;
                if (currentProduct.size === "medium") {
                    sizePrice = 0.5;
                } else if (currentProduct.size === "large") {
                    sizePrice = 1.0;
                }

                // Toppings price
                let toppingsPrice = 0;
                currentProduct.toppings.forEach((topping) => {
                    toppingsPrice += topping.price;
                });

                // Update price displays
                document.getElementById("sizePrice").textContent = "$" + sizePrice.toFixed(2);
                document.getElementById("toppingsPrice").textContent = "$" + toppingsPrice.toFixed(2);

                // Calculate total
                const total = basePrice + sizePrice + toppingsPrice;
                document.getElementById("totalPrice").textContent = "$" + total.toFixed(2);
            }

            // Add to cart
            confirmBtn.addEventListener("click", () => {
                // Get current selections
                const size = drinkSizeSelect.options[drinkSizeSelect.selectedIndex].text;
                const sizeValue = drinkSizeSelect.value;
                const sugar = sugarLevelSelect.options[sugarLevelSelect.selectedIndex].text;
                const sugarValue = sugarLevelSelect.value;
                const ice = iceLevelSelect.options[iceLevelSelect.selectedIndex].text;
                const iceValue = iceLevelSelect.value;

                // Calculate total price
                const basePrice = currentProduct.price;
                let sizePrice = 0;
                if (sizeValue === "medium") {
                    sizePrice = 0.5;
                } else if (sizeValue === "large") {
                    sizePrice = 1.0;
                }

                let toppingsPrice = 0;
                const selectedToppings = [];
                toppingCheckboxes.forEach((checkbox) => {
                    if (checkbox.checked) {
                        const toppingPrice = Number.parseFloat(checkbox.getAttribute("data-price"));
                        toppingsPrice += toppingPrice;
                        selectedToppings.push({
                            name: checkbox.value,
                            price: toppingPrice
                        });
                    }
                });

                const totalPrice = basePrice + sizePrice + toppingsPrice;

                // Create order item
                const orderItem = {
                    id: Date.now(), // Unique ID for the cart item
                    productId: currentProduct.id,
                    name: currentProduct.name,
                    image: currentProduct.image,
                    basePrice: basePrice,
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
                    quantity: 1,
                    totalPrice: totalPrice,
                    orderDate: new Date().toISOString(),
                    status: "processing"
                };

                // Add to cart
                cart.push(orderItem);
                saveCart();
                updateCartCount();

                // Create order summary
                let toppingsText = "";
                if (selectedToppings.length > 0) {
                    const toppingNames = selectedToppings.map((t) => t.name).join(", ");
                    toppingsText = ` with ${toppingNames}`;
                }

                const orderSummary = `${size}, ${sugar}, ${ice}${toppingsText}`;
                const totalPriceText = "$" + totalPrice.toFixed(2);

                // Show toast notification
                showToast(currentProduct.name, orderSummary, totalPriceText);

                // Close order panel
                closeOrderPanel();

                // Show added to cart notification
                setTimeout(() => {
                    showToast("Order Added", "Your order has been added to cart!", "", "success");

                    // Ask if user wants to go to booking page
                    setTimeout(() => {
                        if (confirm("Your order has been added to cart. Would you like to view your orders?")) {
                            window.location.href = '/booking';
                        }
                    }, 1000);
                }, 1500);
            });

            // Save cart to localStorage
            function saveCart() {
                localStorage.setItem("cart", JSON.stringify(cart));
            }

            // Update cart count
            function updateCartCount() {
                const cartCount = cart.length;
                const bookingBadge = document.getElementById("bookingBadge");
                if (bookingBadge) {
                    bookingBadge.textContent = cartCount;
                    bookingBadge.style.display = cartCount > 0 ? "inline-block" : "none";
                }
            }

            // Show toast notification
            function showToast(title, message, price = "", type = "info") {
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
                ${price ? `<p style="font-weight: 600; color: #ff5e62; margin-top: 5px;">${price}</p>` : ""}
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

    // Initialize favorite buttons
    const favoriteButtons = document.querySelectorAll(".favorite-btn");
    favoriteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const productCard = this.closest(".product-card");
            const productId = productCard.querySelector(".order-btn").getAttribute("data-product-id");
            const productName = productCard.querySelector("h3").textContent;
            const productImage = productCard.querySelector(".product-image img").src;
            const productPrice = productCard.querySelector(".product-price").textContent;
            
            const icon = this.querySelector("i");
            if (icon.classList.contains("far")) {
                icon.classList.remove("far");
                icon.classList.add("fas");
                saveFavorite(productId, productName, productImage, productPrice);
                showToast("Added to Favorites", "Item added to your favorites!", "", "success");
            } else {
                icon.classList.remove("fas");
                icon.classList.add("far");
                removeFavorite(productId);
                showToast("Removed from Favorites", "Item removed from your favorites", "", "info");
            }
        });
    });

    // Save favorite to localStorage
    function saveFavorite(id, name, image, price) {
        let favorites = JSON.parse(localStorage.getItem("favorites")) || [];
        
        if (!favorites.some(item => item.id === id)) {
            favorites.push({ id, name, image, price });
            localStorage.setItem("favorites", JSON.stringify(favorites));
        }
    }

    // Remove favorite from localStorage
    function removeFavorite(id) {
        let favorites = JSON.parse(localStorage.getItem("favorites")) || [];
        favorites = favorites.filter(item => item.id !== id);
        localStorage.setItem("favorites", JSON.stringify(favorites));
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(100%); }
        }
        
        .order-panel {
            transition: transform 0.3s ease;
        }
        
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .order-btn {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        
        .order-btn:hover {
            transform: scale(1.05);
        }
        
        .favorite-btn {
            transition: transform 0.3s ease;
        }
        
        .favorite-btn:hover {
            transform: scale(1.2);
        }
    `;
    document.head.appendChild(style);
});