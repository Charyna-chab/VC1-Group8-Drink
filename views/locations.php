<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>


<div class="section-praents-location">
<section class="location-finder">
    <div class="container">
        <div class="finder-container">
            <div class="finder-header">
                <h2>Find a Store</h2>
                <p>Visit us for authentic bubble tea and a warm atmosphere</p>
            </div>
            <div class="filter-toggle">
                <button id="filterToggleBtn">
                    <i class="fas fa-filter"></i> Filter Options <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            
            <div class="filter-options" id="filterOptions">
                <div class="filter-section">
                    <h3>Features</h3>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="features" value="wifi">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Free WiFi</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="features" value="seating">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Indoor Seating</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="features" value="parking">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Parking</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="features" value="delivery">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Delivery</span>
                        </label>
                    </div>
                </div>
                
                <div class="filter-section">
                    <h3>Hours</h3>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="hours" value="early">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Open Early (Before 8AM)</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="hours" value="late">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Open Late (After 8PM)</span>
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" name="hours" value="weekend">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Open Weekends</span>
                        </label>
                    </div>
                </div>
                
                <div class="filter-actions">
                    <button id="applyFilters" class="apply-filters-btn">Apply Filters</button>
                    <button id="resetFilters" class="reset-filters-btn">Reset</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="location-results">
    <div class="container">
        <div class="results-container">
            <div class="map-container">
                <div id="storeMap"></div>
            </div>
            
            <div class="locations-list">
                <div class="locations-header">
                    <h3>Nearby Locations</h3>
                    <div class="sort-options">
                        <label for="sortBy">Sort by:</label>
                        <select id="sortBy">
                            <option value="distance">Distance</option>
                            <option value="name">Name</option>
                            <option value="rating">Rating</option>
                        </select>
                    </div>
                </div>
                
                <div class="locations-grid">
                    <?php foreach ($locations as $location): ?>
                        <div class="location-card" data-id="<?php echo $location['id']; ?>" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                            <div class="location-image">
                                <img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>">
                                <div class="location-badge">
                                    <?php if (isset($location['isNew']) && $location['isNew']): ?>
                                        <span class="badge new-badge">New</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="location-info">
                                <h3><?php echo $location['name']; ?></h3>
                                <div class="location-meta">
                                    <p><i class="fas fa-map-marker-alt"></i> <?php echo $location['address']; ?></p>
                                    <p><i class="fas fa-clock"></i> <?php echo $location['hours']; ?></p>
                                    <p><i class="fas fa-phone"></i> +855 <?php echo rand(10, 99); ?> <?php echo rand(100, 999); ?> <?php echo rand(100, 999); ?></p>
                                </div>
                                <div class="location-features">
                                    <?php 
                                    $features = [
                                        1 => ['wifi', 'seating'],
                                        2 => ['wifi', 'seating', 'parking'],
                                        3 => ['wifi', 'parking'],
                                        4 => ['wifi', 'seating'],
                                        5 => ['wifi', 'seating', 'parking']
                                    ];
                                    
                                    if (isset($features[$location['id']])): 
                                        foreach ($features[$location['id']] as $feature):
                                    ?>
                                        <span class="feature-tag">
                                            <?php if ($feature === 'wifi'): ?>
                                                <i class="fas fa-wifi"></i> WiFi
                                            <?php elseif ($feature === 'seating'): ?>
                                                <i class="fas fa-chair"></i> Seating
                                            <?php elseif ($feature === 'parking'): ?>
                                                <i class="fas fa-parking"></i> Parking
                                            <?php endif; ?>
                                        </span>
                                    <?php 
                                        endforeach;
                                    endif; 
                                    ?>
                                </div>
                                <div class="location-actions">
                                    <a href="https://maps.google.com/?q=<?php echo urlencode($location['address']); ?>" class="btn-directions" target="_blank">
                                        <i class="fas fa-directions"></i> Directions
                                    </a>
                                    <a href="/locations/details/<?php echo $location['id']; ?>" class="btn-view-details">
                                        <i class="fas fa-info-circle"></i> Details
                                    </a>
                                    <a href="/order?location=<?php echo $location['id']; ?>" class="btn-order-online">
                                        <i class="fas fa-shopping-cart"></i> Order
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div id="no-results-message" class="no-results" style="display: none;">
                    <i class="fas fa-search"></i>
                    <h3>No locations found</h3>
                    <p>Try adjusting your search or filters to find a store near you.</p>
                </div>
                
                <div class="pagination">
                    <button class="pagination-btn prev" disabled><i class="fas fa-chevron-left"></i> Previous</button>
                    <div class="pagination-info">Page <span id="currentPage">1</span> of <span id="totalPages">1</span></div>
                    <button class="pagination-btn next" disabled>Next <i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured-locations">
    <div class="container">
        <div class="section-header">
            <h2>Featured Locations</h2>
            <p>Visit our most popular stores</p>
        </div>
        
        <div class="featured-slider">
            <div class="featured-location">
                <div class="featured-image">
                    <img src="/assets/image/locations/featured1.jpg" alt="PTT Location">
                    <div class="featured-overlay">
                        <h3>PTT</h3>
                        <p>Our flagship store with a full menu</p>
                        <a href="/locations/details/1" class="featured-btn">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="featured-location">
                <div class="featured-image">
                    <img src="/assets/image/locations/featured2.jpg" alt="Toul Kork Location">
                    <div class="featured-overlay">
                        <h3>Toul Kork</h3>
                        <p>Cozy atmosphere with indoor seating</p>
                        <a href="/locations/details/2" class="featured-btn">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="featured-location">
                <div class="featured-image">
                    <img src="/assets/image/locations/featured3.jpg" alt="BKK Location">
                    <div class="featured-overlay">
                        <h3>BKK</h3>
                        <p>Student-friendly with study spaces</p>
                        <a href="/locations/details/4" class="featured-btn">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="featured-location">
                <div class="featured-image">
                    <img src="/assets/image/locations/featured3.jpg" alt="BKK Location">
                    <div class="featured-overlay">
                        <h3>TK</h3>
                        <p>Student-friendly with study spaces</p>
                        <a href="/locations/details/4" class="featured-btn">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="location-cta">
    <div class="container">
        <div class="cta-content">
            <h2>Can't Find a Location Near You?</h2>
            <p>We're expanding! Let us know where you'd like to see a XING FU CHA store next.</p>
            <button id="suggestLocationBtn" class="cta-button">Suggest a Location</button>
        </div>
    </div>
</section>

<div id="suggestLocationModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Suggest a New Location</h2>
        <form id="suggestLocationForm">
            <div class="form-group">
                <label for="suggestion-name">Your Name</label>
                <input type="text" id="suggestion-name" required>
            </div>
            <div class="form-group">
                <label for="suggestion-email">Your Email</label>
                <input type="email" id="suggestion-email" required>
            </div>
            <div class="form-group">
                <label for="suggestion-location">Suggested Location</label>
                <input type="text" id="suggestion-location" placeholder="City, District, or Area" required>
            </div>
            <div class="form-group">
                <label for="suggestion-reason">Why this location?</label>
                <textarea id="suggestion-reason" rows="3"></textarea>
            </div>
            <button type="submit" class="submit-btn">Submit Suggestion</button>
        </form>
    </div>
</div>
</div>


<?php $pageScript = '/assets/js/locations.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

