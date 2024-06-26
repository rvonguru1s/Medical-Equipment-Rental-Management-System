<?php
// processManagerLogin.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded username and password
    $validUsername = 'admin';
    $validPassword = 'password123'; // Make sure to use a secure password in a real application

    if ($username === $validUsername && $password === $validPassword) {
        // Authentication successful

        // Start a session and store user information
        session_start();
        $_SESSION['username'] = $username;

        // Redirect to the manager landing page
        header('Location: /Medical equipment rental/managerLanding.php');
        exit();
    } else {
        // Authentication failed
        echo 'Invalid username or password';
    }
}
?>

