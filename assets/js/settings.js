document.addEventListener('DOMContentLoaded', function() {
    // Settings tab navigation
    const tabLinks = document.querySelectorAll('.settings-nav li');
    const tabContents = document.querySelectorAll('.settings-tab');

    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove active class from all tabs
            tabLinks.forEach(item => item.classList.remove('active'));
            tabContents.forEach(item => item.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Show corresponding content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });

    // Font size range slider
    const fontSizeSlider = document.getElementById('font_size');
    const fontSizeValue = document.querySelector('.range-value');

    if (fontSizeSlider) {
        fontSizeSlider.addEventListener('input', function() {
            fontSizeValue.textContent = `${this.value}px`;
        });
    }

    // Delete account confirmation
    const deleteAccountBtn = document.getElementById('deleteAccountBtn');

    if (deleteAccountBtn) {
        deleteAccountBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                // Handle account deletion
                alert('Account deletion request submitted.');
            }
        });
    }
});