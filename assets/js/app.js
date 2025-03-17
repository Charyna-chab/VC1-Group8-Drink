// Variables for notifications
let notificationCount = 0
let bookingCount = 0
const notifications = []
let currentProduct = null

// Make openOrderPanel available globally
window.openOrderPanel = openOrderPanel

// Also make updatePrice available globally
window.updatePrice = updatePrice

// Initialize the page
document.addEventListener("DOMContentLoaded", () => {
    // Set up event listeners
    setupEventListeners()

    // Load notifications if user is logged in
    loadNotifications()
})

// Function to set up event listeners
function setupEventListeners() {
    // Search functionality
    const searchInput = document.getElementById("search")
    if (searchInput) {
        searchInput.addEventListener("input", function() {
            const searchTerm = this.value.toLowerCase()
            filterProducts(searchTerm, null)
        })
    }

    // Category filtering
    const categoryItems = document.querySelectorAll(".category-item")
    categoryItems.forEach((item) => {
        item.addEventListener("click", function() {
            // Remove active class from all items
            categoryItems.forEach((cat) => cat.classList.remove("active"))
                // Add active class to clicked item
            this.classList.add("active")

            // Get the selected category
            const selectedCategory = this.getAttribute("data-category")

            // Filter products based on the selected category
            filterProducts(null, selectedCategory)
        })
    })

    // Favorite buttons
    const favButtons = document.querySelectorAll(".fav-btn")
    favButtons.forEach((button) => {
        button.addEventListener("click", function(event) {
            event.stopPropagation() // Prevent triggering dish-item click event
            this.classList.toggle("favorited")

            // Visual feedback
            if (this.classList.contains("favorited")) {
                this.style.transform = "scale(1.2)"
                setTimeout(() => {
                    this.style.transform = "scale(1)"
                }, 200)
            }
        })
    })

    // Order buttons
    const orderButtons = document.querySelectorAll(".book-btn")
    orderButtons.forEach((button) => {
        button.addEventListener("click", function(event) {
            event.stopPropagation() // Prevent triggering dish-item click event

            // Get product data from data attributes
            const productId = this.getAttribute("data-id")
            const productName = this.getAttribute("data-name")
            const productPrice = Number.parseFloat(this.getAttribute("data-price"))
            const productImage = this.getAttribute("data-image")

            // Open order panel with product data
            openOrderPanel(productId, productName, productPrice, productImage)
        })
    })

    // Size select change
    const sizeSelect = document.getElementById("drinkSize")
    if (sizeSelect) {
        sizeSelect.addEventListener("change", updatePrice)
    }

    // Topping checkboxes
    const toppingCheckboxes = document.querySelectorAll('#toppings input[type="checkbox"]')
    toppingCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updatePrice)
    })

    // Close order panel button
    const closeOrderBtn = document.querySelector(".order-panel .close-btn")
    if (closeOrderBtn) {
        closeOrderBtn.addEventListener("click", closeOrderPanel)
    }

    // Confirm order button
    const confirmBtn = document.querySelector(".confirm-btn")
    if (confirmBtn) {
        confirmBtn.addEventListener("click", placeOrder)
    }

    // Toggle notification panel button
    const notificationBtn = document.getElementById("notificationBtn")
    if (notificationBtn) {
        notificationBtn.addEventListener("click", toggleNotificationPanel)
    }

    // User profile button
    const userProfileBtn = document.getElementById("userProfileBtn")
    if (userProfileBtn) {
        userProfileBtn.addEventListener("click", toggleUserMenu)
    }

    // More menu button
    const moreMenuBtn = document.getElementById("moreMenuBtn")
    if (moreMenuBtn) {
        moreMenuBtn.addEventListener("click", (event) => {
            event.preventDefault()
            toggleMoreMenu()
        })
    }

    // Language selector
    const languageOptions = document.querySelectorAll(".language-option")
    languageOptions.forEach((option) => {
        option.addEventListener("click", function() {
            const lang = this.getAttribute("data-lang")
            changeLanguage(lang)
        })
    })

    // Overlay click event
    const overlay = document.getElementById("overlay")
    if (overlay) {
        overlay.addEventListener("click", () => {
            // Close all panels
            closeOrderPanel()
            closeUserMenu()
            closeMoreMenu()
            closeNotificationPanel()
        })
    }

    // Close toast button
    const closeToastBtn = document.querySelector(".close-toast")
    if (closeToastBtn) {
        closeToastBtn.addEventListener("click", closeToast)
    }
}

