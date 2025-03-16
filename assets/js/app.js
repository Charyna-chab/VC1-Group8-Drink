document.addEventListener("DOMContentLoaded", () => {
    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector(".mobile-menu-toggle")
    const mobileMenu = document.querySelector(".mobile-menu")
    const mobileMenuClose = document.querySelector(".mobile-menu-close")

    if (mobileMenuToggle && mobileMenu && mobileMenuClose) {
        mobileMenuToggle.addEventListener("click", () => {
            mobileMenu.classList.add("active")
        })

        mobileMenuClose.addEventListener("click", () => {
            mobileMenu.classList.remove("active")
        })
    }

    // DOM Elements
    const userProfileBtn = document.getElementById("userProfileBtn")
    const userMenu = document.getElementById("userMenu")
    const moreMenuBtn = document.getElementById("moreMenuBtn")
    const moreMenu = document.getElementById("moreMenu")
    const notificationBtn = document.getElementById("notificationBtn")
    const notificationPanel = document.getElementById("notificationPanel")
    const overlay = document.getElementById("overlay")
    const languageSelector = document.querySelector(".language-selector")
    const languageDropdown = document.querySelector(".language-dropdown")
    const languageOptions = document.querySelectorAll(".language-option")

    // Initialize notification count
    updateNotificationCount()

    // User Profile Menu Toggle
    if (userProfileBtn && userMenu) {
        userProfileBtn.addEventListener("click", (e) => {
            e.stopPropagation()
            userMenu.classList.toggle("active")

            // Close other menus
            if (moreMenu) moreMenu.classList.remove("active")
            if (notificationPanel) notificationPanel.classList.remove("active")
            if (languageDropdown) languageDropdown.classList.remove("active")

            // Toggle overlay
            toggleOverlay(userMenu.classList.contains("active"))
        })
    }

    // More Menu Toggle
    if (moreMenuBtn && moreMenu) {
        moreMenuBtn.addEventListener("click", (e) => {
            e.preventDefault()
            e.stopPropagation()
            moreMenu.classList.toggle("active")

            // Close other menus
            if (userMenu) userMenu.classList.remove("active")
            if (notificationPanel) notificationPanel.classList.remove("active")
            if (languageDropdown) languageDropdown.classList.remove("active")

            // Toggle overlay
            toggleOverlay(moreMenu.classList.contains("active"))
        })
    }

    // Notification Panel Toggle
    if (notificationBtn && notificationPanel) {
        notificationBtn.addEventListener("click", (e) => {
            e.stopPropagation()
            notificationPanel.classList.toggle("active")

            // Close other menus
            if (userMenu) userMenu.classList.remove("active")
            if (moreMenu) moreMenu.classList.remove("active")
            if (languageDropdown) languageDropdown.classList.remove("active")

            // Toggle overlay
            toggleOverlay(notificationPanel.classList.contains("active"))

            // Mark notifications as read
            if (notificationPanel.classList.contains("active")) {
                markNotificationsAsRead()
            }
        })
    }

    // Language Selector Toggle
    if (languageSelector && languageDropdown) {
        languageSelector.addEventListener("click", (e) => {
            e.stopPropagation()
            languageDropdown.classList.toggle("active")

            // Close other menus
            if (userMenu) userMenu.classList.remove("active")
            if (moreMenu) moreMenu.classList.remove("active")
            if (notificationPanel) notificationPanel.classList.remove("active")

            // Toggle overlay
            toggleOverlay(languageDropdown.classList.contains("active"))
        })
    }

    // Language Selection
    if (languageOptions) {
        languageOptions.forEach((option) => {
            option.addEventListener("click", function(e) {
                e.preventDefault()
                const lang = this.getAttribute("data-lang")
                const langText = this.querySelector("span").textContent
                const langFlag = this.querySelector("img").src

                // Update display
                document.getElementById("currentLanguage").textContent = langText
                document.getElementById("currentLanguageFlag").src = langFlag

                // Close dropdown
                languageDropdown.classList.remove("active")
                toggleOverlay(false)

                // In a real app, you would update the language preference here
                // For now, just show a toast notification
                showToast("Language Changed", `Language changed to ${langText}`, "success")
            })
        })
    }

    // Close menus when clicking outside
    document.addEventListener("click", (e) => {
        if (
            userMenu &&
            userMenu.classList.contains("active") &&
            !userMenu.contains(e.target) &&
            !userProfileBtn.contains(e.target)
        ) {
            userMenu.classList.remove("active")
            toggleOverlay(false)
        }

        if (
            moreMenu &&
            moreMenu.classList.contains("active") &&
            !moreMenu.contains(e.target) &&
            !moreMenuBtn.contains(e.target)
        ) {
            moreMenu.classList.remove("active")
            toggleOverlay(false)
        }

        if (
            notificationPanel &&
            notificationPanel.classList.contains("active") &&
            !notificationPanel.contains(e.target) &&
            !notificationBtn.contains(e.target)
        ) {
            notificationPanel.classList.remove("active")
            toggleOverlay(false)
        }

        if (
            languageDropdown &&
            languageDropdown.classList.contains("active") &&
            !languageDropdown.contains(e.target) &&
            !languageSelector.contains(e.target)
        ) {
            languageDropdown.classList.remove("active")
            toggleOverlay(false)
        }
    })

    // Overlay click handler
    if (overlay) {
        overlay.addEventListener("click", () => {
            // Close all menus
            if (userMenu) userMenu.classList.remove("active")
            if (moreMenu) moreMenu.classList.remove("active")
            if (notificationPanel) notificationPanel.classList.remove("active")
            if (languageDropdown) languageDropdown.classList.remove("active")

            // Hide overlay
            toggleOverlay(false)
        })
    }

    // Toggle overlay visibility
    function toggleOverlay(show) {
        if (overlay) {
            if (show) {
                overlay.classList.add("active")
            } else {
                overlay.classList.remove("active")
            }
        }
    }

    // Update notification count
    function updateNotificationCount() {
        const badge = document.getElementById("notificationBadge")
        const bookingBadge = document.getElementById("bookingBadge")

        // In a real app, you would fetch the notification count from the server
        // For now, just use a random number
        const count = Math.floor(Math.random() * 5)

        if (badge) {
            badge.textContent = count
            badge.style.display = count > 0 ? "flex" : "none"
        }

        if (bookingBadge) {
            bookingBadge.textContent = count
            bookingBadge.style.display = count > 0 ? "flex" : "none"
        }
    }

    // Mark notifications as read
    function markNotificationsAsRead() {
        const badge = document.getElementById("notificationBadge")

        // In a real app, you would send a request to the server to mark notifications as read
        // For now, just hide the badge
        if (badge) {
            badge.textContent = "0"
            badge.style.display = "none"
        }

        // Update the notification list
        const notificationList = document.getElementById("notificationList")
        if (notificationList) {
            // In a real app, you would fetch the notifications from the server
            // For now, just show a message
            notificationList.innerHTML = `
                  <div class="empty-notification">
                      <i class="fas fa-bell-slash"></i>
                      <p>No new notifications</p>
                  </div>
              `
        }
    }

    // Show toast notification
    function showToast(title, message, type = "info", image = null) {
        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById("toastContainer")
        if (!toastContainer) {
            toastContainer = document.createElement("div")
            toastContainer.id = "toastContainer"
            toastContainer.className = "toast-container"
            document.body.appendChild(toastContainer)
        }

        // Create toast element
        const toast = document.createElement("div")
        toast.className = "toast"

        // Set icon based on type
        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
            toast.style.borderLeftColor = "#4caf50"
        } else if (type === "error") {
            icon = "exclamation-circle"
            toast.style.borderLeftColor = "#f44336"
        } else if (type === "warning") {
            icon = "exclamation-triangle"
            toast.style.borderLeftColor = "#ff9800"
        }

        let imageElement = ""
        if (image) {
            imageElement = `<img src="${image}" alt="Toast Image" style="width: 30px; height: 30px; margin-right: 10px;">`
        } else {
            imageElement = `<div>
                  <i class="fas fa-${icon}" style="color: ${type === "success" ? "#4caf50" : type === "error" ? "#f44336" : type === "warning" ? "#ff9800" : "#ff5e62"}; font-size: 20px; margin-right: 10px;"></i>
              </div>`
        }

        // Set toast content
        toast.innerHTML = `
              ${imageElement}
              <div style="flex: 1;">
                  <h4>${title}</h4>
                  <p>${message}</p>
              </div>
              <button class="toast-close">&times;</button>
          `

        // Add to container
        toastContainer.appendChild(toast)

        // Add close button functionality
        const closeButton = toast.querySelector(".toast-close")
        closeButton.addEventListener("click", () => {
            toast.remove()
        })

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.opacity = "0"
            setTimeout(() => {
                toast.remove()
            }, 300)
        }, 5000)
    }

    // Toast Notification
    const closeToast = document.querySelector(".close-toast")
    const toastNotification = document.getElementById("toastNotification")

    if (closeToast && toastNotification) {
        closeToast.addEventListener("click", () => {
            toastNotification.classList.remove("active")
        })
    }

    // Function to show toast notification

    // Order Panel
    const orderBtn = document.querySelector(".order-btn")
    const orderPanel = document.getElementById("orderPanel")
    const closeOrderBtn = orderPanel ? orderPanel.querySelector(".close-btn") : null

    if (orderBtn && orderPanel && closeOrderBtn) {
        orderBtn.addEventListener("click", () => {
            orderPanel.classList.add("active")
            overlay.classList.add("active")
        })

        closeOrderBtn.addEventListener("click", () => {
            orderPanel.classList.remove("active")
            overlay.classList.remove("active")
        })
    }

    // Product Quantity Controls
    const quantityMinusButtons = document.querySelectorAll(".quantity-btn.minus")
    const quantityPlusButtons = document.querySelectorAll(".quantity-btn.plus")

    if (quantityMinusButtons.length > 0 && quantityPlusButtons.length > 0) {
        quantityMinusButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const input = this.nextElementSibling
                let value = Number.parseInt(input.value)
                if (value > 1) {
                    value--
                    input.value = value
                }
            })
        })

        quantityPlusButtons.forEach((button) => {
            button.addEventListener("click", function() {
                const input = this.previousElementSibling
                let value = Number.parseInt(input.value)
                if (value < 10) {
                    value++
                    input.value = value
                }
            })
        })
    }

    // Form Validation
    const forms = document.querySelectorAll("form")

    forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            const requiredFields = form.querySelectorAll("[required]")
            let isValid = true

            requiredFields.forEach((field) => {
                if (!field.value.trim()) {
                    isValid = false
                    field.classList.add("error")
                } else {
                    field.classList.remove("error")
                }
            })

            // Password confirmation validation
            const password = form.querySelector("#password")
            const confirmPassword = form.querySelector("#confirm_password")

            if (password && confirmPassword) {
                if (password.value !== confirmPassword.value) {
                    isValid = false
                    confirmPassword.classList.add("error")
                    alert("Passwords do not match")
                }
            }

            if (!isValid) {
                e.preventDefault()
            }
        })
    })
})

