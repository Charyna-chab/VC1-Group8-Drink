document.addEventListener("DOMContentLoaded", () => {
    // Get all menu items
    const menuItems = document.querySelectorAll(".menu-item")

    // Get category filters
    const categoryFilters = document.querySelectorAll(".category-item")

    // Get search input
    const searchInput = document.getElementById("search")

    // Get no products message
    const noProductMessage = document.getElementById("no-product-message")

    // Initialize current filter
    let currentCategory = "all"
    let currentSearch = ""

    // Add event listeners to category filters
    categoryFilters.forEach((filter) => {
        filter.addEventListener("click", function() {
            // Remove active class from all filters
            categoryFilters.forEach((f) => f.classList.remove("active"))

            // Add active class to clicked filter
            this.classList.add("active")

            // Update current category
            currentCategory = this.getAttribute("data-category")

            // Filter menu items
            filterMenuItems()
        })
    })

    // Add event listener to search input
    searchInput.addEventListener("input", function() {
        // Update current search
        currentSearch = this.value.toLowerCase()

        // Filter menu items
        filterMenuItems()
    })

    // Function to filter menu items
    function filterMenuItems() {
        let itemsVisible = 0

        menuItems.forEach((item) => {
            const category = item.getAttribute("data-category")
            const name = item.querySelector("h3").textContent.toLowerCase()
            const description = item.querySelector("p").textContent.toLowerCase()

            // Check if item matches category and search
            const matchesCategory = currentCategory === "all" || category === currentCategory
            const matchesSearch = name.includes(currentSearch) || description.includes(currentSearch)

            if (matchesCategory && matchesSearch) {
                item.style.display = "flex"
                itemsVisible++
            } else {
                item.style.display = "none"
            }
        })

        // Show/hide no products message
        if (itemsVisible === 0) {
            noProductMessage.style.display = "block"
        } else {
            noProductMessage.style.display = "none"
        }
    }

    // Add event listeners to favorite buttons
    const favButtons = document.querySelectorAll(".fav-btn")
    favButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.stopPropagation()

            // Toggle favorited class
            this.classList.toggle("favorited")

            // Change icon
            const icon = this.querySelector("i")
            if (this.classList.contains("favorited")) {
                icon.classList.remove("far")
                icon.classList.add("fas")

                // Show toast notification
                showToast("Added to Favorites", "Item has been added to your favorites", "/assets/images/logo/logo-small.png")
            } else {
                icon.classList.remove("fas")
                icon.classList.add("far")

                // Show toast notification
                showToast(
                    "Removed from Favorites",
                    "Item has been removed from your favorites",
                    "/assets/images/logo/logo-small.png",
                )
            }
        })
    })

    // Remove the custom openOrderPanel function and use the one from app.js instead

    // Add event listeners to order buttons
    const orderButtons = document.querySelectorAll(".book-btn")
    orderButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.stopPropagation()

            // Get product data
            const productId = this.getAttribute("data-id")
            const productName = this.getAttribute("data-name")
            const productPrice = Number.parseFloat(this.getAttribute("data-price"))
            const productImage = this.getAttribute("data-image")

            // Use the existing openOrderPanel function from app.js
            if (typeof window.openOrderPanel === "function") {
                // If the function exists in the global scope, use it
                window.openOrderPanel(productId, productName, productPrice, productImage)
            } else {
                // Otherwise, show the order panel and set the values manually
                const orderPanel = document.getElementById("orderPanel")
                if (orderPanel) {
                    // Set product details
                    document.getElementById("productImage").src = productImage
                    document.getElementById("productName").textContent = productName
                    document.getElementById("productPrice").textContent = `$${productPrice.toFixed(2)}`
                    document.getElementById("basePrice").textContent = `$${productPrice.toFixed(2)}`
                    document.getElementById("totalPrice").textContent = `$${productPrice.toFixed(2)}`

                    // Reset selections
                    document.getElementById("drinkSize").selectedIndex = 0
                    document.getElementById("sugarLevel").selectedIndex = 2 // Default to 50%
                    document.querySelectorAll('#toppings input[type="checkbox"]').forEach((cb) => (cb.checked = false))

                    // Reset prices
                    document.getElementById("sizePrice").textContent = "$0.00"
                    document.getElementById("toppingsPrice").textContent = "$0.00"

                    // Show panel with animation
                    orderPanel.classList.add("active")
                    document.getElementById("overlay").style.display = "block"

                    // Declare updatePrice here, assuming it's defined elsewhere or will be
                    let updatePrice

                    // Update price
                    if (typeof updatePrice === "function") {
                        updatePrice()
                    }
                }
            }
        })
    })

    // Make entire menu item clickable to open order panel
    menuItems.forEach((item) => {
        item.addEventListener("click", function() {
            const orderButton = this.querySelector(".order-now-btn")
            if (orderButton) {
                orderButton.click()
            }
        })
    })

    // Function to show toast notification
    function showToast(title, message, image) {
        const toast = document.getElementById("toastNotification")
        const toastTitle = document.getElementById("toastTitle")
        const toastMessage = document.getElementById("toastMessage")
        const toastImage = document.getElementById("toastImage")

        if (toast && toastTitle && toastMessage && toastImage) {
            toastTitle.textContent = title
            toastMessage.textContent = message
            toastImage.src = image

            toast.classList.add("active")

            setTimeout(() => {
                toast.classList.remove("active")
            }, 3000)
        }
    }
})