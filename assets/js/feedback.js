document.addEventListener("DOMContentLoaded", () => {
    // Tab switching functionality
    const tabs = document.querySelectorAll(".feedback-tab")
    const tabContents = document.querySelectorAll(".feedback-content")

    tabs.forEach((tab) => {
        tab.addEventListener("click", function() {
            // Remove active class from all tabs and contents
            tabs.forEach((t) => t.classList.remove("active"))
            tabContents.forEach((c) => c.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            // Show corresponding content
            const tabName = this.getAttribute("data-tab")
            document.getElementById(`${tabName}-tab`).classList.add("active")
        })
    })

    // Rating stars functionality
    const ratingStars = document.querySelectorAll(".rating-stars i")
    const ratingInput = document.querySelector('input[name="rating"]')

    ratingStars.forEach((star) => {
        star.addEventListener("click", function() {
            const rating = Number.parseInt(this.getAttribute("data-rating"))

            // Update hidden input value
            if (ratingInput) {
                ratingInput.value = rating
            }

            // Update stars display
            ratingStars.forEach((s) => {
                const starRating = Number.parseInt(s.getAttribute("data-rating"))

                if (starRating <= rating) {
                    s.classList.remove("far")
                    s.classList.add("fas")
                    s.classList.add("active")
                } else {
                    s.classList.remove("fas")
                    s.classList.add("far")
                    s.classList.remove("active")
                }
            })
        })
    })

    // Show/hide product select based on review type
    const reviewTypeSelect = document.querySelector('select[name="review_type"]')
    const productSelect = document.querySelector(".product-select")

    if (reviewTypeSelect && productSelect) {
        reviewTypeSelect.addEventListener("change", function() {
            if (this.value === "product") {
                productSelect.style.display = "block"
            } else {
                productSelect.style.display = "none"
            }
        })
    }

    // Show/hide order select based on issue type
    const issueTypeSelect = document.querySelector('select[name="issue_type"]')
    const orderSelect = document.querySelector(".order-select")

    if (issueTypeSelect && orderSelect) {
        issueTypeSelect.addEventListener("change", function() {
            if (this.value === "order") {
                orderSelect.style.display = "block"
            } else {
                orderSelect.style.display = "none"
            }
        })
    }

    // Photo upload preview
    const photoInputs = document.querySelectorAll('input[type="file"]')

    photoInputs.forEach((input) => {
        input.addEventListener("change", function() {
            const previewContainer = this.parentElement.querySelector(".photo-preview")

            if (previewContainer) {
                previewContainer.innerHTML = ""

                if (this.files) {
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i]

                        if (file.type.startsWith("image/")) {
                            const reader = new FileReader()

                            reader.onload = (e) => {
                                const img = document.createElement("img")
                                img.src = e.target.result
                                previewContainer.appendChild(img)
                            }

                            reader.readAsDataURL(file)
                        }
                    }
                }
            }
        })
    })

    // Form submission handling
    const forms = document.querySelectorAll("form")

    forms.forEach((form) => {
        form.addEventListener("submit", function(e) {
            e.preventDefault()

            // Get form ID to determine which form was submitted
            const formId = this.id
            let successMessage = ""

            switch (formId) {
                case "reviewForm":
                    successMessage = "Thank you for your review! Your feedback helps us improve."
                    break
                case "suggestionForm":
                    successMessage = "Thank you for your suggestion! We appreciate your input."
                    break
                case "reportForm":
                    successMessage = "Thank you for reporting this issue. We'll look into it right away."
                    break
                default:
                    successMessage = "Thank you for your feedback!"
            }

            // Show success message
            showToast("Feedback Submitted", successMessage, "/assets/images/logo/logo-small.png")

            // Reset form
            this.reset()

            // Reset rating stars if present
            if (formId === "reviewForm") {
                ratingStars.forEach((s) => {
                    s.classList.remove("fas")
                    s.classList.remove("active")
                    s.classList.add("far")
                })

                if (ratingInput) {
                    ratingInput.value = "0"
                }
            }

            // Clear photo previews
            const previewContainers = this.querySelectorAll(".photo-preview")
            previewContainers.forEach((container) => {
                container.innerHTML = ""
            })
        })
    })

    // Function to show toast notification
    function showToast(title, message, image) {
        const toast = document.getElementById("toastNotification")
        const toastTitle = document.getElementById("toastTitle")
        const toastMessage = document.getElementById("toastMessage")
        const toastImage = document.getElementById("toastImage")

        if (toast && toastTitle && toastMessage && toastImage) {
            toastTitle.textContent = title
            toastMessage.textContent = message
            toastImage.src = image

            toast.classList.add("active")

            setTimeout(() => {
                toast.classList.remove("active")
            }, 5000)
        }
    }
})