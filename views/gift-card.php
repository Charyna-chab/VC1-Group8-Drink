<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>

<div class="section-praents">
<section class="gift-card-options">
    <div class="container">
        <div class="section-header">
            <h2>Choose Your Gift Card</h2>
            <p>Perfect for birthdays, holidays, or just to say thank you</p>
        </div>
        
        <div class="gift-card-container">
            <?php
            $giftCards = [
                [
                    'id' => 1,
                    'name' => 'Classic Gift Card',
                    'description' => 'Perfect for any occasion',
                    'image' => '/assets/image/giftcard.jpg',
                    'options' => [
                        ['value' => '0.20', 'label' => '20%'],
                        ['value' => '0.30', 'label' => '30%'],
                        ['value' => '0.40', 'label' => '40%']
                    ]
                ],
                [
                    'id' => 2,
                    'name' => 'Member Gift Card',
                    'description' => 'Celebrate with bubble tea',
                    'image' => '/assets/image/2membership.jpg',
                    'options' => [
                        ['value' => '0.15', 'label' => '15%'],
                        ['value' => '0.25', 'label' => '25%'],
                        ['value' => '0.35', 'label' => '35%']
                    ]
                ],
                [
                    'id' => 3,
                    'name' => 'Holiday Gift Card',
                    'description' => 'Seasonal special design',
                    'image' => '/assets/image/holyday.jpg',
                    'options' => [
                        ['value' => '0.25', 'label' => '25%'],
                        ['value' => '0.50', 'label' => '50%'],
                        ['value' => '0.70', 'label' => '70%']
                    ]
                ]
            ];
            
            foreach ($giftCards as $index => $card): 
                // Force the second card (index 1) to be image-right
                $layoutClass = ($index == 1) ? 'image-right' : (($index % 2 == 0) ? 'image-left' : 'image-right');
            ?>
                <div class="gift-card-item <?php echo $layoutClass; ?>" data-id="<?php echo $card['id']; ?>">
                    <?php if($layoutClass == ''): ?>
                        <div class="gift-card-content">
                            <h3><?php echo $card['name']; ?></h3>
                            <p class="card-description"><?php echo $card['description']; ?></p>
                            <div class="price-options">
                                <?php foreach ($card['options'] as $optIndex => $option): ?>
                                    <button class="price-option <?php echo $optIndex === 0 ? 'active' : ''; ?>" data-value="<?php echo $option['value']; ?>"><?php echo $option['label']; ?></button>
                                <?php endforeach; ?>
                            </div>
                            <button class="add-to-cart-btn" data-id="<?php echo $card['id']; ?>">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                        <div class="gift-card-image">
                            <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>">
                            <div class="card-overlay">
                                <a href="/gift-card/details/<?php echo $card['id']; ?>" class="view-details-btn">View Details</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="gift-card-image">
                            <img src="<?php echo $card['image']; ?>" alt="<?php echo $card['name']; ?>">
                            <div class="card-overlay">
                                <a href="/gift-card/details/<?php echo $card['id']; ?>" class="view-details-btn">View Details</a>
                            </div>
                        </div>
                        <div class="gift-card-content">
                            <h3><?php echo $card['name']; ?></h3>
                            <p class="card-description"><?php echo $card['description']; ?></p>
                            <div class="price-options">
                                <?php foreach ($card['options'] as $optIndex => $option): ?>
                                    <button class="price-option <?php echo $optIndex === 0 ? 'active' : ''; ?>" data-value="<?php echo $option['value']; ?>"><?php echo $option['label']; ?></button>
                                <?php endforeach; ?>
                            </div>
                            <button class="add-to-cart-btn" data-id="<?php echo $card['id']; ?>">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Rest of your sections remain the same -->
<section class="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2>How It Works</h2>
            <p>Sending a gift card is quick and easy</p>
        </div>
        
        <div class="steps-container">
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3>1. Choose a Card</h3>
                <p>Select from our beautiful gift card designs</p>
            </div>
            
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <h3>2. Select Discount</h3>
                <p>Choose the perfect discount amount</p>
            </div>
            
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>3. Personalize</h3>
                <p>Add a custom message for the recipient</p>
            </div>
            
            <div class="step-item">
                <div class="step-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h3>4. Send or Print</h3>
                <p>Email directly or print at home</p>
            </div>
        </div>
    </div>
</section>

<section class="gift-card-info">
    <div class="container">
        <div class="section-header">
            <h2>Gift Card Information</h2>
            <p>Everything you need to know about our gift cards</p>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <i class="fas fa-credit-card"></i>
                <h3>No Expiration</h3>
                <p>Our gift cards never expire, so your gift can be enjoyed anytime.</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-store"></i>
                <h3>Use at Any Location</h3>
                <p>Gift cards can be redeemed at any XING FU CHA location.</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <h3>Digital Delivery</h3>
                <p>Send directly to the recipient's email for immediate gifting.</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-gift"></i>
                <h3>Personalize Your Gift</h3>
                <p>Add a custom message to make your gift more special.</p>
            </div>
        </div>
    </div>
</section>

<section class="gift-card-faq">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about our gift cards</p>
        </div>
        
        <div class="faq-accordion">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I redeem a gift card?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I check my gift card balance?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I reload my gift card?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What if my gift card is lost or stolen?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I use my gift card for online orders?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>
        </div>
    </div>
</section>

</div>

<style>
.gift-card-container {
    display: flex;
    flex-direction: column;
    gap: 40px;
    margin-top: 140px;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding: 0 20px;
}

.gift-card-item {
    display: flex;
    align-items: stretch; /* Changed from center to stretch for equal height */
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    width: 100%; /* Ensure full width of container */
    height: 350px; /* Fixed height for all cards */
}

.gift-card-item:hover {
    transform: translateY(-5px);
}

.gift-card-item.image-right {
    flex-direction: row;
}

.gift-card-item.image-left {
    flex-direction: row-reverse;
}

.gift-card-image {
    flex: 1;
    position: relative;
    min-height: 100%; /* Changed from fixed px to percentage */
    width: 50%; /* Fixed width for image section */
}

.gift-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gift-card-image:hover .card-overlay {
    opacity: 1;
}

.view-details-btn {
    padding: 10px 20px;
    background: #fff;
    color: #333;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.view-details-btn:hover {
    background: #333;
    color: #fff;
}

.gift-card-content {
    flex: 1;
    padding: 30px;
    width: 50%; /* Fixed width for content section */
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.gift-card-content h3 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #333;
}

.card-description {
    color: #666;
    margin-bottom: 20px;
    font-size: 16px;
}

.price-options {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
}

.price-option {
    padding: 8px 15px;
    border: 1px solid #ddd;
    background: #f9f9f9;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.price-option.active, .price-option:hover {
    background: #333;
    color: #fff;
    border-color: #333;
}

.add-to-cart-btn {
    padding: 12px 25px;
    background: #ff6b6b;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    width: fit-content;
}

.add-to-cart-btn:hover {
    background: #ff5252;
    transform: translateY(-2px);
}

/* Responsive styles */
@media (max-width: 768px) {
    .gift-card-item, 
    .gift-card-item.image-right, 
    .gift-card-item.image-left {
        flex-direction: column;
        height: auto; /* Allow height to adjust on mobile */
    }
    
    .gift-card-image,
    .gift-card-content {
        width: 100%; /* Full width on mobile */
    }
    
    .gift-card-image {
        min-height: 200px;
    }
    
    .gift-card-content {
        padding: 20px;
    }
}
</style>

<?php $pageScript = '/assets/js/gift-card.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>