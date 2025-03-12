<?php
// controllers/PageController.php
class PageController {
    public function giftCard() {
        // Render the Gift Card page view
        require_once 'views/giftCard.php'; // Create this view file
    }

    public function locations() {
        // Render the Locations page view
        require_once 'views/locations.php'; // Create this view file
    }

    public function joinTheTeam() {
        // Render the Join The Team page view
        require_once 'views/joinTheTeam.php'; // Create this view file
    }
}
