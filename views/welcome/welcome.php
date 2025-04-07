<style>
    /* Main Styles for Welcome and Order Pages */
    @import url("https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Lobster&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    background: #fdf8f2;
    font-family: "Poppins", sans-serif;
    color: #333;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}


/* Layout Structure */

.main-container {
    display: flex;
    min-height: 100vh;
    justify-content: center;
}

.section-sidebar {
    width: 250px;
    min-width: 250px;
    background-color: #fff;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 900;
}

.content {
    flex: 1;
    margin-left: 250px;
    /* Same as sidebar width */
    padding: 20px;
    padding-top: 90px;
    /* Space for fixed header */
    min-height: 100vh;
    position: relative;
    top: 70px;
}


/* Header Styles - Fixed at the top */

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 5%;
    background: #ff6769;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 70px;
    z-index: 1000;
}

header img {
    width: 50px;
    height: auto;
}

nav {
    flex: 1;
    text-align: center;
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    padding: 0;
    margin: 0;
}

nav ul li {
    display: inline-block;
    margin: 0 10px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    font-weight: 600;
    font-size: 16px;
    padding: 8px 12px;
    transition: all 0.3s;
    border-radius: 8px;
}

nav ul li a:hover {
    color: #000000;
    background-color: rgba(255, 255, 255, 0.3);
}

.search-bar {
    position: relative;
    margin-right: 15px;
}

.search-bar input {
    padding: 10px 15px;
    width: 250px;
    border-radius: 20px;
    border: none;
    outline: none;
    font-size: 14px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.order-search {
    background: #ff3b30;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 20px;
    font-weight: bold;
    transition: all 0.3s;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.order-search:hover {
    background: #e62e24;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}


/* User Profile in Header */

.user-profile {
    display: flex;
    align-items: center;
    margin-left: 15px;
    cursor: pointer;
    position: relative;
}

.user-profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.notification-icon {
    position: relative;
    margin-left: 15px;
    cursor: pointer;
}

.notification-icon i {
    font-size: 22px;
    color: white;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff3b30;
    color: white;
    font-size: 10px;
    font-weight: bold;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* Auth buttons container */
.auth-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    /* Play Button (No border) */
    .play-button {
        background: black;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    /* Sign In Button (White - No border) */
    .sign-in-button {
        background: white;
        color:  #ff2a2a;
        padding: 10px 22px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    /* Sign Out Button (Black - No border) */
    .sign-out-button {
        background:  #ff2a2a;
        color: white;
        padding: 10px 22px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    /* Hover effects */
    .play-button:hover {
        background: #333;
        transform: scale(1.05);
    }

    .sign-in-button:hover {
        background: #f5f5f5;
        transform: translateY(-2px);
    }

    .sign-out-button:hover {
        background: #333;
        transform: translateY(-2px);
    }


/* Discount Banner */

.discount-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #ff9a9e 0%, #ff5e62 100%);
    border-radius: 16px;
    padding: 40px 60px;
    margin: 0;
    height: 30vh;
    width: 100%;
    /* Change to 100% for responsiveness */
    position: relative;
    color: white;
    box-sizing: border-box;
}

.banner-content {
    z-index: 1;
    max-width: 600px;
}

.discount-banner img {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    object-fit: cover;
    width: 100%;
    height: 100%;
    opacity: 0.5;
    /* Slightly transparent */
}

.btn-primary {
    background-color: #ff5e62;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #ff9a9e;
}

.discount-banner h2 {
    font-size: 24px;
    margin: 0 0 10px;
}

.discount-banner p {
    font-size: 16px;
    margin: 0 0 15px;
    opacity: 0.9;
}

.discount-banner button {
    background: white;
    color: #ff5e62;
    border: none;
    padding: 10px 20px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.discount-banner button:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
}

.header-banner img {
    width: 200%;
    /* Make the image bigger */
    max-width: 500px;
    display: block;
    margin: auto;
    border-radius: 20px;
    transition: transform 0.3s ease-in-out, filter 0.3s ease-in-out;
}

.header-banner img:hover {
    transform: scale(1.1);
    /* Zoom effect */
    filter: brightness(1.1);
    /* Make it slightly brighter */
}

.wave-text {
    font-size: 28px;
    font-weight: bold;
    color: #ff6363;
    animation: waveEffect 1.5s infinite alternate;
    margin: 10px 0;
}

@keyframes waveEffect {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-5px);
    }
}

.social-media {
    margin-top: 15px;
}

.social-icon {
    display: inline-block;
    margin-right: 10px;
    text-decoration: none;
    font-weight: bold;
    color: #ff6363;
    transition: color 0.3s ease-in-out;
}

.social-icon:hover {
    color: #ff2a2a;
}


/* Category Section */

.category-section {
    display: flex;
    /* Use flexbox for layout */
    justify-content: space-between;
    /* Space items between left and right */
    align-items: center;
    /* Vertically align items */
    margin-bottom: 30px;
    position: relative;
    top: 20px;
}

.category-list {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 0;
    /* Remove bottom margin for alignment */
    justify-content: flex-start;
    /* Align category items to the left */
}

.category-item {
    padding: 12px 20px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 600;
    color: #666;
    cursor: pointer;
    transition: all 0.3s;
}

.category-item.active,
.category-item:hover {
    background: #ff5e62;
    color: white;
    border-color: #ff5e62;
}

.search-container {
    position: relative;
    display: flex;
    /* Make it flex for alignment */
    justify-content: start;
    /* Align search container to the right */
    width: 25%;
    /* Adjust width if necessary */
    left: 10px;
}

.search-container input {
    width: 100%;
    padding: 12px 20px 12px 45px;
    border: 1px solid #ddd;
    border-radius: 30px;
    font-size: 14px;
    transition: all 0.3s;
}

.search-container input:focus {
    outline: none;
    border-color: #ff5e62;
    box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.2);
}

.search-container i {
    position: absolute;
    left: 30px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}


/* Popular Dishes Section */

.popular-dishes {
    margin-bottom: 30px;
}

.popular-dishes h3 {
    font-size: 20px;
    margin: 0 0 20px;
    color: #333;
}

.dishes-list {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}

.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease-in-out;
    width: 30%;
    box-sizing: border-box;
    text-align: center;
    padding-bottom: 15px;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.product-image {
    position: relative;
    height: 140px;
    /* Smaller image */
    width: 140px;
    /* Fixed size for centering */
    margin: 0 auto;
    /* Centering */
    overflow: hidden;
    border-radius: 12px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}

.product-image:hover img {
    transform: scale(1.05);
}

.favorite-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 30px;
    height: 30px;
    background: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.3s;
}

.favorite-btn:hover {
    background: #ff5e62;
    color: white;
}

.product-info {
    padding: 10px;
    text-align: center;
}

.product-info h4 {
    font-size: 16px;
    margin: 0 0 5px;
    color: #333;
}

.description {
    font-size: 14px;
    color: #666;
    margin: 0 auto 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 90%;
}

.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 15px 15px;
}

.product-price {
    font-size: 18px;
    font-weight: 700;
    color: #ff5e62;
}

.btn-primary {
    padding: 8px 12px;
    background: #ff5e62;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease-in-out, transform 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-primary:hover {
    background: #e62e24;
    transform: translateY(-2px);
}

#no-product-message {
    grid-column: 1 / -1;
    text-align: center;
    padding: 30px;
    background: #f9f9f9;
    border-radius: 8px;
    color: #666;
    font-size: 16px;
}


/* Modal Styles */

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transform: translateY(20px);
    transition: all 0.3s;
}

.modal-overlay.active .modal-container {
    transform: translateY(0);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #eee;
}

.modal-header h3 {
    font-size: 20px;
    margin: 0;
    color: #333;
}

.close-modal {
    background: transparent;
    border: none;
    font-size: 20px;
    color: #999;
    cursor: pointer;
    transition: all 0.3s;
}

.close-modal:hover {
    color: #ff5e62;
}

.modal-body {
    padding: 25px;
    overflow-y: auto;
}

.product-details {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.modal-product-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
}

.modal-product-info {
    flex: 1;
}

.modal-product-name {
    font-size: 18px;
    margin: 0 0 5px;
    color: #333;
}

.modal-product-description {
    font-size: 14px;
    color: #666;
    margin: 0 0 10px;
}

.modal-product-price {
    font-size: 18px;
    font-weight: 700;
    color: #ff5e62;
}

.modal-divider {
    border: none;
    height: 1px;
    background: #eee;
    margin: 20px 0;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

.form-group .optional {
    font-size: 12px;
    font-weight: normal;
    color: #999;
}

.option-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.option-button {
    flex: 1;
    min-width: 80px;
    position: relative;
    cursor: pointer;
}

.option-button input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.option-button span {
    display: block;
    padding: 10px 15px;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
    transition: all 0.3s;
}

.option-button small {
    display: block;
    font-size: 12px;
    color: #999;
    margin-top: 5px;
}

.option-button input:checked+span {
    background: #ff5e62;
    color: white;
    border-color: #ff5e62;
}

.option-button input:checked+span+small {
    color: #ff5e62;
}

.toppings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 10px;
}

.topping-option {
    position: relative;
    display: flex;
    align-items: center;
    padding: 10px 15px;
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.topping-option input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.topping-option span {
    flex: 1;
    font-size: 14px;
    padding-left: 25px;
    position: relative;
}

.topping-option span::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: white;
}

.topping-option input:checked+span::before {
    background: #ff5e62;
    border-color: #ff5e62;
}

