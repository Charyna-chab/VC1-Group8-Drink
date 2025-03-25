<?php
require_once './Controllers/BaseController.php';

class FeedbackController extends BaseController {
    function index() {
        // Get filter parameters
        $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
        $nameFilter = isset($_GET['name']) ? $_GET['name'] : '';

        // Create fake feedback data
        $feedbackEntries = [
            [
                'id' => 1,
                'message' => 'The drinks are amazing! I especially loved the mango smoothie.',
                'created_at' => '2024-03-20 14:30:00',
                'customer_name' => 'John Smith'
            ],
            [
                'id' => 2,
                'message' => 'Service was excellent and the staff was very friendly.',
                'created_at' => '2024-03-18 10:15:00',
                'customer_name' => 'Sarah Johnson'
            ],
            [
                'id' => 3,
                'message' => 'The coffee was a bit too strong for my taste.',
                'created_at' => '2024-03-15 16:45:00',
                'customer_name' => 'Guest'
            ],
            [
                'id' => 4,
                'message' => 'I love the new fruit tea options! Please add more varieties.',
                'created_at' => '2024-03-12 09:20:00',
                'customer_name' => 'Michael Wong'
            ],
            [
                'id' => 5,
                'message' => 'The atmosphere is very cozy and relaxing.',
                'created_at' => '2024-03-10 13:50:00',
                'customer_name' => 'Emily Chen'
            ]
        ];

        // Apply filters to fake data
        $filteredEntries = [];
        foreach ($feedbackEntries as $entry) {
            $dateMatches = empty($dateFilter) || date('Y-m-d', strtotime($entry['created_at'])) == $dateFilter;
            $nameMatches = empty($nameFilter) || 
                          (stripos($entry['customer_name'], $nameFilter) !== false);
            
            if ($dateMatches && $nameMatches) {
                $filteredEntries[] = $entry;
            }
        }

        // Pass data to the view
        $data = [
            'feedbackEntries' => $filteredEntries,
            'dateFilter' => $dateFilter,
            'nameFilter' => $nameFilter
        ];

        // Load the feedback view
        $this->views('feedback/feedback_view.php', $data);
    }
}
?>