// Function to open order panel
function openOrderPanel(productId, name, price, image) {
    currentProduct = {
        id: productId,
        name: name,
        price: Number.parseFloat(price),
        image: image,
    }

    // Update product info
    document.getElementById("productImage").src = image
    document.getElementById("productName").textContent = name
    document.getElementById("productPrice").textContent = `$${price.toFixed(2)}`
    document.getElementById("basePrice").textContent = `$${price.toFixed(2)}`
    document.getElementById("totalPrice").textContent = `$${price.toFixed(2)}`

    // Reset selections
    document.getElementById("drinkSize").selectedIndex = 0
    document.getElementById("sugarLevel").selectedIndex = 2 // Default to 50%
    document.querySelectorAll('#toppings input[type="checkbox"]').forEach((cb) => (cb.checked = false))

    // Reset prices
    document.getElementById("sizePrice").textContent = "$0.00"
    document.getElementById("toppingsPrice").textContent = "$0.00"

    // Show panel with animation
    const orderPanel = document.getElementById("orderPanel")
    orderPanel.classList.add("active")
    document.getElementById("overlay").style.display = "block"

    // Add animation classes to elements
    setTimeout(() => {
        const productInfo = orderPanel.querySelector(".product-info")
        if (productInfo) productInfo.style.opacity = 1
    }, 100)
}

// Function to close order panel
function closeOrderPanel() {
    document.getElementById("orderPanel").classList.remove("active")
    document.getElementById("overlay").style.display = "none"
    currentProduct = null
}

// Function to update price with animation
function updatePrice() {
    if (!currentProduct) return

    let total = currentProduct.price

    // Add size price
    const sizeSelect = document.getElementById("drinkSize")
    const sizePrice = Number.parseFloat(sizeSelect.options[sizeSelect.selectedIndex].dataset.price)
    total += sizePrice

    // Add toppings price
    const selectedToppings = document.querySelectorAll('#toppings input[type="checkbox"]:checked')
    const toppingsPrice = selectedToppings.length * 0.85
    total += toppingsPrice

    // Update summary with animation
    const sizePriceElement = document.getElementById("sizePrice")
    const toppingsPriceElement = document.getElementById("toppingsPrice")
    const totalPriceElement = document.getElementById("totalPrice")

    // Apply highlight animation
    sizePriceElement.classList.add("highlight")
    toppingsPriceElement.classList.add("highlight")
    totalPriceElement.classList.add("highlight")

    // Update values
    sizePriceElement.textContent = `$${sizePrice.toFixed(2)}`
    toppingsPriceElement.textContent = `$${toppingsPrice.toFixed(2)}`
    totalPriceElement.textContent = `$${total.toFixed(2)}`

    // Remove highlight animation after a delay
    setTimeout(() => {
        sizePriceElement.classList.remove("highlight")
        toppingsPriceElement.classList.remove("highlight")
        totalPriceElement.classList.remove("highlight")
    }, 300)
}

// Combined function to filter products by search term and/or category
function filterProducts(searchTerm, category) {
    const dishes = document.querySelectorAll(".dish-item")
    let productFound = false
    const noProductMessage = document.getElementById("no-product-message")

    dishes.forEach((dish) => {
        const dishName = dish.querySelector("h4").textContent.toLowerCase()
        const dishDescription = dish.querySelector("p").textContent.toLowerCase()
        const dishCategory = dish.getAttribute("data-category")

        // Check if the dish matches both search term and category (if provided)
        const matchesSearch = !searchTerm || dishName.includes(searchTerm) || dishDescription.includes(searchTerm)
        const matchesCategory = !category || category === "all" || dishCategory === category

        if (matchesSearch && matchesCategory) {
            dish.style.display = "block"
            productFound = true
        } else {
            dish.style.display = "none"
        }
    })

    // Show "No product found" message if no products are matched
    if (noProductMessage) {
        if (!productFound) {
            noProductMessage.style.display = "block"
        } else {
            noProductMessage.style.display = "none"
        }
    }
}

