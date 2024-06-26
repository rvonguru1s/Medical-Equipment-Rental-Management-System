<?php
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

// Get the rental ID from the URL
$rental_id = isset($_GET['rental_id']) ? intval($_GET['rental_id']) : 0;

// Fetch the rental information from the database
$stmt = $conn->prepare("SELECT r.*, e.name AS EquipmentName, e.rent_price_per_day, c.name AS ClientName, c.address, c.telephone_number, c.email 
                        FROM rentals r 
                        INNER JOIN medicalequipment e ON r.equipment_id = e.id 
                        INNER JOIN clients c ON r.client_id = c.client_id 
                        WHERE r.rental_id = ?");
$stmt->bind_param("i", $rental_id);
$stmt->execute();
$result = $stmt->get_result();
$rental = $result->fetch_assoc();

if (!$rental) {
    die("Rental information not found.");
}

// Calculate rental days and total price
$rental_days = (strtotime($rental['end_date']) - strtotime($rental['start_date'])) / (60 * 60 * 24);
$total_price = $rental['rent_price_per_day'] * $rental_days;

// Company information
$company_name = "LifeLine Equipment Rentals";
$company_address = "123 Health St, Wellness City";
$company_telephone = "123-456-7890";
$company_email = "info@lifelinerentals.com";

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #228B22;
            margin-bottom: 15px;
        }
        p {
            margin-bottom: 10px;
        }
        button {
            background-color: #228B22;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #1a7e1f;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Rental Receipt</h1>
    <p>Thank you for renting from us, <?= htmlspecialchars($rental['ClientName']) ?>!</p>
    
    <h2>Rental Details</h2>
    <p><strong>Equipment Rented:</strong> <?= htmlspecialchars($rental['EquipmentName']) ?></p>
    <p><strong>Rent Start Date:</strong> <?= htmlspecialchars($rental['start_date']) ?></p>
    <p><strong>Rent End Date:</strong> <?= htmlspecialchars($rental['end_date']) ?></p>
    <p><strong>Days Rented:</strong> <?= htmlspecialchars($rental_days) ?></p>
    <p><strong>Total Price:</strong> $<?= htmlspecialchars(number_format($total_price, 2)) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($rental['status']) ?></p>
    <p><strong>Payment Status:</strong> <?= htmlspecialchars($rental['payment_status']) ?></p>
    
    <h2>Client Information</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($rental['ClientName']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($rental['address']) ?></p>
    <p><strong>Telephone:</strong> <?= htmlspecialchars($rental['telephone_number']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($rental['email']) ?></p>
    
    <h2>Company Information</h2>
    <p><?= htmlspecialchars($company_name) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($company_address) ?></p>
    <p><strong>Telephone:</strong> <?= htmlspecialchars($company_telephone) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($company_email) ?></p>

    <p>Please send a check to the above company address.</p>

    <button onClick="window.print()">Print this receipt</button>
</div>

</body>
</html>
