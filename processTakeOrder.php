<?php
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

    // Process the form data
    $clientId = $_POST['clientId'];
    $equipmentId = $_POST['equipmentId'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Calculate total price based on rental duration and rental rates (hypothetical example)
    $startDateObj = new DateTime($startDate);
    $endDateObj = new DateTime($endDate);
    $rentalDays = $endDateObj->diff($startDateObj)->days;
    
    // Example: Calculate total price based on rental days and a hypothetical daily rental rate
    $dailyRentalRate = 10; // Adjust this based on your actual rental rate per day
    $totalPrice = $rentalDays * $dailyRentalRate;

    // Example SQL query to insert the order into the rentals table
    $sql = "INSERT INTO rentals (client_id, equipment_id, start_date, end_date, total_price)
            VALUES ('$clientId', '$equipmentId', '$startDate', '$endDate', '$totalPrice')";

    if ($conn->query($sql) === TRUE) {
        // If insertion is successful, provide a success message
        echo "Order submitted successfully. Total Price: $" . number_format($totalPrice, 2);
    } else {
        // If there's an error, provide an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