// Function to toggle notification panel
function toggleNotificationPanel() {
    const panel = document.getElementById("notificationPanel")
    const overlay = document.getElementById("overlay")

    if (panel) {
        panel.classList.toggle("active")

        if (panel.classList.contains("active")) {
            if (overlay) overlay.style.display = "block"
                // Reset notification count when panel is opened
            resetNotificationCount()

            // Close other menus
            closeUserMenu()
            closeMoreMenu()
        } else {
            if (overlay) overlay.style.display = "none"
        }
    }
}

// Function to close notification panel
function closeNotificationPanel() {
    const panel = document.getElementById("notificationPanel")
    if (panel) {
        panel.classList.remove("active")
    }
}

// Function to toggle user menu
function toggleUserMenu() {
    const userMenu = document.getElementById("userMenu")
    const overlay = document.getElementById("overlay")

    if (userMenu) {
        userMenu.classList.toggle("active")

        if (userMenu.classList.contains("active")) {
            if (overlay) overlay.style.display = "block"

            // Close other menus
            closeNotificationPanel()
            closeMoreMenu()
        } else {
            if (overlay) overlay.style.display = "none"
        }
    }
}

// Function to close user menu
function closeUserMenu() {
    const userMenu = document.getElementById("userMenu")
    if (userMenu) {
        userMenu.classList.remove("active")
    }
}

// Function to toggle more menu
function toggleMoreMenu() {
    const moreMenu = document.getElementById("moreMenu")
    const overlay = document.getElementById("overlay")

    if (moreMenu) {
        moreMenu.classList.toggle("active")

        if (moreMenu.classList.contains("active")) {
            if (overlay) overlay.style.display = "block"

            // Close other menus
            closeNotificationPanel()
            closeUserMenu()
        } else {
            if (overlay) overlay.style.display = "none"
        }
    }
}

// Function to close more menu
function closeMoreMenu() {
    const moreMenu = document.getElementById("moreMenu")
    if (moreMenu) {
        moreMenu.classList.remove("active")
    }
}

// Function to change language
function changeLanguage(lang) {
    const currentLanguage = document.getElementById("currentLanguage")
    const currentLanguageFlag = document.getElementById("currentLanguageFlag")

    if (currentLanguage && currentLanguageFlag) {
        // Update language display
        switch (lang) {
            case "en":
                currentLanguage.textContent = "English"
                currentLanguageFlag.src = "/assets/image/flags/en.png"
                break
            case "zh":
                currentLanguage.textContent = "中文"
                currentLanguageFlag.src = "/assets/image/flags/zh.png"
                break
            case "es":
                currentLanguage.textContent = "Español"
                currentLanguageFlag.src = "/assets/image/flags/es.png"
                break
            case "fr":
                currentLanguage.textContent = "Français"
                currentLanguageFlag.src = "/assets/image/flags/fr.png"
                break
            case "ja":
                currentLanguage.textContent = "日本語"
                currentLanguageFlag.src = "/assets/image/flags/ja.png"
                break
        }

        // In a real application, you would reload the page or fetch translations
        // For demo purposes, we'll just show a toast
        showToast(
            "Language Changed",
            `The language has been changed to ${currentLanguage.textContent}`,
            currentLanguageFlag.src,
        )
    }
}

// Function to update notification badge
function updateNotificationBadge() {
    const badge = document.getElementById("notificationBadge")
    if (badge) {
        badge.textContent = notificationCount

        if (notificationCount > 0) {
            badge.classList.add("active")
        } else {
            badge.classList.remove("active")
        }
    }
}

