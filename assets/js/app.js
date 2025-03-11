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