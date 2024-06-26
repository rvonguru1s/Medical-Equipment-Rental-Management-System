<?php

include 'C:/xampp/htdocs/Medical equipment rental/dbconnect.php'; // Ensure this path is correct

$pdo = openDatabaseConnection();

$query = "
    SELECT c.client_id, c.name AS clientName, c.address, c.telephone_number, SUM(r.total_price) AS totalUnpaid
    FROM Clients c
    JOIN Rentals r ON c.client_id = r.client_id
    WHERE r.payment_status = 'pending'
    GROUP BY c.client_id
    ORDER BY c.name
";

$stmt = $pdo->query($query);

echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Unpaid Rentals Report</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light gray background */
            margin: 20px;
        }

        /* Table styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.9em;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .table th, .table td {
            padding: 12px 15px;
            border: 1px solid #dddddd; /* Light gray borders */
        }

        .table thead {
            background-color: #007bff; /* Primary color for header */
            color: #ffffff; /* White text for header */
            text-align: left;
            font-weight: bold;
        }

        .table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3; /* Light gray background for even rows */
        }

        .table tbody tr:last-of-type {
            border-bottom: 2px solid #007bff; /* Bottom border for the last row */
        }
    </style>
</head>
<body>
    <h2 style='color: #007bff;'>Unpaid Rentals Report</h2>
    <table class='table'>
        <thead>
            <tr>
                <th>Client ID</th>
                <th>Client Name</th>
                <th>Address</th>
                <th>Telephone</th>
                <th>Total Unpaid Amount</th>
            </tr>
        </thead>
        <tbody>
";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['client_id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['clientName']) . "</td>";
    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
    echo "<td>" . htmlspecialchars($row['telephone_number']) . "</td>";
    echo "<td>$" . htmlspecialchars($row['totalUnpaid']) . "</td>";
    echo "</tr>";
}

echo "
        </tbody>
    </table>
</body>
</html>
";
?>
