document.addEventListener("DOMContentLoaded", () => {
    // Tab switching functionality
    const tabs = document.querySelectorAll(".profile-tab")
    const tabContents = document.querySelectorAll(".profile-tab-content")

    tabs.forEach((tab) => {
        tab.addEventListener("click", function() {
            // Remove active class from all tabs and contents
            tabs.forEach((t) => t.classList.remove("active"))
            tabContents.forEach((c) => c.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            // Show corresponding content
            const tabName = this.getAttribute("data-tab")
            document.getElementById(`${tabName}-tab`).classList.add("active")
        })
    })

    // Profile image upload functionality
    const profileImageContainer = document.querySelector(".profile-image-container")
    if (profileImageContainer) {
        profileImageContainer.addEventListener("click", () => {
            // Create a file input element
            const fileInput = document.createElement("input")
            fileInput.type = "file"
            fileInput.accept = "image/*"

            // Trigger click on file input
            fileInput.click()

            // Handle file selection
            fileInput.addEventListener("change", function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader()

                    reader.onload = (e) => {
                        // Update profile image
                        const profileImage = document.querySelector(".profile-image")
                        profileImage.src = e.target.result

                        // In a real app, you would upload the image to the server
                        // For demo purposes, we'll just show a success message
                        showAlert("Profile image updated successfully", "success")
                    }

                    reader.readAsDataURL(this.files[0])
                }
            })
        })
    }

    // Add payment method button
    const addPaymentBtn = document.querySelector(".add-payment-btn")
    if (addPaymentBtn) {
        addPaymentBtn.addEventListener("click", () => {
            // In a real app, you would show a payment method form
            // For demo purposes, we'll just show an alert
            alert("Payment method functionality would be implemented here.")
        })
    }

    // Form submission handling
    const forms = document.querySelectorAll(".profile-form")
    forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            // In a real app, you would submit the form to the server
            // For demo purposes, we'll prevent the default action and show a success message
            e.preventDefault()

            // Show success message
            showAlert("Profile updated successfully", "success")
        })
    })

    // Function to show alert
    function showAlert(message, type) {
        // Check if alert already exists
        let alert = document.querySelector(".alert")

        // If not, create a new one
        if (!alert) {
            alert = document.createElement("div")
            alert.className = `alert alert-${type}`

            const icon = document.createElement("i")
            icon.className = type === "success" ? "fas fa-check-circle" : "fas fa-exclamation-circle"

            const span = document.createElement("span")
            span.textContent = message

            alert.appendChild(icon)
            alert.appendChild(span)

            // Insert after profile header
            const profileHeader = document.querySelector(".profile-header")
            profileHeader.insertAdjacentElement("afterend", alert)
        } else {
            // Update existing alert
            alert.className = `alert alert-${type}`
            alert.querySelector("i").className = type === "success" ? "fas fa-check-circle" : "fas fa-exclamation-circle"
            alert.querySelector("span").textContent = message
        }

        // Auto-hide after 5 seconds
        setTimeout(() => {
            alert.style.opacity = "0"
            setTimeout(() => {
                alert.remove()
            }, 300)
        }, 5000)
    }
})