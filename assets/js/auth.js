document.addEventListener("DOMContentLoaded", () => {
    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll(".toggle-password")

    togglePasswordButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const passwordInput = this.previousElementSibling

            if (passwordInput.type === "password") {
                passwordInput.type = "text"
                this.classList.remove("fa-eye")
                this.classList.add("fa-eye-slash")
            } else {
                passwordInput.type = "password"
                this.classList.remove("fa-eye-slash")
                this.classList.add("fa-eye")
            }
        })
    })

    // Form validation
    const loginForm = document.querySelector('form[action="/login"]')
    const registerForm = document.querySelector('form[action="/register"]')
    const forgotPasswordForm = document.querySelector('form[action="/forgot-password"]')
    const adminLoginForm = document.querySelector('form[action="/admin-login"]')
    const adminVerificationForm = document.querySelector('form[action="/admin-verification"]')

    if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
            const email = document.getElementById("email").value
            const password = document.getElementById("password").value

            if (!email || !password) {
                e.preventDefault()
                showError("Please fill in all required fields")
            }
        })
    }

    if (registerForm) {
        registerForm.addEventListener("submit", (e) => {
            const name = document.getElementById("name").value
            const email = document.getElementById("email").value
            const password = document.getElementById("password").value
            const confirmPassword = document.getElementById("confirm_password").value
            const terms = document.querySelector('input[name="terms"]').checked

            if (!name || !email || !password || !confirmPassword) {
                e.preventDefault()
                showError("Please fill in all required fields")
            } else if (password !== confirmPassword) {
                e.preventDefault()
                showError("Passwords do not match")
            } else if (password.length < 8) {
                e.preventDefault()
                showError("Password must be at least 8 characters long")
            } else if (!terms) {
                e.preventDefault()
                showError("You must agree to the Terms of Service")
            }
        })
    }

    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener("submit", (e) => {
            const email = document.getElementById("email").value

            if (!email) {
                e.preventDefault()
                showError("Please enter your email address")
            }
        })
    }

    if (adminLoginForm) {
        adminLoginForm.addEventListener("submit", (e) => {
            const email = document.getElementById("email").value
            const password = document.getElementById("password").value

            if (!email || !password) {
                e.preventDefault()
                showError("Please fill in all required fields")
            }
        })
    }

    if (adminVerificationForm) {
        adminVerificationForm.addEventListener("submit", (e) => {
            const verificationCode = document.getElementById("verification_code").value

            if (!verificationCode || verificationCode.length !== 6 || !/^\d+$/.test(verificationCode)) {
                e.preventDefault()
                showError("Please enter a valid 6-digit verification code")
            }
        })
    }

    // Show error message
    function showError(message) {
        let errorDiv = document.querySelector(".auth-error")

        if (!errorDiv) {
            errorDiv = document.createElement("div")
            errorDiv.className = "auth-error"
            errorDiv.innerHTML = `
                  <i class="fas fa-exclamation-circle"></i>
                  <span>${message}</span>
              `

            const form = document.querySelector(".auth-form")
            form.parentNode.insertBefore(errorDiv, form)
        } else {
            errorDiv.querySelector("span").textContent = message
        }

        // Scroll to error
        errorDiv.scrollIntoView({ behavior: "smooth", block: "start" })
    }

    // Social login buttons (placeholder functionality)
    const socialButtons = document.querySelectorAll(".social-button")

    socialButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const provider = this.classList.contains("google") ? "Google" : "Facebook"
            alert(`${provider} login would be implemented here in a real application.`)
        })
    })

    // Handle logout button click
    const logoutBtn = document.getElementById("logoutBtn")
    if (logoutBtn) {
        logoutBtn.addEventListener("click", (e) => {
            // No need to prevent default - we want the link to work normally
            // This is just for any additional functionality you might want to add
            console.log("Logging out...")
        })
    }
})