// Function to update booking badge
function updateBookingBadge() {
    const badge = document.getElementById("bookingBadge")
    if (badge) {
        badge.textContent = bookingCount

        if (bookingCount > 0) {
            badge.classList.add("active")
        } else {
            badge.classList.remove("active")
        }
    }
}

// Function to reset notification count
function resetNotificationCount() {
    notificationCount = 0
    updateNotificationBadge()
}

// Function to load notifications from server
function loadNotifications() {
    // For demo purposes, we'll add some sample notifications
    addNotification("Order: Taro Milk Tea", "Medium-Size, 50% Sugar with Pearl, Cream - $5.35", "/assets/images/taro.jpg")

    addNotification(
        "Order: Brown Sugar Boba",
        "Large-Size, 75% Sugar with Pearl - $6.85",
        "/assets/images/brown-sugar.jpg",
    )

    /* In a real application, you would use AJAX:
      fetch('/user/notifications')
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  notifications = data.notifications;
                  notificationCount = notifications.length;
                  bookingCount = notifications.length;
                  
                  updateNotificationBadge();
                  updateBookingBadge();
                  updateNotificationList();
              }
          })
          .catch(error => console.error('Error loading notifications:', error));
      */
}

// Function to add notification
function addNotification(title, message, image) {
    // Increment notification count
    notificationCount++
    bookingCount++

    // Update badges
    updateNotificationBadge()
    updateBookingBadge()

    // Create notification object
    const notification = {
        id: Date.now(),
        title: title,
        message: message,
        image: image,
        time: new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }),
    }

    // Add to notifications array
    notifications.unshift(notification)

    // Update notification list
    updateNotificationList()

    // Show toast notification
    showToast(title, message, image)
}

// Function to update notification list
function updateNotificationList() {
    const notificationList = document.getElementById("notificationList")
    if (!notificationList) return

    if (notifications.length === 0) {
        notificationList.innerHTML = `
        <div class="empty-notification">
            <i class="fas fa-bell-slash"></i>
            <p>No notifications yet</p>
        </div>
        `
        return
    }

    let html = ""
    notifications.forEach((notification) => {
        html += `
        <div class="notification-item" id="notification-${notification.id}">
            <img src="${notification.image}" alt="${notification.title}">
            <div class="notification-content">
                <h4>${notification.title}</h4>
                <p>${notification.message}</p>
                <span class="time">${notification.time}</span>
            </div>
            <div class="close-notification" onclick="removeNotification(${notification.id})">×</div>
        </div>
        `
    })

    notificationList.innerHTML = html
}

// Function to remove notification
function removeNotification(id) {
    // Find index of notification
    const index = notifications.findIndex((n) => n.id === id)

    if (index !== -1) {
        // Remove notification from array
        notifications.splice(index, 1)

        // Update notification list
        updateNotificationList()
    }
}

// Function to show toast notification
function showToast(title, message, image) {
    const toast = document.getElementById("toastNotification")
    const toastTitle = document.getElementById("toastTitle")
    const toastMessage = document.getElementById("toastMessage")
    const toastImage = document.getElementById("toastImage")

    if (!toast || !toastTitle || !toastMessage || !toastImage) return

    // Set content
    toastTitle.textContent = title
    toastMessage.textContent = message
    toastImage.src = image

    // Show toast
    toast.classList.add("active")

    // Auto hide after 5 seconds
    setTimeout(() => {
        closeToast()
    }, 5000)
}

// Function to close toast
function closeToast() {
    const toast = document.getElementById("toastNotification")
    if (toast) {
        toast.classList.remove("active")
    }
}

