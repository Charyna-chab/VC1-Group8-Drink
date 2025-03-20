document.addEventListener('DOMContentLoaded', function() {
    // Feedback tab navigation
    const tabLinks = document.querySelectorAll('.feedback-tab');
    const tabContents = document.querySelectorAll('.feedback-content');

    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove active class from all tabs
            tabLinks.forEach(item => item.classList.remove('active'));
            tabContents.forEach(item => item.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Show corresponding content
            const tabId = this.getAttribute('data-tab');
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });

    // Star rating functionality
    const stars = document.querySelectorAll('.rating-stars i');
    const ratingInput = document.querySelector('input[name="rating"]');

    if (stars && ratingInput) {
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;

                // Update star display
                stars.forEach(s => {
                    const sRating = s.getAttribute('data-rating');
                    if (sRating <= rating) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                    }
                });
            });
        });
    }

    // Show/hide product select based on review type
    const reviewTypeSelect = document.querySelector('select[name="review_type"]');
    const productSelect = document.querySelector('.product-select');

    if (reviewTypeSelect && productSelect) {
        reviewTypeSelect.addEventListener('change', function() {
            if (this.value === 'product') {
                productSelect.style.display = 'block';
            } else {
                productSelect.style.display = 'none';
            }
        });
    }

    // Show/hide order select based on issue type
    const issueTypeSelect = document.querySelector('select[name="issue_type"]');
    const orderSelect = document.querySelector('.order-select');

    if (issueTypeSelect && orderSelect) {
        issueTypeSelect.addEventListener('change', function() {
            if (this.value === 'order') {
                orderSelect.style.display = 'block';
            } else {
                orderSelect.style.display = 'none';
            }
        });
    }

    // Photo upload preview
    const photoInputs = document.querySelectorAll('input[type="file"]');

    photoInputs.forEach(input => {
        input.addEventListener('change', function() {
            const previewContainer = this.parentElement.querySelector('.photo-preview');
            if (previewContainer) {
                previewContainer.innerHTML = '';

                if (this.files) {
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];
                        if (file.type.match('image.*')) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'upload-preview-img';
                                previewContainer.appendChild(img);
                            }

                            reader.readAsDataURL(file);
                        }
                    }
                }
            }
        });
    });
});