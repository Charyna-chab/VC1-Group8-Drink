document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const filterTabs = document.querySelectorAll(".filter-tab")
    const bookingCards = document.querySelectorAll(".booking-card")
    const searchInput = document.getElementById("bookingSearch")
    const cancelButtons = document.querySelectorAll(".cancel-booking-btn")

    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById("toastContainer")
    if (!toastContainer) {
        toastContainer = document.createElement("div")
        toastContainer.id = "toastContainer"
        toastContainer.className = "toast-container"
        document.body.appendChild(toastContainer)
    }

    // Filter bookings by status
    filterTabs.forEach((tab) => {
        tab.addEventListener("click", function() {
            // Remove active class from all tabs
            filterTabs.forEach((t) => t.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            const status = this.getAttribute("data-status")

            // Filter bookings
            bookingCards.forEach((card) => {
                if (status === "all" || card.getAttribute("data-status") === status) {
                    card.style.display = "block"
                } else {
                    card.style.display = "none"
                }
            })

            // Check if any bookings are visible
            checkEmptyState()
        })
    })

    // Search functionality
    searchInput.addEventListener("input", function() {
        const searchTerm = this.value.toLowerCase().trim()

        bookingCards.forEach((card) => {
            const orderNumber = card.querySelector("h3").textContent.toLowerCase()

            if (orderNumber.includes(searchTerm)) {
                card.style.display = "block"
            } else {
                card.style.display = "none"
            }
        })

        // Check if any bookings are visible
        checkEmptyState()
    })

    // Check if any bookings are visible and show empty state if needed
    function checkEmptyState() {
        let visibleCount = 0

        bookingCards.forEach((card) => {
            if (card.style.display !== "none") {
                visibleCount++
            }
        })

        // Get or create empty state element
        let emptyState = document.querySelector(".empty-state")

        if (visibleCount === 0) {
            if (!emptyState) {
                emptyState = document.createElement("div")
                emptyState.className = "empty-state"
                emptyState.innerHTML = `
                      <img src="/assets/images/empty-orders.svg" alt="No Orders">
                      <h3>No Orders Found</h3>
                      <p>No orders match your current filter. Try changing your search or filter criteria.</p>
                      <a href="/order" class="btn-primary">Order Now</a>
                  `
                document.querySelector(".bookings-list").appendChild(emptyState)
            } else {
                emptyState.style.display = "block"
            }
        } else if (emptyState) {
            emptyState.style.display = "none"
        }
    }

    // Cancel booking
    cancelButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const bookingId = this.getAttribute("data-id")
            const bookingCard = this.closest(".booking-card")

            // Show confirmation dialog
            if (confirm("Are you sure you want to cancel this order?")) {
                // In a real application, you would send an AJAX request to cancel the order
                // For demo purposes, we'll just update the UI

                // Update status
                const statusElement = bookingCard.querySelector(".booking-status")
                statusElement.textContent = "Cancelled"
                statusElement.className = "booking-status cancelled"

                // Remove cancel button
                this.remove()

                // Update data-status attribute
                bookingCard.setAttribute("data-status", "cancelled")

                // Show toast notification
                showToast("Order Cancelled", "Your order has been cancelled successfully.", "success")
            }
        })
    })

    // Show toast notification
    function showToast(title, message, type = "info") {
        const toast = document.createElement("div")
        toast.className = "toast"

        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
            toast.style.borderLeftColor = "#4caf50"
        } else if (type === "error") {
            icon = "exclamation-circle"
            toast.style.borderLeftColor = "#f44336"
        }

        toast.innerHTML = `
              <div>
                  <i class="fas fa-${icon}" style="color: ${type === "success" ? "#4caf50" : type === "error" ? "#f44336" : "#ff5e62"}; font-size: 20px; margin-right: 10px;"></i>
              </div>
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

    // Initialize - check if any bookings exist
    if (bookingCards.length === 0) {
        const emptyState = document.createElement("div")
        emptyState.className = "empty-state"
        emptyState.innerHTML = `
              <img src="/assets/images/empty-orders.svg" alt="No Orders">
              <h3>No Orders Yet</h3>
              <p>You haven't placed any orders yet. Start ordering your favorite drinks!</p>
              <a href="/order" class="btn-primary">Order Now</a>
          `
        document.querySelector(".bookings-list").appendChild(emptyState)
    }
})