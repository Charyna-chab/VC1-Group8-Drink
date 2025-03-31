<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>

<section class="hero gift-card-hero">
    <div class="container">
        <h1><?php echo $giftCard['name']; ?></h1>
        <p>Gift Card Details</p>
    </div>
</section>

<section class="gift-card-details">
    <div class="container">
        <div class="breadcrumbs">
            <a href="/">Home</a> &gt; 
            <a href="/gift-card">Gift Cards</a> &gt; 
            <span><?php echo $giftCard['name']; ?></span>
        </div>
        
        <div class="gift-card-details-content">
            <div class="gift-card-image-container">
                <div class="gift-card-image">
                    <img src="<?php echo $giftCard['image']; ?>" alt="<?php echo $giftCard['name']; ?>">
                </div>
                <div class="gift-card-thumbnails">
                    <div class="thumbnail active">
                        <img src="<?php echo $giftCard['image']; ?>" alt="Front">
                    </div>
                    <div class="thumbnail">
                        <img src="/assets/image/gift-card-back.jpg" alt="Back">
                    </div>
                </div>
            </div>
            
            <div class="gift-card-info">
                <h2><?php echo $giftCard['name']; ?></h2>
                <div class="card-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span>(24 reviews)</span>
                </div>
                <p class="description"><?php echo $giftCard['description']; ?></p>
                
                <div class="discount-options">
                    <h3>Select Discount</h3>
                    <div class="options-list">
                        <?php foreach ($giftCard['options'] as $index => $option): ?>
                            <label class="option-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <input type="radio" name="discount" value="<?php echo $option['value']; ?>" <?php echo $index === 0 ? 'checked' : ''; ?>>
                                <span class="option-label"><?php echo $option['label']; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="recipient-info">
                    <h3>Recipient Information</h3>
                    <div class="form-group">
                        <label for="recipient-name">Recipient Name <span class="required">*</span></label>
                        <input type="text" id="recipient-name" placeholder="Enter recipient's name" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-email">Recipient Email <span class="required">*</span></label>
                        <input type="email" id="recipient-email" placeholder="Enter recipient's email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Personal Message (Optional)</label>
                        <textarea id="message" placeholder="Add a personal message" rows="3"></textarea>
                        <div class="char-count"><span id="message-chars">0</span>/200 characters</div>
                    </div>
                </div>
                
                <div class="delivery-options">
                    <h3>Delivery Method</h3>
                    <div class="options-list">
                        <label class="option-item active">
                            <input type="radio" name="delivery" value="email" checked>
                            <span class="option-label"><i class="fas fa-envelope"></i> Email</span>
                        </label>
                        <label class="option-item">
                            <input type="radio" name="delivery" value="print">
                            <span class="option-label"><i class="fas fa-print"></i> Print at Home</span>
                        </label>
                    </div>
                </div>
                
                <div class="gift-card-actions">
                    <div class="quantity-selector">
                        <button class="quantity-btn minus"><i class="fas fa-minus"></i></button>
                        <input type="number" value="1" min="1" max="10" id="quantity">
                        <button class="quantity-btn plus"><i class="fas fa-plus"></i></button>
                    </div>
                    <button class="btn-add-to-cart" data-id="<?php echo $giftCard['id']; ?>">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                    <button class="btn-buy-now">
                        <i class="fas fa-bolt"></i> Buy Now
                    </button>
                </div>
                
                <div class="gift-card-meta">
                    <div class="meta-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure transaction</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-infinity"></i>
                        <span>No expiration date</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-store"></i>
                        <span>Valid at all locations</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gift-card-details-tabs">
    <div class="container">
        <div class="tabs-container">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="description">Description</button>
                <button class="tab-btn" data-tab="how-to-use">How to Use</button>
                <button class="tab-btn" data-tab="terms">Terms & Conditions</button>
                <button class="tab-btn" data-tab="reviews">Reviews</button>
            </div>
            
            <div class="tabs-content">
                <div class="tab-panel active" id="description">
                    <h3>About this Gift Card</h3>
                    <p>The <?php echo $giftCard['name']; ?> is perfect for any occasion. Whether it's a birthday, anniversary, or just because, this gift card allows the recipient to enjoy their favorite bubble tea drinks at any XING FU CHA location.</p>
                    <p>Our gift cards are beautifully designed and can be personalized with your own message. They're available in various discount options, making it easy to find the perfect gift for your budget.</p>
                    <h4>Features:</h4>
                    <ul>
                        <li>No expiration date</li>
                        <li>Redeemable at all XING FU CHA locations</li>
                        <li>Available in digital or printable format</li>
                        <li>Customizable with personal message</li>
                    </ul>
                </div>
                
                <div class="tab-panel" id="how-to-use">
                    <h3>How to Use Your Gift Card</h3>
                    <div class="usage-steps">
                        <div class="usage-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h4>Receive Your Gift Card</h4>
                                <p>Your gift card will be delivered via email or you can print it at home.</p>
                            </div>
                        </div>
                        <div class="usage-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h4>Visit Any XING FU CHA Location</h4>
                                <p>Bring your gift card to any of our stores.</p>
                            </div>
                        </div>
                        <div class="usage-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h4>Place Your Order</h4>
                                <p>Choose your favorite bubble tea drinks and food items.</p>
                            </div>
                        </div>
                        <div class="usage-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h4>Redeem at Checkout</h4>
                                <p>Present your gift card to the cashier or enter the code for online orders.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-panel" id="terms">
                    <h3>Terms & Conditions</h3>
                    <div class="terms-content">
                        <p>By purchasing or using a XING FU CHA gift card, you agree to the following terms and conditions:</p>
                        <ul>
                            <li>Gift cards are redeemable for food and beverages at participating XING FU CHA locations.</li>
                            <li>Gift cards have no expiration date and no fees.</li>
                            <li>Gift cards cannot be redeemed for cash unless required by law.</li>
                            <li>XING FU CHA is not responsible for lost, stolen, or damaged gift cards.</li>
                            <li>Gift cards are not returnable or refundable.</li>
                            <li>XING FU CHA reserves the right to change these terms and conditions at any time without notice.</li>
                        </ul>
                    </div>
                </div>
                
                <div class="tab-panel" id="reviews">
                    <h3>Customer Reviews</h3>
                    <div class="reviews-summary">
                        <div class="average-rating">
                            <div class="rating-number">4.5</div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="rating-count">Based on 24 reviews</div>
                        </div>
                        <div class="rating-breakdown">
                            <div class="rating-bar">
                                <span class="rating-label">5 stars</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 75%"></div>
                                </div>
                                <span class="rating-percent">75%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-label">4 stars</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 15%"></div>
                                </div>
                                <span class="rating-percent">15%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-label">3 stars</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 5%"></div>
                                </div>
                                <span class="rating-percent">5%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-label">2 stars</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 3%"></div>
                                </div>
                                <span class="rating-percent">3%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-label">1 star</span>
                                <div class="progress-bar">
                                    <div class="progress" style="width: 2%"></div>
                                </div>
                                <span class="rating-percent">2%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="review-list">
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
                                <p>I bought this gift card for my friend's birthday and she loved it! The design is beautiful and the process was very easy. Highly recommend!</p>
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
                                <p>Great gift option! The email delivery was instant and my sister was able to use it right away. Would be nice to have more design options though.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="load-more-reviews">
                        <button class="load-more-btn">Load More Reviews</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="related-gift-cards">
    <div class="container">
        <div class="section-header">
            <h2>You May Also Like</h2>
            <p>Explore our other gift card options</p>
        </div>
        
        <div class="related-cards-slider">
            <div class="related-card">
                <div class="related-card-image">
                    <img src="/assets/image/giftcard.jpg" alt="Classic Gift Card">
                </div>
                <h3>Classic Gift Card</h3>
                <a href="/gift-card/details/1" class="view-card-btn">View Card</a>
            </div>
            
            <div class="related-card">
                <div class="related-card-image">
                    <img src="/assets/image/2membership.jpg" alt="Member Gift Card">
                </div>
                <h3>Member Gift Card</h3>
                <a href="/gift-card/details/2" class="view-card-btn">View Card</a>
            </div>
            
            <div class="related-card">
                <div class="related-card-image">
                    <img src="/assets/image/holyday.jpg" alt="Holiday Gift Card">
                </div>
                <h3>Holiday Gift Card</h3>
                <a href="/gift-card/details/3" class="view-card-btn">View Card</a>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Can't Decide? Send a Digital Gift Card!</h2>
            <p>Let them choose their favorite design and discount amount</p>
            <a href="/gift-card/digital" class="cta-button">Send Digital Gift Card</a>
        </div>
    </div>
</section>

<?php $pageScript = '/assets/js/gift-card-details.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

