document.addEventListener('DOMContentLoaded', function() {
    // Toggle filter options
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterOptions = document.getElementById('filterOptions');
    
    if (filterToggleBtn && filterOptions) {
        filterToggleBtn.addEventListener('click', function() {
            filterOptions.classList.toggle('active');
            const icon = this.querySelector('.fa-chevron-down');
            if (icon) {
                icon.classList.toggle('fa-chevron-up');
            }
            
            // Close on mobile when clicking outside
            if (window.innerWidth <= 768) {
                document.addEventListener('click', function closeOnClickOutside(e) {
                    if (!filterOptions.contains(e.target) && e.target !== filterToggleBtn) {
                        filterOptions.classList.remove('active');
                        if (icon) icon.classList.remove('fa-chevron-up');
                        document.removeEventListener('click', closeOnClickOutside);
                    }
                });
            }
        });
    }
    
    // Filter functionality
    const applyFiltersBtn = document.getElementById('applyFilters');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            // In a real implementation, this would filter the locations
            alert('Filters applied! (This is a demo)');
            if (window.innerWidth <= 768) {
                filterOptions.classList.remove('active');
            }
        });
    }
    
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.filter-options input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    }
    
    // Sort functionality
    const sortBy = document.getElementById('sortBy');
    if (sortBy) {
        sortBy.addEventListener('change', function() {
            console.log('Sorting by:', this.value);
        });
    }
    
    // Modal functionality
    const suggestLocationModal = document.getElementById('suggestLocationModal');
    const openModalButtons = document.querySelectorAll('[data-target="suggestLocationModal"]');
    const closeModal = document.querySelector('.close-modal');
    
    if (suggestLocationModal) {
        function openModal() {
            suggestLocationModal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }
        
        function closeModalFunc() {
            suggestLocationModal.style.display = 'none';
            document.body.style.overflow = ''; // Re-enable scrolling
        }
        
        openModalButtons.forEach(button => {
            button.addEventListener('click', openModal);
        });
        
        if (closeModal) {
            closeModal.addEventListener('click', closeModalFunc);
        }
        
        window.addEventListener('click', function(event) {
            if (event.target === suggestLocationModal) {
                closeModalFunc();
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalFunc();
            }
        });
    }
    
    // Form submission
    const suggestLocationForm = document.getElementById('suggestLocationForm');
    if (suggestLocationForm) {
        suggestLocationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your suggestion!');
            document.getElementById('suggestLocationModal').style.display = 'none';
            document.body.style.overflow = ''; // Re-enable scrolling
            this.reset();
        });
    }
    
    // Responsive adjustments for location cards
    function handleCardLayout() {
        const locationCards = document.querySelectorAll('.location-card');
        if (window.innerWidth <= 768) {
            locationCards.forEach(card => {
                const image = card.querySelector('.location-image');
                const info = card.querySelector('.location-info');
                if (image && info) {
                    card.insertBefore(image, card.firstChild);
                }
            });
        }
    }
    
    // Run on load and resize
    handleCardLayout();
    window.addEventListener('resize', handleCardLayout);
});