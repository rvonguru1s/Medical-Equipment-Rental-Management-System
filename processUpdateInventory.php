<?php

include 'C:/xampp/htdocs/Medical equipment rental/dbconnect.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipmentId = $_POST['equipmentId'];
    $equipmentName = $_POST['equipmentName']; // Optional: update if provided
    $quantity = $_POST['quantity'];

    $pdo = openDatabaseConnection();
    $sql = "UPDATE medicalequipment SET ";
    $sql .= $equipmentName ? "name = ?, " : "";
    $sql .= "quantity_in_store = ? WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    if ($equipmentName) {
        $stmt->execute([$equipmentName, $quantity, $equipmentId]);
    } else {
        $stmt->execute([$quantity, $equipmentId]);
    }

    if ($stmt->rowCount() > 0) {
        echo "Inventory updated successfully.";
    } else {
        echo "No changes made to the inventory.";
    }
}
?>

