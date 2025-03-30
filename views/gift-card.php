<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Cards - XING FU CHA</title>
    <style>
        /* Gift Card Page Styles */

        /* General Styles */
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

        .container {
          width: 100%;
          max-width: 1200px;
          margin: 0 auto;
          padding: 0 15px;
        }

        /* Hero Section */
        .hero {
          background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                      url('/assets/image/backgrounds/gift-card-hero.jpg') center/cover no-repeat;
          color: white;
          text-align: center;
          padding: 80px 20px;
          margin-bottom: 50px;
        }

        .hero h1 {
          font-size: 3rem;
          margin-bottom: 15px;
          font-weight: 700;
        }

        .hero p {
          font-size: 1.2rem;
          max-width: 600px;
          margin: 0 auto;
          opacity: 0.9;
        }

        /* Gift Card Options Section */
        .gift-card-options {
          padding: 50px 0;
        }

        .gift-card-options h2 {
          text-align: center;
          font-size: 2.2rem;
          margin-bottom: 40px;
          color: var(--dark-color);
        }

        .gift-card-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
          gap: 30px;
        }

        .gift-card-item {
          background-color: white;
          border-radius: 10px;
          overflow: hidden;
          box-shadow: var(--shadow);
          transition: var(--transition);
          display: flex;
          flex-direction: column;
        }

        .gift-card-item:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .gift-card-item img {
          width: 100%;
          height: 200px;
          object-fit: cover;
          border-bottom: 1px solid var(--border-color);
        }

        .gift-card-item h3 {
          font-size: 1.5rem;
          margin: 20px 20px 10px;
          color: var(--dark-color);
        }

        .gift-card-item p {
          margin: 0 20px 20px;
          color: #6c757d;
        }

        /* Price Options */
        .price-options {
          display: flex;
          justify-content: center;
          gap: 10px;
          margin: 0 20px 20px;
        }

        .price-option {
          background-color: #f8f9fa;
          border: 2px solid #dee2e6;
          border-radius: 5px;
          padding: 8px 15px;
          font-weight: 600;
          cursor: pointer;
          transition: var(--transition);
          color: var(--dark-color);
        }

        .price-option:hover {
          background-color: #e9ecef;
        }

        .price-option.active {
          background-color: var(--primary-color);
          border-color: var(--primary-color);
          color: white;
        }

        /* Add to Cart Button */
        .add-to-cart {
          background-color: var(--secondary-color);
          color: white;
          border: none;
          border-radius: 5px;
          padding: 12px 20px;
          font-weight: 600;
          cursor: pointer;
          transition: var(--transition);
          margin: 0 20px 20px;
          text-transform: uppercase;
          letter-spacing: 0.5px;
        }

        .add-to-cart:hover {
          background-color: #5a36a0; /* Darker purple */
          transform: translateY(-2px);
        }

        /* Gift Card Information Section */
        .gift-card-info {
          background-color: #f8f9fa;
          padding: 60px 0;
          margin-top: 50px;
        }

        .gift-card-info h2 {
          text-align: center;
          font-size: 2.2rem;
          margin-bottom: 40px;
          color: var(--dark-color);
        }

        .info-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
          gap: 30px;
        }

        .info-item {
          background-color: white;
          border-radius: 10px;
          padding: 30px;
          text-align: center;
          box-shadow: var(--shadow);
          transition: var(--transition);
        }

        .info-item:hover {
          transform: translateY(-5px);
        }

        .info-item i {
          font-size: 2.5rem;
          color: var(--primary-color);
          margin-bottom: 20px;
        }

        .info-item h3 {
          font-size: 1.3rem;
          margin-bottom: 15px;
          color: var(--dark-color);
        }

        .info-item p {
          color: #6c757d;
          line-height: 1.6;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
          .hero {
            padding: 60px 20px;
          }
          
          .hero h1 {
            font-size: 2.5rem;
          }
          
          .gift-card-grid, .info-grid {
            grid-template-columns: 1fr;
          }
          
          .gift-card-options, .gift-card-info {
            padding: 40px 0;
          }
          
          .gift-card-options h2, .gift-card-info h2 {
            font-size: 1.8rem;
          }
        }

        @media (max-width: 480px) {
          .hero h1 {
            font-size: 2rem;
          }
          
          .hero p {
            font-size: 1rem;
          }
          
          .price-options {
            flex-direction: column;
            align-items: center;
          }
          
          .price-option {
            width: 100%;
            text-align: center;
          }
          
          .add-to-cart {
            width: 100%;
          }
        }
    </style>
</head>
<body>
    
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

    <section class="gift-card-options">
        <div class="container">
            <h2>Choose Your Gift Card</h2>
            
            <div class="gift-card-grid">
                <div class="gift-card-item">
                    <img src="/assets/image/giftcard.jpg" alt="Classic Gift Card">
                    <h3>Classic Gift Card</h3>
                    <p>Perfect for any occasion</p>
                    <div class="price-options">
                        <button class="price-option active" data-value="0.20">20%</button>
                        <button class="price-option" data-value="0.30">30%</button>
                        <button class="price-option" data-value="0.40">40%</button>
                    </div>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                
                <div class="gift-card-item">
                    <img src="/assets/image/2membership.jpg" alt="Birthday Gift Card">
                    <h3>Member Gift Card</h3>
                    <p>Celebrate with bubble tea</p>
                    <div class="price-options">
                        <button class="price-option active" data-value="0.15">15%</button>
                        <button class="price-option" data-value="0.25">25%</button>
                        <button class="price-option" data-value="0.35">35%</button>
                    </div>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                
                <div class="gift-card-item">
                    <img src="/assets/image/holyday.jpg" alt="Holiday Gift Card">
                    <h3>Holiday Gift Card</h3>
                    <p>Seasonal special design</p>
                    <div class="price-options">
                        <button class="price-option active" data-value="0.25">25%</button>
                        <button class="price-option" data-value="0.50">50%</button>
                        <button class="price-option" data-value="0.70">70%</button>
                    </div>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
            </div>
        </div>
    </section>

    <section class="gift-card-info">
        <div class="container">
            <h2>Gift Card Information</h2>
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
            </div>
        </div>
    </section>

    <script src="/assets/js/gift-card.js"></script>
</body>
</html>