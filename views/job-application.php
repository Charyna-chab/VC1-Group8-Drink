<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>

<section class="hero application-hero">
    <div class="container">
        <h1>Apply for <?php echo isset($_GET['position']) ? $positions[$_GET['position'] - 1]['title'] : 'a Position'; ?></h1>
        <p>Join our team and start your journey with XING FU CHA</p>
    </div>
</section>

<section class="application-form-section">
    <div class="container">
        <div class="breadcrumbs">
            <a href="/">Home</a> &gt; 
            <a href="/join-the-team">Join Our Team</a> &gt; 
            <span>Application Form</span>
        </div>
        
        <div class="form-container">
            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <div class="error-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error-content">
                        <h3>Please correct the following errors:</h3>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="application-progress">
                <div class="progress-step active" data-step="personal">
                    <div class="step-number">1</div>
                    <div class="step-label">Personal Information</div>
                </div>
                <div class="progress-step" data-step="job">
                    <div class="step-number">2</div>
                    <div class="step-label">Job Preferences</div>
                </div>
                <div class="progress-step" data-step="experience">
                    <div class="step-number">3</div>
                    <div class="step-label">Experience & Resume</div>
                </div>
                <div class="progress-step" data-step="additional">
                    <div class="step-number">4</div>
                    <div class="step-label">Additional Information</div>
                </div>
            </div>
            
            <form action="/join-the-team/apply" method="POST" enctype="multipart/form-data" id="applicationForm">
                <div class="form-step active" id="step-personal">
                    <div class="form-section">
                        <h3>Personal Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Full Name <span class="required">*</span></label>
                                <input type="text" id="name" name="name" required>
                                <div class="form-hint">Enter your legal name as it appears on your ID</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address <span class="required">*</span></label>
                                <input type="email" id="email" name="email" required>
                                <div class="form-hint">We'll use this to contact you about your application</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" id="phone" name="phone" required>
                                <div class="form-hint">Format: +855 XX XXX XXXX</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" placeholder="Street address">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city">
                            </div>
                            
                            <div class="form-group">
                                <label for="postal-code">Postal Code</label>
                                <input type="text" id="postal-code" name="postal_code">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-next" data-next="job">Next: Job Preferences</button>
                    </div>
                </div>
                
                <div class="form-step" id="step-job">
                    <div class="form-section">
                        <h3>Job Preferences</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="position">Position <span class="required">*</span></label>
                                <select id="position" name="position" required>
                                    <option value="">Select a position</option>
                                    <?php foreach ($positions as $position): ?>
                                        <option value="<?php echo $position['id']; ?>" <?php echo isset($_GET['position']) && $_GET['position'] == $position['id'] ? 'selected' : ''; ?>>
                                            <?php echo $position['title']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="location">Preferred Location</label>
                                <select id="location" name="location">
                                    <option value="">Select a location</option>
                                    <option value="1">PTT</option>
                                    <option value="2">Toul Kork</option>
                                    <option value="3">Steng Meanchey</option>
                                    <option value="4">BKK</option>
                                    <option value="5">TK</option>
                                </select>
                                <div class="form-hint">If you have no preference, leave blank</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="employment-type">Employment Type <span class="required">*</span></label>
                                <select id="employment-type" name="employment_type" required>
                                    <option value="">Select employment type</option>
                                    <option value="full-time">Full-time</option>
                                    <option value="part-time">Part-time</option>
                                    <option value="either">Either</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="start-date">Earliest Start Date</label>
                                <input type="date" id="start-date" name="start_date">
                                <div class="form-hint">When would you be available to start?</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label>Availability</label>
                                <div class="availability-grid">
                                    <div class="availability-header">
                                        <div class="day-header"></div>
                                        <div class="time-header">Morning</div>
                                        <div class="time-header">Afternoon</div>
                                        <div class="time-header">Evening</div>
                                    </div>
                                    <?php 
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    foreach ($days as $day): 
                                    ?>
                                    <div class="availability-row">
                                        <div class="day-label"><?php echo $day; ?></div>
                                        <div class="time-cell">
                                            <input type="checkbox" id="<?php echo strtolower($day); ?>-morning" name="availability[<?php echo strtolower($day); ?>][]" value="morning">
                                        </div>
                                        <div class="time-cell">
                                            <input type="checkbox" id="<?php echo strtolower($day); ?>-afternoon" name="availability[<?php echo strtolower($day); ?>][]" value="afternoon">
                                        </div>
                                        <div class="time-cell">
                                            <input type="checkbox" id="<?php echo strtolower($day); ?>-evening" name="availability[<?php echo strtolower($day); ?>][]" value="evening">
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="form-hint">Check all times
                                </div>
                                <div class="form-hint">Check all times you are available to work</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="hours-per-week">Hours per week you can work</label>
                                <select id="hours-per-week" name="hours_per_week">
                                    <option value="">Select hours</option>
                                    <option value="1-10">1-10 hours</option>
                                    <option value="11-20">11-20 hours</option>
                                    <option value="21-30">21-30 hours</option>
                                    <option value="31-40">31-40 hours</option>
                                    <option value="40+">40+ hours</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-prev" data-prev="personal">Previous: Personal Information</button>
                        <button type="button" class="btn-next" data-next="experience">Next: Experience & Resume</button>
                    </div>
                </div>
                
                <div class="form-step" id="step-experience">
                    <div class="form-section">
                        <h3>Experience & Resume</h3>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="experience">Relevant Experience</label>
                                <textarea id="experience" name="experience" rows="4" placeholder="Describe your previous work experience, skills, or qualifications relevant to this position"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="education">Highest Level of Education</label>
                                <select id="education" name="education">
                                    <option value="">Select education level</option>
                                    <option value="high-school">High School</option>
                                    <option value="vocational">Vocational Training</option>
                                    <option value="associate">Associate Degree</option>
                                    <option value="bachelor">Bachelor's Degree</option>
                                    <option value="master">Master's Degree</option>
                                    <option value="doctorate">Doctorate</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="languages">Languages Spoken</label>
                                <input type="text" id="languages" name="languages" placeholder="e.g., Khmer, English, Chinese">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="resume">Resume/CV <span class="required">*</span></label>
                                <div class="file-upload">
                                    <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
                                    <label for="resume" class="file-label">
                                        <i class="fas fa-upload"></i>
                                        <span>Choose a file</span>
                                    </label>
                                    <span class="file-name">No file chosen</span>
                                </div>
                                <div class="form-hint">Accepted formats: PDF, DOC, DOCX. Max size: 5MB</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-prev" data-prev="job">Previous: Job Preferences</button>
                        <button type="button" class="btn-next" data-next="additional">Next: Additional Information</button>
                    </div>
                </div>
                
                <div class="form-step" id="step-additional">
                    <div class="form-section">
                        <h3>Additional Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label for="cover-letter">Cover Letter (Optional)</label>
                                <textarea id="cover-letter" name="cover_letter" rows="6" placeholder="Tell us why you want to join XING FU CHA and what makes you a great fit for our team"></textarea>
                                <div class="char-count"><span id="letter-chars">0</span>/1000 characters</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label>How did you hear about us?</label>
                                <div class="radio-group">
                                    <label class="radio-item">
                                        <input type="radio" name="referral_source" value="website">
                                        <span class="radio-label">Company Website</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="referral_source" value="social-media">
                                        <span class="radio-label">Social Media</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="referral_source" value="job-board">
                                        <span class="radio-label">Job Board</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="referral_source" value="friend">
                                        <span class="radio-label">Friend/Family</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="referral_source" value="store">
                                        <span class="radio-label">In-Store</span>
                                    </label>
                                    <label class="radio-item">
                                        <input type="radio" name="referral_source" value="other">
                                        <span class="radio-label">Other</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row" id="referral-other-row" style="display: none;">
                            <div class="form-group full-width">
                                <label for="referral-other">Please specify:</label>
                                <input type="text" id="referral-other" name="referral_other">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group full-width">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="terms" required>
                                    <span class="checkbox-custom"></span>
                                    <span>I agree to the <a href="/terms" target="_blank">terms and conditions</a> and <a href="/privacy" target="_blank">privacy policy</a>. <span class="required">*</span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="btn-prev" data-prev="experience">Previous: Experience & Resume</button>
                        <button type="submit" class="btn-submit">Submit Application</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="application-tips">
    <div class="container">
        <div class="section-header">
            <h2>Application Tips</h2>
            <p>Increase your chances of success with these helpful tips</p>
        </div>
        
        <div class="tips-grid">
            <div class="tip-item">
                <div class="tip-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Resume Tips</h3>
                <ul>
                    <li>Keep your resume clear and concise (1-2 pages)</li>
                    <li>Highlight relevant experience and skills</li>
                    <li>Include measurable achievements when possible</li>
                    <li>Proofread carefully for errors</li>
                </ul>
            </div>
            
            <div class="tip-item">
                <div class="tip-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Interview Tips</h3>
                <ul>
                    <li>Research XING FU CHA before your interview</li>
                    <li>Prepare examples of your customer service experience</li>
                    <li>Dress professionally and arrive 10-15 minutes early</li>
                    <li>Bring a copy of your resume and any questions you have</li>
                </ul>
            </div>
            
            <div class="tip-item">
                <div class="tip-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Stand Out</h3>
                <ul>
                    <li>Show enthusiasm for bubble tea and our products</li>
                    <li>Demonstrate your customer service mindset</li>
                    <li>Highlight your teamwork and communication skills</li>
                    <li>Be authentic and let your personality shine</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2>Application FAQs</h2>
            <p>Common questions about our application process</p>
        </div>
        
        <div class="faq-accordion">
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How long will it take to hear back after applying?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We typically review applications within 3-5 business days. If your qualifications match our needs, you'll receive an email or phone call to schedule an interview. If you don't hear from us within two weeks, feel free to follow up by email.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I apply for multiple positions?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, you can apply for multiple positions if you meet the qualifications. Please submit a separate application for each position you're interested in, and tailor your resume and cover letter accordingly.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What should I wear to the interview?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>We recommend business casual attire for interviews. This shows professionalism while still being appropriate for our casual work environment. Clean, neat appearance is important as you'll be representing our brand to customers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $pageScript = '/assets/js/job-application.js'; ?>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>

