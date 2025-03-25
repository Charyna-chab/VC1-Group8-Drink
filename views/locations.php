
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        /* Hero Section */
        .hero {
            background-color: white;
            color: black;
            padding: 50px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2em;
        }

        /* Location Search Section */
        .location-search {
            background-color: #fff;
            padding: 20px 0;
        }

        .location-search .container {
            text-align: center;
        }

        .location-search input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 25px;
        }

        #searchBtn {
            background-color: #ff6769;
            color: white;
            border: none;
            padding: 10px 50px;
            border-radius: 25px;
            cursor: pointer;
            margin-left: 10px;
        }

        #searchBtn i {
            margin-right: 5px;
        }

        /* Featured Locations Section */
        .featured-locations {
            background-color: #f9f9f9;
            padding: 40px 0;
        }

        .featured-locations h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
        }

        .locations-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .location-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .location-card:hover {
            transform: translateY(-5px);
        }

        .location-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .location-info {
            padding: 20px;
        }

        .location-info h3 {
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .location-info p {
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .location-actions {
            display: flex;
            gap: 10px;
        }

        .location-actions a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .location-actions a:hover {
            color: #ff6769;
        }

        /* Button styles */
        .btn-directions, .btn-order {
            background-color: #e27d60;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .btn-directions:hover, .btn-order:hover {
            background-color: #d16450;
        }

        .fas {
            margin-right: 5px;
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

