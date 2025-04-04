document.addEventListener("DOMContentLoaded", () => {
            // Filter toggle
            const filterToggleBtn = document.getElementById("filterToggleBtn");
            const filterOptions = document.getElementById("filterOptions");

            if (filterToggleBtn && filterOptions) {
                filterToggleBtn.addEventListener("click", () => {
                    if (filterOptions.style.display === "block") {
                        filterOptions.style.display = "none";
                        filterToggleBtn.querySelector("i.fa-chevron-down").classList.remove("fa-chevron-up");
                        filterToggleBtn.querySelector("i.fa-chevron-down").classList.add("fa-chevron-down");
                    } else {
                        filterOptions.style.display = "block";
                        filterToggleBtn.querySelector("i.fa-chevron-down").classList.remove("fa-chevron-down");
                        filterToggleBtn.querySelector("i.fa-chevron-down").classList.add("fa-chevron-up");
                    }
                });
            }

            // Apply filters
            const applyFiltersBtn = document.getElementById("applyFilters");
            if (applyFiltersBtn) {
                applyFiltersBtn.addEventListener("click", () => {
                    filterLocations();
                });
            }

            // Reset filters
            const resetFiltersBtn = document.getElementById("resetFilters");
            if (resetFiltersBtn) {
                resetFiltersBtn.addEventListener("click", () => {
                    // Reset all checkboxes
                    document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
                        checkbox.checked = false;
                    });

                    // Show all locations
                    document.querySelectorAll(".location-card").forEach((card) => {
                        card.style.display = "";
                    });

                    // Hide no results message
                    const noResultsMessage = document.getElementById("no-results-message");
                    if (noResultsMessage) {
                        noResultsMessage.style.display = "none";
                    }
                });
            }

            // Search functionality
            const searchBtn = document.getElementById("searchBtn");
            const locationSearch = document.getElementById("locationSearch");

            if (searchBtn && locationSearch) {
                searchBtn.addEventListener("click", () => {
                    searchLocations();
                });

                locationSearch.addEventListener("keypress", (e) => {
                    if (e.key === "Enter") {
                        searchLocations();
                    }
                });
            }

            // Use my location
            const useMyLocationBtn = document.getElementById("useMyLocation");
            if (useMyLocationBtn) {
                useMyLocationBtn.addEventListener("click", () => {
                    if (navigator.geolocation) {
                        useMyLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                // This would typically send the coordinates to the server
                                // For demo purposes, we'll just show a message
                                locationSearch.value = "Current Location";
                                useMyLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt"></i>';

                                // Simulate search
                                setTimeout(() => {
                                    searchLocations();
                                }, 500);
                            },
                            (error) => {
                                console.error("Error getting location:", error);
                                useMyLocationBtn.innerHTML = '<i class="fas fa-map-marker-alt"></i>';
                                showToast("Could not get your location. Please try again.", "error");
                            }
                        );
                    } else {
                        showToast("Geolocation is not supported by your browser.", "error");
                    }
                });
            }

            // Sort locations
            const sortBy = document.getElementById("sortBy");
            if (sortBy) {
                sortBy.addEventListener("change", () => {
                    sortLocations(sortBy.value);
                });
            }

            // Pagination
            const prevBtn = document.querySelector(".pagination-btn.prev");
            const nextBtn = document.querySelector(".pagination-btn.next");
            const currentPageEl = document.getElementById("currentPage");
            const totalPagesEl = document.getElementById("totalPages");

            if (prevBtn && nextBtn && currentPageEl && totalPagesEl) {
                let currentPage = 1;
                const totalPages = Math.ceil(document.querySelectorAll(".location-card").length / 5);

                totalPagesEl.textContent = totalPages;

                prevBtn.addEventListener("click", () => {
                    if (currentPage > 1) {
                        currentPage--;
                        updatePagination();
                    }
                });

                nextBtn.addEventListener("click", () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        updatePagination();
                    }
                });

                function updatePagination() {
                    currentPageEl.textContent = currentPage;
                    prevBtn.disabled = currentPage === 1;
                    nextBtn.disabled = currentPage === totalPages;

                    // Show/hide locations based on current page
                    const locationCards = document.querySelectorAll(".location-card");
                    locationCards.forEach((card, index) => {
                        const startIndex = (currentPage - 1) * 5;
                        const endIndex = startIndex + 5;

                        if (index >= startIndex && index < endIndex) {
                            card.style.display = "";
                        } else {
                            card.style.display = "none";
                        }
                    });
                }

                // Initialize pagination
                updatePagination();
            }

            // Suggest location modal
            const suggestLocationBtn = document.getElementById("suggestLocationBtn");
            const suggestLocationModal = document.getElementById("suggestLocationModal");
            const suggestLocationForm = document.getElementById("suggestLocationForm");
            const closeModalBtns = document.querySelectorAll(".close-modal");

            if (suggestLocationBtn && suggestLocationModal) {
                suggestLocationBtn.addEventListener("click", () => {
                    suggestLocationModal.style.display = "block";
                    document.body.style.overflow = "hidden";
                });

                closeModalBtns.forEach((btn) => {
                    btn.addEventListener("click", () => {
                        suggestLocationModal.style.display = "none";
                        document.body.style.overflow = "";
                    });
                });

                window.addEventListener("click", (e) => {
                    if (e.target === suggestLocationModal) {
                        suggestLocationModal.style.display = "none";
                        document.body.style.overflow = "";
                    }
                });

                if (suggestLocationForm) {
                    suggestLocationForm.addEventListener("submit", (e) => {
                        e.preventDefault();

                        // This would typically send the form data to the server
                        // For demo purposes, we'll just show a success message
                        showToast("Thank you for your suggestion! We'll consider it for future locations.", "success");

                        // Close the modal
                        suggestLocationModal.style.display = "none";
                        document.body.style.overflow = "";

                        // Reset the form
                        suggestLocationForm.reset();
                    });
                }
            }

            // Initialize Google Maps
            initMap();

            // Helper functions
            function searchLocations() {
                const searchTerm = locationSearch.value.trim().toLowerCase();
                if (searchTerm === "") return;

                // This would typically send a request to the server
                // For demo purposes, we'll just filter the existing cards
                const locationCards = document.querySelectorAll(".location-card");
                let foundMatch = false;

                locationCards.forEach((card) => {
                    const name = card.querySelector("h3").textContent.toLowerCase();
                    const address = card.querySelector(".location-meta p:first-child").textContent.toLowerCase();

                    if (name.includes(searchTerm) || address.includes(searchTerm)) {
                        card.style.display = "";
                        foundMatch = true;
                    } else {
                        card.style.display = "none";
                    }
                });

                // Show/hide no results message
                const noResultsMessage = document.getElementById("no-results-message");
                if (noResultsMessage) {
                    noResultsMessage.style.display = foundMatch ? "none" : "block";
                }
            }

            function filterLocations() {
                // Get selected filters
                const selectedFeatures = Array.from(document.querySelectorAll('input[name="features"]:checked')).map(
                    (cb) => cb.value
                );
                const selectedHours = Array.from(document.querySelectorAll('input[name="hours"]:checked')).map(
                    (cb) => cb.value
                );

                // If no filters selected, show all locations
                if (selectedFeatures.length === 0 && selectedHours.length === 0) {
                    document.querySelectorAll(".location-card").forEach((card) => {
                        card.style.display = "";
                    });

                    // Hide no results message
                    const noResultsMessage = document.getElementById("no-results-message");
                    if (noResultsMessage) {
                        noResultsMessage.style.display = "none";
                    }

                    return;
                }

                // In a real application, this would use actual data attributes on the cards
                // For demo purposes, we'll just use some hardcoded values
                const locationFeatures = {
                    1: ["wifi", "seating"], // PTT
                    2: ["wifi", "seating", "parking"], // Toul Kork
                    3: ["wifi", "parking"], // Steng Meanchey
                    4: ["wifi", "seating"], // BKK
                    5: ["wifi", "seating", "parking"], // TK
                };

                const locationHours = {
                    1: ["late"], // PTT
                    2: ["early", "late"], // Toul Kork
                    3: [], // Steng Meanchey
                    4: ["early"], // BKK
                    5: ["late"], // TK
                };

                // Filter the cards
                const locationCards = document.querySelectorAll(".location-card");
                let foundMatch = false;

                locationCards.forEach((card) => {
                    const locationId = card.dataset.id;

                    // Check if location has all selected features
                    const hasAllFeatures =
                        selectedFeatures.length === 0 ||
                        selectedFeatures.every((feature) => locationFeatures[locationId] ? .includes(feature));

                    // Check if location has any of the selected hours
                    const hasMatchingHours =
                        selectedHours.length === 0 || selectedHours.some((hour) => locationHours[locationId] ? .includes(hour));

                    // Show or hide based on filters
                    if (hasAllFeatures && hasMatchingHours) {
                        card.style.display = "";
                        foundMatch = true;
                    } else {
                        card.style.display = "none";
                    }
                });

                // Show/hide no results message
                const noResultsMessage = document.getElementById("no-results-message");
                if (noResultsMessage) {
                    noResultsMessage