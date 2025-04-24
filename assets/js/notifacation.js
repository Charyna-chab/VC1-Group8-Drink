// Notification System for Xing Fu Cha
document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const notificationPanel = document.getElementById("notificationPanel")
  const notificationList = document.getElementById("notificationList")
  const notificationButtons = document.querySelectorAll(".notification-btn")
  const notificationBadge = document.querySelector(".notification-badge")
  const closeNotificationBtn = document.querySelector(".notification-panel .close-btn")
  const overlay = document.getElementById("overlay")

  // Initialize notifications from localStorage
  let notifications = JSON.parse(localStorage.getItem("notifications")) || []

  // Initialize notification count
  updateNotificationCount()

  // Setup event listeners
  setupEventListeners()

  function setupEventListeners() {
    // Open notification panel
    notificationButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        e.preventDefault()
        e.stopPropagation()

        // Close any other open panels
        closeAllPanels()

        // Show notification panel
        if (notificationPanel) {
          notificationPanel.classList.add("active")
          if (overlay) {
            overlay.style.display = "block"
          }
        }

        // Render notifications
        renderNotifications()
      })
    })

    // Close notification panel
    if (closeNotificationBtn) {
      closeNotificationBtn.addEventListener("click", closeAllPanels)
    }

    // Close when clicking overlay
    if (overlay) {
      overlay.addEventListener("click", closeAllPanels)
    }
  }

  function closeAllPanels() {
    // Close notification panel
    if (notificationPanel && notificationPanel.classList.contains("active")) {
      notificationPanel.classList.remove("active")
    }

    // Close order panel
    const orderPanel = document.getElementById("orderPanel")
    if (orderPanel && orderPanel.classList.contains("active")) {
      orderPanel.classList.remove("active")
    }

    // Close cart panel
    const cartPanel = document.getElementById("cartPanel")
    if (cartPanel && cartPanel.classList.contains("active")) {
      cartPanel.classList.remove("active")
    }

    // Hide overlay
    if (overlay) {
      overlay.classList.remove("active")
      overlay.style.display = "none"
    }

    // Remove any confirmation cards
    const confirmationCards = document.querySelectorAll(".order-confirmation-card")
    confirmationCards.forEach((card) => card.remove())
  }

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

    // Sort notifications by date (newest first)
    notifications.sort((a, b) => new Date(b.date) - new Date(a.date))

    // Render notifications
    notificationList.innerHTML = ""
    notifications.forEach((notification, index) => {
      const notificationItem = document.createElement("div")
      notificationItem.className = "notification-item"
      if (notification.type) {
        notificationItem.classList.add(notification.type)
      }
      if (!notification.read) {
        notificationItem.classList.add("unread")
      }

      // Format time
      const notificationDate = new Date(notification.date)
      const timeAgo = getTimeAgo(notificationDate)

      // Choose icon based on type
      let icon = "bell"
      if (notification.type === "success" || notification.type === "order") icon = "check-circle"
      else if (notification.type === "error") icon = "exclamation-circle"
      else if (notification.type === "cart") icon = "shopping-cart"
      else if (notification.type === "promotion") icon = "gift"

      notificationItem.innerHTML = `
        <div class="notification-icon">
          <i class="fas fa-${icon}"></i>
        </div>
        <div class="notification-content">
          <h4>${notification.title}</h4>
          <p>${notification.message}</p>
          <span class="notification-time">${timeAgo}</span>
        </div>
        <button class="notification-close" data-index="${index}">&times;</button>
      `

      notificationList.appendChild(notificationItem)
    })

    // Add event listeners to close buttons
    const closeNotificationButtons = notificationList.querySelectorAll(".notification-close")
    closeNotificationButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const index = Number.parseInt(this.getAttribute("data-index"))
        removeNotification(index)
      })
    })

    // Mark all as read
    markNotificationsAsRead()
  }

  function addNotification(title, message, type = "info") {
    // Create notification
    const notification = {
      id: Date.now().toString(),
      title,
      message,
      type,
      date: new Date().toISOString(),
      read: false,
    }

    // Add to notifications array
    notifications.unshift(notification)

    // Limit to 20 notifications
    if (notifications.length > 20) {
      notifications = notifications.slice(0, 20)
    }

    // Save to localStorage
    localStorage.setItem("notifications", JSON.stringify(notifications))

    // Update notification count
    updateNotificationCount()

    // Show notification badge animation
    if (notificationBadge) {
      notificationBadge.classList.add("pulse")
      setTimeout(() => {
        notificationBadge.classList.remove("pulse")
      }, 1000)
    }

    // Render if panel is open
    if (notificationPanel && notificationPanel.classList.contains("active")) {
      renderNotifications()
    }

    // Show toast notification
    showToast(title, message, type)

    return notification
  }

  function removeNotification(index) {
    // Remove notification
    notifications.splice(index, 1)

    // Save to localStorage
    localStorage.setItem("notifications", JSON.stringify(notifications))

    // Update notification count
    updateNotificationCount()

    // Re-render notifications
    renderNotifications()
  }

  function markNotificationsAsRead() {
    notifications = notifications.map((notification) => ({
      ...notification,
      read: true,
    }))

    // Save to localStorage
    localStorage.setItem("notifications", JSON.stringify(notifications))

    // Update notification count
    updateNotificationCount()
  }

  function updateNotificationCount() {
    const unreadCount = notifications.filter((notification) => !notification.read).length

    // Update badge
    if (notificationBadge) {
      notificationBadge.textContent = unreadCount
      notificationBadge.style.display = unreadCount > 0 ? "flex" : "none"
    }

    // Update sidebar notification count
    const sidebarNotificationCount = document.querySelector(".sidebar-nav .notification-count")
    if (sidebarNotificationCount) {
      sidebarNotificationCount.textContent = unreadCount
      sidebarNotificationCount.style.display = unreadCount > 0 ? "block" : "none"
    }
  }

  function getTimeAgo(date) {
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
    let borderColor = "#2196f3"

    if (type === "success" || type === "order" || type === "booking") {
      icon = "check-circle"
      borderColor = "#4caf50"
      toast.classList.add("success")
    } else if (type === "error") {
      icon = "exclamation-circle"
      borderColor = "#f44336"
      toast.classList.add("error")
    } else if (type === "cart") {
      icon = "shopping-cart"
      borderColor = "#ff9800"
      toast.classList.add("cart")
    } else if (type === "promotion") {
      icon = "gift"
      borderColor = "#9c27b0"
      toast.classList.add("promotion")
    }

    toast.style.borderLeftColor = borderColor

    toast.innerHTML = `
      <div>
        <i class="fas fa-${icon}" style="color: ${borderColor}; font-size: 20px; margin-right: 10px;"></i>
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
    
    .notification-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-bottom: 1px solid #eee;
    }
    
    .notification-panel h3 {
      margin: 0;
      font-size: 1.2rem;
      color: #333;
    }
    
    .notification-panel .close-btn {
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
    
    .notification-close {
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
    
    .notification-item:hover .notification-close {
      opacity: 1;
    }
    
    .notification-close:hover {
      color: #f44336;
    }
    
    /* Toast Container */
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    
    .toast {
      display: flex;
      align-items: center;
      background-color: white;
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 12px 15px;
      min-width: 300px;
      max-width: 400px;
      border-left: 4px solid #2196f3;
      margin-bottom: 10px;
      animation: slideIn 0.3s ease;
      transition: opacity 0.3s ease;
    }
    
    .toast.success {
      border-left-color: #4caf50;
    }
    
    .toast.error {
      border-left-color: #f44336;
    }
    
    .toast.cart {
      border-left-color: #ff9800;
    }
    
    .toast.promotion {
      border-left-color: #9c27b0;
    }
    
    .toast h4 {
      margin: 0 0 5px;
      font-size: 16px;
      font-weight: 600;
    }
    
    .toast p {
      margin: 0;
      font-size: 14px;
      color: #666;
    }
    
    .toast-close {
      background: none;
      border: none;
      font-size: 18px;
      color: #999;
      cursor: pointer;
      margin-left: 10px;
    }
    
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
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
    
    /* Notification Badge */
    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: #ff5e62;
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }
  `
  document.head.appendChild(style)

  // Make addNotification available globally
  window.addNotification = addNotification

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
