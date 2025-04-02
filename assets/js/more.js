document.addEventListener("DOMContentLoaded", () => {
    // Option card hover effects
    const optionCards = document.querySelectorAll(".option-card")
  
    optionCards.forEach((card) => {
      card.addEventListener("mouseenter", function () {
        this.classList.add("hover")
      })
  
      card.addEventListener("mouseleave", function () {
        this.classList.remove("hover")
      })
    })
  
    // Add click animation
    optionCards.forEach((card) => {
      card.addEventListener("click", function () {
        this.classList.add("clicked")
  
        // Remove the class after animation completes
        setTimeout(() => {
          this.classList.remove("clicked")
        }, 300)
      })
    })
  })
  
  
