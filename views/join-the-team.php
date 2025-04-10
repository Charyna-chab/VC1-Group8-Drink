<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<div class="section-praents-join-team">
<section class="team-intro">
    <div class="container">
        <div class="intro-content">
            <div class="intro-text">
                <h2>Work With Us</h2>
                <p>At XING FU CHA, we believe that our team members are the heart of our business. We're always looking for passionate, friendly, and dedicated individuals to join our growing family.</p>
                <p>Whether you're a bubble tea enthusiast, a customer service pro, or someone looking to start a rewarding career in the food and beverage industry, we'd love to hear from you!</p>
                <a href="#open-positions" class="view-positions-btn">View Open Positions</a>
            </div>
            <div class="intro-video">
                <div class="video-container">
                    <img src="/assets/image/work.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="why-join">
    <div class="container">
        <div class="section-header">
            <h2>Why Work With Us?</h2>
            <p>Discover the benefits of joining the XING FU CHA team</p>
        </div>
        
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Great Team Culture</h3>
                <p>Step into a warm and inviting atmosphere where every member feels like family.</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Growth Opportunities</h3>
                <p>We're all about helping you rise and thrive in your career!</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Training Programs</h3>
                <p>Enjoy thorough training designed to help you perfect your skills and truly shine in your role.</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-mug-hot"></i>
                </div>
                <h3>Free Drinks</h3>
                <p>Enjoy complimentary bubble tea during your shifts.</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Flexible Scheduling</h3>
                <p>Work schedules that accommodate your life and studies.</p>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <h3>Employee Discounts</h3>
                <p>Special discounts for you and your family members.</p>
            </div>
        </div>
    </div>
</section>

<section class="team-values">
    <div class="container">
        <div class="values-content">
            <div class="values-image">
                <img src="assets/image/values-image.png" alt="Our Team Values">
            </div>
            <div class="values-text">
                <h2>Our Values</h2>
                <div class="value-item">
                    <h3><i class="fas fa-heart"></i> Passion</h3>
                    <p>We're passionate about creating the perfect bubble tea experience for our customers.</p>
                </div>
                <div class="value-item">
                    <h3><i class="fas fa-hands-helping"></i> Teamwork</h3>
                    <p>We support each other and work together to achieve our goals.</p>
                </div>
                <div class="value-item">
                    <h3><i class="fas fa-star"></i> Excellence</h3>
                    <p>We strive for excellence in everything we do, from our products to our service.</p>
                </div>
                <div class="value-item">
                    <h3><i class="fas fa-smile"></i> Customer Focus</h3>
                    <p>Our customers are at the heart of our business, and we aim to exceed their expectations.</p>
                </div>
            </div>
        </div>
    </div>
</section>





<div id="sharePositionModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Share This Position</h2>
        <div class="share-options">
            <a href="#" class="share-option" id="sharePositionFacebook">
                <i class="fab fa-facebook-f"></i>
                <span>Facebook</span>
            </a>
            <a href="#" class="share-option" id="sharePositionTwitter">
                <i class="fab fa-twitter"></i>
                <span>Twitter</span>
            </a>
            <a href="#" class="share-option" id="sharePositionWhatsapp">
                <i class="fab fa-whatsapp"></i>
                <span>WhatsApp</span>
            </a>
            <a href="#" class="share-option" id="sharePositionEmail">
                <i class="fas fa-envelope"></i>
                <span>Email</span>
            </a>
        </div>
        <div class="share-link">
            <input type="text" id="positionLink" readonly>
            <button id="copyPositionLinkBtn" class="copy-link-btn">
                <i class="fas fa-copy"></i> Copy Link
            </button>
        </div>
    </div>
</div>

</div>

<?php $pageScript = '/assets/js/join-team.js'; ?>.
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

