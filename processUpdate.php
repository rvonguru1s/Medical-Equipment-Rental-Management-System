<?php

include('C:/xampp/htdocs/Medical equipment rental/dbconnect.php'); // Your database connection file

function openDatabaseConnection() {
    // Assuming the dbconnect.php file has the PDO connection logic
    // Otherwise, add the PDO connection code here
    return new PDO("mysql:host=localhost;dbname=medical_equipment_rental", "username", "password");
}

function isEquipmentInStock($pdo, $equipmentId) {
    $stmt = $pdo->prepare("SELECT quantity_in_store FROM equipment WHERE id = ?");
    $stmt->execute([$equipmentId]);
    $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

    return $equipment && $equipment['quantity_in_store'] > 0;
}

function createRentalRecord($pdo, $clientId, $equipmentId, $startDate, $endDate, $totalPrice) {
    $stmt = $pdo->prepare("INSERT INTO Rentals (client_id, equipment_id, start_date, end_date, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$clientId, $equipmentId, $startDate, $endDate, $totalPrice]);
    return $pdo->lastInsertId();
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = $_POST['clientId'] ?? null;
    $equipmentId = $_POST['equipmentId'] ?? null;
    $startDate = $_POST['startDate'] ?? null;
    $endDate = $_POST['endDate'] ?? null;

    // Validate input data
    if ($clientId && $equipmentId && $startDate && $endDate) {
        $pdo = openDatabaseConnection();

        try {
            $pdo->beginTransaction();

            if (isEquipmentInStock($pdo, $equipmentId)) {
                // Calculate total price (add your calculation logic here)
                $totalPrice = 100; // Placeholder for total price calculation

                // Process rental record creation
                $rentalId = createRentalRecord($pdo, $clientId, $equipmentId, $startDate, $endDate, $totalPrice);

                // Reduce the equipment stock
                $updateStmt = $pdo->prepare("UPDATE equipment SET quantity_in_store = quantity_in_store - 1 WHERE id = ?");
                $updateStmt->execute([$equipmentId]);

                // Commit transaction
                $pdo->commit();

                echo "Rental successful. Rental ID: " . $rentalId;
            } else {
                echo "Item is out of stock.";
            }
        } catch (PDOException $e) {
            // Rollback transaction if an error occurs
            $pdo->rollBack();
            echo "Failed to create rental: " . $e->getMessage();
        } finally {
            // Close the database connection
            $pdo = null;
        }
    } else {
        echo "Invalid input data.";
    }
}
?>
