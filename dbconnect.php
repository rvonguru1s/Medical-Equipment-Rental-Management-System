<?php
function openDatabaseConnection() {
    $host = 'localhost:3307'; // or your host
    $dbname = 'medicalequipmentrental';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
}
?>