.topping-option input:checked+span::after {
    content: '✓';
    position: absolute;
    left: 4px;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    font-size: 12px;
}

.topping-option small {
    font-size: 12px;
    color: #999;
}

textarea {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    resize: vertical;
    min-height: 80px;
    transition: all 0.3s;
}

textarea:focus {
    outline: none;
    border-color: #ff5e62;
    box-shadow: 0 0 0 2px rgba(255, 94, 98, 0.2);
}

.quantity-control {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 20px 0;
}

.quantity-control label {
    font-size: 16px;
    font-weight: 600;
    color: #333;
}

.quantity-buttons {
    display: flex;
    align-items: center;
}

.quantity-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f8f9fa;
    border: 1px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
}

.quantity-btn:hover {
    background: #ff5e62;
    color: white;
    border-color: #ff5e62;
}

.quantity-buttons input {
    width: 50px;
    height: 36px;
    text-align: center;
    border: 1px solid #ddd;
    margin: 0 10px;
    font-size: 16px;
}

.total-price {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    border-top: 1px solid #eee;
    margin: 20px 0;
    font-size: 18px;
    font-weight: 600;
}

.price-value {
    color: #ff5e62;
}

.form-actions {
    display: flex;
    gap: 15px;
}

.form-actions button {
    flex: 1;
    padding: 12px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-actions button i {
    margin-right: 8px;
}

.btn-secondary {
    background: white;
    color: #333;
    border: 1px solid #ddd;
}

.btn-secondary:hover {
    background: #f5f5f5;
}


/* Toast Notification */

.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    min-width: 300px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    animation: slideIn 0.3s forwards;
}

.toast.success {
    border-left: 4px solid #43a047;
}

.toast.error {
    border-left: 4px solid #e53935;
}

.toast.info {
    border-left: 4px solid #039be5;
}

.toast-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.toast.success .toast-icon {
    background: #43a047;
}

.toast.error .toast-icon {
    background: #e53935;
}

.toast.info .toast-icon {
    background: #039be5;
}

.toast-content {
    flex: 1;
}

.toast-title {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 5px;
}

.toast-message {
    font-size: 14px;
    color: #666;
    margin: 0;
}

.toast-close {
    background: transparent;
    border: none;
    color: #999;
    cursor: pointer;
    font-size: 16px;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}


/* Responsive Styles */

@media (max-width: 768px) {
    .product-details {
        flex-direction: column;
    }
    .modal-product-image {
        width: 100%;
        height: 150px;
    }
    .option-buttons {
        flex-direction: column;
    }
    .option-button {
        width: 100%;
    }
    .toppings-grid {
        grid-template-columns: 1fr;
    }
    .form-actions {
        flex-direction: column;
    }
    .dishes-list {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}


/* Footer Styles */

.main-footer {
    background-color: #2c3e50;
    /* Dark background color */
    color: #ecf0f1;
    /* Light text color */
    padding: 40px 20px;
    font-family: 'Arial', sans-serif;
    margin-top: 200px;
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-section {
    flex: 1;
    min-width: 200px;
    margin: 10px 20px;
}

.footer-section h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #f1c40f;
    /* Accent color for headings */
}

.footer-section p {
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 15px;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-links a {
    color: #ecf0f1;
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.social-links a:hover {
    color: #f1c40f;
    /* Accent color on hover */
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul li a {
    color: #ecf0f1;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-section ul li a:hover {
    color: #f1c40f;
    /* Accent color on hover */
}

.contact-info li,
.opening-hours li {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 0.9rem;
}

.contact-info i,
.opening-hours i {
    margin-right: 10px;
    color: #f1c40f;
    /* Accent color for icons */
}

.footer-bottom {
    text-align: center;
    margin-top: 20px;
    padding-top: 10px;
    border-top: 1px solid #34495e;
    /* Subtle border for separation */
    font-size: 0.8rem;
    color: #bdc3c7;
}


/* Responsive Design */

@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .footer-section {
        margin: 10px 0;
    }
    .social-links {
        justify-content: center;
    }
}


/* Global Styles */

:root {
    --primary-color: #fe356b;
    /* Pink - brand color */
    --primary-dark: #f61d53;
    --primary-light: #f06ca6;
    --secondary-color: #6f42c1;
    /* Purple - accent color */
    --secondary-dark: #5a36a0;
    --secondary-light: #8c68d6;
    --dark-color: #343a40;
    --light-color: #f8f9fa;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --info-color: #17a2b8;
    --border-color: #dee2e6;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 20px rgba(0, 0, 0, 0.15);
    --transition: all 0.3s ease;
    --border-radius: 8px;
    --border-radius-lg: 12px;
    --border-radius-sm: 4px;
    --font-family: "Poppins", sans-serif;
    --font-size-base: 1rem;
    --font-size-lg: 1.25rem;
    --font-size-sm: 0.875rem;
    --font-size-xs: 0.75rem;
    --font-weight-normal: 400;
    --font-weight-medium: 500;
    --font-weight-bold: 700;
    --line-height-base: 1.6;
    --container-width: 1200px;
    --header-height: 80px;
    --footer-height: 300px;
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    --spacing-xxl: 3rem;
}

html {
    scroll-behavior: smooth;
}

.container {
    width: 100%;
    max-width: var(--container-width);
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
    top: 2000px;
}

a {
    text-decoration: none;
    color: var(--primary-color);
    transition: var(--transition);
}

a:hover {
    color: var(--primary-dark);
}

button {
    cursor: pointer;
    transition: var(--transition);
    font-family: var(--font-family);
}

img {
    max-width: 100%;
    height: auto;
    display: block;
}

ul,
ol {
    list-style: none;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    margin-bottom: var(--spacing-md);
    font-weight: var(--font-weight-bold);
    line-height: 1.3;
}

p {
    margin-bottom: var(--spacing-md);
}

.section-header {
    text-align: center;
    margin-bottom: var(--spacing-xxl);
}

.section-header h2 {
    font-size: 2.5rem;
    margin-bottom: var(--spacing-sm);
    position: relative;
    display: inline-block;
}

.section-header h2::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: var(--primary-color);
}

.section-header p {
    font-size: var(--font-size-lg);
    color: #6c757d;
    max-width: 700px;
    margin: 0 auto;
}


/* Buttons */

.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: var(--border-radius);
    font-weight: var(--font-weight-medium);
    text-align: center;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    font-size: var(--font-size-base);
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: white;
}

.btn-secondary:hover {
    background-color: var(--secondary-dark);
    transform: translateY(-2px);
}

.btn-outline {
    background-color: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.btn-lg {
    padding: 14px 28px;
    font-size: var(--font-size-lg);
}

.btn-sm {
    padding: 8px 16px;
    font-size: var(--font-size-sm);
}

.btn-icon {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-icon i {
    font-size: 1.1em;
}


/* Forms */

.form-group {
    margin-bottom: var(--spacing-lg);
}

.form-group label {
    display: block;
    margin-bottom: var(--spacing-sm);
    font-weight: var(--font-weight-medium);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-family: var(--font-family);
    font-size: var(--font-size-base);
    transition: var(--transition);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(232, 62, 140, 0.1);
}

.form-group .form-hint {
    font-size: var(--font-size-sm);
    color: #6c757d;
    margin-top: var(--spacing-xs);
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-lg);
}

.form-row .form-group {
    flex: 1;
    min-width: 250px;
}

.form-row .form-group.full-width {
    flex-basis: 100%;
}

.required {
    color: var(--danger-color);
}


/* Checkbox and Radio Styles */

.checkbox-label,
.radio-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-custom,
.radio-custom {
    position: relative;
    display: inline-block;
    width: 18px;
    height: 18px;
    background-color: white;
    border: 1px solid var(--border-color);
    border-radius: 3px;
    vertical-align: middle;
    transition: var(--transition);
}

.radio-custom {
    border-radius: 50%;
}

.checkbox-label input,
.radio-label input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkbox-label input:checked~.checkbox-custom::after {
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: var(--primary-color);
    font-size: 12px;
}

.radio-label input:checked~.radio-custom::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: var(--primary-color);
}

.checkbox-label:hover .checkbox-custom,
.radio-label:hover .radio-custom {
    border-color: var(--primary-color);
}


/* Hero Section Styles */

.hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/hero-bg.jpg") center / cover no-repeat;
    color: white;
    text-align: center;
    padding: 120px 20px;
    margin-bottom: 60px;
    position: relative;
    overflow: hidden;
}

.hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(232, 62, 140, 0.3), rgba(111, 66, 193, 0.3));
    z-index: 1;
}

.hero .container {
    position: relative;
    z-index: 2;
}

.hero h1 {
    font-size: 3.5rem;
    margin-bottom: 20px;
    font-weight: 800;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    animation: fadeInDown 1s ease;
}

.hero p {
    font-size: 1.4rem;
    max-width: 800px;
    margin: 0 auto 30px;
    opacity: 0.9;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    animation: fadeInUp 1s ease 0.3s both;
}


/* Breadcrumbs */

.breadcrumbs {
    margin-bottom: var(--spacing-lg);
    font-size: var(--font-size-sm);
    color: #6c757d;
}

.breadcrumbs a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumbs a:hover {
    color: var(--primary-color);
}

.breadcrumbs span {
    color: var(--dark-color);
}


/* Cards */