// Function to place order with improved animation
function placeOrder() {
    // Get selected options
    const size = document.getElementById("drinkSize").value
    const sugarLevel = document.getElementById("sugarLevel").value

    // Get selected toppings
    const selectedToppings = document.querySelectorAll('#toppings input[type="checkbox"]:checked')
    const toppings = Array.from(selectedToppings).map((checkbox) => checkbox.value)

    // Get total price
    const totalPrice = document.getElementById("totalPrice").textContent

    // Create order summary
    let orderSummary = `${size}, ${sugarLevel} Sugar`
    if (toppings.length > 0) {
        orderSummary += ` with ${toppings.join(", ")}`
    }
    orderSummary += ` - ${totalPrice}`

    // Add animation to confirm button
    const confirmBtn = document.querySelector(".confirm-btn")
    confirmBtn.innerHTML = '<i class="fas fa-check-circle"></i> Added to Cart!'
    confirmBtn.style.backgroundColor = "#4CAF50"

    // Add notification with delay for better UX
    setTimeout(() => {
        // Add notification
        addNotification(`Order: ${currentProduct.name}`, orderSummary, currentProduct.image)

        // Close order panel
        closeOrderPanel()

        // Show confirmation toast
        showToast("Order Confirmed", `Your ${currentProduct.name} has been added to cart`, currentProduct.image)

        // Reset confirm button after panel is closed
        setTimeout(() => {
            confirmBtn.innerHTML = '<i class="fas fa-shopping-cart"></i> Add to Cart'
            confirmBtn.style.backgroundColor = ""
        }, 500)
    }, 800)
}
// Show the order modal
function orderDrink(drinkName) {
    const modal = document.getElementById('order-modal');
    const form = document.getElementById('order-form');
    form.onsubmit = function(event) {
        event.preventDefault();
        // Process the order (this can be extended)
        alert(`${drinkName} ordered! Your customizations are: 
                Size: ${form.size.value}
                Sugar: ${form.sugar.value}
                Topping: ${form.topping.value}`);

        // Close the modal
        closeModal();
        // Show notification
        alert('Your order has been placed successfully!');
    };
    modal.style.display = 'block';
}

