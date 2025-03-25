<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Cards - XING FU CHA</title>
    <style>
        /* Gift Card Page Styles */
        :root {
          --primary-color: #e83e8c; /* Pink - brand color */
          --secondary-color: #6f42c1; /* Purple - accent color */
          --dark-color: #343a40;
          --light-color: #f8f9fa;
          --success-color: #28a745;
          --border-color: #dee2e6;
          --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          --transition: all 0.3s ease;
        }
        /* General Reset */
    /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Hero Section */
        .hero {
            background-color: #white;
            color: black;
            padding: 50px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
        }

        /* Why Join Section */
        .why-join {
            padding: 60px 20px;
            background-color: #ffffff;
        }

        .why-join h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .benefit-item {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .benefit-item i {
            font-size: 3rem;
            color: black;
            margin-bottom: 15px;
        }

        .benefit-item h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .benefit-item p {
            font-size: 1rem;
        }

        /* Open Positions Section */
        .open-positions {
            padding: 60px 20px;
            background-color: #f4f4f4;
        }

        .open-positions h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .positions-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        .position-card {
            background-color: white;
            padding: 20px;
            width: 100%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .position-card h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .position-type,
        .position-location {
            font-size: 1rem;
            color: #888;
        }

        .position-desc {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .position-card .btn-apply {
            background-color: #ff6769;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }

        .position-card .btn-apply:hover {
            background-color: #ff6769;
        }

        /* Application Process Section */
        .application-process {
            padding: 60px 20px;
            background-color: #ffffff;
        }

        .application-process h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .step {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .step-number {
            background-color: #ff6769;
            color: white;
            border-radius: 50%;
            padding: 20px;
            font-size: 1.5rem;
            margin-bottom: 15px;
            width: 60px;
            height: 60px;
            display: inline-block;
        }

        .step h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .step p {
            font-size: 1rem;
            color: #888;
        }
</style>
</head>
<header>
    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
    <nav>
        <ul>
            <li><a href="/gift-card">Gift Card</a></li>
            <li><a href="/locations">Locations</a></li>
            <li><a href="/join-the-team">Join The Team</a></li>
            <li><a href="/more">More</a></li>
        </ul>
    </nav>
    <div class="search-bar">
        <input type="text" placeholder="What do you want to eat today...">
    </div>
    <button class="order-search">Order Now</button>
    <div class="language-selector">
        <div class="selected-language">
            <img src="/assets/image/flags/en.png" alt="English" id="currentLanguageFlag">
            <span id="currentLanguage">English</span>
            <i class="fas fa-chevron-down"></i>
        </div>
        <div class="language-dropdown">
            <a href="/lang/en" class="language-option" data-lang="en">
                <img src="/assets/image/flags/en.png" alt="English">
                <span>English</span>
            </a>
            <a href="/lang/zh" class="language-option" data-lang="zh">
                <img src="/assets/image/flags/zh.png" alt="Chinese">
                <span>中文</span>
            </a>
            <a href="/lang/es" class="language-option" data-lang="es">
                <img src="/assets/image/flags/es.png" alt="Spanish">
                <span>Español</span>
            </a>
            <a href="/lang/fr" class="language-option" data-lang="fr">
                <img src="/assets/image/flags/fr.png" alt="French">
                <span>Français</span>
            </a>
            <a href="/lang/ja" class="language-option" data-lang="ja">
                <img src="/assets/image/flags/ja.png" alt="Japanese">
                <span>日本語</span>
            </a>
        </div>
    </div>
    <div class="user-profile" id="userProfileBtn">
        <img src="<?php echo isset($_SESSION['user']) ? $_SESSION['user']['avatar'] : '/assets/image/placeholder.svg?height=40&width=40'; ?>" alt="User Profile">
    </div>
    <div class="notification-icon" id="notificationBtn">
        <a href="/"></a><i class="fas fa-bell"></i>
        <span class="notification-badge" id="notificationBadge">0</span>
    </div>
</header>
<section class="hero">
    <div class="container">
        <h1>Join Our Team</h1>
        <p>Become part of the XING FU CHA family</p>
    </div>
</section>

<section class="why-join">
    <div class="container">
        <h2>Why Work With Us?</h2>
        
        <div class="benefits-grid">
            <div class="benefit-item">
                <i class="fas fa-users"></i>
                <h3>Great Team Culture</h3>
                <p>Join a supportive and friendly team that feels like family.</p>
            </div>
            
            <div class="benefit-item">
                <i class="fas fa-chart-line"></i>
                <h3>Growth Opportunities</h3>
                <p>Clear paths for advancement and professional development.</p>
            </div>
            
            <div class="benefit-item">
                <i class="fas fa-graduation-cap"></i>
                <h3>Training Programs</h3>
                <p>Comprehensive training to help you master your role.</p>
            </div>
            
            <div class="benefit-item">
                <i class="fas fa-mug-hot"></i>
                <h3>Free Drinks</h3>
                <p>Enjoy complimentary bubble tea during your shifts.</p>
            </div>
            
            <div class="benefit-item">
                <i class="fas fa-calendar-alt"></i>
                <h3>Flexible Scheduling</h3>
                <p>Work schedules that accommodate your life and studies.</p>
            </div>
            
            <div class="benefit-item">
                <i class="fas fa-percentage"></i>
                <h3>Employee Discounts</h3>
                <p>Special discounts for you and your family members.</p>
            </div>
        </div>
    </div>
</section>

<section class="open-positions">
    <div class="container">
        <h2>Current Openings</h2>
        
        <div class="positions-list">
            <div class="position-card">
                <h3>Bubble Tea Barista</h3>
                <p class="position-type"><i class="fas fa-clock"></i> Full-time / Part-time</p>
                <p class="position-location"><i class="fas fa-map-marker-alt"></i> Multiple Locations</p>
                <p class="position-desc">Create delicious bubble tea drinks and provide excellent customer service.</p>
                <a href="#" class="btn-apply">Apply Now</a>
            </div>
            
            <div class="position-card">
                <h3>Shift Supervisor</h3>
                <p class="position-type"><i class="fas fa-clock"></i> Full-time</p>
                <p class="position-location"><i class="fas fa-map-marker-alt"></i> Downtown Location</p>
                <p class="position-desc">Lead a team of baristas and ensure smooth store operations during your shift.</p>
                <a href="#" class="btn-apply">Apply Now</a>
            </div>
            
            <div class="position-card">
                <h3>Kitchen Staff</h3>
                <p class="position-type"><i class="fas fa-clock"></i> Full-time / Part-time</p>
                <p class="position-location"><i class="fas fa-map-marker-alt"></i> Multiple Locations</p>
                <p class="position-desc">Prepare food items according to our recipes and maintain kitchen cleanliness.</p>
                <a href="#" class="btn-apply">Apply Now</a>
            </div>
        </div>
    </div>
</section>

<section class="application-process">
    <div class="container">
        <h2>How to Apply</h2>
        
        <div class="process-steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Submit Application</h3>
                <p>Fill out our online application form for the position you're interested in.</p>
            </div>
            
            <div class="step">
                <div class="step-number">2</div>
                <h3>Initial Interview</h3>
                <p>If selected, you'll be invited for an initial interview with our store manager.</p>
            </div>
            
            <div class="step">
                <div class="step-number">3</div>
                <h3>Skills Assessment</h3>
                <p>Demonstrate your skills and abilities related to the position.</p>
            </div>
            
            <div class="step">
                <div class="step-number">4</div>
                <h3>Final Interview</h3>
                <p>Meet with our district manager for a final interview.</p>
            </div>
            
            <div class="step">
                <div class="step-number">5</div>
                <h3>Welcome Aboard!</h3>
                <p>If selected, you'll receive an offer and begin your training.</p>
            </div>
        </div>
    </div>
</section>

<?php $pageScript = '/assets/js/join-team.js'; ?>