.card {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: var(--transition);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.card-image {
    position: relative;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.card:hover .card-image img {
    transform: scale(1.05);
}

.card-content {
    padding: var(--spacing-lg);
}

.card-title {
    font-size: 1.3rem;
    margin-bottom: var(--spacing-sm);
}

.card-text {
    color: #6c757d;
    margin-bottom: var(--spacing-md);
}

.card-footer {
    padding: var(--spacing-md) var(--spacing-lg);
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}


/* Badges */

.badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 50px;
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge.primary {
    background-color: var(--primary-light);
    color: white;
}

.badge.secondary {
    background-color: var(--secondary-light);
    color: white;
}

.badge.success {
    background-color: var(--success-color);
    color: white;
}

.badge.warning {
    background-color: var(--warning-color);
    color: var(--dark-color);
}

.badge.danger {
    background-color: var(--danger-color);
    color: white;
}

.badge.info {
    background-color: var(--info-color);
    color: white;
}


/* Alerts */

.alert {
    padding: var(--spacing-md) var(--spacing-lg);
    border-radius: var(--border-radius);
    margin-bottom: var(--spacing-lg);
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
}

.alert-icon {
    font-size: 1.5rem;
}

.alert-content {
    flex: 1;
}

.alert-content h4 {
    margin-bottom: var(--spacing-xs);
}

.alert-success {
    background-color: rgba(40, 167, 69, 0.1);
    border-left: 4px solid var(--success-color);
    color: var(--success-color);
}

.alert-warning {
    background-color: rgba(255, 193, 7, 0.1);
    border-left: 4px solid var(--warning-color);
    color: #856404;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border-left: 4px solid var(--danger-color);
    color: var(--danger-color);
}

.alert-info {
    background-color: rgba(23, 162, 184, 0.1);
    border-left: 4px solid var(--info-color);
    color: var(--info-color);
}


/* Modals */

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    overflow-y: auto;
    padding: 50px 0;
    animation: fadeIn 0.3s ease;
}

.modal-content {
    background-color: white;
    border-radius: var(--border-radius);
    max-width: 600px;
    margin: 0 auto;
    padding: var(--spacing-xl);
    position: relative;
    animation: slideInUp 0.4s ease;
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 1.5rem;
    cursor: pointer;
    color: #aaa;
    transition: var(--transition);
}

.close-modal:hover {
    color: var(--dark-color);
}

.modal.active {
    display: block;
}


/* Tabs */

.tabs-container {
    margin-bottom: var(--spacing-xxl);
}

.tabs-header {
    display: flex;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: var(--spacing-lg);
    overflow-x: auto;
    scrollbar-width: none;
    /* Firefox */
}

.tabs-header::-webkit-scrollbar {
    display: none;
    /* Chrome, Safari, Edge */
}

.tab-btn {
    padding: var(--spacing-md) var(--spacing-lg);
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    font-weight: var(--font-weight-medium);
    color: #6c757d;
    cursor: pointer;
    transition: var(--transition);
    white-space: nowrap;
}

.tab-btn:hover {
    color: var(--primary-color);
}

.tab-btn.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
}

.tab-panel {
    display: none;
    animation: fadeIn 0.5s ease;
}

.tab-panel.active {
    display: block;
}


/* Accordions */

.faq-accordion {
    max-width: 800px;
    margin: 0 auto;
}

.faq-item {
    margin-bottom: var(--spacing-md);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.faq-question {
    background-color: #f8f9fa;
    padding: var(--spacing-md) var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: var(--transition);
}

.faq-question h3 {
    font-size: 1.1rem;
    margin: 0;
    font-weight: var(--font-weight-medium);
}

.faq-question i {
    transition: transform 0.3s ease;
    color: var(--primary-color);
}

.faq-item.active .faq-question {
    background-color: #f0f0f0;
}

.faq-item.active .faq-question i {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
}

.faq-item.active .faq-answer {
    padding: var(--spacing-lg);
    max-height: 1000px;
}


/* Pagination */

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: var(--spacing-xl);
    gap: var(--spacing-md);
}

.pagination-btn {
    padding: 8px 16px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background-color: white;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 5px;
}

.pagination-btn:hover:not(:disabled) {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-info {
    font-size: var(--font-size-sm);
    color: #6c757d;
}


/* Tooltips */

.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltip-text {
    visibility: hidden;
    width: 120px;
    background-color: var(--dark-color);
    color: white;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
    font-size: var(--font-size-xs);
}

.tooltip .tooltip-text::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: var(--dark-color) transparent transparent transparent;
}

.tooltip:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}


/* Toasts */

.toast-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.toast {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 15px 20px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-width: 300px;
    max-width: 400px;
    animation: slideInRight 0.3s ease;
}

.toast.toast-hiding {
    animation: slideOutRight 0.3s ease forwards;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.toast-content i {
    font-size: 1.2rem;
}

.toast-close {
    background: none;
    border: none;
    color: #aaa;
    cursor: pointer;
    transition: var(--transition);
}

.toast-close:hover {
    color: var(--dark-color);
}

.toast-success {
    border-left: 4px solid var(--success-color);
}

.toast-success i {
    color: var(--success-color);
}

.toast-error {
    border-left: 4px solid var(--danger-color);
}

.toast-error i {
    color: var(--danger-color);
}

.toast-info {
    border-left: 4px solid var(--info-color);
}

.toast-info i {
    color: var(--info-color);
}

.toast-warning {
    border-left: 4px solid var(--warning-color);
}

.toast-warning i {
    color: var(--warning-color);
}


/* Loaders */

.loader {
    display: inline-block;
    width: 40px;
    height: 40px;
    border: 3px solid rgba(232, 62, 140, 0.3);
    border-radius: 50%;
    border-top-color: var(--primary-color);
    animation: spin 1s ease-in-out infinite;
}

.loader-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: var(--spacing-xl) 0;
}

.loader-text {
    margin-left: var(--spacing-md);
    color: #6c757d;
}


/* CTA Section */

.cta-section {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/cta-bg.jpg") center / cover no-repeat;
    padding: 80px 0;
    margin: 60px 0;
    position: relative;
}

.cta-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(232, 62, 140, 0.7), rgba(111, 66, 193, 0.7));
    z-index: 1;
}

.cta-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    max-width: 800px;
    margin: 0 auto;
}

.cta-content h2 {
    font-size: 2.5rem;
    margin-bottom: var(--spacing-md);
}

.cta-content p {
    font-size: var(--font-size-lg);
    margin-bottom: var(--spacing-lg);
    opacity: 0.9;
}

.cta-button {
    display: inline-block;
    background-color: white;
    color: var(--primary-color);
    padding: 14px 30px;
    border-radius: 50px;
    font-weight: var(--font-weight-bold);
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: var(--transition);
}

.cta-button:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: var(--spacing-md);
    flex-wrap: wrap;
}

.cta-button.primary {
    background-color: white;
    color: var(--primary-color);
}

.cta-button.primary:hover {
    background-color: var(--primary-color);
    color: white;
}

.cta-button.secondary {
    background-color: transparent;
    color: white;
    border: 2px solid white;
}

.cta-button.secondary:hover {
    background-color: white;
    color: var(--primary-color);
}


