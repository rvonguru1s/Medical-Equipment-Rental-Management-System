<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40; /* Dark text color */
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff; /* White background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: #ffffff; /* White background */
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6; /* Light gray border */
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #007bff; /* Primary color bottom border for header */
            background-color: #007bff; /* Primary color background for header */
            color: #ffffff; /* White text color */
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 123, 255, 0.1); /* Light blue striped rows */
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.2); /* Lighter blue on hover */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h3>Customer Information Report</h3>
        <div class="table-responsive">
            <?php
            try {
                // Include database connection script
                require_once('dbconnect.php'); // Adjust as per your project structure

                // Open database connection
                $pdo = openDatabaseConnection(); // Assuming openDatabaseConnection() is defined in dbconnect.php

                // Query to fetch customer information along with rented equipment
                $query = "
                    SELECT c.name AS clientName, c.address, c.telephone_number, me.name AS equipmentName, r.start_date, r.end_date, r.total_price
                    FROM Clients c
                    JOIN Rentals r ON c.client_id = r.client_id
                    JOIN medicalequipment me ON r.equipment_id = me.id
                    WHERE r.status = 'rented'
                    ORDER BY c.name, r.start_date
                ";

                // Prepare SQL statement
                $stmt = $pdo->prepare($query);

                // Execute SQL statement
                $stmt->execute();

                // Check if there are any results
                if ($stmt->rowCount() > 0) {
                    // Start capturing output into buffer
                    ob_start();
                    ?>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Client Name</th>
                                <th>Address</th>
                                <th>Telephone</th>
                                <th>Equipment Rented</th>
                                <th>Rental Start Date</th>
                                <th>Rental End Date</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['clientName']) ?></td>
                                    <td><?= htmlspecialchars($row['address']) ?></td>
                                    <td><?= htmlspecialchars($row['telephone_number']) ?></td>
                                    <td><?= htmlspecialchars($row['equipmentName']) ?></td>
                                    <td><?= htmlspecialchars($row['start_date']) ?></td>
                                    <td><?= htmlspecialchars($row['end_date']) ?></td>
                                    <td>$<?= htmlspecialchars($row['total_price']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php
                    // End capturing output and print the buffered content
                    echo ob_get_clean();
                } else {
                    // If no results found
                    echo '<p>No rented equipment found.</p>';
                }

                // Close the database connection
                $pdo = null;
            } catch (PDOException $e) {
                // Handle database connection or query execution errors
                echo '<p>Error fetching data: ' . $e->getMessage() . '</p>';
            } catch (Exception $e) {
                // Handle other types of exceptions
                echo '<p>Error: ' . $e->getMessage() . '</p>';
            }
            ?>
        </div>
    </div>
</body>

</html>
