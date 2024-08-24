<?php

include 'config.php';
// Start session
session_start();

// Predefined credentials (for demonstration only)
// In a real application, credentials should be stored securely in a database
$valid_username = 'test';
$valid_password = 'test';

$admin_username = 'admin';
$admin_password = 'admin';

// Get the username and password from the POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Validate the credentials
if ($username === $valid_username && $password === $valid_password) {
    // Set session variable to indicate successful login
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    
    // Redirect to a logged-in page (e.g., home page)
    header('Location: home.php');
    exit();
} elseif ($username === $admin_username && $password === $admin_password) {
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    
    // Redirect to a logged-in page (e.g., home page)
    header('Location: add.php');
    exit();

} else {
    // Redirect back to login page with error message
    $_SESSION['error'] = 'Invalid username or password';
    header('Location: login.php');
    exit();
}
?>
