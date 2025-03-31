<?php
namespace YourNamespace\Controllers;

class JoinTheTeamController {
    public function index() {
        // Set page title
        $pageTitle = "Join Our Team - XING FU CHA";
        
        // Get all job positions
        $positions = $this->getAllPositions();
        
        // Include header
        include __DIR__ . '/../views/layouts/header.php';
        
        // Include the join the team page
        include __DIR__ . '/../views/join-the-team.php';
        
        // Include footer
        include __DIR__ . '/../views/layouts/footer.php';
    }
    
    public function apply() {
        // Handle job application submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form data
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $position = $_POST['position'] ?? '';
            $resume = $_FILES['resume'] ?? null;
            
            // Validate data
            $errors = [];
            if (empty($name)) $errors[] = 'Name is required';
            if (empty($email)) $errors[] = 'Email is required';
            if (empty($phone)) $errors[] = 'Phone is required';
            if (empty($position)) $errors[] = 'Position is required';
            if (empty($resume)) $errors[] = 'Resume is required';
            
            if (empty($errors)) {
                // Save application to database or send email
                // Redirect to success page
                header('Location: /join-the-team/success');
                exit;
            } else {
                // Display errors
                $pageTitle = "Apply for Job - XING FU CHA";
                include __DIR__ . '/../views/partials/header.php';
                include __DIR__ . '/../views/job-application.php';
                include __DIR__ . '/../views/partials/footer.php';
            }
        } else {
            // Display application form
            $pageTitle = "Apply for Job - XING FU CHA";
            $positions = $this->getAllPositions();
            include __DIR__ . '/../views/partials/header.php';
            include __DIR__ . '/../views/job-application.php';
            include __DIR__ . '/../views/partials/footer.php';
        }
    }
    
    public function success() {
        // Display success page
        $pageTitle = "Application Submitted - XING FU CHA";
        include __DIR__ . '/../views/partials/header.php';
        include __DIR__ . '/../views/job-application-success.php';
        include __DIR__ . '/../views/partials/footer.php';
    }
    
    private function getAllPositions() {
        // This would typically fetch from a database
        return [
            [
                'id' => 1,
                'title' => 'Bubble Tea Barista',
                'type' => 'Full-time / Part-time',
                'location' => 'Multiple Locations',
                'description' => 'Create delicious bubble tea drinks and provide excellent customer service.'
            ],
            [
                'id' => 2,
                'title' => 'Shift Supervisor',
                'type' => 'Full-time',
                'location' => 'Downtown Location',
                'description' => 'Lead a team of baristas and ensure smooth store operations during your shift.'
            ],
            [
                'id' => 3,
                'title' => 'Kitchen Staff',
                'type' => 'Full-time / Part-time',
                'location' => 'Multiple Locations',
                'description' => 'Prepare food items according to our recipes and maintain kitchen cleanliness.'
            ]
        ];
    }
}

