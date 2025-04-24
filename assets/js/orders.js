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

    // ======== STATE MANAGEMENT ========
    // Current product being customized
    const currentProduct = {
        id: null,
        productId: null,
        name: "",
        price: 0,
        image: "",
        description: "",
        size: { name: "Small-Size", value: "small", price: 0 },
        sugar: { name: "50% Sugar", value: "50" },
        ice: { name: "Normal Ice", value: "normal" },
        toppings: [],
        quantity: 1,
        basePrice: 0,
        totalPrice: 0,
    };

    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // ======== INITIALIZATION ========
    function init() {
        updateCartCount();
        checkUrlParameters();
        setupEventListeners();
        updateFavoriteButtons();
    }

    // Check URL parameters for product_id
    function checkUrlParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        const productIdFromUrl = urlParams.get("product_id");

        if (productIdFromUrl) {
            const productButton = document.querySelector(`.order-btn[data-product-id="${productIdFromUrl}"]`);
            if (productButton) {
                setTimeout(() => productButton.click(), 500);
            }
        }
    }

    // ======== EVENT LISTENERS ========
    function setupEventListeners() {
        // Category filtering
        setupCategoryFilters();

        // Search functionality
        setupSearch();

        // Order buttons
        setupOrderButtons();

        // Product detail actions
        setupProductDetailActions();

        // Close buttons and overlay
        setupCloseActions();

        // Customization form
        setupCustomizationForm();

        // Cart actions
        setupCartActions();

        // Favorites
        setupFavoriteButtons();

        // Notifications
        setupNotifications();
    }

    // ======== CATEGORY FILTERING ========
    function setupCategoryFilters() {
        elements.categoryButtons.forEach((button) => {
            button.addEventListener("click", function() {
                elements.categoryButtons.forEach((btn) => btn.classList.remove("active"));
                this.classList.add("active");

                const category = this.getAttribute("data-category");

                let visibleCount = 0;
                elements.productCards.forEach((card) => {
                    const shouldShow = category === "all" || card.getAttribute("data-category") === category;
                    card.style.display = shouldShow ? "block" : "none";
                    if (shouldShow) visibleCount++;
                });

                if (elements.noProductMessage) {
                    elements.noProductMessage.style.display = visibleCount === 0 ? "block" : "none";
                }
            });
        });
    }

    // ======== SEARCH FUNCTIONALITY ========
    function setupSearch() {
        if (elements.searchInput) {
            elements.searchInput.addEventListener("input", function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                elements.productCards.forEach((card) => {
                    const productName = card.querySelector("h3").textContent.toLowerCase();
                    const productDescription = card.querySelector(".product-desc").textContent.toLowerCase();
                    const shouldShow = productName.includes(searchTerm) || productDescription.includes(searchTerm);

                    card.style.display = shouldShow ? "block" : "none";
                    if (shouldShow) visibleCount++;
                });

                if (elements.noProductMessage) {
                    elements.noProductMessage.style.display = visibleCount === 0 ? "block" : "none";
                }
            });
        }
    }

    // ======== PANEL MANAGEMENT ========
    function closeAllPanels() {
        if (elements.orderPanel && elements.orderPanel.classList.contains("active")) {
            elements.orderPanel.classList.remove("active");
            elements.orderPanel.style.display = "none";
        }

        if (elements.productDetailModal && elements.productDetailModal.classList.contains("active")) {
            elements.productDetailModal.classList.remove("active");
            elements.productDetailModal.style.display = "none";
        }

        if (elements.cartPanel && elements.cartPanel.classList.contains("active")) {
            elements.cartPanel.classList.remove("active");
            elements.cartPanel.style.display = "none";
        }

        if (elements.notificationPanel && elements.notificationPanel.classList.contains("active")) {
            elements.notificationPanel.classList.remove("active");
        }

        if (elements.overlay) {
            elements.overlay.style.display = "none";
            elements.overlay.classList.remove("active");
        }

        document.querySelectorAll(".order-confirmation-card").forEach(card => card.remove());
    }

    // ======== PRODUCT DETAIL ========
    function setupOrderButtons() {
        elements.orderButtons.forEach((button) => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();

                closeAllPanels();

                const productCard = this.closest(".product-card");
                if (!productCard) {
                    console.error("Product card not found");
                    return;
                }

                const productId = this.getAttribute("data-product-id");
                const productName = productCard.querySelector("h3").textContent;
                const productDescription = productCard.querySelector(".product-desc").textContent;
                const productPrice = Number.parseFloat(
                    productCard.querySelector(".product-price").textContent.replace("$", "")
                );
                const productImage = productCard.querySelector(".product-image img").src;
                const productCategory = productCard.getAttribute("data-category");

                Object.assign(currentProduct, {
                    productId,
                    name: productName,
                    description: productDescription,
                    price: productPrice,
                    basePrice: productPrice,
                    image: productImage,
                    quantity: 1
                });

                showProductDetail(productId, productName, productDescription, productPrice, productImage, productCategory);
            });
        });
    }

    function showProductDetail(id, name, description, price, image, category) {
        if (!elements.productDetailModal) return;

        if (elements.detailProductImage) elements.detailProductImage.src = image;
        if (elements.detailProductName) elements.detailProductName.textContent = name;
        if (elements.detailProductDescription) elements.detailProductDescription.textContent = description;
        if (elements.detailProductPrice) elements.detailProductPrice.textContent = price.toFixed(2);

        if (elements.detailProductCategory) {
            const formattedCategory = category
                .split("-")
                .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
                .join(" ");
            elements.detailProductCategory.textContent = formattedCategory;
        }

        updateFavoriteButtonState(id);

        elements.productDetailModal.style.display = "block";
        elements.productDetailModal.classList.add("active");

        if (elements.overlay) {
            elements.overlay.style.display = "block";
            elements.overlay.classList.add("active");
        }
    }

    function updateFavoriteButtonState(productId) {
        if (!elements.addToFavoritesBtn) return;

        const favorites = JSON.parse(localStorage.getItem("favorites")) || [];
        const isFavorite = favorites.some((item) => item.id === productId);

        elements.addToFavoritesBtn.innerHTML = isFavorite ?
            '<i class="fas fa-heart"></i> Remove from Favorites' :
            '<i class="far fa-heart"></i> Add to Favorites';
    }

    function setupProductDetailActions() {
        if (elements.customizeOrderBtn) {
            elements.customizeOrderBtn.addEventListener("click", () => {
                if (elements.productDetailModal) {
                    elements.productDetailModal.classList.remove("active");
                    elements.productDetailModal.style.display = "none";
                }

                if (elements.productImage) elements.productImage.src = currentProduct.image;
                if (elements.productName) {
                    elements.productName.textContent = currentProduct.name;
                    elements.productName.setAttribute("data-id", currentProduct.productId);
                }
                if (elements.productPrice) elements.productPrice.textContent = "$" + currentProduct.price.toFixed(2);
                if (elements.basePrice) elements.basePrice.textContent = "$" + currentProduct.price.toFixed(2);

                resetCustomizationForm();

                if (elements.orderPanel) {
                    elements.orderPanel.style.display = "block";
                    elements.orderPanel.classList.add("active");

                    const toppingsSection = document.getElementById("toppings");
                    if (toppingsSection) {
                        toppingsSection.style.display = "block";
                    }

                    if (elements.overlay) {
                        elements.overlay.style.display = "block";
                        elements.overlay.classList.add("active");
                    }
                }

                addNotification(
                    "Customizing Order",
                    `You're customizing ${currentProduct.name}. Add toppings and adjust options to your liking!`,
                    "info"
                );
            });
        }

        if (elements.addToFavoritesBtn) {
            elements.addToFavoritesBtn.addEventListener("click", function() {
                const favorites = JSON.parse(localStorage.getItem("favorites")) || [];
                const isFavorite = favorites.some((item) => item.id === currentProduct.productId);

                if (isFavorite) {
                    removeFavorite(currentProduct.productId);
                    this.innerHTML = '<i class="far fa-heart"></i> Add to Favorites';
                    showToast("Removed from Favorites", `${currentProduct.name} has been removed from your favorites.`, "info");
                    addNotification("Removed from Favorites", `${currentProduct.name} has been removed from your favorites.`, "info");
                } else {
                    saveFavorite(
                        currentProduct.productId,
                        currentProduct.name,
                        currentProduct.image,
                        currentProduct.price.toFixed(2),
                        currentProduct.description
                    );
                    this.innerHTML = '<i class="fas fa-heart"></i> Remove from Favorites';
                    showToast("Added to Favorites", `${currentProduct.name} has been added to your favorites!`, "success");
                    addNotification("Added to Favorites", `${currentProduct.name} has been added to your favorites.`, "info");

                    const icon = this.querySelector("i");
                    if (icon) {
                        icon.style.animation = "heartBeat 0.5s ease-in-out";
                        setTimeout(() => {
                            icon.style.animation = "";
                        }, 500);
                    }
                }
            });
        }

        const closeDetailBtn = elements.productDetailModal ? elements.productDetailModal.querySelector(".close-btn") : null;
        if (closeDetailBtn) {
            closeDetailBtn.addEventListener("click", closeAllPanels);
        }
    }

    // ======== CLOSE ACTIONS ========
    function setupCloseActions() {
        elements.closeButtons.forEach((button) => {
            button.addEventListener("click", closeAllPanels);
        });

        if (elements.overlay) {
            elements.overlay.addEventListener("click", closeAllPanels);
        }
    }

    // ======== CUSTOMIZATION FORM ========
    function resetCustomizationForm() {
        if (elements.quantityInput) {
            elements.quantityInput.value = 1;
            currentProduct.quantity = 1;
        }

        if (elements.drinkSizeSelect) elements.drinkSizeSelect.selectedIndex = 0;
        if (elements.sugarLevelSelect) elements.sugarLevelSelect.selectedIndex = 2;
        if (elements.iceLevelSelect) elements.iceLevelSelect.selectedIndex = 2;

        elements.toppingCheckboxes.forEach((checkbox) => (checkbox.checked = false));
        currentProduct.toppings = [];

        updateTotalPrice();
    }

    function setupCustomizationForm() {
        if (elements.drinkSizeSelect) {
            elements.drinkSizeSelect.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];
                const sizePrice = Number.parseFloat(selectedOption.getAttribute("data-price") || "0");

                currentProduct.size = {
                    name: selectedOption.text,
                    value: this.value,
                    price: sizePrice
                };

                updateTotalPrice();
            });
        }

        if (elements.sugarLevelSelect) {
            elements.sugarLevelSelect.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];

                currentProduct.sugar = {
                    name: selectedOption.text,
                    value: this.value
                };
            });
        }

        if (elements.iceLevelSelect) {
            elements.iceLevelSelect.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];

                currentProduct.ice = {
                    name: selectedOption.text,
                    value: this.value
                };
            });
        }

        setupQuantityControls();
        setupToppingsSelection();

        if (elements.addToCartBtn) {
            elements.addToCartBtn.addEventListener("click", addCurrentProductToCart);
        }
    }

    function setupQuantityControls() {
        if (!elements.quantityInput) return;

        elements.quantityInput.addEventListener("change", function() {
            let quantity = Number.parseInt(this.value);

            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                this.value = 1;
            }

            currentProduct.quantity = quantity;
            updateTotalPrice();
        });

        const minusBtn = document.querySelector(".quantity-btn.minus");
        const plusBtn = document.querySelector(".quantity-btn.plus");

        if (minusBtn) {
            minusBtn.addEventListener("click", () => {
                let quantity = Number.parseInt(elements.quantityInput.value);
                if (quantity > 1) {
                    quantity--;
                    elements.quantityInput.value = quantity;
                    currentProduct.quantity = quantity;
                    updateTotalPrice();
                }
            });
        }

        if (plusBtn) {
            plusBtn.addEventListener("click", () => {
                let quantity = Number.parseInt(elements.quantityInput.value);
                quantity++;
                elements.quantityInput.value = quantity;
                currentProduct.quantity = quantity;
                updateTotalPrice();
            });
        }
    }

    function setupToppingsSelection() {
        if (!elements.toppingCheckboxes || elements.toppingCheckboxes.length === 0) return;

        elements.toppingCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener("change", () => {
                updateToppings();
                updateTotalPrice();
            });
        });
    }

    function updateToppings() {
        currentProduct.toppings = [];
        elements.toppingCheckboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                currentProduct.toppings.push({
                    name: checkbox.value,
                    price: Number.parseFloat(checkbox.getAttribute("data-price") || "0")
                });
            }
        });
    }

    function updateTotalPrice() {
        const baseItemPrice = currentProduct.price;
        const sizeItemPrice = currentProduct.size.price || 0;

        let toppingsItemPrice = 0;
        currentProduct.toppings.forEach((topping) => {
            toppingsItemPrice += topping.price;
        });

        if (elements.sizePrice) elements.sizePrice.textContent = "$" + sizeItemPrice.toFixed(2);
        if (elements.toppingsPrice) elements.toppingsPrice.textContent = "$" + toppingsItemPrice.toFixed(2);

        const itemTotal = baseItemPrice + sizeItemPrice + toppingsItemPrice;
        const total = itemTotal * currentProduct.quantity;

        currentProduct.totalPrice = total;

        if (elements.totalPrice) elements.totalPrice.textContent = "$" + total.toFixed(2);
    }

    // ======== CART MANAGEMENT ========
    function addCurrentProductToCart() {
        if (!elements.drinkSizeSelect || !elements.sugarLevelSelect || !elements.iceLevelSelect) {
            console.error("Form elements not found");
            return;
        }

        if (elements.addToCartBtn) {
            elements.addToCartBtn.disabled = true;
            elements.addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        }

        const size = elements.drinkSizeSelect.options[elements.drinkSizeSelect.selectedIndex].text;
        const sizeValue = elements.drinkSizeSelect.value;
        const sizePrice = Number.parseFloat(
            elements.drinkSizeSelect.options[elements.drinkSizeSelect.selectedIndex].getAttribute("data-price") || "0"
        );

        const sugar = elements.sugarLevelSelect.options[elements.sugarLevelSelect.selectedIndex].text;
        const sugarValue = elements.sugarLevelSelect.value;

        const ice = elements.iceLevelSelect.options[elements.iceLevelSelect.selectedIndex].text;
        const iceValue = elements.iceLevelSelect.value;

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

        const orderItem = {
            id: Date.now().toString(),
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
            orderDate: new Date().toISOString(),
            status: "processing"
        };

        addToCart(orderItem);

        closeAllPanels();

        if (elements.addToCartBtn) {
            elements.addToCartBtn.disabled = false;
            elements.addToCartBtn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart';
        }

        showToast("Added to Cart", `${orderItem.name} has been added to your cart.`, "success");
        addNotification("Added to Cart", `${orderItem.name} (${orderItem.size.name}) has been added to your cart.`, "cart");
    }

    function addToCart(item) {
        cart.push(item);
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount();

        if (elements.cartPanel && elements.cartPanel.classList.contains("active")) {
            renderCartItems();
        }
    }

    function updateCartCount() {
        const cartCount = cart.length;
        if (elements.cartCount) {
            elements.cartCount.textContent = cartCount;
            elements.cartCount.style.display = cartCount > 0 ? "block" : "none";
        }

        const bookingCountElement = document.querySelector(".sidebar-nav .nav-item:nth-child(2) .notification-count");
        if (bookingCountElement) {
            bookingCountElement.textContent = cartCount;
            bookingCountElement.style.display = cartCount > 0 ? "block" : "none";
        }
    }

    function setupCartActions() {
        const cartButtons = document.querySelectorAll(".cart-btn");
        cartButtons.forEach((button) => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();

                closeAllPanels();

                renderCartItems();

                if (elements.cartPanel) {
                    elements.cartPanel.classList.add("active");
                    elements.cartPanel.style.display = "block";
                    if (elements.overlay) {
                        elements.overlay.style.display = "block";
                        elements.overlay.classList.add("active");
                    }
                }
            });
        });

        if (elements.checkoutBtn) {
            elements.checkoutBtn.addEventListener("click", (e) => {
                e.preventDefault();
                if (cart.length === 0) {
                    showToast("Empty Cart", "Your cart is empty. Add some items before checking out.", "error");
                    return;
                }

                // Create booking and send cart to server
                const bookingId = createBookingFromCart();

                // Send cart data to server via form submission
                const form = document.createElement("form");
                form.method = "POST";
                form.action = `/checkout?booking_id=${bookingId}`;
                const cartInput = document.createElement("input");
                cartInput.type = "hidden";
                cartInput.name = "cart";
                cartInput.value = JSON.stringify(cart);
                form.appendChild(cartInput);
                document.body.appendChild(form);
                form.submit();
            });
        }

        if (elements.clearCartBtn) {
            elements.clearCartBtn.addEventListener("click", () => {
                if (cart.length === 0) return;

                if (confirm("Are you sure you want to clear your cart?")) {
                    cart = [];
                    localStorage.setItem("cart", JSON.stringify(cart));
                    updateCartCount();
                    renderCartItems();
                    showToast("Cart Cleared", "Your cart has been cleared.", "info");
                    addNotification("Cart Cleared", "Your cart has been cleared.", "cart");
                }
            });
        }
    }

    function renderCartItems() {
        if (!elements.cartItemsContainer) return;

        if (cart.length === 0) {
            elements.cartItemsContainer.innerHTML = `
          <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <p>Your cart is empty</p>
            <button class="btn-primary" id="startShoppingBtn">Start Shopping</button>
          </div>
        `;

            const startShoppingBtn = document.getElementById("startShoppingBtn");
            if (startShoppingBtn) {
                startShoppingBtn.addEventListener("click", closeAllPanels);
            }

            updateCartSummary();
            return;
        }

        elements.cartItemsContainer.innerHTML = "";
        cart.forEach((item) => {
            const cartItemElement = document.createElement("div");
            cartItemElement.className = "cart-item";

            let toppingsText = "None";
            if (item.toppings && item.toppings.length > 0) {
                toppingsText = item.toppings.map((t) => t.name).join(", ");
            }

            cartItemElement.innerHTML = `
          <div class="cart-item-image">
            <img src="${item.image}" alt="${item.name}">
          </div>
          <div class="cart-item-details">
            <h4>${item.name}</h4>
            <p>Size: ${item.size.name} | Sugar: ${item.sugar.name} | Ice: ${item.ice.name}</p>
            <p>Toppings: ${toppingsText}</p>
            <div class="cart-item-quantity">
              <button class="quantity-btn minus" data-id="${item.id}">-</button>
              <input type="number" value="${item.quantity}" min="1" max="10" data-id="${item.id}">
              <button class="quantity-btn plus" data-id="${item.id}">+</button>
            </div>
          </div>
          <div class="cart-item-price">
            <p>$${item.totalPrice.toFixed(2)}</p>
            <button class="remove-item-btn" data-id="${item.id}">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        `;

            elements.cartItemsContainer.appendChild(cartItemElement);
        });

        setupCartItemControls();
        updateCartSummary();
    }

    function setupCartItemControls() {
        if (!elements.cartItemsContainer) return;

        const minusButtons = elements.cartItemsContainer.querySelectorAll(".quantity-btn.minus");
        const plusButtons = elements.cartItemsContainer.querySelectorAll(".quantity-btn.plus");
        const quantityInputs = elements.cartItemsContainer.querySelectorAll(".cart-item-quantity input");
        const removeButtons = elements.cartItemsContainer.querySelectorAll(".remove-item-btn");

        minusButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const itemId = button.getAttribute("data-id");
                updateCartItemQuantity(itemId, -1);
            });
        });

        plusButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const itemId = button.getAttribute("data-id");
                updateCartItemQuantity(itemId, 1);
            });
        });

        quantityInputs.forEach((input) => {
            input.addEventListener("change", () => {
                const itemId = input.getAttribute("data-id");
                const quantity = Number.parseInt(input.value);
                if (!isNaN(quantity) && quantity > 0) {
                    setCartItemQuantity(itemId, quantity);
                }
            });
        });

        removeButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const itemId = button.getAttribute("data-id");
                removeCartItem(itemId);
            });
        });
    }

    function updateCartItemQuantity(itemId, change) {
        const itemIndex = cart.findIndex((item) => item.id === itemId);
        if (itemIndex === -1) return;

        const newQuantity = cart[itemIndex].quantity + change;
        if (newQuantity < 1) return;

        setCartItemQuantity(itemId, newQuantity);
    }

    function setCartItemQuantity(itemId, quantity) {
        const itemIndex = cart.findIndex((item) => item.id === itemId);
        if (itemIndex === -1) return;

        cart[itemIndex].quantity = quantity;
        cart[itemIndex].totalPrice = cart[itemIndex].basePrice * quantity;

        localStorage.setItem("cart", JSON.stringify(cart));
        renderCartItems();
    }

    function removeCartItem(itemId) {
        const itemIndex = cart.findIndex((item) => item.id === itemId);
        if (itemIndex === -1) return;

        const itemName = cart[itemIndex].name;

        cart.splice(itemIndex, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount();
        renderCartItems();

        showToast("Item Removed", `${itemName} has been removed from your cart.`, "info");
        addNotification("Item Removed", `${itemName} has been removed from your cart.`, "cart");
    }

    function updateCartSummary() {
        if (!elements.cartSubtotal || !elements.cartTax || !elements.cartTotal) return;

        const subtotal = cart.reduce((total, item) => total + item.totalPrice, 0);
        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        elements.cartSubtotal.textContent = "$" + subtotal.toFixed(2);
        elements.cartTax.textContent = "$" + tax.toFixed(2);
        elements.cartTotal.textContent = "$" + total.toFixed(2);

        if (elements.checkoutBtn) {
            elements.checkoutBtn.disabled = cart.length === 0;
        }

        if (elements.clearCartBtn) {
            elements.clearCartBtn.disabled = cart.length === 0;
        }
    }

    function createBookingFromCart() {
        if (cart.length === 0) return;

        const subtotal = cart.reduce((total, item) => total + item.totalPrice, 0);
        const tax = subtotal * 0.08;
        const total = subtotal + tax;

        const booking = {
            id: "ORD" + Date.now().toString().slice(-6),
            date: new Date().toISOString(),
            items: cart,
            subtotal,
            tax,
            total,
            status: "processing",
        };

        const bookings = JSON.parse(localStorage.getItem("bookings")) || [];
        bookings.unshift(booking);
        localStorage.setItem("bookings", JSON.stringify(bookings));

        return booking.id;
    }

    // ======== FAVORITES MANAGEMENT ========
    function setupFavoriteButtons() {
        elements.favoriteButtons.forEach((button) => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();

                const productCard = this.closest(".product-card");
                const productId = productCard.querySelector(".order-btn").getAttribute("data-product-id");
                const productName = productCard.querySelector("h3").textContent;
                const productImage = productCard.querySelector(".product-image img").src;
                const productPrice = productCard.querySelector(".product-price").textContent;
                const productDescription = productCard.querySelector(".product-desc").textContent;

                const icon = this.querySelector("i");
                if (icon.classList.contains("far")) {
                    icon.classList.remove("far");
                    icon.classList.add("fas");
                    saveFavorite(productId, productName, productImage, productPrice, productDescription);
                    showToast("Added to Favorites", "Item added to your favorites!", "success");
                    addNotification("Added to Favorites", `${productName} has been added to your favorites.`, "info");
                } else {
                    icon.classList.remove("fas");
                    icon.classList.add("far");
                    removeFavorite(productId);
                    showToast("Removed from Favorites", "Item removed from your favorites", "info");
                    addNotification("Removed from Favorites", `${productName} has been removed from your favorites.`, "info");
                }
            });
        });
    }

    function saveFavorite(id, name, image, price, description) {
        const favorites = JSON.parse(localStorage.getItem("favorites")) || [];
        price = price.replace("$", "").trim();

        if (!favorites.some((item) => item.id === id)) {
            favorites.push({
                id,
                name,
                image,
                price,
                description: description || "A delicious drink from Xing Fu Cha",
            });
            localStorage.setItem("favorites", JSON.stringify(favorites));
        }
    }

    function removeFavorite(id) {
        let favorites = JSON.parse(localStorage.getItem("favorites")) || [];
        favorites = favorites.filter((item) => item.id !== id);
        localStorage.setItem("favorites", JSON.stringify(favorites));
    }

    function updateFavoriteButtons() {
        const favorites = JSON.parse(localStorage.getItem("favorites")) || [];

        elements.favoriteButtons.forEach((button) => {
            const productId = button.closest(".product-card").querySelector(".order-btn").getAttribute("data-product-id");
            const icon = button.querySelector("i");

            if (favorites.some((item) => item.id === productId)) {
                icon.classList.remove("far");
                icon.classList.add("fas");
            } else {
                icon.classList.remove("fas");
                icon.classList.add("far");
            }
        });
    }

    // ======== NOTIFICATIONS ========
    function setupNotifications() {
        elements.notificationButtons.forEach((button) => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();

                closeAllPanels();

                if (elements.notificationPanel) {
                    elements.notificationPanel.classList.add("active");
                    if (elements.overlay) {
                        elements.overlay.style.display = "block";
                        elements.overlay.classList.add("active");
                    }
                }
            });
        });
    }

    function showToast(title, message, type = "info") {
        let toastContainer = document.querySelector(".toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.className = "toast-container";
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement("div");
        toast.className = "toast";

        let icon = "info-circle";
        if (type === "success") {
            icon = "check-circle";
            toast.classList.add("success");
        } else if (type === "error") {
            icon = "exclamation-circle";
            toast.classList.add("error");
        } else if (type === "cart") {
            icon = "shopping-cart";
            toast.classList.add("cart");
        }

        toast.innerHTML = `
        <div class="toast-icon">
          <i class="fas fa-${icon}"></i>
        </div>
        <div class="toast-content">
          <h4>${title}</h4>
          <p>${message}</p>
        </div>
        <button class="toast-close">×</button>
      `;

        toastContainer.appendChild(toast);

        const closeButton = toast.querySelector(".toast-close");
        closeButton.addEventListener("click", () => {
            toast.classList.add("toast-hide");
            setTimeout(() => {
                toast.remove();
            }, 300);
        });

        setTimeout(() => {
            toast.classList.add("toast-hide");
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }

    function addNotification(title, message, type = "info") {
        if (!elements.notificationList) return;

        const emptyNotification = elements.notificationList.querySelector(".empty-notification");
        if (emptyNotification) {
            emptyNotification.remove();
        }

        const notification = document.createElement("div");
        notification.className = "notification-item";

        let icon = "info-circle";
        if (type === "success") {
            icon = "check-circle";
            notification.classList.add("success");
        } else if (type === "error") {
            icon = "exclamation-circle";
            notification.classList.add("error");
        } else if (type === "cart") {
            icon = "shopping-cart";
            notification.classList.add("cart");
        } else if (type === "order") {
            icon = "receipt";
            notification.classList.add("order");
        }

        notification.innerHTML = `
        <div class="notification-icon">
          <i class="fas fa-${icon}"></i>
        </div>
        <div class="notification-content">
          <h4>${title}</h4>
          <p>${message}</p>
          <span class="notification-time">Just now</span>
        </div>
        <button class="notification-close">×</button>
      `;

        elements.notificationList.insertBefore(notification, elements.notificationList.firstChild);

        const closeButton = notification.querySelector(".notification-close");
        closeButton.addEventListener("click", () => {
            notification.remove();

            if (elements.notificationList.children.length === 0) {
                elements.notificationList.innerHTML = `
            <div class="empty-notification">
              <i class="fas fa-bell-slash"></i>
              <p>No notifications yet</p>
            </div>
          `;
            }
        });
    }

    // ======== STYLING ========
    function addStyles() {
        const style = document.createElement("style");
        document.head.appendChild(style);

        style.textContent += `
        .product-detail-modal {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: none;
          justify-content: center;
          align-items: center;
          z-index: 1000;
        }
        
        .product-detail-modal.active {
          display: flex;
        }
        
        .product-detail-content {
          position: relative;
          width: 90%;
          max-width: 500px;
          background-color: white;
          border-radius: 10px;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
          display: flex;
          flex-direction: column;
          overflow: hidden;
          animation: fadeIn 0.3s ease;
          max-height: 90vh;
          overflow-y: auto;
        }
        
        .product-detail-image {
          width: 100%;
          padding: 30px;
          display: flex;
          justify-content: center;
          align-items: center;
          background-color: #fff;
        }
        
        .product-detail-image img {
          max-width: 100%;
          height: 250px;
          object-fit: contain;
        }
        
        .product-detail-info {
          padding: 0 20px 20px;
          display: flex;
          flex-direction: column;
        }
        
        .product-detail-info h3 {
          margin: 0 0 15px;
          font-size: 24px;
          color: #333;
          font-weight: 600;
        }
        
        .product-detail-desc {
          margin: 0 0 20px;
          font-size: 16px;
          color: #666;
          line-height: 1.6;
        }
        
        .product-detail-price {
          font-size: 24px;
          font-weight: 700;
          color: #ff5e62;
          margin-bottom: 15px;
        }
        
        .product-detail-category {
          margin-bottom: 20px;
          font-size: 14px;
          color: #666;
        }
        
        .product-detail-category span:first-child {
          font-weight: 600;
        }
        
        .product-detail-actions {
          display: flex;
          gap: 10px;
          margin-top: 20px;
        }
        
        .product-detail-actions button {
          flex: 1;
          padding: 12px;
          font-size: 16px;
          font-weight: 600;
          border-radius: 5px;
          cursor: pointer;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          transition: all 0.3s ease;
        }
        
        .product-detail-content .close-btn {
          position: absolute;
          top: 10px;
          right: 10px;
          background: none;
          border: none;
          font-size: 24px;
          color: #999;
          cursor: pointer;
          z-index: 10;
          width: 30px;
          height: 30px;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: 50%;
          background-color: rgba(255, 255, 255, 0.8);
        }
        
        .product-detail-content .close-btn:hover {
          background-color: rgba(0, 0, 0, 0.1);
          color: #333;
        }
        
        .btn-primary {
          background-color: #ff5e62;
          color: white;
          border: none;
        }
        
        .btn-primary:hover {
          background-color: #ff4146;
        }
        
        .btn-outline {
          background-color: transparent;
          color: #ff5e62;
          border: 1px solid #ff5e62;
        }
        
        .btn-outline:hover {
          background-color: #fff0f0;
        }
        
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(-20px); }
          to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes heartBeat {
          0% { transform: scale(1); }
          50% { transform: scale(1.3); }
          100% { transform: scale(1); }
        }
      `;
    }

    addStyles();
    init();
    window.addNotification = addNotification;
});