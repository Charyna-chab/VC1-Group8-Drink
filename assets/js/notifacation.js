// notification.js - Handles notification system
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const notificationBtn = document.getElementById("notificationBtn")
    const notificationPanel = document.getElementById("notificationPanel")
    const notificationList = document.getElementById("notificationList")
    const notificationBadge = document.getElementById("notificationBadge")
    const closeNotificationBtn = document.querySelector(".notification-panel .close-btn")
    const overlay = document.getElementById("overlay")

    console.log("Notification elements:", {
        notificationBtn: !!notificationBtn,
        notificationPanel: !!notificationPanel,
        notificationList: !!notificationList,
        notificationBadge: !!notificationBadge,
        closeNotificationBtn: !!closeNotificationBtn,
        overlay: !!overlay,
    })

    // Notification data
    let notifications = JSON.parse(localStorage.getItem("notifications")) || []

    // Initialize notification count
    updateNotificationCount()

    // Open notification panel
    if (notificationBtn && notificationPanel) {
        notificationBtn.addEventListener("click", (e) => {
            e.preventDefault()
            e.stopPropagation()

            notificationPanel.classList.toggle("active")

            // Toggle overlay
            if (overlay) {
                if (notificationPanel.classList.contains("active")) {
                    overlay.classList.add("active")
                } else {
                    overlay.classList.remove("active")
                }
            }

            // Mark notifications as read
            if (notificationPanel.classList.contains("active")) {
                markNotificationsAsRead()
            }

            // Render notifications
            renderNotifications()
        })
    }

    // Close notification panel
    if (closeNotificationBtn && notificationPanel) {
        closeNotificationBtn.addEventListener("click", () => {
            notificationPanel.classList.remove("active")
            if (overlay) overlay.classList.remove("active")
        })
    }

    // Close notification panel when clicking on overlay
    if (overlay && notificationPanel) {
        overlay.addEventListener("click", () => {
            notificationPanel.classList.remove("active")
            overlay.classList.remove("active")
        })
    }

    // Update notification count
    function updateNotificationCount() {
        if (!notificationBadge) return

        const unreadCount = notifications.filter((notification) => !notification.read).length

        notificationBadge.textContent = unreadCount

        if (unreadCount > 0) {
            notificationBadge.style.display = "flex"
        } else {
            notificationBadge.style.display = "none"
        }
    }

    // Mark all notifications as read
    function markNotificationsAsRead() {
        notifications = notifications.map((notification) => ({
            ...notification,
            read: true,
        }))

        // Save to localStorage
        localStorage.setItem("notifications", JSON.stringify(notifications))

        // Update UI
        updateNotificationCount()
    }

    // Render notifications
    function renderNotifications() {
        if (!notificationList) return

        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="empty-notification">
                    <i class="fas fa-bell-slash"></i>
                    <p>No notifications yet</p>
                </div>
            `
            return
        }

        notificationList.innerHTML = ""

        // Sort notifications by date (newest first)
        const sortedNotifications = [...notifications].sort((a, b) => new Date(b.date) - new Date(a.date))

        sortedNotifications.forEach((notification) => {
            const notificationItem = document.createElement("div")
            notificationItem.className = `notification-item ${notification.read ? "" : "unread"}`

            // Format date
            const date = new Date(notification.date)
            const formattedDate = formatDate(date)

            notificationItem.innerHTML = `
                <div class="notification-icon ${notification.type}">
                    <i class="fas fa-${getIconForType(notification.type)}"></i>
                </div>
                <div class="notification-content">
                    <h4>${notification.title}</h4>
                    <p>${notification.message}</p>
                    <div class="notification-time">${formattedDate}</div>
                </div>
                <button class="delete-notification" data-id="${notification.id}">
                    <i class="fas fa-times"></i>
                </button>
            `

            notificationList.appendChild(notificationItem)
        })

        // Add event listeners to delete buttons
        const deleteButtons = document.querySelectorAll(".delete-notification")
        deleteButtons.forEach((button) => {
            button.addEventListener("click", function(e) {
                e.stopPropagation()
                const id = this.getAttribute("data-id")
                deleteNotification(id)
            })
        })
    }

    // Delete notification
    function deleteNotification(id) {
        notifications = notifications.filter((notification) => notification.id !== id)

        // Save to localStorage
        localStorage.setItem("notifications", JSON.stringify(notifications))

        // Update UI
        renderNotifications()
        updateNotificationCount()
    }

    // Get icon for notification type
    function getIconForType(type) {
        switch (type) {
            case "order":
                return "shopping-bag"
            case "cart":
                return "shopping-cart"
            case "booking":
                return "calendar-check"
            case "payment":
                return "credit-card"
            case "delivery":
                return "truck"
            case "promotion":
                return "gift"
            default:
                return "bell"
        }
    }

    // Format date
    function formatDate(date) {
        const now = new Date()
        const diff = now - date

        // Less than a minute
        if (diff < 60 * 1000) {
            return "Just now"
        }

        // Less than an hour
        if (diff < 60 * 60 * 1000) {
            const minutes = Math.floor(diff / (60 * 1000))
            return `${minutes} minute${minutes > 1 ? "s" : ""} ago`
        }

        // Less than a day
        if (diff < 24 * 60 * 60 * 1000) {
            const hours = Math.floor(diff / (60 * 60 * 1000))
            return `${hours} hour${hours > 1 ? "s" : ""} ago`
        }

        // Less than a week
        if (diff < 7 * 24 * 60 * 60 * 1000) {
            const days = Math.floor(diff / (24 * 60 * 60 * 1000))
            return `${days} day${days > 1 ? "s" : ""} ago`
        }

        // Format date
        const options = { year: "numeric", month: "short", day: "numeric" }
        return date.toLocaleDateString(undefined, options)
    }

    // Add notification
    const addNotification = (title, message, type = "info") => {
        const notification = {
            id: Date.now().toString(),
            title,
            message,
            type,
            date: new Date().toISOString(),
            read: false,
        }

        notifications.unshift(notification)

        // Limit to 20 notifications
        if (notifications.length > 20) {
            notifications = notifications.slice(0, 20)
        }

        // Save to localStorage
        localStorage.setItem("notifications", JSON.stringify(notifications))

        // Update UI
        updateNotificationCount()

        // Show notification badge animation
        if (notificationBadge) {
            notificationBadge.classList.add("pulse")
            setTimeout(() => {
                notificationBadge.classList.remove("pulse")
            }, 1000)
        }

        // Show toast notification
        showToast(title, message, type)

        return notification
    }

    // Show toast notification
    function showToast(title, message, type = "info") {
        // Create toast container if it doesn't exist
        let toastContainer = document.getElementById("toastContainer")
        if (!toastContainer) {
            toastContainer = document.createElement("div")
            toastContainer.id = "toastContainer"
            toastContainer.className = "toast-container"
            document.body.appendChild(toastContainer)
        }

        const toast = document.createElement("div")
        toast.className = "toast"

        let icon = "info-circle"
        if (type === "success" || type === "order" || type === "booking") {
            icon = "check-circle"
            toast.style.borderLeftColor = "#4caf50"
        } else if (type === "error") {
            icon = "exclamation-circle"
            toast.style.borderLeftColor = "#f44336"
        } else if (type === "cart") {
            icon = "shopping-cart"
            toast.style.borderLeftColor = "#ff9800"
        } else if (type === "promotion") {
            icon = "gift"
            toast.style.borderLeftColor = "#9c27b0"
        }

        toast.innerHTML = `
            <div>
                <i class="fas fa-${icon}" style="color: ${type === "success" || type === "order" || type === "booking" ? "#4caf50" : type === "error" ? "#f44336" : type === "cart" ? "#ff9800" : type === "promotion" ? "#9c27b0" : "#ff5e62"}; font-size: 20px; margin-right: 10px;"></i>
            </div>
            <div style="flex: 1;">
                <h4>${title}</h4>
                <p>${message}</p>
            </div>
            <button class="toast-close">&times;</button>
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
            toast.style.opacity = "0"
            setTimeout(() => {
                toast.remove()
            }, 300)
        }, 5000)
    }

    // Add CSS for notifications
    const style = document.createElement("style")
    style.textContent = `
        .notification-panel {
            position: fixed;
            top: 0;
            right: -350px;
            width: 100%;
            max-width: 350px;
            height: 100vh;
            background-color: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .notification-panel.active {
            right: 0;
        }
        
        .notification-panel h3 {
            margin: 0;
            padding: 20px;
            border-bottom: 1px solid #eee;
            font-size: 1.2rem;
            color: #333;
        }
        
        .notification-panel .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #999;
        }
        
        .notification-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }
        
        .empty-notification {
            text-align: center;
            padding: 30px;
            color: #999;
        }
        
        .empty-notification i {
            font-size: 50px;
            margin-bottom: 10px;
            color: #ddd;
        }
        
        .notification-item {
            display: flex;
            padding: 15px;
            border-bottom: 1px solid #eee;
            position: relative;
            transition: background-color 0.3s ease;
        }
        
        .notification-item:hover {
            background-color: #f9f9f9;
        }
        
        .notification-item.unread {
            background-color: #f0f7ff;
        }
        
        .notification-item.unread:hover {
            background-color: #e5f1ff;
        }
        
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .notification-icon.order {
            background-color: #e8f5e9;
            color: #4caf50;
        }
        
        .notification-icon.cart {
            background-color: #fff3e0;
            color: #ff9800;
        }
        
        .notification-icon.booking {
            background-color: #e3f2fd;
            color: #2196f3;
        }
        
        .notification-icon.payment {
            background-color: #e8eaf6;
            color: #3f51b5;
        }
        
        .notification-icon.delivery {
            background-color: #fce4ec;
            color: #e91e63;
        }
        
        .notification-icon.promotion {
            background-color: #f3e5f5;
            color: #9c27b0;
        }
        
        .notification-icon.info {
            background-color: #e0f7fa;
            color: #00bcd4;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-content h4 {
            margin: 0 0 5px;
            font-size: 1rem;
            color: #333;
        }
        
        .notification-content p {
            margin: 0 0 5px;
            font-size: 0.9rem;
            color: #666;
            line-height: 1.4;
        }
        
        .notification-time {
            font-size: 0.8rem;
            color: #999;
        }
        
        .delete-notification {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #ccc;
            cursor: pointer;
            font-size: 0.8rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .notification-item:hover .delete-notification {
            opacity: 1;
        }
        
        .delete-notification:hover {
            color: #f44336;
        }
        
        /* Notification Badge Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 0.5s ease-in-out;
        }
        
        /* Toast Container */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
        }
        
        .toast {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            align-items: flex-start;
            border-left: 4px solid #ff5e62;
            animation: slideIn 0.3s ease forwards;
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .toast h4 {
            margin: 0 0 5px;
            font-size: 1rem;
            color: #333;
        }
        
        .toast p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
        }
        
        .toast-close {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #999;
            margin-left: 10px;
        }
    `
    document.head.appendChild(style)

    // Add some default notifications if none exist
    if (notifications.length === 0) {
        addNotification(
            "Welcome to Xing Fu Cha",
            "Thank you for visiting our drink ordering system. Enjoy our delicious bubble tea!",
            "info",
        )

        addNotification("Special Promotion", "Get 20% off on all drinks today with code BOBA20 at checkout!", "promotion")
    }
})