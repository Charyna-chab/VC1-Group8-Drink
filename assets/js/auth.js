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
        })
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
})