<section class="hero">
    <div class="container">
        <h1>Our Locations</h1>
        <p>Find XING FU CHA near you</p>
    </div>
</section>

<section class="location-search">
    <div class="container">
        <div class="search-container">
            <input type="text" id="locationSearch" placeholder="Enter your city or zip code">
            <button id="searchBtn"><i class="fas fa-search"></i> Find Stores</button>
        </div>
    </div>
</section>

<section class="featured-locations">
    <div class="container">
        <h2>Featured Locations</h2>
        
        <div class="locations-grid">
            <div class="location-card">
                <img src="/assets/image/locations/location1.jpg" alt="Downtown Store">
                <div class="location-info">
                    <h3>Downtown</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Main Street, City, State 12345</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                    <p><i class="fas fa-clock"></i> 10:00 AM - 10:00 PM</p>
                    <div class="location-actions">
                        <a href="#" class="btn-directions"><i class="fas fa-directions"></i> Get Directions</a>
                        <a href="#" class="btn-order"><i class="fas fa-shopping-bag"></i> Order Online</a>
                    </div>
                </div>
            </div>
            
            <div class="location-card">
                <img src="/assets/image/locations/location2.jpg" alt="Westside Store">
                <div class="location-info">
                    <h3>Westside</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 456 West Avenue, City, State 12345</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7891</p>
                    <p><i class="fas fa-clock"></i> 10:00 AM - 10:00 PM</p>
                    <div class="location-actions">
                        <a href="#" class="btn-directions"><i class="fas fa-directions"></i> Get Directions</a>
                        <a href="#" class="btn-order"><i class="fas fa-shopping-bag"></i> Order Online</a>
                    </div>
                </div>
            </div>
            
            <div class="location-card">
                <img src="/assets/image/locations/location3.jpg" alt="Eastside Store">
                <div class="location-info">
                    <h3>Eastside</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 789 East Boulevard, City, State 12345</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7892</p>
                    <p><i class="fas fa-clock"></i> 10:00 AM - 10:00 PM</p>
                    <div class="location-actions">
                        <a href="#" class="btn-directions"><i class="fas fa-directions"></i> Get Directions</a>
                        <a href="#" class="btn-order"><i class="fas fa-shopping-bag"></i> Order Online</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="map-section">
    <div class="container">
        <h2>Find Us on the Map</h2>
        <div id="storeMap" class="store-map">
            <!-- Map will be loaded here via JavaScript -->
            <img src="/assets/image/locations/map-placeholder.jpg" alt="Store Map" class="map-placeholder">
        </div>
    </div>
</section>

<?php $pageScript = '/assets/js/locations.js'; ?>

