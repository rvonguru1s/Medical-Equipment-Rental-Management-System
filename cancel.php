<?php
session_start();

// Check if the ClientID is set in the session
if (!isset($_SESSION['client_id'])) {
    die("Client ID is not set. Please log in again.");
}

// Logic to handle the cancellation request
// In this case, we simply redirect the user back to the main page or dashboard

header("Location: rentalForm.php"); // Change this to your main page
exit();
?>
