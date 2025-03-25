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
    /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }

        /* Hero Section */
        .hero {
            background-color: white; /* Change color to match your theme */
            padding: 60px 20px;
            text-align: center;
            color: #333;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2rem;
            color: #555;
        }

        /* More Options Section */
        .more-options {
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Options Grid */
        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive grid */
            gap: 20px;
        }

        /* Option Card */
        .option-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #333;
            text-decoration: none;
        }

        .option-card i {
            font-size: 2.5rem;
            color: black;
            margin-bottom: 10px;
        }

        .option-card h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .option-card p {
            font-size: 1rem;
            color: #777;
        }

        /* Hover Effect */
        .option-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .options-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .option-card i {
                font-size: 2rem;
            }

            .option-card h3 {
                font-size: 1.2rem;
            }

            .option-card p {
                font-size: 0.9rem;
            }
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
        <h1>More Options</h1>
        <p>Discover everything XING FU CHA has to offer</p>
    </div>
</section>

<section class="more-options">
    <div class="container">
        <div class="options-grid">
            <a href="/about-us" class="option-card">
                <i class="fas fa-store"></i>
                <h3>About Us</h3>
                <p>Learn about our story and mission</p>
            </a>
            
            <a href="/menu" class="option-card">
                <i class="fas fa-utensils"></i>
                <h3>Full Menu</h3>
                <p>Explore our complete menu offerings</p>
            </a>
            
            <a href="/rewards" class="option-card">
                <i class="fas fa-gift"></i>
                <h3>Rewards Program</h3>
                <p>Join our loyalty program and earn rewards</p>
            </a>
            
            <a href="/catering" class="option-card">
                <i class="fas fa-concierge-bell"></i>
                <h3>Catering</h3>
                <p>Let us cater your next event</p>
            </a>
            
            <a href="/franchising" class="option-card">
                <i class="fas fa-handshake"></i>
                <h3>Franchising</h3>
                <p>Own your own XING FU CHA franchise</p>
            </a>
            
            <a href="/contact" class="option-card">
                <i class="fas fa-envelope"></i>
                <h3>Contact Us</h3>
                <p>Get in touch with our team</p>
            </a>
            
            <a href="/faq" class="option-card">
                <i class="fas fa-question-circle"></i>
                <h3>FAQ</h3>
                <p>Find answers to common questions</p>
            </a>
            
            <a href="/blog" class="option-card">
                <i class="fas fa-newspaper"></i>
                <h3>Blog</h3>
                <p>Read our latest news and articles</p>
            </a>
        </div>
    </div>
</section>

<?php $pageScript = '/assets/js/more.js'; ?>

