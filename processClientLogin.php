<?php
session_start(); // Start session to persist login status

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a database connection established
    // Replace with your actual database connection details
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "medicalequipmentrental";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Process the form data (email and password)
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Example SQL query to fetch user from database using email
    $sql = "SELECT * FROM clients WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // If login is successful, retrieve client ID and store in session
        $row = $result->fetch_assoc();
        $_SESSION['client_id'] = $row['client_id']; // Assuming 'client_id' is the column name for client's ID
        $_SESSION['email'] = $email; // Store email in session for future use

        // Redirect to client dashboard or another page
        header("Location: clientLanding.php");
        exit();
    } else {
        // If login fails, display an error message
        echo "Invalid email or password.";
    }

    // Close database connection
    $conn->close();
}
?>
