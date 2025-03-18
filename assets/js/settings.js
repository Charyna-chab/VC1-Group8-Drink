document.addEventListener("DOMContentLoaded", () => {
    // Tab switching
    const tabLinks = document.querySelectorAll(".settings-nav li")
    const tabContents = document.querySelectorAll(".settings-tab")

    tabLinks.forEach((link) => {
        link.addEventListener("click", function() {
            // Remove active class from all tabs
            tabLinks.forEach((tab) => tab.classList.remove("active"))
            tabContents.forEach((content) => content.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            // Show corresponding content
            const tabId = this.getAttribute("data-tab")
            document.getElementById(`${tabId}-tab`).classList.add("active")
        })
    })

    // Account form submission
    const accountForm = document.getElementById("accountForm")
    if (accountForm) {
        accountForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Get form data
            const formData = new FormData(this)
            const userData = {
                name: formData.get("name"),
                email: formData.get("email"),
                phone: formData.get("phone"),
                birthday: formData.get("birthday"),
            }

            // Save to localStorage (in a real app, this would be an API call)
            localStorage.setItem("userData", JSON.stringify(userData))

            // Update session data (this is just for demo purposes)
            // In a real app, this would be handled by the server
            if (typeof updateSessionData === "function") {
                updateSessionData(userData)
            }

            showToast("Account information updated successfully!", "success")
        })
    }

    // Password form submission
    const passwordForm = document.getElementById("passwordForm")
    if (passwordForm) {
        passwordForm.addEventListener("submit", function(e) {
            e.preventDefault()

            const currentPassword = document.getElementById("current_password").value
            const newPassword = document.getElementById("new_password").value
            const confirmPassword = document.getElementById("confirm_password").value

            if (!currentPassword || !newPassword || !confirmPassword) {
                showToast("Please fill in all password fields", "error")
                return
            }

            if (newPassword !== confirmPassword) {
                showToast("New passwords do not match", "error")
                return
            }

            if (newPassword.length < 8) {
                showToast("Password must be at least 8 characters long", "error")
                return
            }

            // In a real app, this would be an API call to verify the current password
            // and update to the new password

            // Reset form
            this.reset()

            showToast("Password updated successfully!", "success")
        })
    }

    // Notifications form submission
    const notificationsForm = document.getElementById("notificationsForm")
    if (notificationsForm) {
        notificationsForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Get form data
            const formData = new FormData(this)
            const notificationSettings = {
                notify_orders: formData.get("notify_orders") === "on",
                notify_promotions: formData.get("notify_promotions") === "on",
                notify_news: formData.get("notify_news") === "on",
                push_orders: formData.get("push_orders") === "on",
                push_promotions: formData.get("push_promotions") === "on",
                push_news: formData.get("push_news") === "on",
            }

            // Save to localStorage (in a real app, this would be an API call)
            localStorage.setItem("notificationSettings", JSON.stringify(notificationSettings))

            showToast("Notification preferences saved!", "success")
        })
    }

    // Privacy form submission
    const privacyForm = document.getElementById("privacyForm")
    if (privacyForm) {
        privacyForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Get form data
            const formData = new FormData(this)
            const privacySettings = {
                share_analytics: formData.get("share_analytics") === "on",
                share_marketing: formData.get("share_marketing") === "on",
                cookies_preferences: formData.get("cookies_preferences") === "on",
                cookies_analytics: formData.get("cookies_analytics") === "on",
                cookies_marketing: formData.get("cookies_marketing") === "on",
            }

            // Save to localStorage (in a real app, this would be an API call)
            localStorage.setItem("privacySettings", JSON.stringify(privacySettings))

            showToast("Privacy preferences saved!", "success")
        })
    }

    // Appearance form submission
    const appearanceForm = document.getElementById("appearanceForm")
    if (appearanceForm) {
        // Font size range slider
        const fontSizeSlider = document.getElementById("font_size")
        const fontSizeValue = document.querySelector(".range-value")

        if (fontSizeSlider && fontSizeValue) {
            fontSizeSlider.addEventListener("input", function() {
                fontSizeValue.textContent = `${this.value}px`
            })
        }

        appearanceForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Get form data
            const formData = new FormData(this)
            const appearanceSettings = {
                theme: formData.get("theme"),
                font_size: formData.get("font_size"),
            }

            // Save to localStorage (in a real app, this would be an API call)
            localStorage.setItem("appearanceSettings", JSON.stringify(appearanceSettings))

            // Apply theme
            applyTheme(appearanceSettings.theme)

            showToast("Appearance preferences saved!", "success")
        })
    }

    // Language form submission
    const languageForm = document.getElementById("languageForm")
    if (languageForm) {
        languageForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Get form data
            const formData = new FormData(this)
            const languageSettings = {
                language: formData.get("language"),
            }

            // Save to localStorage (in a real app, this would be an API call)
            localStorage.setItem("languageSettings", JSON.stringify(languageSettings))

            showToast("Language preference saved!", "success")
        })
    }

    // Delete account button
    const deleteAccountBtn = document.getElementById("deleteAccountBtn")
    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener("click", () => {
            if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                // In a real app, this would be an API call to delete the account
                showToast("Account deletion request submitted", "info")

                // Redirect to logout after a delay
                setTimeout(() => {
                    window.location.href = "/logout"
                }, 2000)
            }
        })
    }

    // Download data button
    const downloadDataBtn = document.getElementById("downloadDataBtn")
    if (downloadDataBtn) {
        downloadDataBtn.addEventListener("click", () => {
            // In a real app, this would be an API call to generate and download the data
            showToast("Your data is being prepared for download", "info")

            // Simulate download after a delay
            setTimeout(() => {
                showToast("Data download started", "success")
            }, 2000)
        })
    }

    // Add payment method button
    const addPaymentBtn = document.querySelector(".add-payment-btn")
    if (addPaymentBtn) {
        addPaymentBtn.addEventListener("click", () => {
            // In a real app, this would open a payment method form
            showToast("Payment method form would open here", "info")
        })
    }

    // Add address button
    const addAddressBtn = document.querySelector(".add-address-btn")
    if (addAddressBtn) {
        addAddressBtn.addEventListener("click", () => {
            // In a real app, this would open an address form
            showToast("Address form would open here", "info")
        })
    }

    // Load saved settings from localStorage
    loadSavedSettings()

    // Apply theme based on saved settings
    applyThemeFromSettings()

    // Helper function to show toast notifications
    function showToast(message, type = "info") {
        // Check if toast container exists
        let toastContainer = document.querySelector(".toast-container")

        if (!toastContainer) {
            toastContainer = document.createElement("div")
            toastContainer.className = "toast-container"
            document.body.appendChild(toastContainer)
        }

        // Create toast
        const toast = document.createElement("div")
        toast.className = `toast ${type}`

        let icon = "info-circle"
        if (type === "success") {
            icon = "check-circle"
        } else if (type === "error") {
            icon = "exclamation-circle"
        }

        toast.innerHTML = `
              <div class="toast-icon">
                  <i class="fas fa-${icon}"></i>
              </div>
              <div class="toast-content">
                  <p>${message}</p>
              </div>
              <button class="toast-close">
                  <i class="fas fa-times"></i>
              </button>
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
            toast.classList.add("toast-hide")
            setTimeout(() => {
                toast.remove()
            }, 300)
        }, 5000)
    }

    // Helper function to load saved settings
    function loadSavedSettings() {
        // Load user data
        const userData = JSON.parse(localStorage.getItem("userData"))
        if (userData) {
            if (document.getElementById("name")) document.getElementById("name").value = userData.name || ""
            if (document.getElementById("email")) document.getElementById("email").value = userData.email || ""
            if (document.getElementById("phone")) document.getElementById("phone").value = userData.phone || ""
            if (document.getElementById("birthday")) document.getElementById("birthday").value = userData.birthday || ""
        }

        // Load notification settings
        const notificationSettings = JSON.parse(localStorage.getItem("notificationSettings"))
        if (notificationSettings) {
            for (const [key, value] of Object.entries(notificationSettings)) {
                const checkbox = document.querySelector(`input[name="${key}"]`)
                if (checkbox) checkbox.checked = value
            }
        }

        // Load privacy settings
        const privacySettings = JSON.parse(localStorage.getItem("privacySettings"))
        if (privacySettings) {
            for (const [key, value] of Object.entries(privacySettings)) {
                const checkbox = document.querySelector(`input[name="${key}"]`)
                if (checkbox) checkbox.checked = value
            }
        }

        // Load appearance settings
        const appearanceSettings = JSON.parse(localStorage.getItem("appearanceSettings"))
        if (appearanceSettings) {
            // Set theme radio button
            const themeRadio = document.querySelector(`input[name="theme"][value="${appearanceSettings.theme}"]`)
            if (themeRadio) themeRadio.checked = true

            // Set font size
            const fontSizeSlider = document.getElementById("font_size")
            const fontSizeValue = document.querySelector(".range-value")
            if (fontSizeSlider && appearanceSettings.font_size) {
                fontSizeSlider.value = appearanceSettings.font_size
                if (fontSizeValue) fontSizeValue.textContent = `${appearanceSettings.font_size}px`
            }
        }

        // Load language settings
        const languageSettings = JSON.parse(localStorage.getItem("languageSettings"))
        if (languageSettings) {
            const languageSelect = document.getElementById("language")
            if (languageSelect && languageSettings.language) {
                languageSelect.value = languageSettings.language
            }
        }
    }

    // Helper function to apply theme
    function applyTheme(theme) {
        const body = document.body

        // Remove existing theme classes
        body.classList.remove("light-theme", "dark-theme")

        if (theme === "dark") {
            body.classList.add("dark-theme")
        } else if (theme === "system") {
            // Check system preference
            if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
                body.classList.add("dark-theme")
            } else {
                body.classList.add("light-theme")
            }
        } else {
            // Default to light theme
            body.classList.add("light-theme")
        }
    }

    // Apply theme based on saved settings
    function applyThemeFromSettings() {
        const appearanceSettings = JSON.parse(localStorage.getItem("appearanceSettings"))
        if (appearanceSettings && appearanceSettings.theme) {
            applyTheme(appearanceSettings.theme)
        } else {
            // Default to light theme
            applyTheme("light")
        }
    }

    // Function to update session data (for demo purposes)
    window.updateSessionData = (userData) => {
        // This would normally be handled by the server
        console.log("Updating session data:", userData)
    }
})