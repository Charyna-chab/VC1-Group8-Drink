document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');

    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.parentElement.querySelector('input');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });

    // Form validation
    const authForms = document.querySelectorAll('.auth-form');

    authForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const passwordInput = form.querySelector('input[name="password"]');
            const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');

            // If this is a registration form with password confirmation
            if (passwordInput && confirmPasswordInput) {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    event.preventDefault();

                    // Create or update error message
                    let errorDiv = form.parentElement.querySelector('.auth-error');

                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'auth-error';
                        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i><span></span>';
                        form.parentElement.insertBefore(errorDiv, form);
                    }

                    errorDiv.querySelector('span').textContent = 'Passwords do not match';

                    // Scroll to error
                    errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });

    // Social login buttons (placeholder functionality)
    const socialButtons = document.querySelectorAll('.social-button');

    socialButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Social login is not implemented in this demo.');
        });
    });
});
// verification.js
document.addEventListener('DOMContentLoaded', function() {
    const verificationInput = document.getElementById('verification_code');

    if (verificationInput) {
        // Auto focus on verification code input
        verificationInput.focus();

        // Format verification code input to only accept numbers
        verificationInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto-submit when 6 digits are entered
            if (this.value.length === 6) {
                document.querySelector('.auth-form').submit();
            }
        });

        // Add countdown timer for code expiration
        const timerElement = document.getElementById('verification-timer');
        if (timerElement) {
            let timeLeft = 600; // 10 minutes in seconds

            const updateTimer = function() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timerElement.textContent = 'Expired';
                    timerElement.classList.add('text-danger');
                }

                timeLeft--;
            };

            updateTimer();
            const timerInterval = setInterval(updateTimer, 1000);
        }
    }
});