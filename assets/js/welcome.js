document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const exploreBtn = document.querySelector(".explore-btn")
    const orderNowBtns = document.querySelectorAll(".order-now-btn")
    const productCards = document.querySelectorAll(".product-card")
    const categoryItems = document.querySelectorAll(".category-item")
    const loginRedirectModal = document.getElementById("loginRedirectModal")
    const closeModalBtn = document.querySelector(".close-modal")
    const toastContainer = document.getElementById("toastContainer")
    const favoriteButtons = document.querySelectorAll(".favorite-btn")
    const orderButtons = document.querySelectorAll(".order-btn")
    const searchInput = document.getElementById("productSearch")

    // Check if user is logged in
    const isLoggedIn = checkUserLoggedIn()

    // Add event listeners to all interactive elements
    if (exploreBtn) {
        exploreBtn.addEventListener("click", handleInteraction)
    }

    orderNowBtns.forEach((btn) => {
        btn.addEventListener("click", handleInteraction)
    })

    productCards.forEach((card) => {
        card.addEventListener("click", handleInteraction)
    })

    categoryItems.forEach((item) => {
        item.addEventListener("click", handleInteraction)
    })

    favoriteButtons.forEach((button) => {
        button.addEventListener("click", handleInteraction)
    })

    orderButtons.forEach((button) => {
        button.addEventListener("click", handleInteraction)
    })

    // Close modal
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", () => {
            loginRedirectModal.classList.remove("active")
        })
    }

    // Handle click on overlay
    if (loginRedirectModal) {
        loginRedirectModal.addEventListener("click", (e) => {
            if (e.target === loginRedirectModal) {
                loginRedirectModal.classList.remove("active")
            }
        })
    }

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener("input", function() {
            const searchTerm = this.value.toLowerCase().trim()
            let visibleCount = 0

            productCards.forEach((card) => {
                const productName = card.querySelector("h4").textContent.toLowerCase()
                const productDescription = card.querySelector(".description").textContent.toLowerCase()

                if (productName.includes(searchTerm) || productDescription.includes(searchTerm)) {
                    card.style.display = "block"
                    visibleCount++
                } else {
                    card.style.display = "none"
                }
            })

            // Show/hide no products message
            const noProductMessage = document.getElementById("no-product-message")
            if (noProductMessage) {
                if (visibleCount === 0) {
                    noProductMessage.style.display = "block"
                } else {
                    noProductMessage.style.display = "none"
                }
            }
        })
    }

    // Function to handle all interactive elements
    function handleInteraction(e) {
        e.preventDefault()
        e.stopPropagation()

        if (isLoggedIn) {
            // If logged in, redirect to order page
            window.location.href = "/order"
        } else {
            // If not logged in, show login redirect modal
            showLoginRedirectModal()
        }
    }

    // Function to show login redirect modal
    function showLoginRedirectModal() {
        if (loginRedirectModal) {
            loginRedirectModal.classList.add("active")
        }
    }

    // Function to check if user is logged in
    function checkUserLoggedIn() {
        // In a real app, you would check session or token
        // For now, we'll just return false to always show the login modal
        return false
    }

    // Add CSS for welcome page
    const style = document.createElement("style")
    style.textContent = `
          /* Hero Section */
          .hero-section {
              display: flex;
              align-items: center;
              justify-content: space-between;
              padding: 40px 0;
              gap: 40px;
              margin-bottom: 30px;
          }
          
          .hero-content {
              flex: 1;
          }
          
          .hero-content h1 {
              font-size: 2.5rem;
              margin-bottom: 20px;
              color: #333;
          }
          
          .brand-name {
              color: #ff5e62;
          }
          
          .hero-content p {
              font-size: 1.2rem;
              margin-bottom: 30px;
              color: #666;
              line-height: 1.6;
          }
          
          .hero-buttons {
              display: flex;
              gap: 15px;
          }
          
          .hero-image {
              flex: 1;
              text-align: center;
          }
          
          .hero-image img {
              max-width: 100%;
              height: auto;
              border-radius: 10px;
              box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
          }
          
          /* Login Redirect Modal */
          .modal-overlay {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.5);
              display: flex;
              align-items: center;
              justify-content: center;
              z-index: 1000;
              opacity: 0;
              visibility: hidden;
              transition: all 0.3s ease;
          }
          
          .modal-overlay.active {
              opacity: 1;
              visibility: visible;
          }
          
          .modal-container {
              background-color: white;
              border-radius: 10px;
              width: 90%;
              max-width: 500px;
              box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
              overflow: hidden;
              transform: scale(0.9);
              transition: transform 0.3s ease;
          }
          
          .modal-overlay.active .modal-container {
              transform: scale(1);
          }
          
          .modal-header {
              display: flex;
              justify-content: space-between;
              align-items: center;
              padding: 20px;
              border-bottom: 1px solid #eee;
          }
          
          .modal-header h3 {
              margin: 0;
              color: #333;
          }
          
          .close-modal {
              background: none;
              border: none;
              font-size: 20px;
              cursor: pointer;
              color: #999;
          }
          
          .modal-body {
              padding: 30px;
          }
          
          .login-redirect-content {
              text-align: center;
          }
          
          .login-redirect-content i {
              font-size: 60px;
              color: #ff5e62;
              margin-bottom: 20px;
          }
          
          .login-redirect-content p {
              font-size: 18px;
              color: #666;
              margin-bottom: 30px;
          }
          
          .login-redirect-buttons {
              display: flex;
              gap: 15px;
              justify-content: center;
          }
          
          .login-redirect-buttons a {
              flex: 1;
              text-align: center;
              text-decoration: none;
              padding: 12px 0;
              border-radius: 5px;
              font-weight: 600;
              transition: all 0.3s ease;
          }
          
          .btn-primary {
              background-color: #ff5e62;
              color: white;
              border: none;
              padding: 12px 25px;
              border-radius: 5px;
              font-weight: 600;
              cursor: pointer;
              transition: all 0.3s ease;
          }
          
          .btn-primary:hover {
              background-color: #ff4146;
              transform: translateY(-2px);
              box-shadow: 0 5px 15px rgba(255, 94, 98, 0.3);
          }
          
          .btn-outline {
              background-color: transparent;
              color: #ff5e62;
              border: 2px solid #ff5e62;
              padding: 12px 25px;
              border-radius: 5px;
              font-weight: 600;
              cursor: pointer;
              transition: all 0.3s ease;
          }
          
          .btn-outline:hover {
              background-color: #ff5e62;
              color: white;
              transform: translateY(-2px);
              box-shadow: 0 5px 15px rgba(255, 94, 98, 0.3);
          }
      `
    document.head.appendChild(style)
})