<?php

include 'C:/xampp/htdocs/Medical equipment rental/dbconnect.php'; // Ensure this path is correct

try {
    // Open database connection
    $pdo = openDatabaseConnection();

    // SQL query to fetch payments marked as 'paid'
    $query = "
        SELECT p.payment_id, c.name AS clientName, p.amount, p.date_paid, p.payment_method
        FROM Payments p
        JOIN Rentals r ON p.rental_id = r.rental_id
        JOIN Clients c ON r.client_id = c.client_id 
        WHERE p.payment_status = 'paid'
        ORDER BY p.date_paid DESC
    ";

    // Execute the query
    $stmt = $pdo->query($query);

    // Start HTML output
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Payments Paid Report</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
                margin: 20px;
            }
            .styled-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 0.9em;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
                overflow: hidden;
            }
            .styled-table thead {
                background-color: #009879;
                color: #ffffff;
                text-align: left;
            }
            .styled-table th, .styled-table td {
                padding: 12px 15px;
                border-bottom: 1px solid #dddddd;
            }
            .styled-table tbody tr:nth-of-type(even) {
                background-color: #f3f3f3;
            }
            .styled-table tbody tr:last-of-type {
                border-bottom: 2px solid #009879;
            }
        </style>
    </head>
    <body>
        <h2>Payments Paid Report</h2>
        <table class='styled-table'>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Client Name</th>
                    <th>Amount</th>
                    <th>Date Paid</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>";

    // Fetch and display rows
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "
                <tr>
                    <td>" . htmlspecialchars($row['payment_id']) . "</td>
                    <td>" . htmlspecialchars($row['clientName']) . "</td>
                    <td>$" . htmlspecialchars($row['amount']) . "</td>
                    <td>" . htmlspecialchars($row['date_paid']) . "</td>
                    <td>" . htmlspecialchars($row['payment_method']) . "</td>
                </tr>";
    }

    // End HTML output
    echo "
            </tbody>
        </table>
    </body>
    </html>";

} catch (PDOException $e) {
    // Display error message if an exception occurs
    echo "Error: " . $e->getMessage();
}

?>
