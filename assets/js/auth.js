document.addEventListener("DOMContentLoaded", () => {
    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll(".toggle-password")
    togglePasswordButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const passwordField = this.previousElementSibling

            // Toggle password visibility
            if (passwordField.type === "password") {
                passwordField.type = "text"
                this.classList.remove("fa-eye")
                this.classList.add("fa-eye-slash")
            } else {
                passwordField.type = "password"
                this.classList.remove("fa-eye-slash")
                this.classList.add("fa-eye")
            }
        })
    })

    // Form validation
    const authForm = document.querySelector(".auth-form")
    if (authForm) {
        authForm.addEventListener("submit", (event) => {
            // Get form type (login or register)
            const isRegisterForm = window.location.pathname.includes("register")
            const isLoginForm = window.location.pathname.includes("login")
            const isForgotPasswordForm = window.location.pathname.includes("forgot-password")

            // Validate all forms for empty required fields
            const requiredFields = authForm.querySelectorAll("[required]")
            let hasEmptyFields = false

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    event.preventDefault()
                    hasEmptyFields = true
                    field.classList.add("error-field")
                    field.addEventListener("input", function() {
                        this.classList.remove("error-field")
                    }, { once: true })
                }
            })

            if (hasEmptyFields) {
                showError("Please fill in all required fields")
                return
            }

            // Validate email format for all forms with email field
            const emailField = document.getElementById("email")
            if (emailField && !validateEmail(emailField.value)) {
                event.preventDefault()
                showError("Please enter a valid email address")
                return
            }

            if (isRegisterForm) {
                // Validate register form
                const password = document.getElementById("password").value
                const confirmPassword = document.getElementById("confirm_password").value

                if (password !== confirmPassword) {
                    event.preventDefault()
                    showError("Passwords do not match")
                    return
                }

                if (password.length < 8) {
                    event.preventDefault()
                    showError("Password must be at least 8 characters long")
                    return
                }

                const termsCheckbox = document.querySelector('input[name="terms"]')
                if (!termsCheckbox.checked) {
                    event.preventDefault()
                    showError("You must agree to the Terms of Service and Privacy Policy")
                    return
                }
            }

            if (isLoginForm) {
                // Store the last login email in localStorage for convenience
                const emailField = document.getElementById("email")
                if (emailField && emailField.value) {
                    localStorage.setItem("lastLoginEmail", emailField.value)
                }
            }
        })

        // Pre-fill email field if available in localStorage
        const emailField = document.getElementById("email")
        const lastLoginEmail = localStorage.getItem("lastLoginEmail")
        if (emailField && lastLoginEmail && window.location.pathname.includes("login")) {
            emailField.value = lastLoginEmail
        }
    }

    // Social login buttons
    const socialButtons = document.querySelectorAll(".social-button")
    socialButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const provider = this.classList.contains("google") ? "Google" : "Facebook"

            // In a real application, this would redirect to the OAuth provider
            alert(`${provider} login is not implemented in this demo.`)
        })
    })

    // Remember me checkbox
    const rememberCheckbox = document.querySelector('input[name="remember"]')
    if (rememberCheckbox) {
        // Check if user previously selected "remember me"
        const remembered = localStorage.getItem("rememberMe") === "true"
        rememberCheckbox.checked = remembered

        rememberCheckbox.addEventListener("change", function() {
            localStorage.setItem("rememberMe", this.checked)
        })
    }

    // Add focus styles to input fields
    const inputContainers = document.querySelectorAll(".input-with-icon")
    inputContainers.forEach(container => {
        const input = container.querySelector("input")

        input.addEventListener("focus", function() {
            container.classList.add("input-focused")
        })

        input.addEventListener("blur", function() {
            container.classList.remove("input-focused")
        })
    })

    // Function to show error message
    function showError(message) {
        // Check if error element already exists
        let errorElement = document.querySelector(".auth-error")

        if (!errorElement) {
            // Create error element
            errorElement = document.createElement("div")
            errorElement.className = "auth-error"
            errorElement.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                <span>${message}</span>
            `

            // Insert after auth-header
            const authHeader = document.querySelector(".auth-header")
            authHeader.insertAdjacentElement("afterend", errorElement)
        } else {
            // Update existing error message
            errorElement.querySelector("span").textContent = message
        }

        // Scroll to error
        errorElement.scrollIntoView({ behavior: "smooth", block: "center" })
    }

    // Function to validate email format
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return re.test(String(email).toLowerCase())
    }
})