// Function to update total price in order panel
function updateTotalPrice() {
    const drinkSize = document.getElementById("drinkSize")
    if (!drinkSize) return

    const basePrice = Number.parseFloat(document.getElementById("basePrice") ? .textContent ? .replace("$", "") || 0)
    const sizePrice = Number.parseFloat(drinkSize.options[drinkSize.selectedIndex] ? .getAttribute("data-price") || 0)

    let toppingsPrice = 0
    const toppingCheckboxes = document.querySelectorAll('input[name="topping"]:checked, input[name="toppings"]:checked')

    toppingCheckboxes.forEach((checkbox) => {
        toppingsPrice += Number.parseFloat(checkbox.getAttribute("data-price") || 0.85)
    })

    const totalPrice = basePrice + sizePrice + toppingsPrice
    const sizePriceElement = document.getElementById("sizePrice")
    const toppingsPriceElement = document.getElementById("toppingsPrice")
    const totalPriceElement = document.getElementById("totalPrice")

    if (sizePriceElement) sizePriceElement.textContent = "$" + sizePrice.toFixed(2)
    if (toppingsPriceElement) toppingsPriceElement.textContent = "$" + toppingsPrice.toFixed(2)
    if (totalPriceElement) totalPriceElement.textContent = "$" + totalPrice.toFixed(2)
}