/* Animations */

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInUp {
    from {
        transform: translateY(50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideInDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideInLeft {
    from {
        transform: translateX(-50px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideInRight {
    from {
        transform: translateX(50px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(50px);
        opacity: 0;
    }
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes bounce {
    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}

@keyframes shake {
    0%,
    100% {
        transform: translateX(0);
    }
    10%,
    30%,
    50%,
    70%,
    90% {
        transform: translateX(-5px);
    }
    20%,
    40%,
    60%,
    80% {
        transform: translateX(5px);
    }
}


/* Responsive Styles */

@media (max-width: 1200px) {
     :root {
        --container-width: 960px;
    }
}

@media (max-width: 992px) {
     :root {
        --container-width: 720px;
    }
    .section-header h2 {
        font-size: 2.2rem;
    }
    .hero h1 {
        font-size: 3rem;
    }
    .hero p {
        font-size: 1.2rem;
    }
}

@media (max-width: 768px) {
     :root {
        --container-width: 540px;
    }
    .section-header h2 {
        font-size: 2rem;
    }
    .hero {
        padding: 80px 20px;
    }
    .hero h1 {
        font-size: 2.5rem;
    }
    .hero p {
        font-size: 1.1rem;
    }
    .form-row {
        flex-direction: column;
        gap: var(--spacing-md);
    }
    .cta-content h2 {
        font-size: 2rem;
    }
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 576px) {
     :root {
        --container-width: 100%;
    }
    .section-header h2 {
        font-size: 1.8rem;
    }
    .hero h1 {
        font-size: 2rem;
    }
    .hero p {
        font-size: 1rem;
    }
    .tabs-header {
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    .tab-btn {
        padding: 10px 15px;
        font-size: var(--font-size-sm);
    }
    .modal-content {
        padding: var(--spacing-md);
        max-width: 90%;
    }
    .toast {
        min-width: auto;
        max-width: 90%;
    }
}


/* Gift Card Page Styles */

.section-praents {
    position: relative;
    bottom: 800px;
    margin-bottom: 1400px;
    position: relative;
}

.section-praents-location {
    position: relative;
    bottom: 20px;
    margin-bottom: 1400px;
    position: relative;
}

.section-praents-join-team {
    position: relative;
    bottom: 20px;
    margin-bottom: 1400px;
    position: relative;
    top: 240px;
}

.gift-card-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/gift-card-hero.jpg") center / cover no-repeat;
}

.gift-card-options {
    padding: 60px 0;
    position: relative;
}

.gift-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.gift-card-item {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    animation: fadeIn 0.8s ease;
}

.gift-card-item:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.gift-card-image {
    position: relative;
    overflow: hidden;
}

.gift-card-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gift-card-item:hover .gift-card-image img {
    transform: scale(1.08);
}

.card-overlay {
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.7);
    padding: 15px;
    transition: bottom 0.3s ease;
    text-align: center;
}

.gift-card-item:hover .card-overlay {
    bottom: 0;
}

.view-details-btn {
    color: white;
    font-weight: var(--font-weight-medium);
    display: inline-block;
    transition: var(--transition);
}

.view-details-btn:hover {
    color: var(--primary-light);
}

.gift-card-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.gift-card-content h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: var(--dark-color);
}

.card-description {
    margin-bottom: 20px;
    color: #6c757d;
}

.price-options {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 25px;
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
    border-color: var(--primary-color);
}

.price-option.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.add-to-cart-btn {
    background-color: var(--secondary-color);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 12px 20px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.add-to-cart-btn:hover {
    background-color: var(--secondary-dark);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(111, 66, 193, 0.3);
}

.how-it-works {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.steps-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.step-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    box-shadow: var(--shadow);
    flex: 1;
    min-width: 220px;
    max-width: 280px;
    transition: var(--transition);
    position: relative;
}

.step-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.step-item:not(:last-child)::after {
    content: "\f054";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: -20px;
    transform: translateY(-50%);
    color: var(--primary-color);
    font-size: 20px;
    z-index: 1;
}

.step-icon {
    width: 70px;
    height: 70px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.step-icon i {
    font-size: 30px;
    color: var(--primary-color);
}

.step-item h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: var(--dark-color);
}

.step-item p {
    color: #6c757d;
}

.gift-card-info {
    padding: 60px 0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}

.info-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
    border-top: 3px solid var(--primary-color);
}

.info-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
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


/* Gift Card Details Page */

.gift-card-details {
    padding: 40px 0 60px;
}

.gift-card-details-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.gift-card-image-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.gift-card-image {
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

.gift-card-image img {
    width: 100%;
    height: auto;
    transition: transform 0.5s ease;
}

.gift-card-thumbnails {
    display: flex;
    gap: 10px;
}

.thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 5px;
    overflow: hidden;
    cursor: pointer;
    opacity: 0.7;
    transition: var(--transition);
    border: 2px solid transparent;
}

.thumbnail.active {
    opacity: 1;
    border-color: var(--primary-color);
}

.thumbnail:hover {
    opacity: 1;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gift-card-info {
    padding: 0;
}

.gift-card-info h2 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.card-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 20px;
}

.card-rating i {
    color: #ffc107;
}

.card-rating span {
    color: #6c757d;
    font-size: var(--font-size-sm);
    margin-left: 5px;
}

.description {
    font-size: var(--font-size-lg);
    margin-bottom: 25px;
    color: #6c757d;
}

.discount-options {
    margin-bottom: 25px;
}

.discount-options h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.options-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.option-item {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 15px;
    border: 2px solid #dee2e6;
    border-radius: 5px;
    cursor: pointer;
    transition: var(--transition);
}

.option-item input {
    display: none;
}

.option-item:hover {
    border-color: var(--primary-color);
}

.option-item.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.recipient-info {
    margin-bottom: 25px;
}

.recipient-info h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.char-count {
    text-align: right;
    font-size: var(--font-size-sm);
    color: #6c757d;
    margin-top: 5px;
}

.delivery-options {
    margin-bottom: 25px;
}

.delivery-options h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.gift-card-actions {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
}

.quantity-selector {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    overflow: hidden;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    background-color: #f8f9fa;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.quantity-btn:hover {
    background-color: #e9ecef;
}

.quantity-selector input {
    width: 50px;
    height: 40px;
    border: none;
    text-align: center;
    font-weight: var(--font-weight-medium);
}

.btn-add-to-cart {
    flex: 1;
    background-color: var(--secondary-color);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 0 20px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-add-to-cart:hover {
    background-color: var(--secondary-dark);
}

.btn-buy-now {
    flex: 1;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 0 20px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-buy-now:hover {
    background-color: var(--primary-dark);
}

.gift-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: var(--font-size-sm);
}

.meta-item i {
    color: var(--primary-color);
}

.gift-card-details-tabs {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.usage-steps {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.usage-step {
    display: flex;
    gap: 20px;
}

.step-number {
    width: 40px;
    height: 40px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: var(--font-weight-bold);
    flex-shrink: 0;
}

.step-content h4 {
    margin-bottom: 5px;
}

.reviews-summary {
    display: flex;
    gap: 30px;
    margin-bottom: 30px;
}

.average-rating {
    text-align: center;
    padding: 20px;
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    flex-shrink: 0;
}

.rating-number {
    font-size: 3rem;
    font-weight: var(--font-weight-bold);
    color: var(--dark-color);
    line-height: 1;
}

.rating-stars {
    margin: 10px 0;
}

.rating-stars i {
    color: #ffc107;
    font-size: 1.2rem;
}

.rating-count {
    font-size: var(--font-size-sm);
    color: #6c757d;
}

.rating-breakdown {
    flex: 1;
}

.rating-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.rating-label {
    width: 60px;
    font-size: var(--font-size-sm);
}

.progress-bar {
    flex: 1;
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress {
    height: 100%;
    background-color: #ffc107;
}

.rating-percent {
    width: 40px;
    text-align: right;
    font-size: var(--font-size-sm);
    color: #6c757d;
}

.review-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.review-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: var(--shadow);
}

.reviewer-info {
    display: flex;
    gap: 15px;
    margin-bottom: 10px;
}

.reviewer-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
}

.reviewer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.reviewer-details h4 {
    margin-bottom: 5px;
}

.review-date {
    font-size: var(--font-size-sm);
    color: #6c757d;
}

.review-rating {
    margin-bottom: 10px;
}

.review-rating i {
    color: #ffc107;
}

.load-more-reviews {
    text-align: center;
    margin-top: 30px;
}

.load-more-btn {
    background-color: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.load-more-btn:hover {
    background-color: var(--primary-color);
    color: white;
}

.related-gift-cards {
    padding: 60px 0;
}

.related-cards-slider {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding: 10px 0 20px;
    scrollbar-width: thin;
}

.related-cards-slider::-webkit-scrollbar {
    height: 6px;
}

.related-cards-slider::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.related-cards-slider::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

.related-cards-slider::-webkit-scrollbar-thumb:hover {
    background: #aaa;
}

.related-card {
    min-width: 200px;
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    text-align: center;
    padding-bottom: 15px;
}

.related-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.related-card-image {
    margin-bottom: 15px;
}

.related-card-image img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.related-card h3 {
    font-size: 1.1rem;
    margin-bottom: 15px;
    padding: 0 15px;
}

.view-card-btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: var(--font-size-sm);
    transition: var(--transition);
}

.view-card-btn:hover {
    background-color: var(--primary-dark);
    color: white;
}


/* Locations Page Styles */

.locations-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/locations-hero.jpg") center / cover no-repeat;
}

.location-finder {
    padding: 50px 0;
}

.finder-container {
    max-width: 800px;
    margin: 0 auto;
}

.finder-header {
    text-align: center;
    margin-bottom: 30px;
}

.finder-header h2 {
    font-size: 2rem;
    margin-bottom: 10px;
}

.finder-header p {
    color: #6c757d;
}

.search-container {
    margin-bottom: 20px;
}

.search-input-wrapper {
    position: relative;
    margin-bottom: 15px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.search-input-wrapper input {
    width: 100%;
    padding: 15px 15px 15px 45px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: var(--font-size-base);
}

.location-btn {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--primary-color);
    cursor: pointer;
    font-size: 1.2rem;
}

.search-btn {
    width: 100%;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    padding: 15px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.search-btn:hover {
    background-color: var(--primary-dark);
}

.filter-toggle {
    margin-bottom: 15px;
}

#filterToggleBtn {
    width: 100%;
    background-color: #f8f9fa;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: var(--transition);
}

#filterToggleBtn:hover {
    background-color: #e9ecef;
}

.filter-options {
    display: none;
    background-color: white;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 20px;
    margin-bottom: 20px;
}

.filter-section {
    margin-bottom: 20px;
}

.filter-section h3 {
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 10px;
}

.filter-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.apply-filters-btn {
    flex: 1;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    padding: 10px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.apply-filters-btn:hover {
    background-color: var(--primary-dark);
}

.reset-filters-btn {
    flex: 1;
    background-color: #f8f9fa;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 10px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.reset-filters-btn:hover {
    background-color: #e9ecef;
}

.location-results {
    padding-bottom: 60px;
}

.results-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.map-container {
    position: sticky;
    top: 20px;
    height: calc(100vh - 40px);
    max-height: 700px;
}

#storeMap {
    width: 100%;
    height: 100%;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

.locations-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.locations-header h3 {
    font-size: 1.3rem;
    margin-bottom: 0;
}

.sort-options {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sort-options select {
    padding: 8px 12px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: var(--font-size-sm);
}

.locations-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.location-card {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
}

.location-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.location-image {
    position: relative;
    height: 200px;
}

.location-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.location-badge {
    position: absolute;
    top: 10px;
    right: 10px;
}

.badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 50px;
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-bold);
    text-transform: uppercase;
}

.new-badge {
    background-color: var(--primary-color);
    color: white;
}

.location-info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.location-info h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
}

.location-meta {
    margin-bottom: 15px;
}

.location-meta p {
    margin-bottom: 5px;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 8px;
}

.location-meta p i {
    color: var(--primary-color);
    width: 16px;
}

.location-features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 15px;
}

.feature-tag {
    background-color: #f8f9fa;
    padding: 5px 10px;
    border-radius: 50px;
    font-size: var(--font-size-xs);
    display: flex;
    align-items: center;
    gap: 5px;
}

.feature-tag i {
    color: var(--primary-color);
}

.location-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: auto;
}

.btn-directions,
.btn-view-details,
.btn-order-online {
    flex: 1;
    min-width: 100px;
    padding: 8px 12px;
    border-radius: var(--border-radius);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: var(--transition);
}

.btn-directions {
    background-color: var(--secondary-color);
    color: white;
}

.btn-directions:hover {
    background-color: var(--secondary-dark);
    color: white;
}

.btn-view-details {
    background-color: #f8f9fa;
    color: var(--dark-color);
    border: 1px solid var(--border-color);
}

.btn-view-details:hover {
    background-color: #e9ecef;
}

.btn-order-online {
    background-color: var(--primary-color);
    color: white;
}

.btn-order-online:hover {
    background-color: var(--primary-dark);
    color: white;
}

.no-results {
    text-align: center;
    padding: 40px 0;
}

.no-results i {
    font-size: 3rem;
    color: #ccc;
    margin-bottom: 15px;
}

.no-results h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.no-results p {
    color: #6c757d;
}

.featured-locations {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.featured-slider {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding: 10px 0 20px;
    scrollbar-width: thin;
}

.featured-location {
    min-width: 300px;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.featured-location:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.featured-image {
    position: relative;
    height: 250px;
}

.featured-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    padding: 20px;
    color: white;
}

.featured-overlay h3 {
    font-size: 1.5rem;
    margin-bottom: 5px;
}

.featured-overlay p {
    margin-bottom: 15px;
    opacity: 0.9;
}

.featured-btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: var(--font-size-sm);
    transition: var(--transition);
}

.featured-btn:hover {
    background-color: var(--primary-dark);
    color: white;
}

.location-cta {
    padding: 40px 0;
}


/* Location Details Page Styles */

.location-details-hero {
    position: relative;
    height: 400px;
}

.location-details-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    z-index: 1;
}

.location-details-hero .container {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding-bottom: 50px;
}

.location-details-section {
    padding: 50px 0;
}

.location-details-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.location-info-card {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 25px;
    box-shadow: var(--shadow);
}

.location-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.location-header h2 {
    font-size: 1.8rem;
    margin-bottom: 0;
}

.location-status {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: var(--font-weight-medium);
    padding: 5px 10px;
    border-radius: 50px;
    font-size: var(--font-size-sm);
}

.location-status.open {
    background-color: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

.location-status.closed {
    background-color: rgba(220, 53, 69, 0.1);
    color: var(--danger-color);
}

.location-status i {
    font-size: 10px;
}

.location-contact {
    margin-bottom: 25px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 15px;
}

.contact-item i {
    color: var(--primary-color);
    font-size: 1.2rem;
    margin-top: 3px;
}

.contact-item p {
    margin-bottom: 5px;
}

.location-hours {
    margin-bottom: 25px;
}

.location-hours h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    position: relative;
    padding-bottom: 10px;
}

.location-hours h3::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 2px;
    background-color: var(--primary-color);
}

.hours-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.hours-item {
    display: flex;
    justify-content: space-between;
    padding-bottom: 10px;
    border-bottom: 1px dashed #eee;
}

.day {
    font-weight: var(--font-weight-medium);
}

.time {
    color: #6c757d;
}

.location-features {
    margin-bottom: 25px;
}

.location-features h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    position: relative;
    padding-bottom: 10px;
}

