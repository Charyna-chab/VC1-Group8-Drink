<?php
// admin_login_verification.php

// Check if the admin has submitted the verification code
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the verification code entered by the admin
    $verification_code = $_POST['verification_code'];

    // Check if the verification code matches the one stored in the session
    if ($verification_code == $_SESSION['verification_code']) {
        // Login the admin
        // ...

        // Redirect the admin to the dashboard
        header('Location: admin_dashboard.php');
        exit;
    } else {
        // Display an error message
        echo 'Invalid verification code';
    }
}
?>
