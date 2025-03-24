document.addEventListener("DOMContentLoaded", () => {
    // Price option selection
    const priceOptions = document.querySelectorAll(".price-option")
  
    priceOptions.forEach((option) => {
      option.addEventListener("click", function () {
        // Remove active class from siblings
        const siblings = this.parentElement.querySelectorAll(".price-option")
        siblings.forEach((sib) => sib.classList.remove("active"))
  
        // Add active class to clicked option
        this.classList.add("active")
      })
    })
  
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll(".add-to-cart")
  
    addToCartButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const cardItem = this.closest(".gift-card-item")
        const cardName = cardItem.querySelector("h3").textContent
        const selectedPrice = cardItem.querySelector(".price-option.active").getAttribute("data-value")
  
        // Show confirmation message
        alert(`Added ${cardName} ($${selectedPrice}) to cart!`)
  
        // Here you would normally add the item to the cart via AJAX
        // For now, just simulate the action
        const badge = document.getElementById("notificationBadge")
        badge.textContent = Number.parseInt(badge.textContent) + 1
      })
    })
  })
  
  