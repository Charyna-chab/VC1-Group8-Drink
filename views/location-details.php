<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>

<section class="hero location-details-hero" style="background-image: url('<?php echo $location['image']; ?>');">
    <div class="container">
        <h1><?php echo $location['name']; ?></h1>
        <p><?php echo $location['address']; ?></p>
    </div>
</section>

<section class="location-details-section">
    <div class="container">
        <div class="breadcrumbs">
            <a href="/">Home</a> &gt; 
            <a href="/locations">Locations</a> &gt; 
            <span><?php echo $location['name']; ?></span>
        </div>
        
        <div class="location-details-content">
            <div class="location-info-card">
                <div class="location-header">
                    <h2><?php echo $location['name']; ?></h2>
                    <div class="location-status open">
                        <i class="fas fa-circle"></i> Open Now
                    </div>
                </div>
                
                <div class="location-contact">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p><?php echo $location['address']; ?></p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <p>+855 <?php echo rand(10, 99); ?> <?php echo rand(100, 999); ?> <?php echo rand(100, 999); ?></p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <p><?php echo strtolower($location['name']); ?>@xingfucha.com</p>
                    </div>
                </div>
                
                <div class="location-hours">
                    <h3>Hours of Operation</h3>
                    <div class="hours-list">
                        <div class="hours-item">
                            <span class="day">Monday - Friday</span>
                            <span class="time">08:00 AM - 18:15 PM</span>
                        </div>
                        <div class="hours-item">
                            <span class="day">Saturday</span>
                            <span class="time">09:00 AM - 19:00 PM</span>
                        </div>
                        <div class="hours-item">
                            <span class="day">Sunday</span>
                            <span class="time">10:00 AM - 17:00 PM</span>
                        </div>
                    </div>
                </div>
                
                <div class="location-features">
                    <h3>Store Features</h3>
                    <div class="features-list">
                        <?php 
                        $features = [
                            1 => [
                                ['icon' => 'fa-wifi', 'name' => 'Free WiFi'],
                                ['icon' => 'fa-chair', 'name' => 'Indoor Seating'],
                                ['icon' => 'fa-credit-card', 'name' => 'Credit Card']
                            ],
                            2 => [
                                ['icon' => 'fa-wifi', 'name' => 'Free WiFi'],
                                ['icon' => 'fa-chair', 'name' => 'Indoor Seating'],
                                ['icon' => 'fa-parking', 'name' => 'Parking'],
                                ['icon' => 'fa-credit-card', 'name' => 'Credit Card']
                            ],
                            3 => [
                                ['icon' => 'fa-wifi', 'name' => 'Free WiFi'],
                                ['icon' => 'fa-parking', 'name' => 'Parking'],
                                ['icon' => 'fa-credit-card', 'name' => 'Credit Card']
                            ],
                            4 => [
                                ['icon' => 'fa-wifi', 'name' => 'Free WiFi'],
                                ['icon' => 'fa-chair', 'name' => 'Indoor Seating'],
                                ['icon' => 'fa-credit-card', 'name' => 'Credit Card']
                            ],
                            5 => [
                                ['icon' => 'fa-wifi', 'name' => 'Free WiFi'],
                                ['icon' => 'fa-chair', 'name' => 'Indoor Seating'],
                                ['icon' => 'fa-parking', 'name' => 'Parking'],
                                ['icon' => 'fa-credit-card', 'name' => 'Credit Card']
                            ]
                        ];
                        
                        if (isset($features[$location['id']])): 
                            foreach ($features[$location['id']] as $feature):
                        ?>
                            <div class="feature-item">
                                <i class="fas <?php echo $feature['icon']; ?>"></i>
                                <span><?php echo $feature['name']; ?></span>
                            </div>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </div>
                </div>
                
                <div class="location-actions">
                    <a href="https://maps.google.com/?q=<?php echo urlencode($location['address']); ?>" class="btn-directions" target="_blank">
                        <i class="fas fa-directions"></i> Get Directions
                    </a>
                    <a href="/order?location=<?php echo $location['id']; ?>" class="btn-order">
                        <i class="fas fa-shopping-cart"></i> Order Online
                    </a>
                    <button class="btn-share" id="shareLocationBtn">
                        <i class="fas fa-share-alt"></i> Share
                    </button>
                </div>
            </div>
            
            <div class="location-map-container">
                <div id="locationMap" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
                <div class="map-actions">
                    <a href="https://maps.google.com/?q=<?php echo urlencode($location['address']); ?>" class="map-action-btn" target="_blank">
                        <i class="fab fa-google"></i> View on Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="location-tabs">
    <div class="container">
        <div class="tabs-container">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="menu">Menu</button>
                <button class="tab-btn" data-tab="gallery">Gallery</button>
                <button class="tab-btn" data-tab="reviews">Reviews</button>
                <button class="tab-btn" data-tab="events">Events</button>
            </div>
            
            <div class="tabs-content">
                <div class="tab-panel active" id="menu">
                    <div class="menu-categories">
                        <button class="menu-category active" data-category="popular">Popular Items</button>
                        <button class="menu-category" data-category="bubble-tea">Bubble Tea</button>
                        <button class="menu-category" data-category="fruit-tea">Fruit Tea</button>
                        <button class="menu-category" data-category="milk-tea">Milk Tea</button>
                        <button class="menu-category" data-category="snacks">Snacks</button>
                    </div>
                    
                    <div class="menu-items">
                        <div class="menu-category-content active" id="popular">
                            <div class="menu-grid">
                                <div class="menu-item">
                                    <div class="menu-item-image">
                                        <img src="/assets/image/menu/brown-sugar-milk-tea.jpg" alt="Brown Sugar Milk Tea">
                                    </div>
                                    <div class="menu-item-info">
                                        <h3>Brown Sugar Milk Tea</h3>
                                        <p>Our signature milk tea with brown sugar pearls</p>
                                        <div class="menu-item-price">$3.99</div>
                                        <button class="add-to-order-btn">Add to Order</button>
                                    </div>
                                </div>
                                
                                <div class="menu-item">
                                    <div class="menu-item-image">
                                        <img src="/assets/image/menu/taro-milk-tea.jpg" alt="Taro Milk Tea">
                                    </div>
                                    <div class="menu-item-info">
                                        <h3>Taro Milk Tea</h3>
                                        <p>Creamy taro flavor with chewy pearls</p>
                                        <div class="menu-item-price">$4.29</div>
                                        <button class="add-to-order-btn">Add to Order</button>
                                    </div>
                                </div>
                                
                                <div class="menu-item">
                                    <div class="menu-item-image">
                                        <img src="/assets/image/menu/mango-fruit-tea.jpg" alt="Mango Fruit Tea">
                                    </div>
                                    <div class="menu-item-info">
                                        <h3>Mango Fruit Tea</h3>
                                        <p>Refreshing tea with real mango pieces</p>
                                        <div class="menu-item-price">$3.79</div>
                                        <button class="add-to-order-btn">Add to Order</button>
                                    </div>
                                </div>
                                
                                <div class="menu-item">
                                    <div class="menu-item-image">
                                        <img src="/assets/image/menu/popcorn-chicken.jpg" alt="Popcorn Chicken">
                                    </div>
                                    <div class="menu-item-info">
                                        <h3>Popcorn Chicken</h3>
                                        <p>Crispy seasoned chicken bites</p>
                                        <div class="menu-item-price">$5.49</div>
                                        <button class="add-to-order-btn">Add to Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="menu-category-content" id="bubble-tea">
                            <!-- Bubble Tea menu items would go here -->
                            <div class="menu-placeholder">
                                <p>Loading Bubble Tea menu items...</p>
                            </div>
                        </div>
                        
                        <div class="menu-category-content" id="fruit-tea">
                            <!-- Fruit Tea menu items would go here -->
                            <div class="menu-placeholder">
                                <p>Loading Fruit Tea menu items...</p>
                            </div>
                        </div>
                        
                        <div class="menu-category-content" id="milk-tea">
                            <!-- Milk Tea menu items would go here -->
                            <div class="menu-placeholder">
                                <p>Loading Milk Tea menu items...</p>
                            </div>
                        </div>
                        
                        <div class="menu-category-content" id="snacks">
                            <!-- Snacks menu items would go here -->
                            <div class="menu-placeholder">
                                <p>Loading Snacks menu items...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="view-full-menu">
                        <a href="/menu" class="view-menu-btn">View Full Menu</a>
                    </div>
                </div>
                
                <div class="tab-panel" id="gallery">
                    <div class="gallery-grid">
                        <div class="gallery-item">
                            <img src="/assets/image/locations/gallery1.jpg" alt="Store Interior">
                            <div class="gallery-caption">Our cozy interior</div>
                        </div>
                        <div class="gallery-item">
                            <img src="/assets/image/locations/gallery2.jpg" alt="Bubble Tea Counter">
                            <div class="gallery-caption">Bubble tea preparation</div>
                        </div>
                        <div class="gallery-item">
                            <img src="/assets/image/locations/gallery3.jpg" alt="Outdoor Seating">
                            <div class="gallery-caption">Outdoor seating area</div>
                        </div>
                        <div class="gallery-item">
                            <img src="/assets/image/locations/gallery4.jpg" alt="Menu Display">
                            <div class="gallery-caption">Our menu display</div>
                        </div>
                        <div class="gallery-item">
                            <img src="/assets/image/locations/gallery5.jpg" alt="Staff">
                            <div class="gallery-caption">Our friendly staff</div>
                        </div>
                        <div class="gallery-item">
                            <img src="/assets/image/locations/gallery6.jpg" alt="Special Events">
                            <div class="gallery-caption">Special events</div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-panel" id="reviews">
                    <div class="reviews-header">
                        <div class="average-rating">
                            <div class="rating-number">4.7</div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="rating-count">Based on 42 reviews</div>
                        </div>
                        <button class="write-review-btn">Write a Review</button>
                    </div>
                    
                    <div class="reviews-list">
                        <div class="review-item">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    <img src="/assets/image/avatars/avatar1.jpg" alt="Reviewer">
                                </div>
                                <div class="reviewer-details">
                                    <h4>Sophea Chen</h4>
                                    <div class="review-date">June 15, 2023</div>
                                </div>
                            </div>
                            <div class="review-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="review-content">
                                <p>The brown sugar milk tea here is amazing! The staff is very friendly and the atmosphere is cozy. Definitely my favorite bubble tea place in town.</p>
                            </div>
                        </div>
                        
                        <div class="review-item">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    <img src="/assets/image/avatars/avatar2.jpg" alt="Reviewer">
                                </div>
                                <div class="reviewer-details">
                                    <h4>Dara Kim</h4>
                                    <div class="review-date">May 22, 2023</div>
                                </div>
                            </div>
                            <div class="review-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <div class="review-content">
                                <p>Great location with free WiFi. The taro milk tea is my favorite. Would be nice if they had more seating during peak hours.</p>
                            </div>
                        </div>
                        
                        <div class="review-item">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    <img src="/assets/image/avatars/avatar3.jpg" alt="Reviewer">
                                </div>
                                <div class="reviewer-details">
                                    <h4>Virak Phan</h4>
                                    <div class="review-date">April 10, 2023</div>
                                </div>
                            </div>
                            <div class="review-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="review-content">
                                <p>The popcorn chicken is crispy and delicious! Perfect snack to go with bubble tea. The staff is always welcoming and remembers regular customers.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="load-more-reviews">
                        <button class="load-more-btn">Load More Reviews</button>
                    </div>
                </div>
                
                <div class="tab-panel" id="events">
                    <div class="events-list">
                        <div class="event-item">
                            <div class="event-date">
                                <div class="event-month">Jul</div>
                                <div class="event-day">15</div>
                            </div>
                            <div class="event-details">
                                <h3>Bubble Tea Workshop</h3>
                                <p class="event-time"><i class="fas fa-clock"></i> 2:00 PM - 4:00 PM</p>
                                <p class="event-description">Learn how to make your own bubble tea with our expert baristas. Registration required.</p>
                                <a href="/events/register/1" class="event-register-btn">Register</a>
                            </div>
                        </div>
                        
                        <div class="event-item">
                            <div class="event-date">
                                <div class="event-month">Aug</div>
                                <div class="event-day">5</div>
                            </div>
                            <div class="event-details">
                                <h3>Student Discount Day</h3>
                                <p class="event-time"><i class="fas fa-clock"></i> All Day</p>
                                <p class="event-description">Show your student ID and get 20% off any drink. Perfect for back-to-school season!</p>
                            </div>
                        </div>
                        
                        <div class="event-item">
                            <div class="event-date">
                                <div class="event-month">Aug</div>
                                <div class="event-day">20</div>
                            </div>
                            <div class="event-details">
                                <h3>Tea Tasting Event</h3>
                                <p class="event-time"><i class="fas fa-clock"></i> 3:00 PM - 5:00 PM</p>
                                <p class="event-description">Sample our new seasonal flavors before they hit the menu. Free for loyalty members.</p>
                                <a href="/events/register/3" class="event-register-btn">Register</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="no-events" style="display: none;">
                        <i class="fas fa-calendar-times"></i>
                        <h3>No Upcoming Events</h3>
                        <p>Check back soon for new events at this location!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="nearby-locations">
    <div class="container">
        <div class="section-header">
            <h2>Nearby Locations</h2>
            <p>Explore other XING FU CHA stores in the area</p>
        </div>
        
        <div class="nearby-locations-slider">
            <?php 
            // Get all locations except the current one
            $nearbyLocations = array_filter($locations, function($loc) use ($location) {
                return $loc['id'] != $location['id'];
            });
            
            // Display up to 3 nearby locations
            $count = 0;
            foreach ($nearbyLocations as $nearby):
                if ($count >= 3) break;
                $count++;
            ?>
                <div class="nearby-location">
                    <div class="nearby-image">
                        <img src="<?php echo $nearby['image']; ?>" alt="<?php echo $nearby['name']; ?>">
                    </div>
                    <div class="nearby-info">
                        <h3><?php echo $nearby['name']; ?></h3>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo $nearby['address']; ?></p>
                        <p><i class="fas fa-clock"></i> <?php echo $nearby['hours']; ?></p>
                        <a href="/locations/details/<?php echo $nearby['id']; ?>" class="nearby-btn">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div id="shareModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Share This Location</h2>
        <div class="share-options">
            <a href="#" class="share-option" id="shareFacebook">
                <i class="fab fa-facebook-f"></i>
                <span>Facebook</span>
            </a>
            <a href="#" class="share-option" id="shareTwitter">
                <i class="fab fa-twitter"></i>
                <span>Twitter</span>
            </a>
            <a href="#" class="share-option" id="shareWhatsapp">
                <i class="fab fa-whatsapp"></i>
                <span>WhatsApp</span>
            </a>
            <a href="#" class="share-option" id="shareEmail">
                <i class="fas fa-envelope"></i>
                <span>Email</span>
            </a>
        </div>
        <div class="share-link">
            <input type="text" id="locationLink" value="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . '/locations/details/' . $location['id']; ?>" readonly>
            <button id="copyLinkBtn" class="copy-link-btn">
                <i class="fas fa-copy"></i> Copy Link
            </button>
        </div>
    </div>
</div>

<div id="reviewModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Write a Review</h2>
        <form id="reviewForm">
            <div class="form-group">
                <label>Your Rating</label>
                <div class="rating-selector">
                    <i class="far fa-star" data-rating="1"></i>
                    <i class="far fa-star" data-rating="2"></i>
                    <i class="far fa-star" data-rating="3"></i>
                    <i class="far fa-star" data-rating="4"></i>
                    <i class="far fa-star" data-rating="5"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="review-name">Your Name</label>
                <input type="text" id="review-name" required>
            </div>
            <div class="form-group">
                <label for="review-email">Your Email</label>
                <input type="email" id="review-email" required>
            </div>
            <div class="form-group">
                <label for="review-content">Your Review</label>
                <textarea id="review-content" rows="4" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Submit Review</button>
        </form>
    </div>
</div>

<?php $pageScript = '/assets/js/location-details.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

