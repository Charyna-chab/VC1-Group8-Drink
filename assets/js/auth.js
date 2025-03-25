document.addEventListener("DOMContentLoaded", () => {
    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll(".toggle-password")
    togglePasswordButtons.forEach((button) => {
        button.addEventListener("click", function () {
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
    const loginForm = document.querySelector('form[action="/login"]')
    const registerForm = document.querySelector('form[action="/register"]')
    const forgotPasswordForm = document.querySelector('form[action="/forgot-password"]')
    const adminLoginForm = document.querySelector('form[action="/admin-login"]')
    const adminVerificationForm = document.querySelector('form[action="/admin-verification"]')

    // Validate all forms for empty required fields
    const requiredFields = authForm.querySelectorAll("[required]")
    let hasEmptyFields = false

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            event.preventDefault()
            hasEmptyFields = true
            field.classList.add("error-field")
            field.addEventListener("input", function () {
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
        errorDiv.querySelector("span").textContent = message
    }
}

// Social login buttons
const socialButtons = document.querySelectorAll(".social-button")
socialButtons.forEach((button) => {
    button.addEventListener("click", function () {
        const provider = this.classList.contains("google") ? "Google" : "Facebook"

        // In a real application, this would redirect to the OAuth provider
        alert(`${provider} login is not implemented in this demo.`)
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
