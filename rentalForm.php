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

// Function to fetch all equipment
function getAllEquipment($conn) {
    $query = "SELECT * FROM medicalequipment"; // Removed the condition
    $result = $conn->query($query);
    if (!$result) {
        die('Error executing query: ' . $conn->error);
    }
    $equipment = $result->fetch_all(MYSQLI_ASSOC);
    return $equipment;
}

$allEquipment = getAllEquipment($conn); // Pass the $conn variable

// Close the database connection
$conn->close();

// Start of HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Equipment</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
            text-align: center;
        }
        h1 {
            color: #228B22;
            margin-bottom: 20px;
        }
        label {
            color: #333;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }
        select, input[type="date"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #228B22;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #1a7e1f;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Rent Equipment</h1>

    <form action="processRental.php" method="post">
        <div>
            <label for="equipment_id">Select Equipment:</label>
            <select name="equipment_id" id="equipment_id" required>
                <?php foreach ($allEquipment as $equipment): ?>
                    <option value="<?= htmlspecialchars($equipment['id']) ?>">
                        <?= htmlspecialchars($equipment['name']) ?> - Available: <?= htmlspecialchars($equipment['quantity_in_store']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
        </div>

        <div>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
        </div>

        <div>
            <input type="submit" value="Rent Equipment">
        </div>
    </form>
</div>

</body>
</html>
