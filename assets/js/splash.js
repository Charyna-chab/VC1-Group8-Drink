document.addEventListener("DOMContentLoaded", () => {
    // Get modal elements
    const loginModal = document.getElementById("loginModal")
    const registerModal = document.getElementById("registerModal")

    // Get buttons
    const loginBtn = document.getElementById("loginBtn")
    const registerBtn = document.getElementById("registerBtn")
    const guestBtn = document.getElementById("guestBtn")
    const switchToRegisterBtn = document.getElementById("switchToRegister")
    const switchToLoginBtn = document.getElementById("switchToLogin")

    // Get close buttons
    const closeButtons = document.querySelectorAll(".close-modal")

    // Get forms
    const loginForm = document.getElementById("loginForm")
    const registerForm = document.getElementById("registerForm")

    // Get error containers
    const loginError = document.getElementById("loginError")
    const registerError = document.getElementById("registerError")

    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll(".toggle-password")

    // Open login modal
    loginBtn.addEventListener("click", () => {
        loginModal.style.display = "block"
    })

    // Open register modal
    registerBtn.addEventListener("click", () => {
        registerModal.style.display = "block"
    })

    // Continue as guest
    guestBtn.addEventListener("click", () => {
        window.location.href = "/menu"
    })

    // Switch between modals
    switchToRegisterBtn.addEventListener("click", (e) => {
        e.preventDefault()
        loginModal.style.display = "none"
        registerModal.style.display = "block"
    })

    switchToLoginBtn.addEventListener("click", (e) => {
        e.preventDefault()
        registerModal.style.display = "none"
        loginModal.style.display = "block"
    })

    // Close modals
    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            loginModal.style.display = "none"
            registerModal.style.display = "none"
        })
    })

    // Close modal when clicking outside
    window.addEventListener("click", (event) => {
        if (event.target === loginModal) {
            loginModal.style.display = "none"
        }
        if (event.target === registerModal) {
            registerModal.style.display = "none"
        }
    })

    // Toggle password visibility
    togglePasswordButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const passwordField = this.previousElementSibling

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

    // Handle login form submission
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault()

        const email = document.getElementById("loginEmail").value
        const password = document.getElementById("loginPassword").value

        // Basic validation
        if (!email || !password) {
            showError(loginError, "Please enter both email and password")
            return
        }

        // Simulate login API call
        simulateLogin(email, password)
    })

    // Handle register form submission
    registerForm.addEventListener("submit", (e) => {
        e.preventDefault()

        const name = document.getElementById("registerName").value
        const email = document.getElementById("registerEmail").value
        const password = document.getElementById("registerPassword").value
        const confirmPassword = document.getElementById("registerConfirmPassword").value
        const termsChecked = document.querySelector('input[name="terms"]').checked

        // Basic validation
        if (!name || !email || !password || !confirmPassword) {
            showError(registerError, "Please fill in all fields")
            return
        }

        if (password !== confirmPassword) {
            showError(registerError, "Passwords do not match")
            return
        }

        if (password.length < 6) {
            showError(registerError, "Password must be at least 6 characters long")
            return
        }

        if (!termsChecked) {
            showError(registerError, "You must agree to the Terms of Service and Privacy Policy")
            return
        }

        // Simulate register API call
        simulateRegister(name, email, password)
    })

    // Function to show error message
    function showError(errorElement, message) {
        errorElement.querySelector("span").textContent = message
        errorElement.style.display = "flex"

        // Hide error after 5 seconds
        setTimeout(() => {
            errorElement.style.display = "none"
        }, 5000)
    }

    // Simulate login API call
    function simulateLogin(email, password) {
        // Show loading state
        const loginButton = loginForm.querySelector('button[type="submit"]')
        const originalText = loginButton.textContent
        loginButton.textContent = "Logging in..."
        loginButton.disabled = true

        // Simulate API delay
        setTimeout(() => {
            // For demo purposes, we'll accept any login
            // In a real app, you would validate with your server

            // Create a session cookie
            document.cookie = "user_session=logged_in; path=/; max-age=86400"

            // Redirect to menu page instead of home
            window.location.href = "/menu"

            // Reset button (in case the redirect fails)
            loginButton.textContent = originalText
            loginButton.disabled = false
        }, 1500)
    }

    // Simulate register API call
    function simulateRegister(name, email, password) {
        // Show loading state
        const registerButton = registerForm.querySelector('button[type="submit"]')
        const originalText = registerButton.textContent
        registerButton.textContent = "Creating Account..."
        registerButton.disabled = true

        // Simulate API delay
        setTimeout(() => {
            // For demo purposes, we'll accept any registration
            // In a real app, you would send this data to your server

            // Create a session cookie
            document.cookie = "user_session=registered; path=/; max-age=86400"

            // Redirect to menu page instead of home
            window.location.href = "/menu"

            // Reset button (in case the redirect fails)
            registerButton.textContent = originalText
            registerButton.disabled = false
        }, 1500)
    }

    // Add bubble animation
    const bubbles = document.querySelectorAll(".bubble")
    bubbles.forEach((bubble) => {
        // Randomize starting positions
        const randomLeft = Math.random() * 100
        bubble.style.left = `${randomLeft}%`

        // Randomize animation delay
        const randomDelay = Math.random() * 5
        bubble.style.animationDelay = `${randomDelay}s`
    })
})