// Function to open booking panel with product details
function openBookingPanel(productId, productName, productPrice, productImage) {
    const bookingPanel = document.getElementById("bookingPanel")
    const overlay = document.getElementById("overlay")
    const productNameElement = document.getElementById("productName")
    const productPriceElement = document.getElementById("productPrice")
    const productImageElement = document.getElementById("productImage")
    const basePriceElement = document.getElementById("basePrice")
    const totalPriceElement = document.getElementById("totalPrice")

    if (bookingPanel && overlay) {
        if (productNameElement) productNameElement.textContent = productName
        if (productPriceElement) productPriceElement.textContent = "$" + productPrice.toFixed(2)
        if (productImageElement) productImageElement.src = productImage
        if (basePriceElement) basePriceElement.textContent = "$" + productPrice.toFixed(2)
        if (totalPriceElement) totalPriceElement.textContent = "$" + productPrice.toFixed(2)

        bookingPanel.classList.add("active")
        overlay.classList.add("active")

        updateTotalPrice()
    }
}

// Function to close booking panel
function closeBookingPanel() {
    const bookingPanel = document.getElementById("bookingPanel")
    const overlay = document.getElementById("overlay")

    if (bookingPanel && overlay) {
        bookingPanel.classList.remove("active")
        overlay.classList.remove("active")
    }
}

// Function to place order
function placeOrder() {
    // In a real app, you would send the order data to the server
    // For now, just show a success message
    closeBookingPanel()
    showToast("Order Placed", "Your order has been placed successfully!", "success", "/assets/images/success.png")
}