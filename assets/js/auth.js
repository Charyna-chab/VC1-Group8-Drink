// Enhanced Auth System JavaScript with Animations and Transitions
document.addEventListener("DOMContentLoaded", () => {
    // Create background elements
    createBackgroundElements()

    // Create bubble decorations
    createBubbleDecorations()

    // Create tea elements
    createTeaElements()

    // Create button bubbles
    createButtonBubbles()

    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll(".toggle-password")

    togglePasswordButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
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

            // Add ripple effect
            addRippleEffect(this, e)
        })
    })

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll(".auth-button, .social-button")
    buttons.forEach((button) => {
        button.addEventListener("click", function(e) {
            addRippleEffect(this, e)
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
                shakeForm()
            } else {
                // Show loading animation on button
                const submitButton = loginForm.querySelector(".auth-button")
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...'
                submitButton.disabled = true
            }
        })
    }

    if (registerForm) {
        registerForm.addEventListener("submit", (e) => {
            const name = document.getElementById("name").value
            const email = document.getElementById("email").value
            const password = document.getElementById("password").value
            const confirmPassword = document.getElementById("confirm_password").value
            const terms = document.querySelector('input[name="terms"]') ? .checked

            if (!name || !email || !password || !confirmPassword) {
                e.preventDefault()
                showError("Please fill in all required fields")
                shakeForm()
            } else if (password !== confirmPassword) {
                e.preventDefault()
                showError("Passwords do not match")
                shakeForm()
            } else if (password.length < 8) {
                e.preventDefault()
                showError("Password must be at least 8 characters long")
                shakeForm()
            } else if (!terms) {
                e.preventDefault()
                showError("You must agree to the Terms of Service")
                shakeForm()
            } else {
                // Show loading animation on button
                const submitButton = registerForm.querySelector(".auth-button")
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating account...'
                submitButton.disabled = true
            }
        })
    }

    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener("submit", (e) => {
            const email = document.getElementById("email").value

            if (!email) {
                e.preventDefault()
                showError("Please enter your email address")
                shakeForm()
            } else {
                // Show loading animation on button
                const submitButton = forgotPasswordForm.querySelector(".auth-button")
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending reset link...'
                submitButton.disabled = true
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
                shakeForm()
            } else {
                // Show loading animation on button
                const submitButton = adminLoginForm.querySelector(".auth-button")
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...'
                submitButton.disabled = true
            }
        })
    }

    if (adminVerificationForm) {
        adminVerificationForm.addEventListener("submit", (e) => {
            const verificationCode = document.getElementById("verification_code").value

            if (!verificationCode || verificationCode.length !== 6 || !/^\d+$/.test(verificationCode)) {
                e.preventDefault()
                showError("Please enter a valid 6-digit verification code")
                shakeForm()
            } else {
                // Show loading animation on button
                const submitButton = adminVerificationForm.querySelector(".auth-button")
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...'
                submitButton.disabled = true
            }
        })
    }

    // Show error message with animation
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
                // Restart animation
            errorDiv.style.animation = "none"
            void errorDiv.offsetWidth // Trigger reflow
            errorDiv.style.animation = "shake 0.5s ease-in-out"
        }

        // Scroll to error
        errorDiv.scrollIntoView({ behavior: "smooth", block: "start" })
    }

    // Shake form on error
    function shakeForm() {
        const form = document.querySelector(".auth-form")
        form.classList.add("shake")

        setTimeout(() => {
            form.classList.remove("shake")
        }, 500)
    }

    // Add ripple effect to buttons
    function addRippleEffect(element, event) {
        const ripple = document.createElement("span")
        ripple.classList.add("ripple")
        element.appendChild(ripple)

        const rect = element.getBoundingClientRect()
        const size = Math.max(rect.width, rect.height)

        ripple.style.width = ripple.style.height = `${size}px`
        ripple.style.left = `${event.clientX - rect.left - size / 2}px`
        ripple.style.top = `${event.clientY - rect.top - size / 2}px`

        ripple.classList.add("active")

        setTimeout(() => {
            ripple.remove()
        }, 600)
    }

    // Social login buttons with animations
    const socialButtons = document.querySelectorAll(".social-button")

    socialButtons.forEach((button) => {
        button.addEventListener("click", function() {
            const provider = this.classList.contains("google") ? "Google" : "Facebook"

            // Add animation
            this.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Connecting to ${provider}...`

            // Simulate login process
            setTimeout(() => {
                alert(`${provider} login would be implemented here in a real application.`)

                // Reset button
                if (provider === "Google") {
                    this.innerHTML = `<i class="fab fa-google"></i><span>Google</span>`
                } else {
                    this.innerHTML = `<i class="fab fa-facebook-f"></i><span>Facebook</span>`
                }
            }, 1500)
        })
    })

    // Create background elements
    function createBackgroundElements() {
        const container = document.querySelector(".main-container")
        if (!container) return

        // Create background elements container
        const elementsContainer = document.createElement("div")
        elementsContainer.className = "background-bubbles"

        // Create bubbles
        for (let i = 0; i < 6; i++) {
            const bubble = document.createElement("div")
            bubble.className = "bg-bubble"
            elementsContainer.appendChild(bubble)
        }

        container.appendChild(elementsContainer)
    }

    // Create bubble decorations
    function createBubbleDecorations() {
        const authImage = document.querySelector(".auth-image")
        if (!authImage) return

        // Create bubble decoration if it doesn't exist
        let bubbleContainer = document.querySelector(".bubble-decoration")
        if (!bubbleContainer) {
            bubbleContainer = document.createElement("div")
            bubbleContainer.className = "bubble-decoration"
            authImage.appendChild(bubbleContainer)
        }

        // Clear existing bubbles
        bubbleContainer.innerHTML = ""

        // Create new bubbles
        for (let i = 0; i < 15; i++) {
            const bubble = document.createElement("div")
            bubble.className = "bubble"

            // Random size between 10px and 60px
            const size = Math.random() * 50 + 10
            bubble.style.width = `${size}px`
            bubble.style.height = `${size}px`

            // Random position
            bubble.style.left = `${Math.random() * 100}%`
            bubble.style.top = `${Math.random() * 100}%`

            // Random animation delay
            bubble.style.animationDelay = `${Math.random() * 8}s`

            // Random opacity
            bubble.style.opacity = Math.random() * 0.5 + 0.1

            bubbleContainer.appendChild(bubble)
        }

        // Add drink animation
        const drinkAnimation = document.createElement("div")
        drinkAnimation.className = "drink-animation"

        const cup = document.createElement("div")
        cup.className = "cup"

        const tea = document.createElement("div")
        tea.className = "tea"

        const straw = document.createElement("div")
        straw.className = "straw"

        // Create boba balls
        for (let i = 0; i < 8; i++) {
            const boba = document.createElement("div")
            boba.className = "boba"
            boba.style.left = `${Math.random() * 80}%`
            boba.style.bottom = `${Math.random() * 50}%`
            boba.style.animationDelay = `${Math.random() * 4}s`
            tea.appendChild(boba)
        }

        cup.appendChild(tea)
        drinkAnimation.appendChild(cup)
        drinkAnimation.appendChild(straw)
        authImage.appendChild(drinkAnimation)
    }

    // Create tea elements for background
    function createTeaElements() {
        const container = document.querySelector(".main-container")
        if (!container) return

        // Create tea elements container
        const teaContainer = document.createElement("div")
        teaContainer.className = "tea-elements"

        // Create boba balls
        for (let i = 0; i < 10; i++) {
            const boba = document.createElement("div")
            boba.className = "boba-ball"
            boba.style.left = `${Math.random() * 100}%`
            boba.style.top = `${Math.random() * 100}%`
            boba.style.animationDelay = `${Math.random() * 10}s`
            teaContainer.appendChild(boba)
        }

        // Create tea leaves
        for (let i = 0; i < 6; i++) {
            const leaf = document.createElement("div")
            leaf.className = "tea-leaf"
            leaf.style.left = `${Math.random() * 100}%`
            leaf.style.top = `${Math.random() * 100}%`
            leaf.style.animationDelay = `${Math.random() * 15}s`
            teaContainer.appendChild(leaf)
        }

        // Create tea cups
        for (let i = 0; i < 4; i++) {
            const cup = document.createElement("div")
            cup.className = "tea-cup"
            cup.style.left = `${Math.random() * 100}%`
            cup.style.top = `${Math.random() * 100}%`
            cup.style.animationDelay = `${Math.random() * 20}s`
            teaContainer.appendChild(cup)
        }

        container.appendChild(teaContainer)
    }

    // Create button bubbles
    function createButtonBubbles() {
        const authButtons = document.querySelectorAll(".auth-button")

        authButtons.forEach((button) => {
            // Create bubbles for each button
            for (let i = 0; i < 5; i++) {
                const bubble = document.createElement("span")
                bubble.className = "bubble-btn"

                // Random size between 5px and 15px
                const size = Math.random() * 10 + 5
                bubble.style.width = `${size}px`
                bubble.style.height = `${size}px`

                // Random position
                bubble.style.left = `${Math.random() * 100}%`
                bubble.style.bottom = "0"

                // Random animation delay
                bubble.style.animationDelay = `${Math.random() * 3}s`

                button.appendChild(bubble)
            }
        })
    }

    // Auto-focus first input field
    const firstInput = document.querySelector(".auth-form input:first-of-type")
    if (firstInput) {
        setTimeout(() => {
            firstInput.focus()
        }, 500)
    }

    // Verification code input handling
    const verificationCodeInput = document.getElementById("verification_code")
    if (verificationCodeInput) {
        verificationCodeInput.focus()

        // Add animation when typing
        verificationCodeInput.addEventListener("input", function() {
            if (this.value.length === 6) {
                this.classList.add("complete")
            } else {
                this.classList.remove("complete")
            }
        })
    }

    // Auto-focus and auto-tab for verification code inputs
    const verificationInputs = document.querySelectorAll(".verification-code input")
    if (verificationInputs.length > 0) {
        verificationInputs.forEach((input, index) => {
            input.addEventListener("keyup", (e) => {
                if (e.key >= "0" && e.key <= "9") {
                    if (index < verificationInputs.length - 1) {
                        verificationInputs[index + 1].focus()
                    }
                } else if (e.key === "Backspace") {
                    if (index > 0) {
                        verificationInputs[index - 1].focus()
                    }
                }
            })

            input.addEventListener("click", function() {
                this.select()
            })
        })

        // Focus first input on page load
        verificationInputs[0].focus()
    }
})