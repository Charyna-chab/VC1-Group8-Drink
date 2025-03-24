document.addEventListener("DOMContentLoaded", () => {
    // Application button functionality
    const applyButtons = document.querySelectorAll(".btn-apply")
  
    applyButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault()
  
        const positionCard = this.closest(".position-card")
        const positionTitle = positionCard.querySelector("h3").textContent
        const positionLocation = positionCard.querySelector(".position-location").textContent.replace("📍", "").trim()
  
        // Redirect to application form with position details
        window.location.href = `/apply?position=${encodeURIComponent(positionTitle)}&location=${encodeURIComponent(positionLocation)}`
      })
    })
  
    // Animate the process steps on scroll
    const processSteps = document.querySelectorAll(".step")
  
    function checkScroll() {
      processSteps.forEach((step) => {
        const stepTop = step.getBoundingClientRect().top
        const windowHeight = window.innerHeight
  
        if (stepTop < windowHeight * 0.8) {
          step.classList.add("visible")
        }
      })
    }
  
    // Initial check
    checkScroll()
  
    // Check on scroll
    window.addEventListener("scroll", checkScroll)
  })
  
  