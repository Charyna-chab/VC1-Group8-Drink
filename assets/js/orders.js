document.addEventListener("DOMContentLoaded", () => {
    // Filter tabs functionality
    const filterTabs = document.querySelectorAll(".filter-tab")
    const orderCards = document.querySelectorAll(".order-card")
    const searchInput = document.getElementById("orderSearch")

    // Initialize current filter
    let currentFilter = "all"
    let searchTerm = ""

    // Add event listeners to filter tabs
    filterTabs.forEach((tab) => {
        tab.addEventListener("click", function() {
            // Remove active class from all tabs
            filterTabs.forEach((t) => t.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            // Update current filter
            currentFilter = this.getAttribute("data-status")

            // Filter orders
            filterOrders()
        })
    })

    // Add event listener to search input
    if (searchInput) {
        searchInput.addEventListener("input", function() {
            searchTerm = this.value.toLowerCase()
            filterOrders()
        })
    }

    // Function to filter orders
    function filterOrders() {
        orderCards.forEach((card) => {
            const status = card.getAttribute("data-status")
            const orderTitle = card.querySelector("h3").textContent.toLowerCase()
            const orderDetails = card.querySelector(".order-info").textContent.toLowerCase()

            // Check if order matches filter and search term
            const matchesFilter = currentFilter === "all" || status === currentFilter
            const matchesSearch = orderTitle.includes(searchTerm) || orderDetails.includes(searchTerm)

            if (matchesFilter && matchesSearch) {
                card.style.display = "flex"
            } else {
                card.style.display = "none"
            }
        })
    }

    // Cancel order functionality
    const cancelButtons = document.querySelectorAll(".cancel-order")
    cancelButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const orderId = this.getAttribute("data-id")

            // Show confirmation dialog
            if (confirm("Are you sure you want to cancel this order?")) {
                // In a real app, you would send a request to the server
                // For demo purposes, we'll just update the UI
                const orderCard = this.closest(".order-card")
                const statusBadge = orderCard.querySelector(".order-status")

                // Update status
                statusBadge.textContent = "Cancelled"
                statusBadge.classList.remove("processing")
                statusBadge.classList.add("cancelled")

                // Update data attribute
                orderCard.setAttribute("data-status", "cancelled")

                // Remove cancel button
                this.remove()

                // Show toast notification
                showToast("Order Cancelled", `Order #${orderId} has been cancelled`, "/assets/images/logo/logo-small.png")
            }
        })
    })

    // Reorder functionality
    const reorderButtons = document.querySelectorAll(".reorder")
    reorderButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const orderId = this.getAttribute("data-id")

            // In a real app, you would send a request to the server
            // For demo purposes, we'll just show a toast notification
            showToast("Order Placed", `Your order has been placed again`, "/assets/images/logo/logo-small.png")
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