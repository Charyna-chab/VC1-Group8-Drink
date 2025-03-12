// public/assets/js/booking.js
document.addEventListener('DOMContentLoaded', function() {
    // Booking search functionality
    const searchInput = document.getElementById('bookingSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const bookingCards = document.querySelectorAll('.booking-card');

            bookingCards.forEach(card => {
                const orderNumber = card.querySelector('h3').textContent.toLowerCase();

                if (orderNumber.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Cancel booking functionality
    const cancelButtons = document.querySelectorAll('.cancel-booking-btn');
    if (cancelButtons.length > 0) {
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const bookingId = this.getAttribute('data-id');

                // In a real application, you would send an AJAX request to cancel the booking
                // For now, we'll just show a confirmation dialog
                if (confirm('Are you sure you want to cancel this order?')) {
                    // Show success message
                    alert('Order cancelled successfully!');

                    // Update the booking card status
                    const bookingCard = this.closest('.booking-card');
                    if (bookingCard) {
                        bookingCard.setAttribute('data-status', 'cancelled');
                        const statusElement = bookingCard.querySelector('.booking-status');
                        if (statusElement) {
                            statusElement.textContent = 'Cancelled';
                            statusElement.className = 'booking-status cancelled';
                        }

                        // Remove cancel button
                        this.remove();
                    }
                }
            });
        });
    }
});