// Close the modal
function closeModal() {
    const modal = document.getElementById('order-modal');
    modal.style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('order-modal');
    if (event.target === modal) {
        closeModal();
    }
};
// public/assets/js/order.js
document.addEventListener('DOMContentLoaded', function() {
    // Product search functionality
    const searchInput = document.getElementById('productSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');
            let foundProducts = false;

            productCards.forEach(card => {
                const productName = card.querySelector('h3').textContent.toLowerCase();
                const productDesc = card.querySelector('p').textContent.toLowerCase();

                if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                    card.style.display = 'block';
                    foundProducts = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no products message
            const noProductMessage = document.getElementById('no-product-message');
            if (noProductMessage) {
                noProductMessage.style.display = foundProducts ? 'none' : 'block';
            }
        });
    }

    // Category filter functionality
    const categoryButtons = document.querySelectorAll('.category-btn');
    if (categoryButtons.length > 0) {
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => btn.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Filter products by category
                const category = this.getAttribute('data-category');
                const productCards = document.querySelectorAll('.product-card');

                productCards.forEach(card => {
                    if (category === 'all') {
                        card.style.display = 'block';
                    } else {
                        const cardCategory = card.getAttribute('data-category');
                        if (cardCategory === category) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        });
    }

    // Favorite button functionality
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const icon = this.querySelector('i');

            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                showToast('success', 'Added to Favorites', 'Item added to your favorites list');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                showToast('info', 'Removed from Favorites', 'Item removed from your favorites list');
            }
        });
    });

    // Order modal functionality
    const orderButtons = document.querySelectorAll('.order-btn');
    const orderModal = document.getElementById('orderModal');
    const closeModalBtn = document.querySelector('.close-modal');
    const cancelOrderBtn = document.getElementById('cancelOrder');

    // Open modal when order button is clicked
    orderButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const productCard = this.closest('.product-card');

            if (!productCard) {
                showToast('error', 'Error', 'Product not found');
                return;
            }

            // Get product details from the card
            const productName = productCard.querySelector('h3').textContent;
            const productDesc = productCard.querySelector('p').textContent;
            const productPrice = productCard.querySelector('.product-price').textContent.replace('$', '');
            const productImage = productCard.querySelector('img').src;

            // Populate modal with product details
            document.getElementById('product_id').value = productId;
            document.querySelector('.modal-product-image').src = productImage;
            document.querySelector('.modal-product-name').textContent = productName;
            document.querySelector('.modal-product-description').textContent = productDesc;
            document.querySelector('.modal-product-price').textContent = '$' + productPrice;

            // Calculate initial total price
            updateTotalPrice(parseFloat(productPrice));

            // Show modal
            orderModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal
    function closeModal() {
        orderModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (cancelOrderBtn) {
        cancelOrderBtn.addEventListener('click', closeModal);
    }

    // Close modal when clicking outside
    orderModal.addEventListener('click', function(e) {
        if (e.target === orderModal) {
            closeModal();
        }
    });

    // Quantity controls
    const minusBtn = document.querySelector('.minus-btn');
    const plusBtn = document.querySelector('.plus-btn');
    const quantityInput = document.querySelector('input[name="quantity"]');

    if (minusBtn && plusBtn && quantityInput) {
        minusBtn.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
                updateTotalPrice();
            }
        });

        plusBtn.addEventListener('click', function() {
            let quantity = parseInt(quantityInput.value);
            if (quantity < 10) {
                quantityInput.value = quantity + 1;
                updateTotalPrice();
            }
        });
    }

    // Update total price when options change
    const sizeInputs = document.querySelectorAll('input[name="size"]');
    const toppingInputs = document.querySelectorAll('input[name="toppings[]"]');

    if (sizeInputs.length > 0) {
        sizeInputs.forEach(input => {
            input.addEventListener('change', updateTotalPrice);
        });
    }

    if (toppingInputs.length > 0) {
        toppingInputs.forEach(input => {
            input.addEventListener('change', updateTotalPrice);
        });
    }

    if (quantityInput) {
        quantityInput.addEventListener('change', updateTotalPrice);
    }

    // Calculate and update total price
    function updateTotalPrice(basePrice) {
        if (!basePrice) {
            const productPriceElement = document.querySelector('.modal-product-price');
            if (productPriceElement) {
                basePrice = parseFloat(productPriceElement.textContent.replace('$', ''));
            } else {
                basePrice = 0;
            }
        }

        let sizePrice = 0;
        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (selectedSize) {
            sizePrice = parseFloat(selectedSize.getAttribute('data-price') || 0);
        }

        let toppingsPrice = 0;
        const selectedToppings = document.querySelectorAll('input[name="toppings[]"]:checked');
        selectedToppings.forEach(topping => {
            toppingsPrice += parseFloat(topping.getAttribute('data-price') || 0);
        });

        const quantity = parseInt(quantityInput.value || 1);

        const totalPrice = (basePrice + sizePrice + toppingsPrice) * quantity;
        const priceValueElement = document.querySelector('.price-value');
        if (priceValueElement) {
            priceValueElement.textContent = '$' + totalPrice.toFixed(2);
        }
    }

    // Form submission
    const customizeForm = document.getElementById('customizeForm');
    if (customizeForm) {
        customizeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);
            const productId = formData.get('product_id');
            const productName = document.querySelector('.modal-product-name').textContent;
            const size = formData.get('size');
            const sugar = formData.get('sugar') + '%';
            const ice = formData.get('ice') + '%';
            const toppings = formData.getAll('toppings[]');
            const quantity = formData.get('quantity');

            // Close modal
            closeModal();

            // Show success toast
            showToast('success', 'Order Added', `${quantity}x ${productName} added to your cart`);

            // Redirect to booking page after a short delay
            setTimeout(() => {
                window.location.href = '/booking';
            }, 1500);
        });
    }

    // Toast notification
    function showToast(type, title, message) {
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        let icon = '';
        if (type === 'success') {
            icon = 'check';
        } else if (type === 'error') {
            icon = 'times';
        } else {
            icon = 'info';
        }

        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${icon}"></i>
            </div>
            <div class="toast-content">
                <h4 class="toast-title">${title}</h4>
                <p class="toast-message">${message}</p>
            </div>
            <button class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;

        toastContainer.appendChild(toast);

        // Auto remove toast after 5 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);

        // Close toast on click
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', function() {
            toast.style.animation = 'slideOut 0.3s forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        });
    }
});