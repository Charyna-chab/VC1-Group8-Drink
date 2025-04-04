<?php
namespace YourNamespace\Controllers;

class LocationsController {
    public function index() {
        // Set page title
        $pageTitle = "Our Locations - XING FU CHA";
        
        // Get all locations
        $locations = $this->getAllLocations();
        
        // Include header
        include __DIR__ . '/../views/layouts/header.php';
        
        // Include the locations page
        include __DIR__ . '/../views/locations.php';
        
        // Include footer
        include __DIR__ . '/../views/layouts/footer.php';
    }
    
    public function details($id) {
        // Set page title
        $pageTitle = "Location Details - XING FU CHA";
        
        // Get location details based on ID
        $location = $this->getLocationById($id);
        
        // Include header
        include __DIR__ . '/../views/partials/header.php';
        
        // Include the location details page
        include __DIR__ . '/../views/location-details.php';
        
        // Include footer
        include __DIR__ . '/../views/partials/footer.php';
    }
    
    private function getAllLocations() {
        // This would typically fetch from a database
        return [
            [
                'id' => 1,
                'name' => 'PTT',
                'address' => 'PTT Gas Station, Maeda Street 2004, Phnom Penh 12352',
                'hours' => '08:00 AM - 18:15 PM',
                'image' => '/assets/image/locations/location1.jpg',
                'lat' => 11.5564,
                'lng' => 104.9282
            ],
            [
                'id' => 2,
                'name' => 'Toul Kork',
                'address' => 'Xin Fu Cha Toul Kork Phnom Penh',
                'hours' => '08:00 AM - 18:15 PM',
                'image' => '/assets/image/locations/location2.jpg',
                'lat' => 11.5762,
                'lng' => 104.8991
            ],
            [
                'id' => 3,
                'name' => 'Steng Meanchey',
                'address' => 'XIN FU CHA Steng Meanchey Veng Sreng Blvd, Phnom Penh 12000',
                'hours' => '08:00 AM - 18:15 PM',
                'image' => '/assets/image/locations/location3.jpg',
                'lat' => 11.5297,
                'lng' => 104.8921
            ],
            [
                'id' => 4,
                'name' => 'BKK',
                'address' => 'XIN FU CHA BKK 292 15 St 292, Phnom Penh',
                'hours' => '08:00 AM - 18:15 PM',
                'image' => '/assets/image/locations/location3.jpg',
                'lat' => 11.5500,
                'lng' => 104.9167
            ],
            [
                'id' => 5,
                'name' => 'TK',
                'address' => 'Xin Fu Cha TK 66 Street 317, Phnom Penh 120408',
                'hours' => '08:00 AM - 18:15 PM',
                'image' => '/assets/image/locations/location3.jpg',
                'lat' => 11.5762,
                'lng' => 104.8991
            ]
        ];
    }
    
    private function getLocationById($id) {
        $locations = $this->getAllLocations();
        foreach ($locations as $location) {
            if ($location['id'] == $id) {
                return $location;
            }
        }
        return null;
    }
}

