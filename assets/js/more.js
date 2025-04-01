document.addEventListener("DOMContentLoaded", () => {
    // Option card hover effects
    const optionCards = document.querySelectorAll(".option-card")
    optionCards.forEach((card) => {
        card.addEventListener("mouseenter", function() {
            const icon = this.querySelector(".option-icon i")
            if (icon) {
                icon.classList.add("fa-bounce")
            }
        })

        card.addEventListener("mouseleave", function() {
            const icon = this.querySelector(".option-icon i")
            if (icon) {
                icon.classList.remove("fa-bounce")
            }
        })
    })

    // Social media links tracking
    const socialLinks = document.querySelectorAll(".social-item")
    socialLinks.forEach((link) => {
        link.addEventListener("click", function(e) {
            // This would typically send analytics data
            const platform = this.querySelector("span").textContent
            console.log("Social media click:", platform)
        })
    })
})