.location-features h3::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 2px;
    background-color: var(--primary-color);
}

.features-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
}

.feature-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 10px;
}

.feature-item i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.location-actions {
    display: flex;
    gap: 10px;
}

.btn-directions,
.btn-order,
.btn-share {
    flex: 1;
    padding: 12px;
    border-radius: var(--border-radius);
    font-weight: var(--font-weight-medium);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: var(--transition);
}

.btn-directions {
    background-color: var(--secondary-color);
    color: white;
    border: none;
}

.btn-directions:hover {
    background-color: var(--secondary-dark);
}

.btn-order {
    background-color: var(--primary-color);
    color: white;
    border: none;
}

.btn-order:hover {
    background-color: var(--primary-dark);
}

.btn-share {
    background-color: #f8f9fa;
    color: var(--dark-color);
    border: 1px solid var(--border-color);
}

.btn-share:hover {
    background-color: #e9ecef;
}

.location-map-container {
    height: 100%;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

#locationMap {
    flex-grow: 1;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    min-height: 300px;
}

.map-actions {
    display: flex;
    gap: 10px;
}

.map-action-btn {
    flex: 1;
    padding: 12px;
    border-radius: var(--border-radius);
    font-weight: var(--font-weight-medium);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background-color: #f8f9fa;
    color: var(--dark-color);
    border: 1px solid var(--border-color);
    transition: var(--transition);
}

.map-action-btn:hover {
    background-color: #e9ecef;
}

.location-tabs {
    padding: 50px 0;
    background-color: #f8f9fa;
}

.menu-categories {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    margin-bottom: 25px;
    padding-bottom: 10px;
    scrollbar-width: thin;
}

.menu-categories::-webkit-scrollbar {
    height: 6px;
}

.menu-categories::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.menu-categories::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

.menu-categories::-webkit-scrollbar-thumb:hover {
    background: #aaa;
}

.menu-category {
    padding: 10px 20px;
    background-color: white;
    border: 1px solid var(--border-color);
    border-radius: 50px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
    white-space: nowrap;
}

.menu-category:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.menu-category.active {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.menu-category-content {
    display: none;
}

.menu-category-content.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.menu-item {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.menu-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.menu-item-image {
    height: 150px;
}

.menu-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.menu-item-info {
    padding: 15px;
}

.menu-item-info h3 {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.menu-item-info p {
    color: #6c757d;
    font-size: var(--font-size-sm);
    margin-bottom: 10px;
}

.menu-item-price {
    font-weight: var(--font-weight-bold);
    color: var(--primary-color);
    margin-bottom: 15px;
}

.add-to-order-btn {
    width: 100%;
    background-color: var(--secondary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    padding: 8px 12px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.add-to-order-btn:hover {
    background-color: var(--secondary-dark);
}

.view-full-menu {
    text-align: center;
    margin-top: 30px;
}

.view-menu-btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 12px 25px;
    border-radius: 50px;
    font-weight: var(--font-weight-medium);
    transition: var(--transition);
}

.view-menu-btn:hover {
    background-color: var(--primary-dark);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(232, 62, 140, 0.3);
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
}

.gallery-item {
    position: relative;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    cursor: pointer;
}

.gallery-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
    color: white;
    padding: 10px;
    font-size: var(--font-size-sm);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-caption {
    opacity: 1;
}

.reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.write-review-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    padding: 10px 20px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.write-review-btn:hover {
    background-color: var(--primary-dark);
}

.events-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.event-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: var(--shadow);
    display: flex;
    gap: 20px;
}

.event-date {
    width: 80px;
    height: 80px;
    background-color: var(--primary-color);
    color: white;
    border-radius: var(--border-radius);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    flex-shrink: 0;
}

.event-month {
    font-size: var(--font-size-sm);
    text-transform: uppercase;
    font-weight: var(--font-weight-medium);
}

.event-day {
    font-size: 1.8rem;
    font-weight: var(--font-weight-bold);
    line-height: 1;
}

.event-details {
    flex: 1;
}

.event-details h3 {
    font-size: 1.3rem;
    margin-bottom: 5px;
}

.event-time {
    color: #6c757d;
    font-size: var(--font-size-sm);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.event-description {
    margin-bottom: 15px;
}

.event-register-btn {
    display: inline-block;
    background-color: var(--secondary-color);
    color: white;
    padding: 8px 15px;
    border-radius: var(--border-radius);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    transition: var(--transition);
}

.event-register-btn:hover {
    background-color: var(--secondary-dark);
    color: white;
}

.no-events {
    text-align: center;
    padding: 40px 0;
}

.no-events i {
    font-size: 3rem;
    color: #ccc;
    margin-bottom: 15px;
}

.nearby-locations {
    padding: 60px 0;
}

.nearby-locations-slider {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    padding: 10px 0 20px;
    scrollbar-width: thin;
}

.nearby-location {
    min-width: 300px;
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.nearby-location:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.nearby-image {
    height: 150px;
}

.nearby-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.nearby-info {
    padding: 15px;
}

.nearby-info h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.nearby-info p {
    margin-bottom: 5px;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nearby-info p i {
    color: var(--primary-color);
    width: 16px;
}

.nearby-btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 8px 15px;
    border-radius: var(--border-radius);
    font-size: var(--font-size-sm);
    margin-top: 15px;
    transition: var(--transition);
}

.nearby-btn:hover {
    background-color: var(--primary-dark);
    color: white;
}

.share-options {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.share-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 15px;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.share-option i {
    font-size: 1.5rem;
}

.share-option:hover {
    background-color: #f8f9fa;
    transform: translateY(-3px);
}

.share-option#shareFacebook {
    color: #3b5998;
}

.share-option#shareTwitter {
    color: #1da1f2;
}

.share-option#shareWhatsapp {
    color: #25d366;
}

.share-option#shareEmail {
    color: #ea4335;
}

.share-link {
    display: flex;
    gap: 10px;
}

.share-link input {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: var(--font-size-base);
    background-color: #f8f9fa;
    cursor: text;
}

.copy-link-btn {
    background-color: var(--secondary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    padding: 0 15px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 8px;
}

.copy-link-btn:hover {
    background-color: var(--secondary-dark);
}

.rating-selector {
    display: flex;
    gap: 5px;
    margin-bottom: 15px;
}

.rating-selector i {
    font-size: 1.5rem;
    color: #ccc;
    cursor: pointer;
    transition: var(--transition);
}

.rating-selector i:hover,
.rating-selector i.active {
    color: #ffc107;
}


/* Join The Team Page Styles */

.join-team-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/join-team-hero.jpg") center / cover no-repeat;
}

.team-intro {
    padding: 60px 0;
}

.intro-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.intro-text h2 {
    font-size: 2.2rem;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 15px;
}

.intro-text h2::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 3px;
    background-color: var(--primary-color);
}

.intro-text p {
    margin-bottom: 20px;
    font-size: var(--font-size-lg);
    color: #6c757d;
}

.view-positions-btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 12px 25px;
    border-radius: 50px;
    font-weight: var(--font-weight-medium);
    transition: var(--transition);
    margin-top: 10px;
}

