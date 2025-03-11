document.addEventListener("DOMContentLoaded", () => {
    // Tab switching functionality
    const navItems = document.querySelectorAll(".settings-nav li")
    const tabContents = document.querySelectorAll(".settings-tab")

    navItems.forEach((item) => {
        item.addEventListener("click", function() {
            // Remove active class from all items and contents
            navItems.forEach((i) => i.classList.remove("active"))
            tabContents.forEach((c) => c.classList.remove("active"))

            // Add active class to clicked item
            this.classList.add("active")

            // Show corresponding content
            const tabName = this.getAttribute("data-tab")
            document.getElementById(`${tabName}-tab`).classList.add("active")
        })
    })

    // Font size range slider
    const fontSizeSlider = document.getElementById("font_size")
    const fontSizeValue = document.querySelector(".range-value")

    if (fontSizeSlider && fontSizeValue) {
        fontSizeSlider.addEventListener("input", function() {
            fontSizeValue.textContent = `${this.value}px`
        })
    }

    // Theme selection
    const themeOptions = document.querySelectorAll('input[name="theme"]')

    themeOptions.forEach((option) => {
        option.addEventListener("change", function() {
            if (this.checked) {
                const theme = this.value

                // In a real app, you would apply the theme to the body
                // For demo purposes, we'll just show a toast notification
                showToast("Theme Changed", `Theme has been changed to ${theme}`, "/assets/images/logo/logo-small.png")
            }
        })
    })

    // Language selection
    const languageSelect = document.getElementById("language")

    if (languageSelect) {
        languageSelect.addEventListener("change", function() {
            const language = this.options[this.selectedIndex].text

            // In a real app, you would change the language
            // For demo purposes, we'll just show a toast notification
            showToast("Language Changed", `Language has been changed to ${language}`, "/assets/images/logo/logo-small.png")
        })
    }

    // Form submission handling
    const forms = document.querySelectorAll(".settings-form")

    forms.forEach((form) => {
        form.addEventListener("submit", function(e) {
            e.preventDefault()

            // Get form ID to determine which form was submitted
            const formId = this.id
            let successMessage = ""

            switch (formId) {
                case "accountForm":
                    successMessage = "Account information updated successfully"
                    break
                case "passwordForm":
                    successMessage = "Password updated successfully"
                    break
                case "notificationsForm":
                    successMessage = "Notification preferences saved"
                    break
                case "privacyForm":
                    successMessage = "Privacy settings updated"
                    break
                case "appearanceForm":
                    successMessage = "Appearance settings saved"
                    break
                case "languageForm":
                    successMessage = "Language preference saved"
                    break
                default:
                    successMessage = "Settings updated successfully"
            }

            // Show success message
            showToast("Settings Saved", successMessage, "/assets/images/logo/logo-small.png")
        })
    })

    // Delete account button
    const deleteAccountBtn = document.getElementById("deleteAccountBtn")

    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener("click", () => {
            // Show confirmation dialog
            if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                // In a real app, you would send a request to the server
                // For demo purposes, we'll just show a toast notification
                showToast("Account Deleted", "Your account has been deleted", "/assets/images/logo/logo-small.png")

                // Redirect to home page after a delay
                setTimeout(() => {
                    window.location.href = "/"
                }, 3000)
            }
        })
    }

    // Download data button
    const downloadDataBtn = document.getElementById("downloadDataBtn")

    if (downloadDataBtn) {
        downloadDataBtn.addEventListener("click", () => {
            // In a real app, you would generate and download the data
            // For demo purposes, we'll just show a toast notification
            showToast(
                "Data Export",
                "Your data export has been initiated. You will receive an email when it's ready.",
                "/assets/images/logo/logo-small.png",
            )
        })
    }

    // Add payment method button
    const addPaymentBtn = document.querySelector(".add-payment-btn")

    if (addPaymentBtn) {
        addPaymentBtn.addEventListener("click", () => {
            // In a real app, you would show a payment method form
            // For demo purposes, we'll just show a toast notification
            showToast(
                "Add Payment Method",
                "Payment method functionality would be implemented here",
                "/assets/images/logo/logo-small.png",
            )
        })
    }

    // Add address button
    const addAddressBtn = document.querySelector(".add-address-btn")

    if (addAddressBtn) {
        addAddressBtn.addEventListener("click", () => {
            // In a real app, you would show an address form
            // For demo purposes, we'll just show a toast notification
            showToast("Add Address", "Address functionality would be implemented here", "/assets/images/logo/logo-small.png")
        })
    }

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