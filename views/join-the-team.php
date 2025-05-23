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
                <!-- <div class="intro-video">
                    <div class="video-container">
                        <img src="/assets/image/team/team-video-thumbnail.jpg" alt="Team Video Thumbnail">
                        <div class="play-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </div> -->
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

    <section class="open-positions" id="open-positions">
        <div class="container">
            <div class="section-header">
                <h2>Current Openings</h2>
                <p>Find the perfect role for your skills and passion</p>
            </div>
            
            <div class="positions-filter">
                <div class="filter-group">
                    <label for="position-type">Position Type:</label>
                    <select id="position-type">
                        <option value="all">All Types</option>
                        <option value="full-time">Full-time</option>
                        <option value="part-time">Part-time</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="position-location">Location:</label>
                    <select id="position-location">
                        <option value="all">All Locations</option>
                        <option value="ptt">PTT</option>
                        <option value="toul-kork">Toul Kork</option>
                        <option value="steng-meanchey">Steng Meanchey</option>
                        <option value="bkk">BKK</option>
                        <option value="tk">TK</option>
                    </select>
                </div>
            </div>
            
            <div class="positions-list">
                <?php foreach ($positions as $position): ?>
                    <div class="position-card">
                        <div class="position-header">
                            <h3><?php echo $position['title']; ?></h3>
                            <div class="position-badge">
                                <?php if (strpos($position['type'], 'Full-time') !== false): ?>
                                    <span class="badge full-time">Full-time</span>
                                <?php endif; ?>
                                <?php if (strpos($position['type'], 'Part-time') !== false): ?>
                                    <span class="badge part-time">Part-time</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="position-details">
                            <p class="position-type"><i class="fas fa-clock"></i> <?php echo $position['type']; ?></p>
                            <p class="position-location"><i class="fas fa-map-marker-alt"></i> <?php echo $position['location']; ?></p>
                            <p class="position-desc"><?php echo $position['description']; ?></p>
                            
                            <div class="position-responsibilities">
                                <h4>Key Responsibilities:</h4>
                                <ul>
                                    <?php if ($position['id'] == 1): // Bubble Tea Barista ?>
                                        <li>Prepare bubble tea and other beverages according to recipes</li>
                                        <li>Provide excellent customer service</li>
                                        <li>Maintain cleanliness of work area</li>
                                        <li>Handle cash and card transactions</li>
                                    <?php elseif ($position['id'] == 2): // Shift Supervisor ?>
                                        <li>Oversee daily operations during assigned shifts</li>
                                        <li>Train and mentor team members</li>
                                        <li>Ensure quality standards are met</li>
                                        <li>Handle customer concerns and feedback</li>
                                    <?php elseif ($position['id'] == 3): // Kitchen Staff ?>
                                        <li>Prepare food items according to recipes</li>
                                        <li>Maintain kitchen cleanliness and organization</li>
                                        <li>Follow food safety guidelines</li>
                                        <li>Assist with inventory management</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            
                            <div class="position-requirements">
                                <h4>Requirements:</h4>
                                <ul>
                                    <?php if ($position['id'] == 1): // Bubble Tea Barista ?>
                                        <li>No prior experience required, training provided</li>
                                        <li>Friendly and positive attitude</li>
                                        <li>Basic math skills</li>
                                        <li>Ability to work in a fast-paced environment</li>
                                    <?php elseif ($position['id'] == 2): // Shift Supervisor ?>
                                        <li>1+ year of experience in food service or retail</li>
                                        <li>Leadership skills and ability to motivate team</li>
                                        <li>Strong problem-solving abilities</li>
                                        <li>Excellent communication skills</li>
                                    <?php elseif ($position['id'] == 3): // Kitchen Staff ?>
                                        <li>Basic food preparation knowledge</li>
                                        <li>Understanding of food safety principles</li>
                                        <li>Ability to follow recipes and instructions</li>
                                        <li>Team player mentality</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="position-footer">
                            <a href="/join-the-team/apply?position=<?php echo $position['id']; ?>" class="btn-apply">Apply Now</a>
                            <button class="btn-share-position" data-position="<?php echo $position['title']; ?>">
                                <i class="fas fa-share-alt"></i> Share
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="no-positions" style="display: none;">
                <i class="fas fa-search"></i>
                <h3>No positions found</h3>
                <p>Try adjusting your filters or check back later for new openings.</p>
            </div>
        </div>
    </section>

    <section class="application-process">
        <div class="container">
            <div class="section-header">
                <h2>How to Apply</h2>
                <p>Our simple application process</p>
            </div>
            
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Submit Application</h3>
                        <p>Fill out our online form for the position you're interested in. We can't wait to hear from you!</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Initial Interview</h3>
                        <p>If selected, you'll be invited for a friendly initial interview with our store manager.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Skills Assessment</h3>
                        <p>Demonstrate your talents and abilities in a fun skills assessment related to the position.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Final Interview</h3>
                        <p>Meet with your future manager for a final chat to discuss your fit with the team.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Welcome Aboard!</h3>
                        <p>If selected, you'll receive an offer and we'll kick off your training!</p>
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
<?php $pageScript = '/assets/js/join-team.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

