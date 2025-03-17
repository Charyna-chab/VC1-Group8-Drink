document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const filterTabs = document.querySelectorAll('.filter-tab');
    const bookingCards = document.querySelectorAll('.booking-card');
    const searchInput = document.getElementById('bookingSearch');
    const cancelButtons = document.querySelectorAll('.cancel-booking-btn');

    // Initialize
    function init() {
        // Add event listeners
        filterTabs.forEach(tab => {
            tab.addEventListener('click', filterBookings);
        });

        if (searchInput) {
            searchInput.addEventListener('input', searchBookings);
        }

        cancelButtons.forEach(btn => {
            btn.addEventListener('click', cancelBooking);
        });

        // Add animation to booking cards
        bookingCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    // Filter Bookings by Status
    function filterBookings() {
        const status = this.dataset.status;

        // Update active tab
        filterTabs.forEach(tab => {
            tab.classList.remove('active');
        });
        this.classList.add('active');

        // Filter bookings
        bookingCards.forEach(card => {
            if (status === 'all' || card.dataset.status === status) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Search Bookings
    function searchBookings() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        bookingCards.forEach(card => {
            const orderNumber = card.querySelector('h3').textContent.toLowerCase();

            if (orderNumber.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Cancel Booking
    function cancelBooking() {
        const bookingId = this.dataset.id;

        // Show confirmation dialog
        if (!confirm('Are you sure you want to cancel this order?')) {
            return;
        }

        // Send request to server
        fetch(`/api/bookings/cancel/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI
                    const card = this.closest('.booking-card');
                    const statusElement = card.querySelector('.booking-status');

                    statusElement.textContent = 'Cancelled';
                    statusElement.className = 'booking-status cancelled';

                    // Remove cancel button
                    this.remove();

                    // Show success message
                    showToast('success', 'Order cancelled successfully');
                } else {
                    showToast('error', data.message || 'Failed to cancel order.');
                }
            })
            .catch(error => {
                console.error('Error cancelling order:', error);
                showToast('error', 'An error occurred. Please try again.');
            });
    }

    // Show Toast Notification
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        <div class="toast-content">
          <div class="toast-title">${type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Information'}</div>
          <div class="toast-message">${message}</div>
        </div>
      `;

        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container';
            document.body.appendChild(toastContainer);
        }

        // Add toast to container
        toastContainer.appendChild(toast);

        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Initialize
    init();
});