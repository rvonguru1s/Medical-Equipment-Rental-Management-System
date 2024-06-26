<?php

include 'C:/xampp/htdocs/Medical equipment rental/dbconnect.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['newEquipmentName'];
    $description = $_POST['newEquipmentDescription'];
    $quantity = $_POST['newEquipmentQuantity'];
    $manufacturer = $_POST['manufacturer'];
    $rentPricePerDay = $_POST['rentPricePerDay'];

    try {
        $pdo = openDatabaseConnection();
        $stmt = $pdo->prepare("INSERT INTO medicalequipment (name, description, quantity_in_store, manufacturer, rent_price_per_day) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $quantity, $manufacturer, $rentPricePerDay]);

        if ($stmt->rowCount() > 0) {
            echo "New equipment added successfully.";
        } else {
            echo "Failed to add new equipment.";
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
