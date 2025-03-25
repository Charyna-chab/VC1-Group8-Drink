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
                'message' => 'The drinks are amazing! I especially loved the mango smoothie. The texture was perfect and the flavor was refreshing.',
                'created_at' => '2024-03-20 14:30:00',
                'customer_name' => 'John Smith'
            ],
            [
                'id' => 2,
                'message' => 'Service was excellent and the staff was very friendly. I appreciated how they took the time to explain the different drink options.',
                'created_at' => '2024-03-18 10:15:00',
                'customer_name' => 'Sarah Johnson'
            ],
            [
                'id' => 3,
                'message' => 'The coffee was a bit too strong for my taste. Maybe offer more customization options for coffee strength?',
                'created_at' => '2024-03-15 16:45:00',
                'customer_name' => 'Guest'
            ],
            [
                'id' => 4,
                'message' => 'I love the new fruit tea options! Please add more varieties. The passion fruit tea was exceptional.',
                'created_at' => '2024-03-12 09:20:00',
                'customer_name' => 'Michael Wong'
            ],
            [
                'id' => 5,
                'message' => 'The atmosphere is very cozy and relaxing. Perfect place to work or study while enjoying a nice drink.',
                'created_at' => '2024-03-10 13:50:00',
                'customer_name' => 'Emily Chen'
            ],
            [
                'id' => 6,
                'message' => 'Prices are a bit high compared to other places, but the quality makes up for it.',
                'created_at' => '2024-03-08 11:25:00',
                'customer_name' => 'David Miller'
            ],
            [
                'id' => 7,
                'message' => 'The boba tea was amazing! Perfect sweetness and the pearls were cooked just right.',
                'created_at' => '2024-03-05 15:10:00',
                'customer_name' => 'Lisa Wang'
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
            'nameFilter' => $nameFilter,
            'title' => 'Customer Feedback Management'
        ];

        // Load the feedback view
        $this->views('feedback/feedback_view.php', $data);
    }
    
    // Method to handle viewing a single feedback entry
    function view($id) {
        // In a real application, you would fetch the specific feedback by ID
        // For now, we'll just redirect to the index
        $this->redirect('feedback');
    }
    
    // Method to handle replying to feedback
    function reply($id) {
        // In a real application, this would process the reply form
        // and send a notification to the customer
        
        // For demo purposes, just redirect back to feedback list
        $this->redirect('feedback');
    }
    
    // Method to handle deleting feedback
    function delete($id) {
        // In a real application, this would delete the feedback entry
        // or mark it as deleted in the database
        
        // For demo purposes, just redirect back to feedback list
        $this->redirect('feedback');
    }
    
    // Method to export feedback data
    function export() {
        // In a real application, this would generate a CSV or Excel file
        // with all feedback data
        
        // For demo purposes, just redirect back to feedback list
        $this->redirect('feedback');
    }
}
?>