.view-positions-btn:hover {
    background-color: var(--primary-dark);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(232, 62, 140, 0.3);
}

.video-container {
    position: relative;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    cursor: pointer;
}

.video-container img {
    width: 100%;
    height: auto;
    display: block;
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background-color: rgba(232, 62, 140, 0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.play-button i {
    color: white;
    font-size: 2rem;
}

.video-container:hover .play-button {
    background-color: var(--primary-color);
    transform: translate(-50%, -50%) scale(1.1);
}

.why-join {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.benefit-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
    border-bottom: 3px solid transparent;
}

.benefit-item:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
    border-bottom-color: var(--primary-color);
}

.benefit-icon {
    width: 80px;
    height: 80px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.benefit-icon i {
    font-size: 2rem;
    color: var(--primary-color);
}

.benefit-item h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: var(--dark-color);
}

.benefit-item p {
    color: #6c757d;
    line-height: 1.6;
}

.team-values {
    padding: 60px 0;
}

.values-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.values-image {
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

.values-image img {
    width: 100%;
    height: auto;
    display: block;
}

.values-text h2 {
    font-size: 2.2rem;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 15px;
}

.values-text h2::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 3px;
    background-color: var(--primary-color);
}

.value-item {
    margin-bottom: 20px;
}

.value-item h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.value-item h3 i {
    color: var(--primary-color);
}

.value-item p {
    color: #6c757d;
    padding-left: 35px;
}

.open-positions {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.positions-filter {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-group label {
    font-weight: var(--font-weight-medium);
}

.filter-group select {
    padding: 10px 15px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: var(--font-size-base);
    min-width: 200px;
}

.positions-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
}

.position-card {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
}

.position-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.position-header {
    padding: 20px;
    background-color: #f8f9fa;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.position-header h3 {
    font-size: 1.3rem;
    margin-bottom: 0;
}

.position-badge {
    display: flex;
    gap: 5px;
}

.badge {
    padding: 5px 10px;
    border-radius: 50px;
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
}

.full-time {
    background-color: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

.part-time {
    background-color: rgba(23, 162, 184, 0.1);
    color: var(--info-color);
}

.position-details {
    padding: 20px;
    flex-grow: 1;
}

.position-type,
.position-location {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    color: #6c757d;
}

.position-type i,
.position-location i {
    color: var(--primary-color);
    width: 16px;
}

.position-desc {
    margin-bottom: 20px;
}

.position-responsibilities,
.position-requirements {
    margin-bottom: 20px;
}

.position-responsibilities h4,
.position-requirements h4 {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: var(--dark-color);
}

.position-responsibilities ul,
.position-requirements ul {
    padding-left: 20px;
    margin-bottom: 15px;
}

.position-responsibilities ul li,
.position-requirements ul li {
    margin-bottom: 5px;
    position: relative;
    padding-left: 15px;
}

.position-responsibilities ul li::before,
.position-requirements ul li::before {
    content: "\f054";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    left: 0;
    top: 2px;
    font-size: 10px;
    color: var(--primary-color);
}

.position-footer {
    padding: 15px 20px;
    border-top: 1px solid var(--border-color);
    display: flex;
    gap: 10px;
}

.btn-apply {
    flex: 1;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    padding: 10px;
    font-weight: var(--font-weight-medium);
    text-align: center;
    transition: var(--transition);
}

.btn-apply:hover {
    background-color: var(--primary-dark);
    color: white;
}

.btn-share-position {
    background-color: #f8f9fa;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    transition: var(--transition);
}

.btn-share-position:hover {
    background-color: #e9ecef;
}

.no-positions {
    text-align: center;
    padding: 40px 0;
}

.application-process {
    padding: 60px 0;
}

.process-steps {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.step {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
    transition: var(--transition);
    flex: 1;
    min-width: 200px;
    max-width: 250px;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.step:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.step:not(:last-child)::after {
    content: "\f054";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: -20px;
    transform: translateY(-50%);
    color: var(--primary-color);
    font-size: 20px;
    z-index: 1;
}

.step-number {
    width: 40px;
    height: 40px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: var(--font-weight-bold);
    margin-bottom: 15px;
}

.step-content {
    text-align: center;
}

.step-content h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.step-content p {
    color: #6c757d;
}

.testimonials {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.testimonials-slider {
    max-width: 900px;
    margin: 0 auto;
    position: relative;
}

.testimonial-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
    display: flex;
    gap: 30px;
    margin: 0 auto;
}

.testimonial-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.testimonial-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.testimonial-content {
    flex: 1;
}

.testimonial-quote {
    position: relative;
    padding-left: 30px;
    margin-bottom: 20px;
}

.testimonial-quote i {
    position: absolute;
    left: 0;
    top: 0;
    color: var(--primary-color);
    font-size: 1.5rem;
    opacity: 0.5;
}

.testimonial-quote p {
    font-style: italic;
    color: #6c757d;
}

.testimonial-author h4 {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.testimonial-position {
    color: var(--primary-color);
    font-size: var(--font-size-sm);
}

.testimonial-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ccc;
    cursor: pointer;
    transition: var(--transition);
}

.dot.active {
    background-color: var(--primary-color);
}


/* Job Application Page Styles */

.application-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/application-hero.jpg") center / cover no-repeat;
}

.application-form-section {
    padding: 50px 0;
}

.form-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.error-message {
    background-color: rgba(220, 53, 69, 0.1);
    border-left: 4px solid var(--danger-color);
    padding: 15px 20px;
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
}

.error-icon {
    color: var(--danger-color);
    font-size: 1.5rem;
    flex-shrink: 0;
}

.error-content h3 {
    color: var(--danger-color);
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.error-content ul {
    padding-left: 20px;
}

.error-content ul li {
    margin-bottom: 5px;
}

.application-progress {
    display: flex;
    background-color: #f8f9fa;
    border-bottom: 1px solid var(--border-color);
}

.progress-step {
    flex: 1;
    padding: 20px 15px;
    text-align: center;
    position: relative;
    cursor: pointer;
}

.progress-step::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: transparent;
    transition: var(--transition);
}

.progress-step.active::after {
    background-color: var(--primary-color);
}

.step-number {
    width: 30px;
    height: 30px;
    background-color: #ccc;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    transition: var(--transition);
}

.progress-step.active .step-number {
    background-color: var(--primary-color);
}

.step-label {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: #6c757d;
    transition: var(--transition);
}

.progress-step.active .step-label {
    color: var(--dark-color);
}

.form-step {
    display: none;
    padding: 30px;
}

.form-step.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h3 {
    font-size: 1.3rem;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
}

.form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.btn-prev,
.btn-next,
.btn-submit {
    padding: 12px 25px;
    border-radius: var(--border-radius);
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.btn-prev {
    background-color: #f8f9fa;
    border: 1px solid var(--border-color);
    color: var(--dark-color);
}

.btn-prev:hover {
    background-color: #e9ecef;
}

.btn-next {
    background-color: var(--secondary-color);
    color: white;
    border: none;
}

.btn-next:hover {
    background-color: var(--secondary-dark);
}

.btn-submit {
    background-color: var(--primary-color);
    color: white;
    border: none;
}

.btn-submit:hover {
    background-color: var(--primary-dark);
}

.availability-grid {
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.availability-header {
    display: grid;
    grid-template-columns: 120px repeat(3, 1fr);
    background-color: #f8f9fa;
    border-bottom: 1px solid var(--border-color);
}

.day-header,
.time-header {
    padding: 10px;
    text-align: center;
    font-weight: var(--font-weight-medium);
}

.availability-row {
    display: grid;
    grid-template-columns: 120px repeat(3, 1fr);
    border-bottom: 1px solid var(--border-color);
}

.availability-row:last-child {
    border-bottom: none;
}

.day-label {
    padding: 10px;
    background-color: #f8f9fa;
    font-weight: var(--font-weight-medium);
    border-right: 1px solid var(--border-color);
}

.time-cell {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
}

.file-upload {
    position: relative;
    margin-bottom: 10px;
}

.file-upload input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

.file-label {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background-color: #f8f9fa;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
}

.file-label:hover {
    background-color: #e9ecef;
}

.file-name {
    margin-top: 5px;
    font-size: var(--font-size-sm);
    color: #6c757d;
}

.radio-group {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
}

.application-tips {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.tip-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.tip-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.tip-icon {
    width: 60px;
    height: 60px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.tip-icon i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.tip-item h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    text-align: center;
}

.tip-item ul {
    padding-left: 20px;
}

.tip-item ul li {
    margin-bottom: 10px;
    position: relative;
    padding-left: 15px;
}

.tip-item ul li::before {
    content: "\f054";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    left: 0;
    top: 2px;
    font-size: 10px;
    color: var(--primary-color);
}


/* More Page Styles */

.more-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/more-hero.jpg") center / cover no-repeat;
}

.more-options {
    padding: 60px 0;
}

.options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
}

.option-card {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.option-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.option-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background-color: var(--primary-color);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.option-card:hover::before {
    transform: scaleX(1);
}

.option-icon {
    width: 80px;
    height: 80px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    transition: var(--transition);
}

.option-card:hover .option-icon {
    background-color: var(--primary-color);
}

.option-icon i {
    font-size: 2rem;
    color: var(--primary-color);
    transition: var(--transition);
}

.option-card:hover .option-icon i {
    color: white;
}

.option-card h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: var(--dark-color);
}

.option-card p {
    color: #6c757d;
    margin-bottom: 20px;
}

.card-arrow {
    opacity: 0;
    transform: translateX(-20px);
    transition: var(--transition);
    color: var(--primary-color);
    font-size: 1.2rem;
}

.option-card:hover .card-arrow {
    opacity: 1;
    transform: translateX(0);
}

.contact-info {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.contact-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.contact-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.contact-icon {
    width: 70px;
    height: 70px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.contact-icon i {
    font-size: 1.8rem;
    color: var(--primary-color);
}

.contact-item h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: var(--dark-color);
}

.contact-item p {
    color: #6c757d;
    margin-bottom: 5px;
}

.contact-hours {
    font-size: var(--font-size-sm);
    color: #6c757d;
    margin-bottom: 20px;
}

.contact-action {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 8px 15px;
    border-radius: 50px;
    font-size: var(--font-size-sm);
    transition: var(--transition);
}

.contact-action:hover {
    background-color: var(--primary-dark);
    color: white;
    transform: translateY(-2px);
}

.contact-form-section {
    padding: 60px 0;
}

.contact-form-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--shadow);
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-actions {
    text-align: center;
    margin-top: 10px;
}

.submit-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 12px 30px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.submit-btn:hover {
    background-color: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(232, 62, 140, 0.3);
}

.social-media {
    padding: 60px 0;
}

.social-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
}

.social-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 25px 20px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.social-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.social-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    transition: var(--transition);
}

.social-item:hover .social-icon {
    transform: scale(1.1);
}

.social-item:nth-child(1) .social-icon {
    background-color: rgba(59, 89, 152, 0.1);
}

.social-item:nth-child(2) .social-icon {
    background-color: rgba(225, 48, 108, 0.1);
}

.social-item:nth-child(3) .social-icon {
    background-color: rgba(29, 161, 242, 0.1);
}

.social-item:nth-child(4) .social-icon {
    background-color: rgba(255, 0, 0, 0.1);
}

.social-item:nth-child(5) .social-icon {
    background-color: rgba(0, 0, 0, 0.1);
}

.social-item:nth-child(6) .social-icon {
    background-color: rgba(0, 119, 181, 0.1);
}

.social-item i {
    font-size: 1.8rem;
}

.social-item:nth-child(1) i {
    color: #3b5998;
}

.social-item:nth-child(2) i {
    color: #e1306c;
}

.social-item:nth-child(3) i {
    color: #1da1f2;
}

.social-item:nth-child(4) i {
    color: #ff0000;
}

.social-item:nth-child(5) i {
    color: #000000;
}

.social-item:nth-child(6) i {
    color: #0077b5;
}

.social-item span {
    font-weight: var(--font-weight-medium);
    margin-bottom: 5px;
}

.social-followers {
    font-size: var(--font-size-sm);
    color: #6c757d;
}

.newsletter-section {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.newsletter-container {
    max-width: 900px;
    margin: 0 auto;
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    display: flex;
}

.newsletter-content {
    flex: 1;
    padding: 40px;
}

.newsletter-content h2 {
    font-size: 1.8rem;
    margin-bottom: 15px;
}

.newsletter-content p {
    color: #6c757d;
    margin-bottom: 25px;
}

.newsletter-input-group {
    display: flex;
    margin-bottom: 15px;
}

.newsletter-input-group input {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 5px 0 0 5px;
    font-size: var(--font-size-base);
}

.newsletter-input-group button {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 0 5px 5px 0;
    padding: 0 20px;
    font-weight: var(--font-weight-medium);
    cursor: pointer;
    transition: var(--transition);
}

.newsletter-input-group button:hover {
    background-color: var(--primary-dark);
}

.newsletter-privacy {
    font-size: var(--font-size-sm);
}

.newsletter-image {
    width: 40%;
    display: flex;
    align-items: stretch;
}

.newsletter-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


/* About Us Page Styles */

.about-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("/assets/image/backgrounds/about-hero.jpg") center / cover no-repeat;
}

.about-intro {
    padding: 60px 0;
}

.intro-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.intro-image {
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

.intro-image img {
    width: 100%;
    height: auto;
    display: block;
}

.intro-text h2 {
    font-size: 2.2rem;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 15px;
}

.intro-text h2::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 3px;
    background-color: var(--primary-color);
}

.intro-text p {
    margin-bottom: 20px;
    font-size: var(--font-size-lg);
    color: #6c757d;
}

.mission-vision {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.mission-vision-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.mission-box,
.vision-box {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 40px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.mission-box:hover,
.vision-box:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.mission-icon,
.vision-icon {
    width: 80px;
    height: 80px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.mission-icon i,
.vision-icon i {
    font-size: 2rem;
    color: var(--primary-color);
}

.mission-box h2,
.vision-box h2 {
    font-size: 1.8rem;
    margin-bottom: 20px;
}

.mission-box p,
.vision-box p {
    color: #6c757d;
    font-size: var(--font-size-lg);
}

.our-values {
    padding: 60px 0;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}

.value-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.value-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.value-icon {
    width: 70px;
    height: 70px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.value-icon i {
    font-size: 1.8rem;
    color: var(--primary-color);
}

.value-item h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
}

.value-item p {
    color: #6c757d;
}

.our-journey {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px 0;
}

.timeline::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 2px;
    background-color: var(--border-color);
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 50px;
}

.timeline-dot {
    position: absolute;
    top: 0;
    left: 50%;
    width: 20px;
    height: 20px;
    background-color: var(--primary-color);
    border-radius: 50%;
    transform: translateX(-50%);
    z-index: 1;
}

.timeline-date {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: var(--primary-color);
    color: white;
    padding: 5px 15px;
    border-radius: 50px;
    font-weight: var(--font-weight-medium);
    margin-top: -40px;
}

.timeline-content {
    width: 45%;
    background-color: white;
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: var(--shadow);
    position: relative;
}

.timeline-item:nth-child(odd) .timeline-content {
    margin-left: auto;
}

.timeline-item:nth-child(even) .timeline-content {
    margin-right: auto;
}

.timeline-content h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: var(--primary-color);
}

.timeline-content p {
    color: #6c757d;
}

.team-section {
    padding: 60px 0;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}

.team-member {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.team-member:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.member-image {
    height: 250px;
    overflow: hidden;
}

.member-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.team-member:hover .member-image img {
    transform: scale(1.05);
}

.member-info {
    padding: 20px;
    text-align: center;
}

.member-info h3 {
    font-size: 1.3rem;
    margin-bottom: 5px;
}

.member-title {
    color: var(--primary-color);
    font-weight: var(--font-weight-medium);
    margin-bottom: 15px;
}

.member-bio {
    color: #6c757d;
    font-size: var(--font-size-sm);
}

.quality-commitment {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.quality-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
}

.quality-text h2 {
    font-size: 2.2rem;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 15px;
}

.quality-text h2::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 3px;
    background-color: var(--primary-color);
}

.quality-text p {
    margin-bottom: 20px;
    font-size: var(--font-size-lg);
    color: #6c757d;
}

.quality-image {
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
}

.quality-image img {
    width: 100%;
    height: auto;
    display: block;
}

.community-impact {
    padding: 60px 0;
}

.impact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
}

.impact-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.impact-item:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.impact-icon {
    width: 70px;
    height: 70px;
    background-color: rgba(232, 62, 140, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.impact-icon i {
    font-size: 1.8rem;
    color: var(--primary-color);
}

.impact-item h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
}

.impact-item p {
    color: #6c757d;
}

.product-actions{
    margin-left: 20px;
}
.favorite-btn{
    color: #ff2a2a;
    margin-left: 200px;
}
.btn-outline {
    justify-content: center;
}



/* Responsive Adjustments */

@media (max-width: 1200px) {
    .intro-content,
    .values-content,
    .quality-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    .location-details-content {
        grid-template-columns: 1fr;
    }
    .gift-card-details-content {
        grid-template-columns: 1fr;
    }
    .results-container {
        grid-template-columns: 1fr;
    }
    .map-container {
        height: 400px;
        position: relative;
        top: 0;
    }
    .newsletter-container {
        flex-direction: column;
    }
    .newsletter-image {
        width: 100%;
        height: 200px;
    }
}

@media (max-width: 768px) {
    .mission-vision-content {
        grid-template-columns: 1fr;
    }
    .timeline::before {
        left: 30px;
    }
    .timeline-dot {
        left: 30px;
    }
    .timeline-date {
        left: 30px;
        transform: translateX(0);
    }
    .timeline-content {
        width: calc(100% - 60px);
        margin-left: 60px !important;
    }
    .testimonial-item {
        flex-direction: column;
        text-align: center;
    }
    .testimonial-image {
        margin: 0 auto 20px;
    }
    .testimonial-quote {
        padding-left: 0;
    }
    .testimonial-quote i {
        position: static;
        display: block;
        margin-bottom: 10px;
    }
    .event-item {
        flex-direction: column;
        text-align: center;
    }
    .event-date {
        margin: 0 auto 20px;
    }
    .step:not(:last-child)::after {
        display: none;
    }
    .step-item:not(:last-child)::after {
        display: none;
    }
}

@media (max-width: 576px) {
    .gift-card-actions {
        flex-direction: column;
    }
    .quantity-selector {
        width: 100%;
        margin-bottom: 10px;
    }
    .btn-add-to-cart,
    .btn-buy-now {
        width: 100%;
    }
    .reviews-summary {
        flex-direction: column;
    }
    .average-rating {
        margin-bottom: 20px;
    }
    .location-actions {
        flex-direction: column;
    }
    .btn-directions,
    .btn-order,
    .btn-share {
        width: 100%;
    }
    .availability-header,
    .availability-row {
        grid-template-columns: 100px repeat(3, 1fr);
    }
    .application-progress {
        flex-wrap: wrap;
    }
    .progress-step {
        flex: 0 0 50%;
    }
}


/* Animation Classes */

.animate-fadeIn {
    animation: fadeIn 1s ease;
}

.animate-fadeInUp {
    animation: fadeInUp 1s ease;
}

.animate-fadeInDown {
    animation: fadeInDown 1s ease;
}

.animate-fadeInLeft {
    animation: fadeInLeft 1s ease;
}

.animate-fadeInRight {
    animation: fadeInRight 1s ease;
}

.animate-pulse {
    animation: pulse 2s infinite;
}

.animate-bounce {
    animation: bounce 2s infinite;
}

.animate-shake {
    animation: shake 0.5s;
}

.delay-100 {
    animation-delay: 0.1s;
}

.delay-200 {
    animation-delay: 0.2s;
}

.delay-300 {
    animation-delay: 0.3s;
}

.delay-400 {
    animation-delay: 0.4s;
}

.delay-500 {
    animation-delay: 0.5s;
}
    /* Auth buttons container */
    .auth-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    /* Play Button (No border) */
    .play-button {
        background: black;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    /* Sign In Button (White - No border) */
    .sign-in-button {
        background: white;
        color:  #ff2a2a;
        padding: 10px 22px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    /* Sign Out Button (Black - No border) */
    .sign-out-button {
        background:  #ff2a2a;
        color: white;
        padding: 10px 22px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    /* Hover effects */
    .play-button:hover {
        background: #333;
        transform: scale(1.05);
    }

    .sign-in-button:hover {
        background: #f5f5f5;
        transform: translateY(-2px);
    }

    .sign-out-button:hover {
        background: #333;
        transform: translateY(-2px);
    }

</style>
<header>
  <div class="mobile-menu-icon">
    <i class="fas fa-bars" id="menuToggle"></i>
  </div>

  <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo" class="logo">

  <nav id="navLinks">
    <ul>
      <li><a href="/gift-card">Gift Card</a></li>
      <li><a href="/locations">Locations</a></li>
      <li><a href="/join-the-team">Join The Team</a></li>
    </ul>
  </nav>

  <div class="auth-buttons">
    <button class="sign-in-button" onclick="window.location.href='/login'">Sign In</button>
    <button class="sign-out-button" onclick="window.location.href='/register'">Sign Out</button>
  </div>
</header>

<!-- Sidebar for Mobile -->
<div id="mobileSidebar" class="mobile-sidebar">
  <ul>
    <li><a href="/gift-card">Gift Card</a></li>
    <li><a href="/locations">Locations</a></li>
    <li><a href="/join-the-team">Join The Team</a></li>
  </ul>
</div>


<section class="content-welcome">
    
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1>Welcome to <span class="brand-name">XING FU CHA</span></h1>
            <p>
                Experience the authentic taste of premium bubble tea and refreshing drinks. 
                Our handcrafted beverages are made with the finest ingredients, offering a perfect 
                balance of sweetness, creaminess, and chewiness in every sip. Whether you love 
                classic milk tea, fruity blends, or unique toppings, we have something special for you. 
                Come and indulge in the ultimate bubble tea experience!
            </p>

            
            <div class="wave-text">Sip Happiness in Every Cup! </div> <!-- New animated text -->

            <div class="hero-buttons">
                <button class="btn-primary explore-btn">Explore Menu</button>
                <button class="btn-outline order-now-btn">Order Now</button>
            </div>

        </div>
        <div class="header-banner">
            <img src="/assets/image/Header-banner.png" alt="Xing Fu Cha Bubble Tea">
        </div>
    </div>
    <!-- Category Section -->
    <div class="category-section">
        <div class="category-list">
            <div class="category-item active" data-category="all">All</div>
            <div class="category-item" data-category="milk-tea">Milk Tea</div>
            <div class="category-item" data-category="fruit-tea">Fruit Tea</div>
            <div class="category-item" data-category="smoothie">Smoothies</div>
            <div class="category-item" data-category="coffee">Coffee</div>
            <div class="category-item" data-category="snacks">Snacks</div>
        </div>
        <div class="search-container">
            <input type="text" id="productSearch" placeholder="Search for your favorite drink...">
            <i class="fas fa-search"></i>
        </div>
    </div>
    <!-- Popular dishes section -->
    <div class="popular-dishes">
        <h3>Popular Drinks & Snacks</h3>
        <div class="dishes-list" id="dishes-container">
            <!-- Product Cards (Dynamic Product List) -->
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/milk-tea-macha.png" alt="Strawberry Smoothie">
                </div>


                <div class="product-info">
                    <h4>Strawberry Smoothie</h4>
                    <p class="description">Delicious strawberry smoothie with a creamy texture.</p>
                    <div class="product-price">$4.99</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="9">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="smoothie">
                <div class="product-image">
                    <img src="/assets/image/products/Almond Puff 55baht.png" alt="Mango Smoothie">
                </div>

                <div class="product-info">
                    <h4>Almond Puff</h4>
                    <p class="description">A refreshing mango smoothie for your hot day.</p>
                    <div class="product-price">$5.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="10">Order Now</button>
                </div>
            </div>
            
            <div class="product-card" data-category="milk-tea">
                <div class="product-image">
                    <img src="/assets/image/products/coffee-cream.png" alt="Classic Milk Tea">
                </div>

                <div class="product-info">
                    <h4>Classic Milk Tea</h4>
                    <p class="description">Our signature milk tea with premium black tea and creamy milk.</p>
                    <div class="product-price">$4.50</div>
                </div>
                <div class="product-actions">
                    <button class="btn-primary order-btn" data-product-id="1">Order Now</button>
                </div>
            </div>
            

            
            <!-- No products found message -->

        </div>
    </div>
</section>

<!-- Login Redirect Modal -->
<div class="modal-overlay" id="loginRedirectModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Login Required</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="login-redirect-content">
                <i class="fas fa-user-lock"></i>
                <p>Please login to continue with your order</p>
                <div class="login-redirect-buttons">
                    <a href="/login" class="btn-primary">Login</a>
                    <a href="/register" class="btn-outline">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div class="modal-overlay" id="orderModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3>Customize Your Drink</h3>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="product-details">
                <img src="/placeholder.svg?height=100&width=100" alt="" class="modal-product-image">
                <div class="modal-product-info">
                    <h4 class="modal-product-name"></h4>
                    <p class="modal-product-description"></p>
                    <div class="modal-product-price"></div>
                </div>
            </div>
            
            <hr class="modal-divider">
            
            <form id="customizeForm">
                <input type="hidden" name="product_id" id="product_id">
                
                <div class="form-group">
                    <label>Size</label>
                    <div class="option-buttons size-buttons">
                        <label class="option-button">
                            <input type="radio" name="size" value="small" data-price="0">
                            <span>Small</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="medium" data-price="0.50" checked>
                            <span>Medium</span>
                            <small>+$0.50</small>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="size" value="large" data-price="1.00">
                            <span>Large</span>
                            <small>+$1.00</small>
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Sugar Level</label>
                    <div class="option-buttons sugar-buttons">
                        <label class="option-button">
                            <input type="radio" name="sugar" value="0">
                            <span>0%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="30">
                            <span>30%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="50" checked>
                            <span>50%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="70">
                            <span>70%</span>
                        </label>
                        <label class="option-button">
                            <input type="radio" name="sugar" value="100">
                            <span>100%</span>
                        </label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" id="cancelOrder">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification Toast -->
<div class="toast-container" id="toastContainer"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    const authButtons = document.querySelector('.auth-buttons');
    
    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('show');
        authButtons.classList.toggle('show');
    });
    
    // Close mobile menu when clicking on a link
    const navItems = document.querySelectorAll('#navLinks a');
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            navLinks.classList.remove('show');
            authButtons.classList.remove('show');
        });
    });
});
  </script>

<script src="/assets/js/welcome.js"></script>
