document.addEventListener("DOMContentLoaded", () => {
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById("sidebarToggle")
    const sidebar = document.querySelector(".admin-sidebar")
  
    if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener("click", () => {
        sidebar.classList.toggle("open")
      })
    }
  
    // Tab functionality
    const tabButtons = document.querySelectorAll(".tab-btn")
    const tabContents = document.querySelectorAll(".tab-content")
  
    if (tabButtons.length && tabContents.length) {
      tabButtons.forEach((button) => {
        button.addEventListener("click", function () {
          // Remove active class from all buttons and contents
          tabButtons.forEach((btn) => btn.classList.remove("active"))
          tabContents.forEach((content) => content.classList.remove("active"))
  
          // Add active class to clicked button
          this.classList.add("active")
  
          // Show corresponding content
          const tabId = this.getAttribute("data-tab")
          document.getElementById(tabId).classList.add("active")
        })
      })
    }
  })
  
  