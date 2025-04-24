// utils.js
// Utility functions for redirects and notifications

// Show a notification with redirect option
function showRedirectNotification(title, message, redirectUrl, delay = 3000) {
    const notification = document.createElement("div");
    notification.className = "order-success-notification left-notification";
    notification.innerHTML = `
        <div class="notification-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="notification-text">
                <h4>${title}</h4>
                <p>${message}</p>
            </div>
            <button class="close-notification">×</button>
        </div>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add("fade-out");
        setTimeout(() => {
            notification.remove();
            window.location.href = redirectUrl;
        }, 500);
    }, delay);

    notification.querySelector(".close-notification").addEventListener("click", () => {
        notification.remove();
        window.location.href = redirectUrl;
    });
}

// Format price to 2 decimal places
function formatPrice(price) {
    return `$${parseFloat(price).toFixed(2)}`;
}

// Generate unique ID
function generateId(prefix) {
    return `${prefix}${Date.now().toString().slice(-6)}`;
}