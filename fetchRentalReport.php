<?php
include 'C:/xampp/htdocs/Medical equipment rental/dbconnect.php';

$pdo = openDatabaseConnection();

if (!$pdo) {
    die('Database connection failed.');
}

$query = "
    SELECT DISTINCT c.client_id, c.name AS clientName, me.name AS equipmentName, r.start_date, r.end_date
    FROM Clients c
    JOIN Rentals r ON c.client_id = r.client_id
    JOIN Medicalequipment me ON r.equipment_id = me.id
    WHERE r.status = 'rented'
    ORDER BY c.client_id
";

try {
    $stmt = $pdo->query($query);
    $rentalData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection
    $pdo = null;

    // Output JSON data wrapped in HTML structure
    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Rental Report</title>
              <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f8f9fa;
                      padding: 20px;
                  }
                  .container {
                      max-width: 1100px;
                      margin: 0 auto;
                      background-color: #ffffff;
                      padding: 20px;
                      border-radius: 8px;
                      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                  }
                  h2 {
                      margin-bottom: 20px;
                      color: #007bff; /* Primary color for heading */
                  }
                  table {
                      width: 100%;
                      margin-top: 20px;
                      border-collapse: collapse;
                  }
                  th, td {
                      padding: 12px;
                      text-align: left;
                      border-bottom: 1px solid #dee2e6;
                  }
                  th {
                      background-color: #f8f9fa;
                      color: #343a40; /* Dark gray text color */
                      font-weight: bold;
                  }
                  tr:nth-child(even) {
                      background-color: #f2f2f2; /* Light gray background for even rows */
                  }
                  .error-message {
                      color: red;
                      margin-top: 20px;
                  }
              </style>
          </head>
          <body>
              <div class='container'>
                  <h2>Rental Report</h2>
                  <table class='table table-striped'>
                      <thead>
                          <tr>
                              <th>Client ID</th>
                              <th>Client Name</th>
                              <th>Equipment Name</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                          </tr>
                      </thead>
                      <tbody>";

    foreach ($rentalData as $row) {
        echo "<tr>
                  <td>{$row['client_id']}</td>
                  <td>{$row['clientName']}</td>
                  <td>{$row['equipmentName']}</td>
                  <td>{$row['start_date']}</td>
                  <td>{$row['end_date']}</td>
              </tr>";
    }

    echo "</tbody>
          </table>
      </div>
  </body>
  </html>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
