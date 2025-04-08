<?php
session_start();

// Store temporary redirect URL if needed
$redirect = isset($_SESSION['redirect_after_logout']) ? $_SESSION['redirect_after_logout'] : '/login';

// Clear all session variables and user data
$_SESSION = array();

// Unset all session variables
foreach ($_SESSION as $key => $value) {
    unset($_SESSION[$key]);
}

// Clear authentication cookies
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}
if (isset($_COOKIE['user_token'])) {
    setcookie('user_token', '', time() - 3600, '/');
}
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Clear all cookies
foreach ($_COOKIE as $name => $value) {
    setcookie($name, '', time() - 3600, '/');
    setcookie($name, '', time() - 3600, '/', '', true, true);
}

// Clear browser storage
echo "<script>
    localStorage.clear();
    sessionStorage.clear();
</script>";

// Destroy the session
session_destroy();

// Force session cookie expiration
setcookie(session_name(), '', time() - 3600, '/');

// Clear PHP output buffer
ob_clean();

// Return JSON response
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
echo json_encode([
    'status' => 'success',
    'message' => 'Logged out successfully',
    'redirect' => $redirect
]);
exit();
?>
