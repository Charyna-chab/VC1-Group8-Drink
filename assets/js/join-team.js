document.addEventListener("DOMContentLoaded", () => {
    // Testimonials slider
    initTestimonialsSlider()

    // Apply button functionality
    const applyButtons = document.querySelectorAll(".btn-apply")
    applyButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            // This is handled by the href attribute, but we can add analytics here
            const positionTitle = this.closest(".position-card").querySelector("h3").textContent
            console.log("Applying for position:", positionTitle)
        })
    })

    // Helper functions
    function initTestimonialsSlider() {
        const slider = document.querySelector(".testimonials-slider")
        if (!slider) return

        // If we have multiple testimonials, set up a simple auto-rotation
        const testimonials = slider.querySelectorAll(".testimonial-item")
        if (testimonials.length <= 1) return

        // Hide all testimonials except the first one
        testimonials.forEach((testimonial, index) => {
            if (index > 0) {
                testimonial.style.display = "none"
            }
        })

        // Create navigation dots
        const dotsContainer = document.createElement("div")
        dotsContainer.className = "slider-dots"

        testimonials.forEach((_, index) => {
            const dot = document.createElement("button")
            dot.className = "slider-dot"
            if (index === 0) {
                dot.classList.add("active")
            }

            dot.addEventListener("click", () => {
                showTestimonial(index)
            })

            dotsContainer.appendChild(dot)
        })

        slider.appendChild(dotsContainer)

        // Auto-rotate testimonials every 5 seconds
        let currentIndex = 0
        setInterval(() => {
            currentIndex = (currentIndex + 1) % testimonials.length
            showTestimonial(currentIndex)
        }, 5000)

        function showTestimonial(index) {
            // Hide all testimonials
            testimonials.forEach((testimonial) => {
                testimonial.style.display = "none"
            })

            // Show the selected testimonial
            testimonials[index].style.display = "flex"

            // Update active dot
            const dots = dotsContainer.querySelectorAll(".slider-dot")
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.add("active")
                } else {
                    dot.classList.remove("active")
                }
            })
        }
    }
})
