document.addEventListener("DOMContentLoaded", () => {
            // DOM Elements
            const categoryButtons = document.querySelectorAll(".category-btn");
            const productCards = document.querySelectorAll(".product-card");
            const searchInput = document.getElementById("productSearch");
            const orderButtons = document.querySelectorAll(".order-btn");
            const orderPanel = document.getElementById("orderPanel");
            const closeBtn = document.querySelector(".order-panel .close-btn");
            const overlay = document.getElementById("overlay");

            // Form Elements
            const drinkSizeSelect = document.getElementById("drinkSize");
            const sugarLevelSelect = document.getElementById("sugarLevel");
            const toppingCheckboxes = document.querySelectorAll('#toppings input[type="checkbox"]');
            const confirmBtn = document.querySelector(".confirm-btn");

            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById("toastContainer");
            if (!toastContainer) {
                toastContainer = document.createElement("div");
                toastContainer.id = "toastContainer";
                toastContainer.className = "toast-container";
                document.body.appendChild(toastContainer);
            }

            // Current product data
            const currentProduct = {
                id: null,
                name: "",
                price: 0,
                image: "",
                size: "small",
                sugar: "no",
                toppings: [],
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
                    productCards.forEach((card) => {
                        if (category === "all" || card.getAttribute("data-category") === category) {
                            card.style.display = "block";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            });

            // Search functionality
            searchInput.addEventListener("input", function() {
                const searchTerm = this.value.toLowerCase().trim();

                productCards.forEach((card) => {
                    const productName = card.querySelector("h3").textContent.toLowerCase();
                    const productDescription = card.querySelector("p").textContent.toLowerCase();

                    if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
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
                    document.getElementById("productImage").src = currentProduct.image;
                    document.getElementById("productName").textContent = currentProduct.name;
                    document.getElementById("productPrice").textContent = "$" + currentProduct.price.toFixed(2);
                    document.getElementById("basePrice").textContent = "$" + currentProduct.price.toFixed(2);

                    // Reset form
                    drinkSizeSelect.selectedIndex = 0;
                    sugarLevelSelect.selectedIndex = 0;
                    toppingCheckboxes.forEach((checkbox) => (checkbox.checked = false));

                    // Update total price
                    updateTotalPrice();

                    // Show order panel and overlay
                    orderPanel.classList.add("active");
                    overlay.classList.add("active");
                });
            });

            // Close order panel
            closeBtn.addEventListener("click", closeOrderPanel);
            overlay.addEventListener("click", closeOrderPanel);

            function closeOrderPanel() {
                orderPanel.classList.remove("active");
                overlay.classList.remove("active");
            }

            // Update price when options change
            drinkSizeSelect.addEventListener("change", function() {
                currentProduct.size = this.value;
                updateTotalPrice();
            });

            sugarLevelSelect.addEventListener("change", function() {
                currentProduct.sugar = this.value;
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
                const sugar = sugarLevelSelect.options[sugarLevelSelect.selectedIndex].text;

                // Create order summary
                let toppingsText = "";
                if (currentProduct.toppings.length > 0) {
                    const toppingNames = currentProduct.toppings.map((t) => t.name).join(", ");
                    toppingsText = ` with ${toppingNames}`;
                }

                const orderSummary = `${size}, ${sugar}${toppingsText}`;
                const totalPrice = document.getElementById("totalPrice").textContent;

                // Show toast notification
                showToast(currentProduct.name, orderSummary, totalPrice);

                // Close order panel
                closeOrderPanel();

                // Redirect to booking page after a delay (simulating adding to cart)
                setTimeout(() => {
                    // In a real application, you would save the order to the cart first
                    // window.location.href = '/booking';

                    // For demo purposes, just show another toast
                    showToast("Order Added", "Your order has been added to cart!", "", "success");
                }, 1500);
            });

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

            const icon = this.querySelector("i");
            if (icon.classList.contains("far")) {
                icon.classList.remove("far");
                icon.classList.add("fas");
                showToast("Added to Favorites", "Item added to your favorites!", "", "success");
            } else {
                icon.classList.remove("fas");
                icon.classList.add("far");
                showToast("Removed from Favorites", "Item removed from your favorites", "", "info");
            }
        });
    });
});