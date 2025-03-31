<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>

<section class="hero more-hero">
    <div class="container">
        <h1>More Options</h1>
        <p>"Xing Fu Cha brings you the finest selection of authentic Chinese teas, crafted for purity and wellness. Our teas are sourced from sustainable farms, ensuring quality in every sip. Discover the art of tea with us!"</p>
    </div>
</section>

<section class="more-options">
    <div class="container">
        <div class="section-header">
            <h2>Explore More</h2>
            <p>Discover everything XING FU CHA has to offer</p>
        </div>
        
        <div class="options-grid">
            <a href="/about-us" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3>About Us</h3>
                <p>Learn about our story, mission, and values</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/contact-us" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Contact & Support</h3>
                <p>Get in touch with our customer service team</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/faq" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3>FAQ</h3>
                <p>Find answers to frequently asked questions</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/terms" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Terms & Conditions</h3>
                <p>Read our terms of service</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/privacy" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Privacy Policy</h3>
                <p>Learn how we protect your data</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/franchising" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Franchising</h3>
                <p>Interested in opening your own XING FU CHA?</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/loyalty-program" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h3>Loyalty Program</h3>
                <p>Earn rewards with every purchase</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/careers" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Careers</h3>
                <p>Join our growing team</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            
            <a href="/sustainability" class="option-card">
                <div class="option-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Sustainability</h3>
                <p>Our commitment to the environment</p>
                <div class="card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="contact-info">
    <div class="container">
        <div class="section-header">
            <h2>Contact Information</h2>
            <p>We're here to help with any questions or feedback</p>
        </div>
        
        <div class="contact-grid">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Phone</h3>
                <p>+855 (123) 456-7890</p>
                <p class="contact-hours">Monday - Friday: 9AM - 5PM</p>
                <a href="tel:+85512345678" class="contact-action">
                    <i class="fas fa-phone"></i> Call Now
                </a>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email</h3>
                <p>info@xingfucha.com</p>
                <p>support@xingfucha.com</p>
                <a href="mailto:info@xingfucha.com" class="contact-action">
                    <i class="fas fa-envelope"></i> Send Email
                </a>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Headquarters</h3>
                <p>123 Tea Street, Phnom Penh</p>
                <p>Cambodia 12000</p>
                <a href="https://maps.google.com/?q=123+Tea+Street+Phnom+Penh+Cambodia" target="_blank" class="contact-action">
                    <i class="fas fa-directions"></i> Get Directions
                </a>
            </div>
        </div>
    </div>
</section>

<section class="contact-form-section">
    <div class="container">
        <div class="section-header">
            <h2>Send Us a Message</h2>
            <p>We'd love to hear from you</p>
        </div>
        
        <div class="contact-form-container">
            <form id="contactForm" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name">Your Name <span class="required">*</span></label>
                        <input type="text" id="contact-name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email">Your Email <span class="required">*</span></label>
                        <input type="email" id="contact-email" name="email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-phone">Phone Number</label>
                        <input type="tel" id="contact-phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-subject">Subject <span class="required">*</span></label>
                        <select id="contact-subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="feedback">Feedback</option>
                            <option value="support">Customer Support</option>
                            <option value="partnership">Partnership Opportunity</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="contact-message">Message <span class="required">*</span></label>
                        <textarea id="contact-message" name="message" rows="5" required></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label class="checkbox-label">
                            <input type="checkbox" name="subscribe" checked>
                            <span class="checkbox-custom"></span>
                            <span>Subscribe to our newsletter for updates and promotions</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="social-media">
    <div class="container">
        <div class="section-header">
            <h2>Connect With Us</h2>
            <p>Follow us on social media for updates, promotions, and more</p>
        </div>
        
        <div class="social-grid">
            <a href="https://facebook.com/xingfucha" class="social-item" target="_blank">
                <div class="social-icon">
                    <i class="fab fa-facebook-f"></i>
                </div>
                <span>Facebook</span>
                <div class="social-followers">12.5K Followers</div>
            </a>
            
            <a href="https://instagram.com/xingfucha" class="social-item" target="_blank">
                <div class="social-icon">
                    <i class="fab fa-instagram"></i>
                </div>
                <span>Instagram</span>
                <div class="social-followers">8.7K Followers</div>
            </a>
            
            <a href="https://twitter.com/xingfucha" class="social-item" target="_blank">
                <div class="social-icon">
                    <i class="fab fa-twitter"></i>
                </div>
                <span>Twitter</span>
                <div class="social-followers">5.2K Followers</div>
            </a>
            
            <a href="https://youtube.com/xingfucha" class="social-item" target="_blank">
                <div class="social-icon">
                    <i class="fab fa-youtube"></i>
                </div>
                <span>YouTube</span>
                <div class="social-followers">3.8K Subscribers</div>
            </a>
            
            <a href="https://tiktok.com/@xingfucha" class="social-item" target="_blank">
                <div class="social-icon">
                    <i class="fab fa-tiktok"></i>
                </div>
                <span>TikTok</span>
                <div class="social-followers">15.3K Followers</div>
            </a>
            
            <a href="https://linkedin.com/company/xingfucha" class="social-item" target="_blank">
                <div class="social-icon">
                    <i class="fab fa-linkedin-in"></i>
                </div>
                <span>LinkedIn</span>
                <div class="social-followers">2.1K Followers</div>
            </a>
        </div>
    </div>
</section>

<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <h2>Subscribe to Our Newsletter</h2>
                <p>Stay updated with our latest news, promotions, and bubble tea tips!</p>
                <form class="newsletter-form">
                    <div class="newsletter-input-group">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </div>
                    <div class="newsletter-privacy">
                        <label class="checkbox-label">
                            <input type="checkbox" required>
                            <span class="checkbox-custom"></span>
                            <span>I agree to the <a href="/privacy" target="_blank">privacy policy</a></span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="newsletter-image">
                <img src="/assets/image/newsletter-image.jpg" alt="Newsletter">
            </div>
        </div>
    </div>
</section>

<?php $pageScript = '/assets/js/more.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

