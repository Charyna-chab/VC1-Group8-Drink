// feedback.js - Handles feedback functionality
document.addEventListener("DOMContentLoaded", () => {
    // Feedback tab navigation
    const tabLinks = document.querySelectorAll(".feedback-tab")
    const tabContents = document.querySelectorAll(".feedback-content")

    tabLinks.forEach((link) => {
        link.addEventListener("click", function() {
            // Remove active class from all tabs
            tabLinks.forEach((item) => item.classList.remove("active"))
            tabContents.forEach((item) => item.classList.remove("active"))

            // Add active class to clicked tab
            this.classList.add("active")

            // Show corresponding content
            const tabId = this.getAttribute("data-tab")
            const contentToShow = document.getElementById(`${tabId}-tab`)

            if (contentToShow) {
                contentToShow.classList.add("active")
            } else {
                console.error(`Tab content with ID "${tabId}-tab" not found`)
            }
        })
    })

    // Star rating functionality
    const stars = document.querySelectorAll(".rating-stars i")
    const ratingInput = document.querySelector('input[name="rating"]')

    if (stars && ratingInput) {
        stars.forEach((star) => {
            star.addEventListener("click", function() {
                const rating = this.getAttribute("data-rating")
                ratingInput.value = rating

                // Update star display
                stars.forEach((s) => {
                    const sRating = s.getAttribute("data-rating")
                    if (sRating <= rating) {
                        s.classList.remove("far")
                        s.classList.add("fas")
                    } else {
                        s.classList.remove("fas")
                        s.classList.add("far")
                    }
                })
            })

            // Add hover effect
            star.addEventListener("mouseover", function() {
                const rating = this.getAttribute("data-rating")

                // Update star display on hover
                stars.forEach((s) => {
                    const sRating = s.getAttribute("data-rating")
                    if (sRating <= rating) {
                        s.classList.add("hover")
                    }
                })
            })

            star.addEventListener("mouseout", () => {
                stars.forEach((s) => {
                    s.classList.remove("hover")
                })
            })
        })
    }

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
                        if (file.type.match("image.*")) {
                            const reader = new FileReader()

                            reader.onload = (e) => {
                                const img = document.createElement("img")
                                img.src = e.target.result
                                img.className = "upload-preview-img"
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
    const reviewForm = document.getElementById("reviewForm")
    const suggestionForm = document.getElementById("suggestionForm")
    const reportForm = document.getElementById("reportForm")

    if (reviewForm) {
        reviewForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Validate form
            const reviewType = this.querySelector('select[name="review_type"]').value
            const rating = this.querySelector('input[name="rating"]').value
            const title = this.querySelector("#review_title").value
            const content = this.querySelector("#review_content").value

            if (!reviewType || rating < 1 || !title || !content) {
                showFormError(this, "Please fill in all required fields")
                return
            }

            // If review type is product, product_id is required
            if (reviewType === "product") {
                const productId = this.querySelector('select[name="product_id"]').value
                if (!productId) {
                    showFormError(this, "Please select a product")
                    return
                }
            }

            // Submit form via AJAX
            const formData = new FormData(this)

            fetch("/feedback/submitReview", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        showFormSuccess(this, data.message || "Review submitted successfully!")
                        this.reset()
                            // Reset stars
                        stars.forEach((s) => {
                                s.classList.remove("fas")
                                s.classList.add("far")
                            })
                            // Reset photo preview
                        const photoPreview = this.querySelector(".photo-preview")
                        if (photoPreview) {
                            photoPreview.innerHTML = ""
                        }
                    } else {
                        showFormError(this, data.message || "An error occurred. Please try again.")
                    }
                })
                .catch((error) => {
                    console.error("Error submitting review:", error)
                    showFormError(this, "An error occurred. Please try again.")
                })
        })
    }

    if (suggestionForm) {
        suggestionForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Validate form
            const suggestionType = this.querySelector('select[name="suggestion_type"]').value
            const title = this.querySelector("#suggestion_title").value
            const content = this.querySelector("#suggestion_content").value

            if (!suggestionType || !title || !content) {
                showFormError(this, "Please fill in all required fields")
                return
            }

            // Submit form via AJAX
            const formData = new FormData(this)

            fetch("/feedback/submitSuggestion", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        showFormSuccess(this, data.message || "Suggestion submitted successfully!")
                        this.reset()
                    } else {
                        showFormError(this, data.message || "An error occurred. Please try again.")
                    }
                })
                .catch((error) => {
                    console.error("Error submitting suggestion:", error)
                    showFormError(this, "An error occurred. Please try again.")
                })
        })
    }

    if (reportForm) {
        reportForm.addEventListener("submit", function(e) {
            e.preventDefault()

            // Validate form
            const issueType = this.querySelector('select[name="issue_type"]').value
            const title = this.querySelector("#issue_title").value
            const content = this.querySelector("#issue_content").value

            if (!issueType || !title || !content) {
                showFormError(this, "Please fill in all required fields")
                return
            }

            // If issue type is order, order_id is required
            if (issueType === "order") {
                const orderId = this.querySelector('select[name="order_id"]').value
                if (!orderId) {
                    showFormError(this, "Please select an order")
                    return
                }
            }

            // Submit form via AJAX
            const formData = new FormData(this)

            fetch("/feedback/submitReport", {
                    method: "POST",
                    body: formData,
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        showFormSuccess(this, data.message || "Report submitted successfully!")
                        this.reset()
                            // Reset photo preview
                        const photoPreview = this.querySelector(".photo-preview")
                        if (photoPreview) {
                            photoPreview.innerHTML = ""
                        }
                    } else {
                        showFormError(this, data.message || "An error occurred. Please try again.")
                    }
                })
                .catch((error) => {
                    console.error("Error submitting report:", error)
                    showFormError(this, "An error occurred. Please try again.")
                })
        })
    }

    // Show form error message
    function showFormError(form, message) {
        // Remove any existing messages
        const existingMessages = form.querySelectorAll(".form-message")
        existingMessages.forEach((msg) => msg.remove())

        // Create error message
        const errorMessage = document.createElement("div")
        errorMessage.className = "form-message error"
        errorMessage.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`

        // Insert at the top of the form
        form.insertBefore(errorMessage, form.firstChild)

        // Scroll to error message
        errorMessage.scrollIntoView({ behavior: "smooth", block: "start" })

        // Auto remove after 5 seconds
        setTimeout(() => {
            errorMessage.classList.add("fade-out")
            setTimeout(() => {
                errorMessage.remove()
            }, 300)
        }, 5000)
    }

    // Show form success message
    function showFormSuccess(form, message) {
        // Remove any existing messages
        const existingMessages = form.querySelectorAll(".form-message")
        existingMessages.forEach((msg) => msg.remove())

        // Create success message
        const successMessage = document.createElement("div")
        successMessage.className = "form-message success"
        successMessage.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`

        // Insert at the top of the form
        form.insertBefore(successMessage, form.firstChild)

        // Scroll to success message
        successMessage.scrollIntoView({ behavior: "smooth", block: "start" })

        // Auto remove after 5 seconds
        setTimeout(() => {
            successMessage.classList.add("fade-out")
            setTimeout(() => {
                successMessage.remove()
            }, 300)
        }, 5000)
    }

    // Add animation for tab switching
    function addTabSwitchAnimation() {
        const tabContents = document.querySelectorAll(".feedback-content")

        tabContents.forEach((content) => {
            content.addEventListener("transitionend", function(e) {
                if (e.propertyName === "opacity" && !this.classList.contains("active")) {
                    this.style.display = "none"
                }
            })
        })

        // Add CSS for animations
        const animationStyle = document.createElement("style")
        animationStyle.textContent = `
            .feedback-content {
                opacity: 0;
                transition: opacity 0.3s ease;
                display: none;
            }
            
            .feedback-content.active {
                opacity: 1;
                display: block;
            }
        `
        document.head.appendChild(animationStyle)
    }

    // Call the animation function
    addTabSwitchAnimation()

    // Add CSS for feedback forms
    const style = document.createElement("style")
    style.textContent = `
      /* Feedback Form Styles */
      .feedback-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
      }
      
      .feedback-tab {
        padding: 10px 20px;
        background-color: #f5f5f5;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        color: #666;
        transition: all 0.3s ease;
      }
      
      .feedback-tab:hover {
        background-color: #e5e5e5;
      }
      
      .feedback-tab.active {
        background-color: #ff5e62;
        color: white;
        box-shadow: 0 3px 8px rgba(255, 94, 98, 0.3);
      }
      
      .feedback-content {
        display: none;
      }
      
      .feedback-content.active {
        display: block;
      }
      
      .feedback-form {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 30px;
        margin-bottom: 30px;
      }
      
      .feedback-form h3 {
        margin: 0 0 10px;
        font-size: 22px;
        color: #333;
      }
      
      .feedback-form p {
        margin: 0 0 20px;
        font-size: 16px;
        color: #666;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 16px;
        font-weight: 500;
        color: #333;
      }
      
      .form-group select,
      .form-group input[type="text"],
      .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        color: #333;
        transition: all 0.3s ease;
      }
      
      .form-group select:focus,
      .form-group input[type="text"]:focus,
      .form-group textarea:focus {
        border-color: #ff5e62;
        box-shadow: 0 0 0 3px rgba(255, 94, 98, 0.1);
        outline: none;
      }
      
      .form-group textarea {
        min-height: 120px;
        resize: vertical;
      }
      
      .rating-stars {
        display: flex;
        gap: 5px;
        font-size: 24px;
        color: #ddd;
        margin-bottom: 10px;
      }
      
      .rating-stars i {
        cursor: pointer;
        transition: all 0.3s ease;
      }
      
      .rating-stars i.fas {
        color: #ffb400;
      }
      
      .rating-stars i.hover {
        color: #ffb400;
      }
      
      .photo-upload {
        margin-top: 10px;
      }
      
      .photo-upload input[type="file"] {
        display: none;
      }
      
      .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        background-color: #f5f5f5;
        border: 1px dashed #ddd;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        color: #666;
        transition: all 0.3s ease;
      }
      
      .upload-btn:hover {
        background-color: #e5e5e5;
        border-color: #ccc;
      }
      
      .photo-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
      }
      
      .upload-preview-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ddd;
      }
      
      .btn-primary {
        padding: 12px 25px;
        background-color: #ff5e62;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
      }
      
      .btn-primary:hover {
        background-color: #ff4146;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 94, 98, 0.3);
      }
      
      /* Form Messages */
      .form-message {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: fadeIn 0.3s ease;
      }
      
      .form-message.error {
        background-color: #ffebee;
        color: #f44336;
        border-left: 4px solid #f44336;
      }
      
      .form-message.success {
        background-color: #e8f5e9;
        color: #4caf50;
        border-left: 4px solid #4caf50;
      }
      
      .form-message.fade-out {
        opacity: 0;
        transition: opacity 0.3s ease;
      }
      
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
      }
      
      /* Responsive Styles */
      @media (max-width: 768px) {
        .feedback-form {
          padding: 20px;
        }
        
        .feedback-tabs {
          flex-direction: column;
        }
        
        .feedback-tab {
          width: 100%;
          text-align: center;
        }
      }
      
      /* Additional animations */
      .feedback-tab {
        position: relative;
        overflow: hidden;
      }
      
      .feedback-tab::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #ff5e62;
        transition: width 0.3s ease;
      }
      
      .feedback-tab:hover::after {
        width: 100%;
      }
      
      .feedback-tab.active::after {
        width: 100%;
      }
      
      /* Pulse animation for submit buttons */
      @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
      }
      
      .btn-primary:focus {
        animation: pulse 1s infinite;
      }
    `
    document.head.appendChild(style)
})